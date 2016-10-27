function BoneGroup(name, skeleton){
	this.name = name;
	this.skeleton = skeleton;
	this.meshes = new ObservableDict(this);
	this.parentBone = 0;
	this.currentPose;
	this.attachPoints = {};

	for (var i = 0; i < skeleton.bones.length; i++){
		bone = skeleton.bones[i];
		if (bone.name.startsWith("#")){
			this.attachPoints[bone.name] = bone;
		}
	}
}

BoneGroup.prototype = {
	addMesh: function (meshName, geometry,  materials){
		console.log('Adding mesh "' + meshName + '" bone group "' + this.name + '".');

		// For each bone, assign same bone weights as in original mesh, to this skeleton.
		// Create mapping between the new mesh's bone names and this object's skeleton's
		// bone names.
		/*var new_bone_indices = {};
		for (var i = 0; i < this.bones.length; i++){
			new_bone_indices[this.bones[i].name] = i;
		}*/

		materials[0].skinning = true;

		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		mesh.frustumCulled = false;

		/*new_skin_indices = []
		for (var i = 0; i < tmp_mesh.geometry.vertices.length; i++) {
			var vertex = tmp_mesh.geometry.vertices[i];

			this_vertex_old_skin_indices = tmp_mesh.geometry.skinIndices[i];
			this_vertex_new_skin_indices = new THREE.Vector4(0, 0, 0, 0);
			for (var j = 0; j < 4; j++){ // Each vertex can be influenced by 4 bones.
				old_bone_index = this_vertex_old_skin_indices[j];
				// What is the name of the bone at old_bone_index?
				old_bone_name = tmp_mesh.geometry.bones[old_bone_index].name;
				this_vertex_new_skin_indices[j] = new_bone_indices[old_bone_name];
			}
			new_skin_indices.push(this_vertex_new_skin_indices);
			
			
			//geometry.skinIndices.push(  );
			//geometry.skinWeights.push(  );

		}*/

		mesh.children = []
		mesh.add(this.skeleton.bones[0])
		mesh.bind(this.skeleton);

		//mesh.position.set(0,0,0);
		//mesh.castShadow = true;
		//mesh.receiveShadow = true;
		mesh.name = meshName;

		this.meshes.put(meshName, mesh);

		this.tmp = mesh;
	},

	attachToBone: function(parentBone){
		//this.parentBone = parentBone;
		parentBone.add(this.skeleton.bones[0]);
	},

	update: function(){
		if (this.parentBone != 0){
			this.skeleton.bones[0].position.setFromMatrixPosition(this.parentBone.matrixWorld);

			//bones2[0].position.x = this.parentBone.position.x
			//bones2[0].position.y = this.parentBone.position.y
			//bones2[0].position.z = this.parentBone.position.z
			var position = new THREE.Vector3();
			var quaternion = new THREE.Quaternion();
			var scale = new THREE.Vector3();

			this.parentBone.matrixWorld.decompose(position, quaternion, scale);
			var rotation = new THREE.Euler().setFromQuaternion(quaternion);
			this.skeleton.bones[0].rotation.x = rotation.x;
			this.skeleton.bones[0].rotation.y = rotation.y;
			this.skeleton.bones[0].rotation.z = rotation.z;
			this.skeleton.bones[0].scale.x = this.parentBone.scale.x;
			this.skeleton.bones[0].scale.y = this.parentBone.scale.y;
			this.skeleton.bones[0].scale.z = this.parentBone.scale.z;
		}
	}
};
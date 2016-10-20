

var BoneGroup = function(name, skeleton) {
	this.name = name;
	this.skeleton = skeleton;
	this.meshes = {};
	this.parent_bone = 0;
	this.current_pose;

	this.add_mesh = function (mesh_name, callback, geometry,  materials){
		console.log('Adding mesh "' + mesh_name + '" bone group "' + this.name + '".');

		// For each bone, assign same bone weights as in original mesh, to this skeleton.
		// Create mapping between the new mesh's bone names and this object's skeleton's
		// bone names.
		/*var new_bone_indices = {};
		for (var i = 0; i < this.bones.length; i++){
			new_bone_indices[this.bones[i].name] = i;
		}*/

		materials[0].skinning = true;

		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));

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

		mesh.add(this.skeleton.bones[0])
		mesh.bind(this.skeleton);

		//mesh.position.set(0,0,0);
		//mesh.castShadow = true;
		//mesh.receiveShadow = true;
		mesh.name = mesh_name;

		this.meshes[mesh_name] = mesh;

		this.tmp = mesh;
		
		callback(mesh);
	};
};
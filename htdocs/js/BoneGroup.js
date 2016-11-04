function BoneGroup(name, skeleton){
	this.name = name;
	this.skeleton = skeleton;
	this.meshes = new ObservableDict(this);
	this.currentPose;
	this.attachPoints = {};
	this.parentBone === null;

	for (var i = 0; i < skeleton.bones.length; i++){
		bone = skeleton.bones[i];
		if (bone.name.startsWith("#")){
			this.attachPoints[bone.name] = bone;
		}
	}
}

BoneGroup.prototype = {
	addMesh: function (meshName, mesh){
		console.log('Adding mesh "' + meshName + '" bone group "' + this.name + '".');

		var bone0 = this.skeleton.bones[0];

		// Save position, rotation, and scale because they get reset.
		var position = new THREE.Vector3(bone0.position.x, bone0.position.y, bone0.position.z);
		var rotation = new THREE.Vector3(bone0.rotation.x, bone0.rotation.y, bone0.rotation.z);
		var scale = new THREE.Vector3(bone0.scale.x, bone0.scale.y, bone0.scale.z);

		if (this.parentBone != null){
			this.parentBone.remove(bone0);

			// Is the following necessary?
			bone0.position.x = 0;
			bone0.position.y = 0;
			bone0.position.z = 0;

			bone0.rotation.x = 0;
			bone0.rotation.y = 0;
			bone0.rotation.z = 0;

			bone0.scale.x = 0;
			bone0.scale.y = 0;
			bone0.scale.z = 0;
		}

		mesh.children = [];
		mesh.add(this.skeleton.bones[0]);
		mesh.bind(this.skeleton);
		mesh.name = meshName;
		this.meshes.put(meshName, mesh);

		if (this.parentBone != null){
			this.attachToBone(this.parentBone); // Restore bone parent.
			// Restore previous position, rotation, scale.
			bone0.position.x = position.x;
			bone0.position.y = position.y;
			bone0.position.z = position.z;

			bone0.rotation.x = rotation.x;
			bone0.rotation.y = rotation.y;
			bone0.rotation.z = rotation.z;

			bone0.scale.x = scale.x;
			bone0.scale.y = scale.y;
			bone0.scale.z = scale.z;
		}
	},

	attachToBone: function(parentBone){
		parentBone.add(this.skeleton.bones[0]);
		this.parentBone = parentBone;
	},

	unattach: function(){
		var bone0 = this.skeleton.bones[0];

		if (this.parentBone != null){
			this.parentBone.remove(bone0);
		}

		this.parentBone = null;

		bone0.position.x = 0;
		bone0.position.y = 0;
		bone0.position.z = 0;
		bone0.updateMatrixWorld()
	}
};
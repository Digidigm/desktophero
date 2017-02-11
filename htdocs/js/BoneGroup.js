function BoneGroup(name, libraryName, skeleton){
	this.uid = createUid();
	this.name = name;
	this.libraryName = libraryName; // Keeps track of where this bone group is found, for saving characters.
	this.skeleton = skeleton;
	this.meshes = new ObservableDict(this);
	this.currentPose;
	this.attachPoints = {};

	this.attachedEvent = new Event(this);
	this.unattachedEvent = new Event(this);

	this.parentBoneGroupUid; // Used when saving character.
	this.parentBoneName; // Used when saving character.
	this.parentBone = null;

	this.metadata = null;

	for (var i = 0; i < skeleton.bones.length; i++){
		bone = skeleton.bones[i];
		if (bone.name.startsWith("#")){
			this.attachPoints[bone.name] = bone;
		}
	}
}

BoneGroup.prototype = {
	resetPose: function(){
		var bones = this.skeleton.bones;
		for (var i = 0; i < bones.length; i++){
			var bone = bones[i];
			/*bone.position.x = 0;
			bone.position.y = 0;
			bone.position.z = 0;*/

			bone.rotation.x = 0;
			bone.rotation.y = 0;
			bone.rotation.z = 0;

			bone.scale.x = 1;
			bone.scale.y = 1;
			bone.scale.z = 1;
		}
	},

	setPose: function(positions, rotations, scales){
		var bones = this.skeleton.bones;
		for (var i = 0; i < bones.length; i++){
			var bone = bones[i];
			if (i < positions.length){
				bone.position.x = positions[i][0];
				bone.position.y = positions[i][1];
				bone.position.z = positions[i][2];
			}

			if (i < rotations.length){
				bone.rotation.x = rotations[i][0];
				bone.rotation.y = rotations[i][1];
				bone.rotation.z = rotations[i][2];
			}
			
			if (i < scales.length){
				bone.scale.x = scales[i][0];
				bone.scale.y = scales[i][1];
				bone.scale.z = scales[i][2];
			}
		}
	},

	getPositions: function(){
		var bones = this.skeleton.bones;
		var positions = [];
		for (var i = 0; i < bones.length; i++){
			var bone = bones[i];
			positions.push([bone.position.x, bone.position.y, bone.position.z]);
		}
		return positions;
	},

	getRotations: function(){
		var bones = this.skeleton.bones;
		var rotations = [];
		for (var i = 0; i < bones.length; i++){
			var bone = bones[i];
			rotations.push([bone.rotation.x, bone.rotation.y, bone.rotation.z]);
		}
		return rotations;
	},

	getScales: function(){
		var bones = this.skeleton.bones;
		var scales = [];
		for (var i = 0; i < bones.length; i++){
			var bone = bones[i];
			scales.push([bone.scale.x, bone.scale.y, bone.scale.z]);
		}
		return scales;
	},

	attachPickingMesh(mesh){
		var bones = this.skeleton.bones;

		var savedPositions = this.getPositions();
		var savedRotations = this.getRotations();
		var savedScales = this.getScales();

		if (this.parentBone != null){
			this.parentBone.remove(bones[0]);
		}

		this.resetPose();

		mesh.children = [];
		//mesh.add(this.skeleton.bones[0]);
		console.log("Meshers")
		console.log(mesh)
		console.log(this.meshes)
		mesh.bind(this.skeleton);
		
		this.setPose(savedPositions, savedRotations, savedScales);

		if (this.parentBone != null){
			// Restore bone parent.
			this.attachToBone(this.parentBoneGroupUid,
								this.parentBoneName,
								this.parentBone);
		}
	},

	addMesh: function (meshName, mesh){
		console.log('Adding mesh "' + meshName + '" to bone group "' + this.name + '".');

		var bones = this.skeleton.bones;

		var savedPositions = this.getPositions();
		var savedRotations = this.getRotations();
		var savedScales = this.getScales();

		if (this.parentBone != null){
			this.parentBone.remove(bones[0]);
		}

		this.resetPose();

		mesh.children = [];
		mesh.add(this.skeleton.bones[0]);
		mesh.bind(this.skeleton);
		mesh.name = meshName;
		this.meshes.put(meshName, mesh);

		this.setPose(savedPositions, savedRotations, savedScales);

		if (this.parentBone != null){
			// Restore bone parent.
			this.attachToBone(this.parentBoneGroupUid,
								this.parentBoneName,
								this.parentBone);
		}
	},

	removeMesh: function (meshName){
		this.meshes.remove(meshName);
	},

	attachToBone: function(parentBoneGroupUid, parentBoneName, parentBone){
		parentBone.add(this.skeleton.bones[0]);
		this.parentBoneGroupUid = parentBoneGroupUid;
		this.parentBoneName = parentBoneName;
		this.parentBone = parentBone;

		this.attachedEvent.notify(parentBoneGroupUid);
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
		bone0.updateMatrixWorld();

		this.unattachedEvent.notify();
	},

	toJSON: function(){
		return {
			name: this.name,
			libraryName: this.libraryName,
			meshes: this.meshes.dict,
			parentBoneGroupUid: this.parentBoneGroupUid,
			parentBoneName: this.parentBoneName
		};
	}
};
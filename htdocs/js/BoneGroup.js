function BoneGroup(name, skeleton){
	this.name = name;
	this.skeleton = skeleton;
	this.meshes = new ObservableDict(this);
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
	addMesh: function (meshName, mesh){
		console.log('Adding mesh "' + meshName + '" bone group "' + this.name + '".');

		mesh.children = [];
		mesh.add(this.skeleton.bones[0]);
		mesh.bind(this.skeleton);
		mesh.name = meshName;
		this.meshes.put(meshName, mesh);
	},

	attachToBone: function(parentBone){
		parentBone.add(this.skeleton.bones[0]);
	}
};
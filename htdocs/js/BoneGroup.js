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
	addMesh: function (meshName, geometry,  materials){
		console.log('Adding mesh "' + meshName + '" bone group "' + this.name + '".');

		materials[0].skinning = true;

		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		mesh.frustumCulled = false;

		mesh.children = []
		mesh.add(this.skeleton.bones[0])
		mesh.bind(this.skeleton);

		mesh.name = meshName;

		this.meshes.put(meshName, mesh);
	},

	attachToBone: function(parentBone){
		parentBone.add(this.skeleton.bones[0]);
	}
};
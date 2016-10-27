function SceneModel(){
	this.boneGroups = new ObservableDict(this);

	this.loader = new THREE.JSONLoader();
}

SceneModel.prototype = {
	initCharacter: function(){
		this.loader.load('/test/models/head.js', this.addBoneGroup.bind(this, 'head'));
		this.loader.load('/test/models/torso.js', this.addBoneGroup.bind(this, 'torso'));
		this.loader.load('/test/models/neck.js', this.addBoneGroup.bind(this, 'neck'));
		this.loader.load('/test/models/left arm.js', this.addBoneGroup.bind(this, 'left arm'));
		this.loader.load('/test/models/right arm.js', this.addBoneGroup.bind(this, 'right arm'));
		this.loader.load('/test/models/handheld.js', this.addBoneGroup.bind(this, 'right handheld'));
	},

	addBoneGroup: function(name, geometry, materials){
		// Get skeleton out of geometry.
		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		var skeleton = mesh.skeleton;

		// Construct new bone group with skeleton.
		boneGroup = new BoneGroup(name, skeleton);
		this.boneGroups.put(name, boneGroup);
	}

}
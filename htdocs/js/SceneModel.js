function SceneModel(){
	this.boneGroups = new ObservableDict(this);

	this.loader = new THREE.JSONLoader();
}

SceneModel.prototype = {
	initCharacter: function(){
		var self = this;
		var boneGroupsLeftToBeLoaded = 6;

		self.loader.load('/test/models/head.js', function(geometry, materials){
			self.addBoneGroup('head', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
		self.loader.load('/test/models/torso.js', function(geometry, materials){
			self.addBoneGroup('torso', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
		self.loader.load('/test/models/neck.js', function(geometry, materials){
			self.addBoneGroup('neck', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
		self.loader.load('/test/models/left arm.js', function(geometry, materials){
			self.addBoneGroup('left arm', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
		self.loader.load('/test/models/right arm.js', function(geometry, materials){
			self.addBoneGroup('right arm', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
		self.loader.load('/test/models/handheld.js', function(geometry, materials){
			self.addBoneGroup('handheld', geometry, materials);
			boneGroupsLeftToBeLoaded -= 1;
			if (boneGroupsLeftToBeLoaded <= 0){
				self.initBoneGroupsAdded();
			}
		});
	},

	initBoneGroupsAdded: function(){
		var self = this;

		console.log("Promises must be done.");
		var head = self.boneGroups.get("head");
		var neck = self.boneGroups.get("neck");
		var torso = self.boneGroups.get("torso");
		var leftArm = self.boneGroups.get("left arm");
		var rightArm = self.boneGroups.get("right arm");
		var handheld = self.boneGroups.get("handheld");

		self.loader.load('/test/models/head.js', head.addMesh.bind(head, "head"));
		self.loader.load('/test/models/hat.js', head.addMesh.bind(head, "hat"));
		self.loader.load('/test/models/neck.js', neck.addMesh.bind(neck, "neck"));
		self.loader.load('/test/models/torso.js', torso.addMesh.bind(torso, "torso"));
		self.loader.load('/test/models/left arm.js', leftArm.addMesh.bind(leftArm, "left arm"));
		self.loader.load('/test/models/right arm.js', rightArm.addMesh.bind(rightArm, "right arm"));
		self.loader.load('/test/models/handheld.js', handheld.addMesh.bind(handheld, "handheld"));
	},

	addBoneGroup: function(name, geometry, materials){
		var self = this;
		var model = self;
		var promise = new Promise(
			function(resolve, reject){
				// Get skeleton out of geometry.
				var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
				var skeleton = mesh.skeleton;

				// Construct new bone group with skeleton.
				boneGroup = new BoneGroup(name, skeleton);
				model.boneGroups.put(name, boneGroup);
				console.log("Finishing one promise.");
				window.setTimeout(resolve(), 2);
			}
			);

		return promise;
	}

}
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

		// Attach meshes to bone groups.
		var head = self.boneGroups.get("head");
		var neck = self.boneGroups.get("neck");
		var torso = self.boneGroups.get("torso");
		var leftArm = self.boneGroups.get("left arm");
		var rightArm = self.boneGroups.get("right arm");
		var handheld = self.boneGroups.get("handheld");

		var meshesLeftToBeLoaded = 7;
		self.loader.load('/test/models/head.js', function(geometry, materials){
			head.addMesh("head", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/hat.js', function(geometry, materials){
			head.addMesh("hat", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/neck.js', function(geometry, materials){
			neck.addMesh("neck", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/torso.js', function(geometry, materials){
			torso.addMesh("torso", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/left arm.js', function(geometry, materials){
			leftArm.addMesh("left arm", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/right arm.js', function(geometry, materials){
			rightArm.addMesh("right arm", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
		self.loader.load('/test/models/handheld.js', function(geometry, materials){
			handheld.addMesh("handheld", geometry, materials);
			meshesLeftToBeLoaded -= 1;
			if (meshesLeftToBeLoaded <= 0){
				self.initMeshesAdded();
			}
		});
	},

	initMeshesAdded: function(){
		// Attach bone groups to their correct parent bones.

		// TODO: You should be able to do this even before loading the meshes. 
		// But it seems that even if the bone is not at position 0, 0, 0 the mesh 
		// still DOES get added at 0, 0, 0 and it doesn't match.

		self = this;

		var head = self.boneGroups.get("head");
		var neck = self.boneGroups.get("neck");
		var torso = self.boneGroups.get("torso");
		var leftArm = self.boneGroups.get("left arm");
		var rightArm = self.boneGroups.get("right arm");
		var handheld = self.boneGroups.get("handheld");

		neck.attachToBone(torso.attachPoints["#neck"]);
		leftArm.attachToBone(torso.attachPoints["#left arm"]);
		rightArm.attachToBone(torso.attachPoints["#right arm"]);
		head.attachToBone(neck.attachPoints["#top"]);
		handheld.attachToBone(leftArm.attachPoints["#hand"]);

		// Place manually because OrbitControls jumps if not centered on (0, 0, 0).
		torso.skeleton.bones[0].position.y = 0;
	},

	addBoneGroup: function(name, geometry, materials){
		// Get skeleton out of geometry.
		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		var skeleton = mesh.skeleton;

		// Construct new bone group with skeleton.
		var boneGroup = new BoneGroup(name, skeleton);
		model.boneGroups.put(name, boneGroup);
	}, 

	getCurrentPose: function(){
		return Pose.toJson(this.boneGroups);
	},

	loadPose: function(jsonString){
		var pose = Pose.fromJson(jsonString);

		// Find all bones in the character bone groups that have the same name
		// as a bone in the pose being loaded, and set position/rotation/scale
		// to match that bone.
		
		for (var i = 0; i < pose.poseBones.length; i++){
			var poseBone = pose.poseBones[i];

			for (var boneGroupName in this.boneGroups.dict){
				var boneGroup = this.boneGroups.get(boneGroupName);

				for (var j = 0; j < boneGroup.skeleton.bones.length; j++){
					var bone = boneGroup.skeleton.bones[j];

					if (bone.name === poseBone.name){
						bone.position.x = poseBone.position.x;
						bone.position.y = poseBone.position.y;
						bone.position.z = poseBone.position.z;

						bone.rotation.x = poseBone.rotation.x;
						bone.rotation.y = poseBone.rotation.y;
						bone.rotation.z = poseBone.rotation.z;

						bone.scale.x = poseBone.scale.x;
						bone.scale.y = poseBone.scale.y;
						bone.scale.z = poseBone.scale.z;
					}
				}
			}
		}
	}
};
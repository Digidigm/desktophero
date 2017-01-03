function SceneModel(){
	this.userSettings = new UserSettings();

	this.libraries = new ObservableDict();
	this.libraries.put("default", new LocalDataSource("default", "/testlib"));

	this.character = new Character();

	this.materials = {};
}
SceneModel.boneGroupsToLoad = ['human male left arm',
							'human male left hand',
							'human male right arm',
							'human male right hand',
							'human male torso',
							'human male legs',
							'human male head',
							'human male neck',
							'handheld'];
SceneModel.initialPose = 'amazing pose';

SceneModel.prototype = {
	getAvailableMeshes: function(){
		var allMeshes = [];
		for (var libraryName in this.libraries.dict){
			var library = this.libraries.get(libraryName);
			var meshes = library.getMeshes();
			for (var meshName in meshes){
				meshMetadata = meshes[meshName];
				allMeshes.push(meshMetadata);
			}
		}
		return allMeshes;
	},

	addMesh(boneGroupUid, libraryName, meshName){
		var defaultMaterial = self.materials["default"];
		var boneGroup = this.character.boneGroups.get(boneGroupUid);
		this.libraries.get(libraryName).fetchMesh(meshName, function(name, mesh){
			mesh.material = new THREE.MeshFaceMaterial([defaultMaterial]);
			boneGroup.addMesh(boneGroupUid, mesh);
		});
	},

	removeMesh(boneGroupUid, libraryName, meshName){
		var boneGroup = this.character.boneGroups.get(boneGroupUid);
		boneGroup.removeMesh(libraryName, meshName);
	},

	getAvailablePoses: function(){
		var allPoses = {};
		for (var libraryName in this.libraries.dict){
			allPoses[libraryName] = [];

			var library = this.libraries.get(libraryName);
			var poses = library.getPoses();
			console.log(poses);
			for (var poseName in poses.dict){
				var pose = poses.get(poseName);
				allPoses[libraryName].push(pose);
			}
		}
		return allPoses;
	},

	getAvailableBoneGroups: function(){
		var allBoneGroups = {};
		for (var libraryName in this.libraries.dict){
			allBoneGroups[libraryName] = [];

			var library = this.libraries.get(libraryName);
			var boneGroups = library.getBoneGroups();
			for (boneGroupUid in boneGroups.dict){
				var boneGroup = boneGroups.get(boneGroupUid);
				allBoneGroups[libraryName].push(boneGroup);
			}
		}
		return allBoneGroups;
	},

	addBoneGroup: function(libraryName, boneGroupName){
		// TODO: Change the name of the bone group if a bone group with
		// that name already exists on the character.
		self = this;
		self.libraries.get(libraryName).fetchBoneGroup(boneGroupName, function(boneGroup){
			self.character.addBoneGroup(boneGroup);
		});
	},

	removeBoneGroup: function(boneGroupUid){
		self.character.removeBoneGroup(boneGroupUid);
	},

	getAvailableAttachPoints: function(){
		var allAttachPoints = {};
		var boneGroups = this.character.boneGroups;
		for (var boneGroupUid in boneGroups.dict){
			allAttachPoints[boneGroupUid] = [];
			var boneGroup = boneGroups.get(boneGroupUid);
			for (var attachPointName in boneGroup.attachPoints){
				allAttachPoints[boneGroupUid].push(attachPointName);
			}
		}
		return allAttachPoints;
	},

	attachBoneGroup: function(boneGroupUid, toBoneGroupUid, attachPointName){
		var boneGroup = this.character.boneGroups.get(boneGroupUid);
		var attachBone = this.character.boneGroups.get(toBoneGroupUid).attachPoints[attachPointName];
		boneGroup.attachToBone(boneGroupUid, attachPointName, attachBone);
	},

	unattachBoneGroup: function(boneGroupUid){
		var boneGroup = this.character.boneGroups.get(boneGroupUid);
		boneGroup.unattach();
	},

	saveCurrentPose: function(poseName, library, author, type, tags){
		currentPose = this.character.getCurrentPose();
		jsonString = Pose.toJson(currentPose, poseName, library, author, type, tags);
		FileSaver.download(jsonString, poseName + ".txt");
	},

	loadPose: function(libraryName, poseName){
		var self = this;
		self.libraries.get(libraryName).fetchPose(poseName, function(poseJson){
			self.character.loadPose(poseJson);
		});
	},

	saveCharacter: function(){
		// Must save bone groups, meshes attached to bone groups, 
		// places meshes are attached, pos/rot/scale of bone groups, pose.

		var json = {
			character: this.character.toJSON(),
			pose: this.character.getCurrentPose()
		};

		FileSaver.download(JSON.stringify(json, null, " "), this.character.name + ".js");
	},

	initCharacter: function(){
		var self = this;
		
		var defaultDataSource = self.libraries.get('default');
		var boneGroupsLeftToBeLoaded = 9;
		var boneGroupUids = {}

		for (var i = 0; i < SceneModel.boneGroupsToLoad.length; i++){
			var name = SceneModel.boneGroupsToLoad[i];

			defaultDataSource.fetchBoneGroup(name, function(boneGroup){
				self.character.addBoneGroup(boneGroup);
				boneGroupUids[boneGroup.name] = boneGroup.uid;
				boneGroupsLeftToBeLoaded -= 1;
				if (boneGroupsLeftToBeLoaded <= 0){
					self.initBoneGroupsAdded(boneGroupUids);
				}
			});
		}
	},

	initBoneGroupsAdded: function(boneGroupUids){
		var self = this;

		var defaultDataSource = self.libraries.get('default');
		var meshesLeftToBeLoaded = 9;

		var defaultMaterial = self.materials["default"];
		// Attach meshes to bone groups.
		for (var i = 0; i < SceneModel.boneGroupsToLoad.length; i++){
			var name = SceneModel.boneGroupsToLoad[i];

			defaultDataSource.fetchMesh(name, function(name, mesh){
				// Get the UID of the bone group matching this mesh's name.
				var boneGroupUid = boneGroupUids[name];
				var boneGroup = self.character.boneGroups.get(boneGroupUid);
				mesh.material = new THREE.MeshFaceMaterial([defaultMaterial]);
				boneGroup.addMesh(boneGroupUid, mesh);
				meshesLeftToBeLoaded -= 1;
				if (meshesLeftToBeLoaded <= 0){
					self.initMeshesAdded(boneGroupUids);
				}
			});
		}
	},

	initMeshesAdded: function(boneGroupUids){
		// Attach bone groups to their correct parent bones.

		// TODO: You should be able to do this even before loading the meshes. 
		// But it seems that even if the bone is not at position 0, 0, 0 the mesh 
		// still DOES get added at 0, 0, 0 and it doesn't match.

		self = this;

		var headUid = boneGroupUids['human male head'];
		var head = self.character.boneGroups.get(headUid);
		var neckUid = boneGroupUids['human male neck'];
		var neck = self.character.boneGroups.get(neckUid);
		var torsoUid = boneGroupUids['human male torso'];
		var torso = self.character.boneGroups.get(torsoUid);
		var legsUid = boneGroupUids['human male legs'];
		var legs = self.character.boneGroups.get(legsUid);
		var leftArmUid = boneGroupUids['human male left arm'];
		var leftArm = self.character.boneGroups.get(leftArmUid);
		var leftHandUid = boneGroupUids['human male left hand'];
		var leftHand = self.character.boneGroups.get(leftHandUid);
		var rightArmUid = boneGroupUids['human male right arm'];
		var rightArm = self.character.boneGroups.get(rightArmUid);
		var rightHandUid = boneGroupUids['human male right hand'];
		var rightHand = self.character.boneGroups.get(rightHandUid);
		var handheldUid = boneGroupUids['handheld'];
		var handheld = self.character.boneGroups.get(handheldUid);

		neck.attachToBone(torsoUid, "#neck", torso.attachPoints["#neck"]);
		leftArm.attachToBone(torsoUid, "#left arm", torso.attachPoints["#left arm"]);
		leftHand.attachToBone(leftArmUid, "#hand", leftArm.attachPoints["#hand"]);
		rightArm.attachToBone(torsoUid, "#right arm", torso.attachPoints["#right arm"]);
		rightHand.attachToBone(rightArmUid, "#hand", rightArm.attachPoints["#hand"]);
		head.attachToBone(neckUid, "#top", neck.attachPoints["#top"]);
		handheld.attachToBone(leftHandUid, "#palm", leftHand.attachPoints["#palm"]);
		torso.attachToBone(legsUid, "#pelvis", legs.attachPoints["#pelvis"]);

		// Place manually because OrbitControls jumps if not centered on (0, 0, 0).
		legs.skeleton.bones[0].position.y = 0;

		// Load initial pose.
		dataSource = this.libraries.get('default');
		dataSource.fetchPose(SceneModel.initialPose, function(jsonPose){
			self.character.loadPose(jsonPose);
		});
	}
};
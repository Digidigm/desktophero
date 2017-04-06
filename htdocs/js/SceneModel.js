function SceneModel(){
	this.userSettings = new UserSettings();

	this.libraries = new ObservableDict();
	this.libraries.put("default", new LocalDataSource("default", "/defaultlib"));

	this.character = new Character();

	this.materials = {};
}
initialBoneGroups = ['male torso',
							'legs',
							'head',
							'left arm',
							'right arm',
							'left hand',
							'right hand',
							'neck',
							'weapon',
							'platform'];
boneGroupUids = {};

initialMeshes = {'male torso': 'male torso',
				'simple tunic': 'male torso',
				'legs': 'legs', 
				'elvin boots': 'legs', 
				'baggy pants': 'legs', 
				'human male': 'head',
				'muscled arm left': 'left arm',
				'muscled arm right': 'right arm',
				'left hand closed': 'left hand',
				'right hand open': 'right hand',
				'thick neck': 'neck',
				'basic sword': 'weapon',
				'smooth circular platform': 'platform'};

initialAttachments = {'male torso': ['legs', '#top'],
						'head': ['neck', '#top'],
						'left arm': ['male torso', '#left arm'],
						'right arm': ['male torso', '#right arm'],
						'left hand': ['left arm', '#hand'],
						'right hand': ['right arm', '#hand'],
						'neck': ['male torso', '#neck'],
						'weapon': ['left hand', '#palm'],
						'platform': ['legs', '#platform']};

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

	getMeshesForType: function(types){
		var allMeshes = [];
		for (var libraryName in this.libraries.dict){
			var library = this.libraries.get(libraryName);
			var meshes = library.getMeshes();
			for (var meshName in meshes){
				meshMetadata = meshes[meshName];
				if (types.indexOf(meshMetadata.type) > -1){
					allMeshes.push(meshMetadata);
				}
			}
		}
		return allMeshes;
	},

	addMesh(boneGroupUid, libraryName, meshName){
		var defaultMaterial = self.materials["default"];
		var boneGroup = this.character.boneGroups.get(boneGroupUid);
		this.libraries.get(libraryName).fetchMesh(meshName, function(name, mesh){
			mesh.material = new THREE.MeshFaceMaterial([defaultMaterial]);
			boneGroup.addMesh(meshName, mesh);
		});
	},

	removeMesh(meshId){
		var boneGroups = this.character.boneGroups;
		for (var boneGroupUid in boneGroups.dict){
			var boneGroup = this.character.boneGroups.get(boneGroupUid);
			if (meshId in boneGroup.meshes.dict){
				boneGroup.removeMesh(meshId);
			}
		}
	},

	getAvailablePoses: function(){
		var allPoses = {};
		for (var libraryName in this.libraries.dict){
			allPoses[libraryName] = [];

			var library = this.libraries.get(libraryName);
			var poses = library.getPoses();
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
		boneGroup.attachToBone(toBoneGroupUid, attachPointName, attachBone);
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
			self.character.loadPose(poseName, poseJson);
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
		var boneGroupsLeftToBeLoaded = initialBoneGroups.length;

		for (var i = 0; i < initialBoneGroups.length; i++){
			var name = initialBoneGroups[i];

			defaultDataSource.fetchBoneGroup(name, function(boneGroup){
				self.character.addBoneGroup(boneGroup);
				boneGroupUids[boneGroup.name] = boneGroup.uid;
				boneGroupsLeftToBeLoaded -= 1;
				if (boneGroupsLeftToBeLoaded <= 0){
					self.initBoneGroupsAdded();
				}
			});
		}
	},

	initBoneGroupsAdded: function(){
		var self = this;

		var defaultDataSource = self.libraries.get('default');
		var meshesLeftToBeLoaded = Object.keys(initialMeshes).length;

		var defaultMaterial = self.materials["default"];
		// Attach meshes to bone groups.
		for (var i = 0; i < Object.keys(initialMeshes).length; i++){
			var name = Object.keys(initialMeshes)[i];

			defaultDataSource.fetchMesh(name, function(name, mesh){
				// Get the UID of the bone group matching this mesh.
				var boneGroupName = initialMeshes[name];
				var boneGroupUid = boneGroupUids[boneGroupName];
				var boneGroup = self.character.boneGroups.get(boneGroupUid);
				mesh.material = new THREE.MeshFaceMaterial([defaultMaterial]);

				boneGroup.addMesh(name, mesh);
				meshesLeftToBeLoaded -= 1;
				if (meshesLeftToBeLoaded <= 0){
					self.initMeshesAdded();
				}
			});
		}
	},

	initMeshesAdded: function(){
		// Attach bone groups to their correct parent bones.

		self = this;

		for (var i = 0; i < Object.keys(initialAttachments).length; i++){
			var boneGroupName = Object.keys(initialAttachments)[i];
			var boneGroupUid = boneGroupUids[boneGroupName];
			var boneGroup = self.character.boneGroups.get(boneGroupUid);

			var attachToName = initialAttachments[boneGroupName][0];
			var attachToUid = boneGroupUids[attachToName];
			var attachToBoneGroup = self.character.boneGroups.get(attachToUid);
			var attachToPoint = initialAttachments[boneGroupName][1];

			boneGroup.attachToBone(attachToUid, attachToPoint, attachToBoneGroup.attachPoints[attachToPoint]);

		}

		/*var headUid = boneGroupUids['male head'];
		var head = self.character.boneGroups.get(headUid);
		var neckUid = boneGroupUids['male neck'];
		var neck = self.character.boneGroups.get(neckUid);
		var torsoUid = boneGroupUids['male torso'];
		var torso = self.character.boneGroups.get(torsoUid);
		var legsUid = boneGroupUids['legs'];
		var legs = self.character.boneGroups.get(legsUid);
		var leftArmUid = boneGroupUids['male left arm'];
		var leftArm = self.character.boneGroups.get(leftArmUid);
		var leftHandUid = boneGroupUids['male left hand'];
		var leftHand = self.character.boneGroups.get(leftHandUid);
		var rightArmUid = boneGroupUids['male right arm'];
		var rightArm = self.character.boneGroups.get(rightArmUid);
		var rightHandUid = boneGroupUids['male right hand'];
		var rightHand = self.character.boneGroups.get(rightHandUid);
		var platformUid = boneGroupUids['platform'];
		var platform = self.character.boneGroups.get(platformUid);
		var handheldUid = boneGroupUids['weapon'];
		var handheld = self.character.boneGroups.get(handheldUid);

		neck.attachToBone(torsoUid, "#neck", torso.attachPoints["#neck"]);
		leftArm.attachToBone(torsoUid, "#left arm", torso.attachPoints["#left arm"]);
		leftHand.attachToBone(leftArmUid, "#hand", leftArm.attachPoints["#hand"]);
		rightArm.attachToBone(torsoUid, "#right arm", torso.attachPoints["#right arm"]);
		rightHand.attachToBone(rightArmUid, "#hand", rightArm.attachPoints["#hand"]);
		head.attachToBone(neckUid, "#top", neck.attachPoints["#top"]);
		handheld.attachToBone(leftHandUid, "#palm", leftHand.attachPoints["#palm"]);
		torso.attachToBone(legsUid, "#top", legs.attachPoints["#top"]);
		platform.attachToBone(legsUid, "#platform", legs.attachPoints["#platform"]);*/

		// Place manually because OrbitControls jumps if not centered on (0, 0, 0).
		//legs.skeleton.bones[0].position.y = 0;

		// Load initial pose.
		dataSource = this.libraries.get('default');
		dataSource.fetchPose(SceneModel.initialPose, function(jsonPose){
		//	self.character.loadPose(SceneModel.initialPose, jsonPose);
		});
	},

	loadBodyPreset: function(libraryName, presetName){
		dataSource = this.libraries.get(libraryName);
		dataSource.fetchPreset(presetName, function(json){
			preset = JSON.parse(json);
			console.log(preset.meshes);
			
		});
	}
};
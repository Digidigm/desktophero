function SceneModel(){
	this.userSettings = new UserSettings();

	this.character = new Character();
}
SceneModel.boneGroupsToLoad = ['left arm',
							'right arm',
							'torso',
							'head',
							'neck',
							'handheld'];
SceneModel.prototype = {
	initCharacter: function(){
		var self = this;
		
		var defaultDataSource = self.userSettings.libraries.get('Default');
		var boneGroupsLeftToBeLoaded = 6;

		for (var i = 0; i < SceneModel.boneGroupsToLoad.length; i++){
			var name = SceneModel.boneGroupsToLoad[i];

			defaultDataSource.fetchBoneGroup(name, function(boneGroupName, boneGroup){
				self.character.addBoneGroup(boneGroupName, boneGroup);
				boneGroupsLeftToBeLoaded -= 1;
				if (boneGroupsLeftToBeLoaded <= 0){
					self.initBoneGroupsAdded();
				}
			});
		}
	},

	initBoneGroupsAdded: function(){
		var self = this;

		var defaultDataSource = self.userSettings.libraries.get('Default');
		var meshesLeftToBeLoaded = 7;

		// Attach meshes to bone groups.
		for (var i = 0; i < SceneModel.boneGroupsToLoad.length; i++){
			var name = SceneModel.boneGroupsToLoad[i];

			defaultDataSource.fetchMesh(name, function(name, mesh){
				var boneGroup = self.character.boneGroups.get(name);
				boneGroup.addMesh(name, mesh);
				meshesLeftToBeLoaded -= 1;
				if (meshesLeftToBeLoaded <= 0){
					self.initMeshesAdded();
				}
			});
		}

		defaultDataSource.fetchMesh('hat', function(name, mesh){
			var headGroup = self.character.boneGroups.get('head');
			headGroup.addMesh(name, mesh);
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

		var head = self.character.boneGroups.get("head");
		var neck = self.character.boneGroups.get("neck");
		var torso = self.character.boneGroups.get("torso");
		var leftArm = self.character.boneGroups.get("left arm");
		var rightArm = self.character.boneGroups.get("right arm");
		var handheld = self.character.boneGroups.get("handheld");

		neck.attachToBone(torso.attachPoints["#neck"]);
		leftArm.attachToBone(torso.attachPoints["#left arm"]);
		rightArm.attachToBone(torso.attachPoints["#right arm"]);
		head.attachToBone(neck.attachPoints["#top"]);
		handheld.attachToBone(leftArm.attachPoints["#hand"]);

		// Place manually because OrbitControls jumps if not centered on (0, 0, 0).
		torso.skeleton.bones[0].position.y = 0;
	},
};
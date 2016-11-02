/* A datasource that is a folder on the same server where DesktopHero is being hosted.
*/

function LocalDataSource(directoryURL){
	this.topDirectory = directoryURL;
	this.meshesDirectory = directoryURL + '/meshes';
	this.posesDirectory = directoryURL + '/poses';
	this.boneGroupsDirectory = directoryURL + '/bone groups';
	this.meshes = new ObservableList();
	this.poses = new ObservableList();
	this.boneGroups = new ObservableList();

	// Events
	this.meshesRefreshedEvent = new Event(this);
	this.posesRefreshedEvent = new Event(this);
	this.boneGroupsRefreshedEvent = new Event(this);

	// Populate mesh, pose and bone group lists
	this.refreshMeshesList();
	this.refreshPosesList();
	this.refreshBoneGroupsList();
}

LocalDataSource.loader = new THREE.JSONLoader();

LocalDataSource.prototype = {
	getMeshes: function(){
		return this.meshes;
	},

	getPoses: function(){
		return this.poses;
	},

	getBoneGroups: function(){
		return this.boneGroups;
	},

	refreshMeshesList: function(){
		this.meshes.clear();
		// Fake data for now.
		this.meshes.addAll(['left arm',
							'right arm',
							'torso',
							'hat',
							'head',
							'tentacle',
							'neck',
							'handheld']);
		this.meshesRefreshedEvent.notify(this.meshes);
	}, 

	refreshPosesList: function(){
		this.poses.clear();
		// Fake data for now.
		this.poses.addAll(['amazing pose', 'awesome pose', 'cool pose']);
		this.posesRefreshedEvent.notify(this.poses);
	},

	refreshBoneGroupsList: function(){
		this.boneGroups.clear();
		// Fake data for now.
		this.boneGroups.addAll(['left arm',
								'right arm',
								'torso',
								'hat',
								'head',
								'tentacle',
								'neck',
								'handheld']);
		this.boneGroupsRefreshedEvent.notify(this.boneGroups);
	},

	fetchMesh: function(name, callback){
		var filename = this.meshesDirectory + '/' + name + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			materials[0].skinning = true;

			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			mesh.frustumCulled = false;

			callback(name, mesh);
		});
	},

	fetchPose: function(name, callback){
		var filename = this.posesDirectory + '/' + name + '.txt';
		jQuery.get(filename, function(contents){
			callback(contents);
		});
	},

	fetchBoneGroup: function(name, callback){
		var filename = this.boneGroupsDirectory + '/' + name + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			// Get skeleton out of geometry.
			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			var skeleton = mesh.skeleton;

			// Construct new bone group with skeleton.
			var boneGroup = new BoneGroup(name, skeleton);
			callback(name, boneGroup);
		});
	}
}
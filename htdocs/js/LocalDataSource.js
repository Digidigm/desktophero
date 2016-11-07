/* A datasource that is a folder on the same server where DesktopHero is being hosted.
*/

function LocalDataSource(name, directoryURL){
	this.name = name;
	this.topDirectory = directoryURL;
	this.meshesDirectory = directoryURL + '/meshes';
	this.posesDirectory = directoryURL + '/poses';
	this.boneGroupsDirectory = directoryURL + '/bone groups';
	this.meshes = new ObservableDict();
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
		this.meshes = {};

		// Fake data for now.
		this.meshes['left arm'] = new MeshMetadata('left arm', 'stockto2', 'Default', 'arm', ['cool', 'great']);
		this.meshes['right arm'] = new MeshMetadata('right arm', 'stockto2', 'Default', 'arm', ['cool', 'great']);
		this.meshes['torso'] = new MeshMetadata('torso', 'stockto2', 'Default', 'torso', ['cool', 'great']);
		this.meshes['hat'] = new MeshMetadata('hat', 'stockto2', 'Default', 'hat', ['cool', 'monkey']);
		this.meshes['head'] = new MeshMetadata('head', 'stockto2', 'Default', 'head', ['cool', 'great']);
		this.meshes['tentacle'] = new MeshMetadata('tentacle', 'stockto2', 'Default', 'arm', ['cool', 'great']);
		this.meshes['neck'] = new MeshMetadata('neck', 'stockto2', 'Default', 'neck', ['cool', 'great']);
		this.meshes['handheld'] = new MeshMetadata('handheld', 'stockto2', 'Default', 'weapon', ['cool', 'great']);

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
		var self = this;
		var filename = this.meshesDirectory + '/' + name + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			materials[0].skinning = true;

			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			mesh.name = name;
			mesh.libraryName = self.name;

			mesh.frustumCulled = false;
			geometry.computeFaceNormals();
			geometry.computeVertexNormals();
			mesh.castShadow = true;
			mesh.receiveShadow = true;

			callback(name, mesh);
		});
	},

	fetchPose: function(name, callback){
		var filename = this.posesDirectory + '/' + name + '.txt';
		jQuery.get(filename, function(contents){
			callback(contents);
		});
	},

	fetchBoneGroup: function(meshName, callback){
		var self = this;
		var filename = this.boneGroupsDirectory + '/' + meshName + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			// Get skeleton out of geometry.
			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			var skeleton = mesh.skeleton;

			// Construct new bone group with skeleton.
			var boneGroup = new BoneGroup(meshName, self.name, skeleton);
			callback(meshName, boneGroup);
		});
	}
}

function MeshMetadata(name, author, library, type, tags){
	this.name = name;
	this.author = author;
	this.library = library;
	this.type = type;
	this.tags = tags;
}
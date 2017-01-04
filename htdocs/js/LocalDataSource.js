/* A datasource that is a folder on the same server where DesktopHero is being hosted.
*/

function LocalDataSource(name, directoryURL){
	this.name = name;
	this.topDirectory = directoryURL;
	this.meshesDirectory = directoryURL + '/meshes';
	this.posesDirectory = directoryURL + '/poses';
	this.boneGroupsDirectory = directoryURL + '/bone groups';
	this.meshes = new ObservableDict();
	this.poses = new ObservableDict();
	this.boneGroups = new ObservableDict();

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
		this.meshes = new ObservableDict();

		// Fake data for now.
		this.meshes['male left arm'] = new MeshMetadata('male left arm', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['male right arm'] = new MeshMetadata('male right arm', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['male left hand'] = new MeshMetadata('male left hand', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['male right hand'] = new MeshMetadata('male right hand', 'stockto2', 'default', 'arm', ['cool', 'great'])
		this.meshes['male torso'] = new MeshMetadata('male torso', 'stockto2', 'default', 'torso', ['cool', 'great']);
		this.meshes['male head'] = new MeshMetadata('male head', 'stockto2', 'default', 'head', ['cool', 'great']);
		this.meshes['male neck'] = new MeshMetadata('male neck', 'stockto2', 'default', 'neck', ['cool', 'great']);
		
		this.meshes['female left arm'] = new MeshMetadata('female left arm', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['female right arm'] = new MeshMetadata('female right arm', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['female left hand'] = new MeshMetadata('female left hand', 'stockto2', 'default', 'arm', ['cool', 'great']);
		this.meshes['female right hand'] = new MeshMetadata('female right hand', 'stockto2', 'default', 'arm', ['cool', 'great'])
		this.meshes['female torso'] = new MeshMetadata('female torso', 'stockto2', 'default', 'torso', ['cool', 'great']);
		this.meshes['female head'] = new MeshMetadata('female head', 'stockto2', 'default', 'head', ['cool', 'great']);
		this.meshes['female neck'] = new MeshMetadata('female neck', 'stockto2', 'default', 'neck', ['cool', 'great']);

		this.meshes['monkey goggles'] = new MeshMetadata('monkey goggles', 'stockto2', 'default', 'headgear', ['cool', 'great']);
		this.meshes['platform'] = new MeshMetadata('platform', 'stockto2', 'default', 'platform', ['cool', 'great']);
		this.meshes['handheld'] = new MeshMetadata('handheld', 'stockto2', 'default', 'weapon', ['cool', 'great']);

		this.meshesRefreshedEvent.notify(this.meshes);
	},

	refreshPosesList: function(){
		this.poses = new ObservableDict();
		// Fake data for now.
		this.poses.put('amazing pose', new PoseMetadata('amazing pose', 'stockto2', 'default', 'full figure', ['cool', 'great']));
		this.poses.put('awesome pose', new PoseMetadata('awesome pose', 'stockto2', 'default', 'full figure', ['cool', 'great']));
		this.poses.put('cool pose', new PoseMetadata('cool pose', 'stockto2', 'default', 'full figure', ['cool', 'great']));

		this.posesRefreshedEvent.notify(this.poses);
	},

	refreshBoneGroupsList: function(){
		this.boneGroups = new ObservableDict();
		// Fake data for now.
		this.boneGroups.put('male left arm', new PoseMetadata('male left arm', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('male right arm', new PoseMetadata('male right arm', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('male left hand', new PoseMetadata('male left hand', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('male right hand', new PoseMetadata('male right hand', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('male torso', new PoseMetadata('male torso', 'stockto2', 'default', 'torso', ['cool', 'great']));
		this.boneGroups.put('male head', new PoseMetadata('male head', 'stockto2', 'default', 'head', ['cool', 'great']));
		this.boneGroups.put('male neck', new PoseMetadata('male neck', 'stockto2', 'default', 'head', ['cool', 'great']));

		this.boneGroups.put('female left arm', new PoseMetadata('female left arm', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('female right arm', new PoseMetadata('female right arm', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('female left hand', new PoseMetadata('female left hand', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('female right hand', new PoseMetadata('female right hand', 'stockto2', 'default', 'arm', ['cool', 'great']));
		this.boneGroups.put('female torso', new PoseMetadata('female torso', 'stockto2', 'default', 'torso', ['cool', 'great']));
		this.boneGroups.put('female head', new PoseMetadata('female head', 'stockto2', 'default', 'head', ['cool', 'great']));
		this.boneGroups.put('female neck', new PoseMetadata('female neck', 'stockto2', 'default', 'head', ['cool', 'great']));

		this.boneGroups.put('platform', new PoseMetadata('platform', 'stockto2', 'default', 'platform', ['cool', 'great']));
		this.boneGroups.put('handheld', new PoseMetadata('handheld', 'stockto2', 'default', 'weapon', ['cool', 'great']));

		this.boneGroupsRefreshedEvent.notify(this.boneGroups);
	},

	fetchMesh: function(name, callback){
		var self = this;
		var filename = this.meshesDirectory + '/' + name + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			materials[0].skinning = true;

			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			mesh.meshName = name;
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

	fetchBoneGroup: function(boneGroupName, callback){
		var self = this;
		var filename = this.boneGroupsDirectory + '/' + boneGroupName + '.js';
		LocalDataSource.loader.load(filename, function(geometry, materials){
			// Get skeleton out of geometry.
			var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
			var skeleton = mesh.skeleton;

			// Construct new bone group with skeleton.
			var boneGroup = new BoneGroup(boneGroupName, self.name, skeleton);
			callback(boneGroup);
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

function PoseMetadata(name, author, library, type, tags){
	this.name = name;
	this.author = author;
	this.library = library;
	this.type = type;
	this.tags = tags;
}

function BoneGroupMetadata(name, author, library, type, tags){
	this.name = name;
	this.author = author;
	this.library = library;
	this.type = type;
	this.tags = tags;
}
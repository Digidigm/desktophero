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
		this.meshes['male head thin'] = new MeshMetadata('male head thin', 'stockto2', 'default', 'head', ['cool', 'great']);
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

		// Hair
		this.meshes['short hair curly'] = new MeshMetadata('short hair curly', 'stockto2', 'default', 'hair', ['cool', 'great']);
		this.meshes['short hair parted'] = new MeshMetadata('short hair parted', 'stockto2', 'default', 'hair', ['cool', 'great']);

		this.meshes['arctic hood'] = new MeshMetadata('arctic hood', 'stockto2', 'default', 'headgear', []);
		this.meshes['basic helmet 2'] = new MeshMetadata('basic helmet 2', 'stockto2', 'default', 'headgear', []);
		this.meshes['basic helmet'] = new MeshMetadata('basic helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['basic hood'] = new MeshMetadata('basic hood', 'stockto2', 'default', 'headgear', []);
		this.meshes['bearded dwarf'] = new MeshMetadata('bearded dwarf', 'stockto2', 'default', 'head', []);
		this.meshes['bearded male 2'] = new MeshMetadata('bearded male 2', 'stockto2', 'default', 'head', []);
		this.meshes['bearded male'] = new MeshMetadata('bearded male', 'stockto2', 'default', 'head', []);
		this.meshes['bull'] = new MeshMetadata('bull', 'stockto2', 'default', 'head', []);
		this.meshes['captain\'s helmet'] = new MeshMetadata('captain\'s helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['catlike'] = new MeshMetadata('catlike', 'stockto2', 'default', 'head', []);
		this.meshes['cow'] = new MeshMetadata('cow', 'stockto2', 'default', 'head', []);
		this.meshes['crafty human'] = new MeshMetadata('crafty human', 'stockto2', 'default', 'head', []);
		this.meshes['decaying helmet'] = new MeshMetadata('decaying helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['demon'] = new MeshMetadata('demon', 'stockto2', 'default', 'head', []);
		this.meshes['dwarven'] = new MeshMetadata('dwarven', 'stockto2', 'default', 'head', []);
		this.meshes['elvin helmet'] = new MeshMetadata('elvin helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['elvin hood'] = new MeshMetadata('elvin hood', 'stockto2', 'default', 'headgear', []);
		this.meshes['elvish'] = new MeshMetadata('elvish', 'stockto2', 'default', 'head', []);
		this.meshes['elvish human'] = new MeshMetadata('elvish human', 'stockto2', 'default', 'head', []);
		this.meshes['elvish male'] = new MeshMetadata('elvish male', 'stockto2', 'default', 'head', []);
		this.meshes['female'] = new MeshMetadata('female', 'stockto2', 'default', 'head', []);
		this.meshes['griffon'] = new MeshMetadata('griffon', 'stockto2', 'default', 'head', []);
		this.meshes['horns'] = new MeshMetadata('horns', 'stockto2', 'default', 'head', []);
		this.meshes['human male'] = new MeshMetadata('human male', 'stockto2', 'default', 'head', []);
		this.meshes['lich'] = new MeshMetadata('lich', 'stockto2', 'default', 'head', []);
		this.meshes['long beard tufts'] = new MeshMetadata('long beard tufts', 'stockto2', 'default', 'beards', []);
		this.meshes['long front braids'] = new MeshMetadata('long front braids', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair braids messy'] = new MeshMetadata('long hair braids messy', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair messy'] = new MeshMetadata('long hair messy', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair simple'] = new MeshMetadata('long hair simple', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair sleek'] = new MeshMetadata('long hair sleek', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair sleek w braids'] = new MeshMetadata('long hair sleek w braids', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair smooth'] = new MeshMetadata('long hair smooth', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair styled'] = new MeshMetadata('long hair styled', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair tucked ear'] = new MeshMetadata('long hair tucked ear', 'stockto2', 'default', 'hair', []);
		this.meshes['long hair windswept'] = new MeshMetadata('long hair windswept', 'stockto2', 'default', 'hair', []);
		this.meshes['middle aged human'] = new MeshMetadata('middle aged human', 'stockto2', 'default', 'head', []);
		this.meshes['ninja mask bottom'] = new MeshMetadata('ninja mask bottom', 'stockto2', 'default', 'headgear', []);
		this.meshes['pointy cap'] = new MeshMetadata('pointy cap', 'stockto2', 'default', 'headgear', []);
		this.meshes['pointy hood'] = new MeshMetadata('pointy hood', 'stockto2', 'default', 'headgear', []);
		this.meshes['ponytail messy'] = new MeshMetadata('ponytail messy', 'stockto2', 'default', 'hair', []);
		this.meshes['pre-bearded human'] = new MeshMetadata('pre-bearded human', 'stockto2', 'default', 'Uncategorized', []);
		this.meshes['seargent\'s helmet'] = new MeshMetadata('seargent\'s helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['short hair messy'] = new MeshMetadata('short hair messy', 'stockto2', 'default', 'hair', []);
		this.meshes['short hair pulled back'] = new MeshMetadata('short hair pulled back', 'stockto2', 'default', 'hair', []);
		this.meshes['short hair stiff'] = new MeshMetadata('short hair stiff', 'stockto2', 'default', 'hair', []);
		this.meshes['short hair stiff with braids'] = new MeshMetadata('short hair stiff with braids', 'stockto2', 'default', 'hair', []);
		this.meshes['short streaked beard'] = new MeshMetadata('short streaked beard', 'stockto2', 'default', 'beards', []);
		this.meshes['sideburns'] = new MeshMetadata('sideburns', 'stockto2', 'default', 'beards', []);
		this.meshes['simple'] = new MeshMetadata('simple', 'stockto2', 'default', 'head', []);
		this.meshes['simple mask'] = new MeshMetadata('simple mask', 'stockto2', 'default', 'headgear', []);
		this.meshes['simple w eyebrows'] = new MeshMetadata('simple w eyebrows', 'stockto2', 'default', 'head', []);
		this.meshes['skinny hood'] = new MeshMetadata('skinny hood', 'stockto2', 'default', 'headgear', []);
		this.meshes['soldier helmet'] = new MeshMetadata('soldier helmet', 'stockto2', 'default', 'headgear', []);
		this.meshes['specter'] = new MeshMetadata('specter', 'stockto2', 'default', 'head', []);
		this.meshes['stern human'] = new MeshMetadata('stern human', 'stockto2', 'default', 'head', []);
		this.meshes['test'] = new MeshMetadata('test', 'stockto2', 'default', 'headgear', []);
		this.meshes['undead'] = new MeshMetadata('undead', 'stockto2', 'default', 'head', []);
		this.meshes['winged helmet'] = new MeshMetadata('winged helmet', 'stockto2', 'default', 'headgear', []);

		this.meshes['armor w cape - top'] = new MeshMetadata('armor w cape - top', 'stockto2', 'default', 'male shirts', []);
		this.meshes['armor w cape'] = new MeshMetadata('armor w cape', 'stockto2', 'default', 'male shirts', []);
		this.meshes['baggy shirt'] = new MeshMetadata('baggy shirt', 'stockto2', 'default', 'male shirts', []);
		this.meshes['billowing cape'] = new MeshMetadata('billowing cape', 'stockto2', 'default', 'capes', []);
		this.meshes['blacksmith\'s apron'] = new MeshMetadata('blacksmith\'s apron', 'stockto2', 'default', 'male shirts', []);
		this.meshes['cape hood 2'] = new MeshMetadata('cape hood 2', 'stockto2', 'default', 'capes', []);
		this.meshes['cape hood'] = new MeshMetadata('cape hood', 'stockto2', 'default', 'capes', []);
		this.meshes['captain\'s armor'] = new MeshMetadata('captain\'s armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['chain mail'] = new MeshMetadata('chain mail', 'stockto2', 'default', 'male shirts', []);
		this.meshes['chest strap back a'] = new MeshMetadata('chest strap back a', 'stockto2', 'default', 'male shirts', []);
		this.meshes['chest strap back b'] = new MeshMetadata('chest strap back b', 'stockto2', 'default', 'male shirts', []);
		this.meshes['chest strap front a'] = new MeshMetadata('chest strap front a', 'stockto2', 'default', 'male shirts', []);
		this.meshes['chest strap front b'] = new MeshMetadata('chest strap front b', 'stockto2', 'default', 'male shirts', []);
		this.meshes['cloak cape'] = new MeshMetadata('cloak cape', 'stockto2', 'default', 'capes', []);
		this.meshes['decayed armor'] = new MeshMetadata('decayed armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['decaying cape 2'] = new MeshMetadata('decaying cape 2', 'stockto2', 'default', 'capes', []);
		this.meshes['decaying cape'] = new MeshMetadata('decaying cape', 'stockto2', 'default', 'capes', []);
		this.meshes['druid shirt'] = new MeshMetadata('druid shirt', 'stockto2', 'default', 'male shirts', []);
		this.meshes['elvin breastplate'] = new MeshMetadata('elvin breastplate', 'stockto2', 'default', 'male shirts', []);
		this.meshes['elvin cape'] = new MeshMetadata('elvin cape', 'stockto2', 'default', 'capes', []);
		this.meshes['fancy cape'] = new MeshMetadata('fancy cape', 'stockto2', 'default', 'capes', []);
		this.meshes['flowing cape'] = new MeshMetadata('flowing cape', 'stockto2', 'default', 'capes', []);
		this.meshes['human torso'] = new MeshMetadata('human torso', 'stockto2', 'default', 'male torso', []);
		this.meshes['leather armor'] = new MeshMetadata('leather armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['old cape'] = new MeshMetadata('old cape', 'stockto2', 'default', 'capes', []);
		this.meshes['partial armor'] = new MeshMetadata('partial armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['patterned armor'] = new MeshMetadata('patterned armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['plate armor'] = new MeshMetadata('plate armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['regal cape'] = new MeshMetadata('regal cape', 'stockto2', 'default', 'capes', []);
		this.meshes['regal cape thin'] = new MeshMetadata('regal cape thin', 'stockto2', 'default', 'capes', []);
		this.meshes['shirt w buckles'] = new MeshMetadata('shirt w buckles', 'stockto2', 'default', 'male shirts', []);
		this.meshes['simple armor'] = new MeshMetadata('simple armor', 'stockto2', 'default', 'male shirts', []);
		this.meshes['simple cape'] = new MeshMetadata('simple cape', 'stockto2', 'default', 'capes', []);
		this.meshes['simple tunic'] = new MeshMetadata('simple tunic', 'stockto2', 'default', 'male shirts', []);
		this.meshes['thick cape'] = new MeshMetadata('thick cape', 'stockto2', 'default', 'capes', []);
		this.meshes['tunic shirt'] = new MeshMetadata('tunic shirt', 'stockto2', 'default', 'male shirts', []);
		this.meshes['windswept cape'] = new MeshMetadata('windswept cape', 'stockto2', 'default', 'capes', []);




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
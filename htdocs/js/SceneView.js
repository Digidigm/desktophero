function SceneView(model){
	this.model = model;

	this.scene;
	this.camera;
	this.renderer;
	this.guiControls;

	this.hemi;
	this.SCREEN_WIDTH;
	this.SCREEN_HEIGHT;

	this.loader;
	this.exporter = new THREE.STLExporter();

	this.cubeMap;

	this.addModelListeners();
}

SceneView.prototype = {
	init: function(){
		this.scene = new THREE.Scene();
		this.camera =  new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, .001, 500);
		this.renderer = new THREE.WebGLRenderer({antialias:true});
		
		this.renderer.setClearColor(0x000033);
		this.renderer.setSize(window.innerWidth, window.innerHeight);
		this.renderer.shadowMapEnabled= true;
		this.renderer.shadowMapSoft = true;

		this.renderer.shadowMapType = THREE.PCFSoftShadowMap
		
		this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
		this.controls.addEventListener('change', this.render.bind(this));
					
		this.camera.position.x = 0;
		this.camera.position.y = 0;
		this.camera.position.z = 12;
		this.camera.lookAt(this.scene.position);

		this.cubeMap = new THREE.CubeTextureLoader()
				.setPath('/test/cubemaps/0-desnoon-skybox/')
				.load(['px.png', 'nx.png', 'py.png', 'ny.png', 'pz.png', 'nz.png']);
		this.cubeMap.format = THREE.RGBFormat;
		this.scene.background = this.cubeMap;

		this.model.materials["metallic"] = Materials.createReflectiveMaterial(
				new THREE.Color(.75, .75, .7), .4, this.cubeMap);
		this.model.materials["clay"] = Materials.createReflectiveMaterial(
				new THREE.Color(.5, .4, .5), 0.02, this.cubeMap);
		this.model.materials["default"] = this.model.materials["metallic"]

		this.initLights();
	},

	initLights: function(){
		this.scene.add(new THREE.AmbientLight(0x555555));

		var pointLight = new THREE.SpotLight(0xffffff);
		pointLight.position.y = 10;
		pointLight.position.z = 20;
		pointLight.position.x = -5;
		pointLight.castShadow = true;
		pointLight.intensity = .75;
		this.scene.add(pointLight);

		var pointLight2 = new THREE.SpotLight(0xffffdd);
		pointLight2.position.y = 60;
		pointLight2.position.z = -40;
		pointLight2.position.x = 20;
		pointLight2.castShadow = true;
		this.scene.add(pointLight2);

		lightHelper = new THREE.Mesh( new THREE.SphereBufferGeometry(4, 8, 8), new THREE.MeshBasicMaterial({color: 0x00ff00}));
		lightHelper.position.x = pointLight2.position.x;
		lightHelper.position.y = pointLight2.position.y;
		lightHelper.position.z = pointLight2.position.z;
		//this.scene.add(lightHelper);
	},

	exportToSTL: function(){
		var stlString = this.exporter.parse(this.scene);
		var blob = new Blob([stlString], {type: 'text/plain'});
		
		FileSaver.download(blob, model.character.getName() + '.stl');
	},

	render: function(){

	},

	animate: function(){
		requestAnimationFrame(this.animate.bind(this));
	    this.render();
	    this.renderer.render(this.scene, this.camera);
	},

	resize: function(innerWidth, innerHeight){
		this.SCREEN_WIDTH = window.innerWidth;
        this.SCREEN_HEIGHT = window.innerHeight;
        this.camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );
	},

	addModelListeners: function(){
		this.model.character.boneGroups.itemAddedEvent.addListener(this, this.onBoneGroupAdded);
		this.model.character.boneGroups.itemRemovedEvent.addListener(this, this.onBoneGroupRemoved);
	},

	onBoneGroupAdded: function(character, boneGroupName){
		console.log("Bone group added!");
		var boneGroup = character.boneGroups.get(boneGroupName);
		boneGroup.meshes.itemAddedEvent.addListener(this, this.onMeshAdded);

	},

	onBoneGroupRemoved: function(character, boneGroupName){
		console.log("Bone group removed!");
		// TODO: Remove meshes from scene.
		// TODO: Remove bone listeners?
	},

	onMeshAdded: function(boneGroup, meshName){
		console.log("Mesh " + meshName + " added to bone group " + boneGroup.name + ".");
		this.scene.add(boneGroup.meshes.get(meshName));
	}
};
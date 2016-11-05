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
		
		this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
		this.controls.addEventListener('change', this.render.bind(this));
					
		this.camera.position.x = 0;
		this.camera.position.y = 0;
		this.camera.position.z = 12;
		this.camera.lookAt(this.scene.position);

		this.hemi = new THREE.HemisphereLight(0xffffff, 0xffffff);
		this.scene.add(this.hemi);
	},

	exportToSTL: function(){
		var stlString = this.exporter.parse(this.scene);
		var blob = new Blob([stlString], {type: 'text/plain'});
		
		this.download(blob, model.character.getName() + '.stl');
	},

	download: function(blob, filename) {
		var element = document.createElement('a');
		element.setAttribute('href', window.URL.createObjectURL(new Blob([blob])));
		element.setAttribute('download', filename);
		element.style.display = 'none';
		document.body.appendChild(element);
		element.click();
		document.body.removeChild(element);
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
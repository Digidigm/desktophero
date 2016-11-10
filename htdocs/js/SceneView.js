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

	this.boneHandles = [];

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

		for (var i = 0; i < this.boneHandles.length; i++){
			var boneHandle = this.boneHandles[i];
			var boneGroupName = boneHandle.boneGroupName;
 			var boneIndex = boneHandle.boneIndex;

 			var boneGroup = this.model.character.boneGroups.get(boneGroupName);
 			var bone = boneGroup.skeleton.bones[boneIndex];

 			var globalBonePosition = new THREE.Vector3().setFromMatrixPosition(bone.matrixWorld);

			boneHandle.position.x = globalBonePosition.x;
			boneHandle.position.y = globalBonePosition.y;
			boneHandle.position.z = globalBonePosition.z;
		}
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

		for (var i = 0; i < boneGroup.skeleton.bones.length; i++){
			var bone = boneGroup.skeleton.bones[i];
			var sphere = new THREE.Mesh(new THREE.SphereGeometry(.4, 5, 5), new THREE.MeshBasicMaterial({color: 0xffff00, wireframe: true}));
			sphere.boneGroupName = boneGroupName;
			sphere.boneIndex = i;
			this.boneHandles.push(sphere);

			this.scene.add(sphere);
		}
		
	},

	onBoneGroupRemoved: function(character, boneGroupName){
		console.log("Bone group removed!");
		// TODO: Remove meshes from scene.
		// TODO: Remove bone listeners?
	},

	onMeshAdded: function(boneGroup, meshName){
		console.log("Mesh " + meshName + " added to bone group " + boneGroup.name + ".");

		var mesh = boneGroup.meshes.get(meshName);
		this.scene.add(mesh);

		var helper = new THREE.BoundingBoxHelper(mesh, 0xff0000);
		helper.update();
		this.scene.add(helper);
	},

	getCameraDistanceFrom: function(camera, x, y, z){
		var cameraDistance = new THREE.Vector3();
		var target = new THREE.Vector3(x,y,z);
		cameraDistance.subVectors(camera.position, target);
		return cameraDistance.length();
	}
};

document.addEventListener( 'mousedown', onDocumentMouseDown, false );

var projector = new THREE.Projector();

function onDocumentMouseDown( event ) {
	var defaultMaterial = model.materials["clay"];
	var scene = view.scene;
	var camera = view.camera;

    event.preventDefault();

    var vector = new THREE.Vector3(
        ( event.clientX / window.innerWidth ) * 2 - 1,
      - ( event.clientY / window.innerHeight ) * 2 + 1,
        0.5
    );
    vector.unproject(camera);

    var ray = new THREE.Ray(camera.position, 
                             vector.sub(camera.position).normalize());

    for (var i = 0; i < view.boneHandles.length; i++){
    	var boneHandle = view.boneHandles[i];
    	var intersection = ray.intersectsSphere(boneHandle.geometry);
    	console.log(intersection);
    	if (intersection){
    		console.log("Clicked on " + boneHandle.boneGroupName + " bone " + boneHandle.boneIndex);
    	}
    }
    



    /*if (intersects != null) {


        var particle = new THREE.Particle( defaultMaterial );
        particle.position.x = intersects.x;
        particle.position.y = intersects.y;
        particle.position.z = intersects.z;
        particle.scale.x = particle.scale.y = 8;
        scene.add( particle );

    }*/

    /*
    // Parse all the faces
    for ( var i in intersects ) {
        intersects[ i ].face.material[ 0 ].color
            .setHex( Math.random() * 0xffffff | 0x80000000 );
    }
    */
}

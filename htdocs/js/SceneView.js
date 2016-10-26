function SceneView(world){
	var scene, camera, renderer;
	var guiControls;

	var spotLight, hemi;
	var SCREEN_WIDTH, SCREEN_HEIGHT;

	var loader;
}

SceneView.prototype = {
	init: function(){
		scene = new THREE.Scene();
		camera =  new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, .001, 500);
		this.renderer = new THREE.WebGLRenderer({antialias:true});
		
		this.renderer.setClearColor(0x000033);
		this.renderer.setSize(window.innerWidth, window.innerHeight);
		this.renderer.shadowMapEnabled= true;
		this.renderer.shadowMapSoft = true;
		
		controls = new THREE.OrbitControls(camera, this.renderer.domElement);
		controls.addEventListener('change', this.render);
					
		camera.position.x = 0;
		camera.position.y = 0;
		camera.position.z = 6;
		camera.lookAt(scene.position);

		hemi = new THREE.HemisphereLight(0xffffff, 0xffffff);
		scene.add(hemi);
		
		loader = new THREE.JSONLoader();
	},

	render: function(){

	},

	animate: function(){
	    this.render();
	    this.renderer.render(scene, camera);
	},

	resize: function(innerWidth, innerHeight){
		this.SCREEN_WIDTH = window.innerWidth;
        this.SCREEN_HEIGHT = window.innerHeight;
        this.camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );
	}
};
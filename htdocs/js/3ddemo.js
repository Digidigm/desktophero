function readyFunction(){

	/*global variables*/
	var scene, camera, renderer;
	var controls, guiControls, datGUI;
	var stats;
	var spotLight, hemi;
	var SCREEN_WIDTH, SCREEN_HEIGHT;
	var loader, model;

	var bone_groups = {};
	var skeleton_helpers = [];
	

	function init(){
		/*creates empty scene object and renderer*/
		scene = new THREE.Scene();
		window.scene = scene
		camera =  new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, .1, 500);
		renderer = new THREE.WebGLRenderer({antialias:true});
		
		renderer.setClearColor(0x333300);
		renderer.setSize(window.innerWidth, window.innerHeight);
		renderer.shadowMapEnabled= true;
		renderer.shadowMapSoft = true;
		
		/*add controls*/
		controls = new THREE.OrbitControls( camera, renderer.domElement );
		controls.addEventListener( 'change', render );
					
		camera.position.x = 0;
		camera.position.y = 0;
		camera.position.z = 6;
		camera.lookAt(scene.position);

		/*datGUI controls object*/
		guiControls = new function(){
			this.Bone_0 = 0.0;
			this.Bone_1 = 0.0;
			this.Bone_2 = 0.0;
			this.Bone_3 = 0.0;
			
			this.rotationX  = 0.0;
			this.rotationY  = 0.0;
			this.rotationZ  = 0.0;
			
			this.lightX = 131;
			this.lightY = 107;
			this.lightZ = 180;
			this.intensity = 1.5;       
			this.distance = 373;
			this.angle = 1.6;
			this.exponent = 38;
			this.shadowCameraNear = 34;
			this.shadowCameraFar = 2635;
			this.shadowCameraFov = 68;
			this.shadowCameraVisible=false;
			this.shadowMapWidth=512;
			this.shadowMapHeight=512;
			this.shadowBias=0.00;
			this.shadowDarkness=0.11;
			
			this.scene = function(){
				console.log(scene);
			};		   
		}
		
		//add some nice lighting
		hemi = new THREE.HemisphereLight( 0xffffff, 0xffffff );
		scene.add(hemi);
		//add some fog
		//scene.fog = new THREE.Fog( 0xffff90, .01, 500 );
  
		/*adds spot light with starting parameters*/
		spotLight = new THREE.SpotLight(0xffffff);
		spotLight.castShadow = true;
		spotLight.position.set (20, 35, 40);
		spotLight.intensity = guiControls.intensity;        
		spotLight.distance = guiControls.distance;
		spotLight.angle = guiControls.angle;
		spotLight.exponent = guiControls.exponent;
		spotLight.shadowCameraNear = guiControls.shadowCameraNear;
		spotLight.shadowCameraFar = guiControls.shadowCameraFar;
		spotLight.shadowCameraFov = guiControls.shadowCameraFov;
		spotLight.shadowCameraVisible = guiControls.shadowCameraVisible;
		spotLight.shadowBias = guiControls.shadowBias;
		spotLight.shadowDarkness = guiControls.shadowDarkness;
		scene.add(spotLight);
		
		/*add loader call add model function*/
		loader = new THREE.JSONLoader();
		loader.load( '/test/models/human5.js', addModel );
		//loader.load('/test/models/recred.js', add_bone_group.bind(null, 't1'));
		//loader.load('/test/models/recblue.js', add_bone_group.bind(null, 't2'));
		loader.load('/test/models/head.js', add_bone_group.bind(null, 'head'));
		
		/*adds controls to scene*/
		datGUI = new dat.GUI();
		
		/*edit bones*/
		datGUI.add(guiControls, "scene");
		var cfolder = datGUI.addFolder('Controls');
		
		cfolder.add(guiControls, 'Bone_0',-3.14, 3.14);
		cfolder.add(guiControls, 'Bone_1',-3.14, 3.14);
		cfolder.add(guiControls, 'Bone_2',-3.14, 3.14);
		cfolder.add(guiControls, 'Bone_3',-3.14, 3.14);
		

		
		var lfolder = datGUI.addFolder('Lights');
		lfolder.add(guiControls, 'lightX',-60,400); 
		lfolder.add(guiControls, 'lightY',0,400);   
		lfolder.add(guiControls, 'lightZ',-60,400);
		
		lfolder.add(guiControls, 'intensity',0.01, 5).onChange(function(value){
			spotLight.intensity = value;
		});     
		lfolder.add(guiControls, 'distance',0, 1000).onChange(function(value){
			spotLight.distance = value;
		}); 
		lfolder.add(guiControls, 'angle',0.001, 1.570).onChange(function(value){
			spotLight.angle = value;
		});     
		lfolder.add(guiControls, 'exponent',0 ,50 ).onChange(function(value){
			spotLight.exponent = value;
		});
		lfolder.add(guiControls, 'shadowCameraNear',0,100).name("Near").onChange(function(value){       
			spotLight.shadowCamera.near = value;
			spotLight.shadowCamera.updateProjectionMatrix();        
		});
		lfolder.add(guiControls, 'shadowCameraFar',0,5000).name("Far").onChange(function(value){
			spotLight.shadowCamera.far = value;
			spotLight.shadowCamera.updateProjectionMatrix();
		});
		lfolder.add(guiControls, 'shadowCameraFov',1,180).name("Fov").onChange(function(value){
			spotLight.shadowCamera.fov = value;
			spotLight.shadowCamera.updateProjectionMatrix();
		});
		lfolder.add(guiControls, 'shadowCameraVisible').onChange(function(value){
			spotLight.shadowCameraVisible = value;
			spotLight.shadowCamera.updateProjectionMatrix();
		});
		lfolder.add(guiControls, 'shadowBias',0,1).onChange(function(value){
			spotLight.shadowBias = value;
			spotLight.shadowCamera.updateProjectionMatrix();
		});
		lfolder.add(guiControls, 'shadowDarkness',0,1).onChange(function(value){
			spotLight.shadowDarkness = value;
			spotLight.shadowCamera.updateProjectionMatrix();
		});
		datGUI.close();
		$("#editor").append(renderer.domElement);
		/*stats*/
		stats = new Stats();        
		stats.domElement.style.position = 'absolute';
		stats.domElement.style.left = '0px';
		stats.domElement.style.top = '0px';     
		$("#editor").append( stats.domElement );
	}
	var set = [];
	var helpset = [];
	var scaleVal = 3;
	function addModel( geometry,  materials ){
  
		for (var i = 0;i < 1; i++){
			materials[0].skinning = true;

			var cs = 15;
			
			set[i]= new THREE.SkinnedMesh( geometry, new THREE.MeshFaceMaterial(materials) );
			set[i].position.set(0,0,0);
			set[i].scale.set (cs, cs, cs);
			set[i].castShadow = true;
			set[i].receiveShadow = true;
			
			scene.add(set[i]);
			helpset[i] = new THREE.SkeletonHelper(set[i]);
			scene.add(helpset[i]);
		   
		}

	}

	function add_bone_group(name, geometry, materials){
		// Get skeleton out of geometry.
		var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		var skeleton = mesh.skeleton;

		// Construct new bone group with skeleton.
		bone_group = new BoneGroup(name, skeleton);
		bone_groups[name] = bone_group;
		window.bone_groups = bone_groups;
		



		/*materials[0].skinning = true;

		var scale = 15;
		
		mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
		mesh.position.set(0,10,0);
		mesh.scale.set(scale, scale, scale);
		mesh.castShadow = true;
		mesh.receiveShadow = true;
		
		scene.add(mesh);

		skeletonHelper = new THREE.SkeletonHelper(mesh);
		scene.add(skeletonHelper);*/

		//bone_group = new BoneGroup(name, mesh)
		//bone_groups[name] = bone_group
		//window.bone_groups = bone_groups
	}


		
	function render() { 
		spotLight.position.x = guiControls.lightX;
		spotLight.position.y = guiControls.lightY;
		spotLight.position.z = guiControls.lightZ;

		scene.traverse(function(child){
			if (child instanceof THREE.SkinnedMesh){
				
				/*child.skeleton.bones[0].rotation.z = guiControls.Bone_0;
				child.skeleton.bones[1].rotation.z = guiControls.Bone_1;
				child.skeleton.bones[2].rotation.z = guiControls.Bone_2;
				child.skeleton.bones[3].rotation.z = guiControls.Bone_3;  */              
			}
			else if  (child instanceof THREE.SkeletonHelper){
				child.update();
			}
		});

	}
	
	function animate(){
		requestAnimationFrame(animate);
	    render();
	    stats.update();
	    renderer.render(scene, camera);
    }
    
    init();
    animate();
    
    
    $(window).resize(function(){
        SCREEN_WIDTH = window.innerWidth;
        SCREEN_HEIGHT = window.innerHeight;
        camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
        camera.updateProjectionMatrix();
        renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );
    });	

    window.poseModel = function(){
    	pose = getTestPose()
    	console.log(pose)
    	scene.traverse(function(child){
			if (child instanceof THREE.SkinnedMesh){
				bones = child.skeleton.bones;
				
				for (var j = 0; j < bones.length; j++){
					var bone = bones[j]
					// Todo: Have the blender script store bones as <name>:<quat> entries in a dictionary to avoid this loop.
					var red = 0
					var green = 1
					var blue = 2

					for (var i = 0; i < pose.bones.length; i++){
						if (bone.name == pose.bones[i].bone_name){
							//bone.use_quaternion = false
							bone.rotation.order = 'ZYX'; //'YZX' is close
							
							var up, right, forward
							if (bone.name == "Bone" || 
								bone.name == "Bone.001" || 
								bone.name == "Bone.002" || 
								bone.name == "Bone.003" || 
								bone.name == "Bone.004"){
								up = pose.bones[i].rotation[green];
								right = pose.bones[i].rotation[red];
								forward = pose.bones[i].rotation[blue];
							} else if (bone.name == "Bone.005" || 
										bone.name == "Bone.006" || 
										bone.name == "Bone.007"){
								bone.rotation.order = 'YXZ'
								up = pose.bones[i].rotation[blue];
								right = pose.bones[i].rotation[green];
								forward = pose.bones[i].rotation[red];
							} else if (bone.name == "Bone.008" || 
										bone.name == "Bone.009" || 
										bone.name == "Bone.010"){
								bone.rotation.order = 'YXZ'
								up = pose.bones[i].rotation[blue];
								right = -pose.bones[i].rotation[green];
								forward = -pose.bones[i].rotation[red];
							} else if (bone.name == "Bone.011" || 
										bone.name == "Bone.012"){
								up = pose.bones[i].rotation[green];
								right = pose.bones[i].rotation[red];
								forward = pose.bones[i].rotation[blue];
							} else if (bone.name == "Bone.013" || 
								bone.name == "Bone.014" || 
								bone.name == "Bone.015" || 
								bone.name == "Bone.016"){
								up = -pose.bones[i].rotation[green];
								right = pose.bones[i].rotation[red];
								forward = -pose.bones[i].rotation[blue] ;
							} else if (bone.name == "Bone.017" || 
								bone.name == "Bone.018" || 
								bone.name == "Bone.019" || 
								bone.name == "Bone.020"){
								up = pose.bones[i].rotation[blue];
								right = -pose.bones[i].rotation[red];
								forward = -pose.bones[i].rotation[green] ;
							} else {
								up = 0;
								right = 0;
								forward = 0;
							}

							/*console.log(up)
							console.log(right)
							console.log(forward)*/
							bone.rotation.x = right;
							bone.rotation.z = forward;
							bone.rotation.y = up;
							

							if (bone.name == "Bone.005"){
								console.log(pose.bones[i].rotation[0])
								console.log(pose.bones[i].rotation[1])
								console.log(pose.bones[i].rotation[2])
								console.log(bone.rotation.x)
								console.log(bone.rotation.y)
								console.log(bone.rotation.z)
							}
							/*console.log(bone.name + ": ")
							console.log(bone.rotation)*/
							break;
						}
					}
				}
			}
		});
    }

    function getTestPose(){
    	return JSON.parse(
			'{"pose_name":"test", "bones":[{"bone_name":"Bone", "rotation":[1.9226702451705933, -0.0009313142509199679, -0.00016556473565287888]}, {"bone_name":"Bone.001", "rotation":[-0.37607342004776, 3.263347925219762e-11, 4.386852686666387e-11]}, {"bone_name":"Bone.002", "rotation":[0.0, 0.0, 0.0]}, {"bone_name":"Bone.003", "rotation":[-0.44932135939598083, 2.8409503916027035e-11, 4.034667738794795e-11]}, {"bone_name":"Bone.004", "rotation":[-0.3708282709121704, 2.349996933159737e-11, 3.403754361697153e-11]}, {"bone_name":"Bone.005", "rotation":[-0.9046810269355774, 0.5459235906600952, -0.16327519714832306]}, {"bone_name":"Bone.006", "rotation":[0.5804301500320435, -0.40707725286483765, -1.7907335758209229]}, {"bone_name":"Bone.007", "rotation":[0.0, 0.0, 0.0]}, {"bone_name":"Bone.008", "rotation":[0.6201788783073425, -0.2529982328414917, 1.0996545553207397]}, {"bone_name":"Bone.009", "rotation":[0.24127955734729767, -0.029807748273015022, 0.24250195920467377]}, {"bone_name":"Bone.010", "rotation":[0.0, 0.0, 0.0]}, {"bone_name":"Bone.011", "rotation":[-0.1982637196779251, -0.004233112558722496, -0.007679996080696583]}, {"bone_name":"Bone.012", "rotation":[-0.33867502212524414, -0.008108455687761307, -0.012540679425001144]}, {"bone_name":"Bone.013", "rotation":[-0.844447672367096, 2.7732916407785524e-08, 5.5748877514361084e-08]}, {"bone_name":"Bone.014", "rotation":[1.4505610466003418, -3.0599167644140834e-09, -2.529922049632205e-09]}, {"bone_name":"Bone.017", "rotation":[-0.5336959958076477, 1.2534094651073246e-08, 4.6006285003841185e-08]}, {"bone_name":"Bone.018", "rotation":[-0.2973347008228302, -4.172669154645092e-11, -6.836009536215215e-11]}, {"bone_name":"Bone.015", "rotation":[-0.25183165073394775, 3.6357050703372806e-09, 2.058188286468976e-08]}, {"bone_name":"Bone.016", "rotation":[0.27862924337387085, 2.974542834266458e-09, 4.510152529224598e-10]}, {"bone_name":"Bone.019", "rotation":[-0.28812694549560547, -4.07844247263256e-09, -2.794934417238437e-08]}, {"bone_name":"Bone.020", "rotation":[0.0, 0.0, 0.0]}]}' //replace
    	);
    }

    window.go = function (){
    	head_group = bone_groups["head"]

    	loader.load('/test/models/head.js', head_group.add_mesh.bind(head_group, "head", add_mesh_to_scene));
    	loader.load('/test/models/hat.js', head_group.add_mesh.bind(head_group, "hat", add_mesh_to_scene));

    }

    var add_mesh_to_scene = function (mesh){
    	scene.add(mesh);
    	skeleton_helper = new THREE.SkeletonHelper(mesh);
    	skeleton_helpers.push(skeleton_helper);
		//scene.add(skeleton_helper);
    }
}

$(document).ready(readyFunction);

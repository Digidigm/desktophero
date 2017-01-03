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
	this.boneHandlesVisible = false;
	this.selectedBone;
	this.rotateMode = false;
	this.rotateOriginX;
	this.rotateOriginY;

	this.mouseX;
	this.mouseY;

	this.raycaster = new THREE.Raycaster();

	this.X_AXIS = new THREE.Vector3(1,0,0);
	this.Y_AXIS = new THREE.Vector3(0,1,0);
	this.Z_AXIS = new THREE.Vector3(0,0,1);

	this.addModelListeners();

}

SceneView.prototype = {
	init: function(){

		this.scene = new THREE.Scene();
		this.camera =  new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, 0.001, 500);
		this.renderer = new THREE.WebGLRenderer({
													antialias:true,
													preserveDrawingBuffer   : true   // required to support .toDataURL()
												});
		
		this.renderer.setClearColor(0x000033);
		this.renderer.setSize(window.innerWidth, window.innerHeight);
		this.renderer.shadowMapEnabled= true;
		this.renderer.shadowMapSoft = true;

		this.renderer.shadowMapType = THREE.PCFSoftShadowMap;
		
		this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
		this.controls.addEventListener('change', this.render.bind(this));
					
		this.camera.position.x = 0;
		this.camera.position.y = 0;
		this.camera.position.z = 12;
		this.camera.lookAt(this.scene.position);

		this.cubeMap = new THREE.CubeTextureLoader()
				.setPath('/test/cubemaps/bridge/')
				.load(['px.jpg', 'nx.jpg', 'py.jpg', 'ny.jpg', 'pz.jpg', 'nz.jpg']);
		this.cubeMap.format = THREE.RGBFormat;
		this.scene.background = this.cubeMap;

		this.model.materials.metallic = Materials.createReflectiveMaterial( new THREE.Color(0.75, 0.75, 0.7), 0.4, this.cubeMap);
		this.model.materials.clay = Materials.createReflectiveMaterial( 	new THREE.Color(0.5, 0.4, 0.5), 0.02,  this.cubeMap);
		this.model.materials.default = this.model.materials.metallic;

		this.initLights();

		this.populateTabs();
		this.libraryPopulateMeshes();
		this.libraryPopulatePoses();
		this.libraryPopulateBoneGroups();
	},

	initLights: function(){
		this.scene.add(new THREE.AmbientLight(0x555555));

		var pointLight = new THREE.SpotLight(0xffffff);
		pointLight.position.y = 10;
		pointLight.position.z = 20;
		pointLight.position.x = -5;
		pointLight.castShadow = true;
		pointLight.intensity = 0.75;
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
			var boneGroupUid = boneHandle.boneGroupUid;
			var boneIndex = boneHandle.boneIndex;

			var boneGroup = this.model.character.boneGroups.get(boneGroupUid);
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

	onBoneGroupAdded: function(character, boneGroupUid){
		console.log("Bone group added!");
		var boneGroup = character.boneGroups.get(boneGroupUid);
		boneGroup.meshes.itemAddedEvent.addListener(this, this.onMeshAdded);

		var randomColor = '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
		for (var i = 0; i < boneGroup.skeleton.bones.length; i++){
			var bone = boneGroup.skeleton.bones[i];

			if (bone.name.startsWith("#")){
				continue;
			}

			var boneHandle = new THREE.Mesh(new THREE.SphereGeometry(0.3, 5, 5), new THREE.MeshBasicMaterial({color: randomColor, wireframe: true}));
			boneHandle.boneGroupUid = boneGroupUid;
			boneHandle.boneIndex = i;
			this.boneHandles.push(boneHandle);

			boneHandle.visible = this.boneHandlesVisible;
			this.scene.add(boneHandle);
		}

		this.meshesTabAddBoneGroup(boneGroupUid, boneGroup.name);
		//this.poseTabAddBoneGroup(boneGroupUid, boneGroupName);
		this.boneGroupsTabAddBoneGroup(boneGroupUid, boneGroup.name);

		for (var meshName in boneGroup.meshes.dict){
			//TODO: add icon as well.
			this.meshesTabAddMesh(boneGroupUid, meshName);
		}
		
	},

	onBoneGroupRemoved: function(character, boneGroupUid){
		console.log("Bone group removed!");

		// Remove from three.js scene
		var boneGroupsToRemove = [];
		for (var i in this.scene.children){
			var sceneElement = this.scene.children[i];
			if (sceneElement.boneGroupUid === boneGroupUid){
				boneGroupsToRemove.push(sceneElement);
			}
		}
		for (var i in boneGroupsToRemove){
			var element = boneGroupsToRemove[i];
			this.scene.remove(element);
		}

		// Remove boneHandle entries.
		var toRemove = [];
		for (var i = 0; i < this.boneHandles.length; i++){
			if (this.boneHandles[i].boneGroupUid === boneGroupUid){
				toRemove.push(i);
			}
		}
		for (var i = toRemove.length - 1; i >= 0; i--){ // Go backwards so we don't mess up the indices when we're removing elements.
			var index = toRemove[i];
			this.boneHandles.splice(index, 1);
		}
	},

	onMeshAdded: function(boneGroup, meshName){
		console.log("Mesh " + meshName + " added to bone group " + boneGroup.name + ".");

		var mesh = boneGroup.meshes.get(meshName);
		mesh.boneGroupUid = boneGroup.uid;
		this.scene.add(mesh);

		this.meshesTabAddMesh(boneGroup.uid, meshName);
	},

	toggleBoneHandlesVisible: function(){
		this.boneHandlesVisible = !this.boneHandlesVisible;
		for (var i = 0; i < this.boneHandles.length; i++){
			this.boneHandles[i].visible = this.boneHandlesVisible;
		}
	}, 

	startBoneRotate: function(){
		if (this.selectedBone === null){
			return;
		}

		console.log("Entering rotate mode.");
		this.rotateMode = true;
		this.initialRotation = this.selectedBone.rotation.clone();
		this.rotationAxis = null;

		this.rotateOriginX = this.mouseX;
		this.rotateOriginY = this.mouseY;
	},

	finalizeBoneRotate: function(){
		this.rotateMode = false;
	},

	cancelBoneRotate: function(){
		this.selectedBone.rotation.setFromVector3(this.initialRotation);
		this.rotateMode = false;
	},

	setRotationAxis: function(axis){
		if (!this.rotateMode){
			console.error("Cannot set rotation axis, not in rotate mode.");
			return;
		}

		if (axis == 'X' || axis == 'x'){
			this.rotationAxis = 'X';
		} else if (axis == 'Y' || axis == 'y'){
			this.rotationAxis = 'Y';
		} else if (axis == 'Z' || axis == 'z'){
			this.rotationAxis = 'Z';
		}
		console.log("Rotation axis set to " + this.rotationAxis + ".");
	},

	getClickVector: function(mouseX, mouseY, camera, event){
		var vector = new THREE.Vector3(
			( event.clientX / window.innerWidth ) * 2 - 1,
		  - ( event.clientY / window.innerHeight ) * 2 + 1,
			0.5
		);
		vector.unproject(camera);
		return vector;
	},

	onLeftClick: function(mouseX, mouseY, event){
		if (this.rotateMode){
			this.finalizeBoneRotate();
			return;
		} 
	},

	onRightClick: function(mouseX, mouseY, event){
		
		if (this.rotateMode){
			this.cancelBoneRotate();
			return;
		}

		var clickVector = this.getClickVector(mouseX, mouseY, this.camera, event);
		this.raycaster.set(this.camera.position, clickVector.sub(this.camera.position).normalize());

		var intersections = this.raycaster.intersectObjects(this.boneHandles, false);
		var closestBone = null, closestDistance = null;
		for (var i = 0; i < intersections.length; i++){
			var boneHandle = intersections[i].object;
			var boneGroup = this.model.character.boneGroups.get(boneHandle.boneGroupUid);
			var bone = boneGroup.skeleton.bones[boneHandle.boneIndex];
			if (bone.name.startsWith("#")){
				continue;
			}
			if (closestBone === null || intersections[i].distance < closestDistance){
				closestBone = bone;
				closestDistance = intersections[i].distance;
			}
		}
		this.selectedBone = closestBone;
		if (closestBone !== null){
			console.log("Clicked on " + this.selectedBone.name);
		}
	},

	onMiddleClick: function(mouseX, mouseY, event){
		console.log("Middle click");
	},

	onMouseMove: function(event){
		this.mouseX = event.clientX;
		this.mouseY = event.clientY;

		if (this.rotateMode){
			var factor = 500.0;

			var dx = (this.mouseX - this.rotateOriginX);
			var dy = (this.mouseY - this.rotateOriginY);
			var delta = Math.sqrt(dx * dx + dy * dy);
			console.log(delta);
			if (this.mouseX < this.rotateOriginX){
				delta *= -1;
			}

			var rotateAmount = delta / factor;
			this.selectedBone.rotation.setFromVector3(this.initialRotation);
			this.selectedBone.updateMatrix();

			if (this.rotationAxis == 'X'){
				//this.selectedBone.rotateX(delta/factor);
				this.selectedBone.rotateOnWorldAxis(this.X_AXIS, rotateAmount);
				//console.log("Rotate " + delta + " around X axis.");
			} else if (this.rotationAxis == 'Y'){
				//this.selectedBone.rotateY(delta/factor);
				this.selectedBone.rotateOnWorldAxis(this.Y_AXIS, rotateAmount);
				//console.log("Rotate " + delta + " around Y axis.");
			} else if (this.rotationAxis == 'Z'){
				//this.selectedBone.rotateZ(delta/factor);
				this.selectedBone.rotateOnWorldAxis(this.Z_AXIS, rotateAmount);
				//console.log("Rotate " + delta + " around Z axis.");
			} else {
				var cameraAxis = this.getClickVector(window.width/2, window.height/2, this.camera);
				this.selectedBone.rotateOnWorldAxis(cameraAxis, rotateAmount);


			}
		}
	},

	populateTabs: function(){
		var boneGroups = this.model.character.boneGroups.dict;
		for (var boneGroupUid in boneGroups){
			var boneGroup = boneGroups[boneGroupUid];
			this.meshesTabAddBoneGroup(boneGroupUid, boneGroup.name);
			//this.poseTabAddBoneGroup(boneGroupUid, boneGroupName);

			for (var meshName in boneGroup.meshes.dict){
				//TODO: add icon as well.
				this.meshesTabAddMesh(boneGroupUid, meshName, "stuff.png");
			}
		}
	},

	meshesTabAddBoneGroup: function(boneGroupUid, boneGroupName){
		var div = document.createElement('div');
		elementUid = "meshes-tab-" + boneGroupUid;
		div.className = "panel card clearfix";
		div.innerHTML = '<div class="card-header" role="tab" id="' + elementUid + '">\
				<h5>\
					<a class="collapsed" data-toggle="collapse" data-parent="#stuff-accordion" \
						href="#' + elementUid + '-data" aria-expanded="false" aria-controls="' + elementUid + '-data"> ' + boneGroupName + ' </a>\
				</h5>\
			</div>\
			<div id="' + elementUid + '-data" class="collapse scroll" role="tabpanel" aria-labelledby="' + elementUid + '">\
				<div class="card-block">\
				</div>\
			</div>';
		libraryPane = document.getElementById("body-accordion");
		libraryPane.insertBefore(div, libraryPane.childNodes[0]);

		// Add the '+' button
		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("data-mesh-bone-group", boneGroupUid);
		div.setAttribute("add-mesh-button", "stuff");
		div.innerHTML = '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Add-circular-button-thin-symbol.svg/2000px-Add-circular-button-thin-symbol.svg.png" style="width:40px;height:40px;" alt="other stuff">\
			<span class="label"> Add Mesh\
		</span>';

		document.getElementById(elementUid + '-data').children[0].appendChild(div);
	},

	meshesTabAddMesh: function(boneGroupUid, meshName, iconUrl){
		//TODO: Add icon
		boneGroupUid = "meshes-tab-" + boneGroupUid;

		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("meshes-tab-mesh", "stuff");
		div.setAttribute("data-mesh-bone-group", boneGroupUid);
		div.innerHTML = '<img src="stuff.png" alt="other stuff">\
			<span class="label">' + meshName + '\
		</span>';

		libraryPane = document.getElementById(boneGroupUid + '-data').children[0];
		libraryPane.insertBefore(div, libraryPane.childNodes[0]);
	},

	poseTabAddBoneGroup: function(boneGroupUid, boneGroupName){
		var div = document.createElement('div');
		boneGroupUid = "pose-tab-" + boneGroupUid;
		div.className = "panel card clearfix";
		div.innerHTML = '<div class="card-header" role="tab" id="' + boneGroupUid + '">\
				<h5>\
					<a class="collapsed" data-toggle="collapse" data-parent="#stuff-accordion" \
						href="#' + boneGroupUid + '-data" aria-expanded="false" aria-controls="' + boneGroupUid + '-data"> ' + boneGroupName + ' </a>\
				</h5>\
			</div>\
			<div id="' + boneGroupUid + '-data" class="collapse scroll" role="tabpanel" aria-labelledby="' + boneGroupUid + '">\
				<div class="card-block">\
				</div>\
			</div>';

		libraryPane = document.getElementById("pose-accordion");
		libraryPane.insertBefore(div, libraryPane.childNodes[0]);
	},

	poseTabAddPose: function(boneGroupUid, poseName, iconUrl){
		//TODO: Add icon
		boneGroupUid = "pose-tab-" + boneGroupUid;

		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("pose-tab-pose", "stuff");
		div.setAttribute("data-pose-bone-group", boneGroupUid);
		div.innerHTML = '<img src="stuff.png" alt="other stuff">\
			<span class="label">' + poseName + '\
		</span>';

		document.getElementById(boneGroupUid + '-data').children[0].appendChild(div);
	},

	boneGroupsTabAddBoneGroup: function(boneGroupUid, boneGroupName){
		var div = document.createElement('div');
		var boneGroupNameUnderscores = boneGroupName.replaceAll(' ', '__');
		elementId = "bone-groups-tab-" + boneGroupUid;
		div.className = "panel card clearfix";
		html = '<div class="card-header" role="tab" id="' + elementId + '">\
				<h5>\
					<a class="collapsed" data-toggle="collapse" data-parent="#stuff-accordion" \
						href="#' + elementId + '-data" aria-expanded="false" aria-controls="' + elementId + '-data"> ' + boneGroupName + ' </a>\
				</h5>\
			</div>\
			<div id="' + elementId + '-data" class="collapse scroll" role="tabpanel" aria-labelledby="' + elementId + '">\
				<div class="card-block">\
					<label id=' + elementId + '-bone-attach-label>Unattached</label>\
					<button type="button" class="btn btn-secondary btn-sm" onclick=clickedAttachBoneGroup(\'' + boneGroupUid + '\',\'' + boneGroupNameUnderscores + '\')>Attach To...</button>\
				</div>\
				<div class="card-block">\
					<button type="button" class="btn btn-secondary btn-sm" onclick=clickedRemoveBoneGroup(\'' + elementId + '\',\'' + boneGroupUid + '\')>Remove</button>\
				</div>\
			</div>';
		div.innerHTML = html;
		console.log(html);
		console.log('========');
		console.log(div.innerHTML);

		libraryPane = document.getElementById("bones-accordion");
		libraryPane.insertBefore(div, libraryPane.childNodes[0]);
	},

	libraryPopulateMeshes: function(){
		var metadata = model.getAvailableMeshes();
		for (var i = 0; i < metadata.length; i++){
			var meshMetadata = metadata[i];
			var category = meshMetadata.type;
			var element = document.getElementById(category + "-mesh-category");
			if (element === null){
				this.libraryAddCategory("mesh-library", category, category + "-mesh-category");
			}

			this.libraryAddMesh(category, meshMetadata);
		}
	},

	libraryPopulatePoses: function(){
		this.libraryAddCategory("pose-library", 'Poses', 'poses-pose-category');
		var dict = model.getAvailablePoses();
		for (var libraryName in dict){
			var poseMetadatas = dict[libraryName];
			for (var i = 0; i < poseMetadatas.length; i++){
				var poseMetadata = poseMetadatas[i];
				this.libraryAddPose('poses', poseMetadata);
			}
		}
	},

	libraryPopulateBoneGroups: function(){
		var dict = model.getAvailableBoneGroups();
		for (var libraryName in dict){
			var libraryMetadatas = dict[libraryName];
			for (var i = 0; i < libraryMetadatas.length; i++){
				var boneGroupMetadata = libraryMetadatas[i];
				var category = boneGroupMetadata.type;
				var element = document.getElementById(category + "-bone-category");
				if (element === null){
					this.libraryAddCategory("bone-library", category, category + "-bone-category");
				}

				this.libraryAddBoneGroup(category, boneGroupMetadata);
			}
		}
	},

	libraryAddCategory: function(libraryName, categoryName, categoryId){
		var div = document.createElement('div');
		div.className = "panel card clearfix";
		div.innerHTML = '<div class="card-header" role="tab" id="' + categoryId + '">\
				<h5>\
					<a class="collapsed" data-toggle="collapse" data-parent="#stuff-accordion" \
						href="#' + categoryId + '-data" aria-expanded="false" aria-controls="' + categoryId + '-data"> ' + categoryName + ' </a>\
				</h5>\
			</div>\
			<div id="' + categoryId + '-data" class="collapse scroll" role="tabpanel" aria-labelledby="' + categoryId + '">\
				<div class="card-block">\
				</div>\
			</div>';
		document.getElementById(libraryName).appendChild(div);
	}, 

	libraryAddMesh: function(category, meshMetadata){
		//TODO: Add icon
		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("data-mesh-id", "TODO");
		div.setAttribute("data-mesh-library", meshMetadata.library);
		div.setAttribute("data-mesh-mesh-name", meshMetadata.name);
		div.innerHTML = '<img src="stuff.png" alt="other stuff">\
			<span class="label">' + meshMetadata.name + '\
		</span>';

		document.getElementById(category + '-mesh-category-data').children[0].appendChild(div);
	},

	libraryAddPose: function(category, poseMetadata){
		//TODO: Add icon
		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("data-pose-id", "TODO");
		div.setAttribute("data-pose-library", poseMetadata.library);
		div.setAttribute("data-pose-pose-name", poseMetadata.name);
		div.innerHTML = '<img src="stuff.png" alt="other stuff">\
			<span class="label">' + poseMetadata.name + '\
		</span>';

		document.getElementById(category + '-pose-category-data').children[0].appendChild(div);
	},

	libraryAddBoneGroup: function(category, boneMetadata){
		//TODO: Add icon
		var div = document.createElement('div');
		div.className = "mini-select col-md-3";
		div.setAttribute("data-bone-id", "TODO");
		div.setAttribute("data-bone-library", boneMetadata.library);
		div.setAttribute("data-bone-bone-name", boneMetadata.name);
		div.innerHTML = '<img src="stuff.png" alt="other stuff">\
			<span class="label">' + boneMetadata.name + '\
		</span>';

		document.getElementById(category + '-bone-category-data').children[0].appendChild(div);
	}
};

function onMouseDown(event){

	//make it so i can still pull up the JS console by using shift-right-click
	//make it so you can click on UI
	//TODO: Test this in multiple browsers
	/*var target = event.originalEvent || event.originalTarget;
	if (event.shiftKey || ! $(target.srcElement || target.originalTarget).is('canvas') ) {

		//if you hold down shift or cick on anything other than the canvas do the normal thing
		console.log("don't prevent me");

	} else {

		//if you're holding down shift or you click on a canvas element, don't do the normal thin
		event.preventDefault();
	}*/

	if (event.button === 0){
		view.onLeftClick(event.clientX, event.clientY, event);
	} else if (event.button == 1){
		view.onMiddleClick(event.clientX, event.clientY, event);
	} else if (event.button == 2){
		view.onRightClick(event.clientX, event.clientY, event);
	}
}

function onMouseMove(event){
	//TODO: this was generating errors and was commented out
	//view.onMouseMove(event.clientX, event.clientY);
}

function onKeyDown(event){

	//check to see if you're typing in a input or form field, if so skip this event
	var target = event.target;
	if ( $(target).is('input') || $(target).is('textarea') ) {
		//continue bubling up the event chain, but don't do this method
		return true;
	}

	var keynum;	

    if(window.event) { // IE                    
      keynum = event.keyCode;
    } else if(event.which){ // Netscape/Firefox/Opera                   
      keynum = event.which;
    }

    var letter = String.fromCharCode(keynum);

    if (letter == 'Q' || letter == 'q'){
    	view.toggleBoneHandlesVisible();
    } else if (letter == 'R' || letter == 'r'){
    	view.startBoneRotate();
    } else if ('XxYyZz'.indexOf(letter) != -1){
    	view.setRotationAxis(letter);
    } else if (letter == "p" || letter == "P"){
    	//TODO: Make this update the photo_render
    	var dataUrl =  window.view.renderer.domElement.toDataURL("image/png");
    	console.log(dataUrl);
    }
}

document.addEventListener('mousedown', onMouseDown, false);
document.onmousemove = onMouseMove;
document.addEventListener('keydown', onKeyDown, false);
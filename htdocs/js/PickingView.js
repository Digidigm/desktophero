function PickingView(){
	this.scene = new THREE.Scene();
	this.colorIdMap = {};

	this.scene.add(new THREE.AmbientLight(0x555555));

	this.pickingTexture = new THREE.WebGLRenderTarget( window.innerWidth, window.innerHeight );
	this.pickingTexture.texture.minFilter = THREE.LinearFilter;

	this.meshIdMap = {};
}

PickingView.prototype = {

	getUnusedColor: function(){
		var randomColor = '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
		while (this.colorIdMap.keys().contains(randomColor)){
			var randomColor = '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
		}

		return randomColor;
	}, 

	addMesh: function(mesh, boneGroup){
		function applyVertexColors( g, c ) {
			g.faces.forEach( function( f ) {
				var n = ( f instanceof THREE.Face3 ) ? 3 : 4;
				for( var j = 0; j < n; j ++ ) {
					f.vertexColors[ j ] = c;
				}
			});
		}

		// Find a unique color/id for this mesh
		var color;
		var id = undefined;
		while (id == undefined || id in this.meshIdMap){
			color = new THREE.Color(Math.random() * 0xffffff);
			// Create id from RGB color values
			var r = (color.r * 255);
			var g = (color.g * 255);
			var b = (color.b * 255);
			var id = ( r << 16 ) | ( g << 8 ) | ( b );
		}

		var pickingMesh = mesh.clone(); //new THREE.SkinnedMesh(pickingGeometry, pickingMaterial);
		pickingMesh.material = pickingMesh.material.clone();
		pickingMesh.material.materials = [PickingView.pickingMaterial];
		
		applyVertexColors( pickingMesh.geometry, color);
		boneGroup.attachPickingMesh(pickingMesh);

		this.meshIdMap[id] = mesh.name;
		this.scene.add(pickingMesh);
	}
}

// Class properties/functions

PickingView.pickingMaterial = new THREE.MeshBasicMaterial( { vertexColors: THREE.VertexColors } );
PickingView.pickingMaterial.skinning = true;

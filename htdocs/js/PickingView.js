function PickingView(){
	this.scene = new THREE.Scene();
	this.colorIdMap = {};

	this.scene.add(new THREE.AmbientLight(0x555555));
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

		/*var pickingGeometry = new THREE.Geometry();
		var pickingMaterial = new THREE.MeshBasicMaterial({vertexColors: THREE.VertexColors });

		pickingGeometry.merge(mesh.geometry, mesh.matrixWorld)
		pickingGeometry.bones = mesh.geometry.bones.slice();
		pickingGeometry.skinIndices = mesh.geometry.skinIndices.slice();
		pickingGeometry.skinWeights = mesh.geometry.skinWeights.slice();*/

		function applyVertexColors( g, c ) {
			g.faces.forEach( function( f ) {
				var n = ( f instanceof THREE.Face3 ) ? 3 : 4;
				for( var j = 0; j < n; j ++ ) {
					f.vertexColors[ j ] = c;
				}
			});
		}

		var pickingMesh = mesh.clone(); //new THREE.SkinnedMesh(pickingGeometry, pickingMaterial);
		pickingMesh.material = pickingMesh.material.clone();
		pickingMesh.material.materials = [PickingView.pickingMaterial];

		var color = new THREE.Color(Math.random() * 0xffffff);
		applyVertexColors( pickingMesh.geometry, color);
		boneGroup.attachPickingMesh(pickingMesh);

		this.scene.add(pickingMesh);
	}
}

// Class properties/functions

PickingView.pickingTexture = new THREE.WebGLRenderTarget( window.innerWidth, window.innerHeight );
PickingView.pickingTexture.texture.minFilter = THREE.LinearFilter;
PickingView.pickingMaterial = new THREE.MeshBasicMaterial( { vertexColors: THREE.VertexColors } );
PickingView.pickingMaterial.skinning = true;

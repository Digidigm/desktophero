function init(){

	var world = new SceneModel();
	var view = new SceneView(world);

	view.init();
	view.animate();

	$("#editor").append(view.renderer.domElement);
}

$(document).ready(init);

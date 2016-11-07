<header class="bg-inverse text-center center-vertically" role="banner">
  <div class="editor-container">
    <div id='threejs-demo'>
	<div id='editor'> </div>
  </div>
  
</header>

<!--Feature Specific Scripts (be sure they load after the js in the footer with document.ready-->
<script src="/vendor/threejs/build/three.js"></script>
<script src="/vendor/threejs/external/OrbitControls.js"></script>
<script src="/vendor/threejs/external/STLExporter.js"></script>

<script src="/js/Editor.js"></script>
<script src="/js/UserSettings.js"></script>
<script src="/js/LocalDataSource.js"></script>
<script src="/js/SceneModel.js"></script>
<script src="/js/SceneView.js"></script>
<script src="/js/Character.js"></script>
<script src="/js/BoneGroup.js"></script>
<script src="/js/Pose.js"></script>
<script src="/js/Materials.js"></script>

<script src="/js/Event.js"></script>
<script src="/js/ObservableDict.js"></script>
<script src="/js/ObservableList.js"></script>

<script src="/js/FileSaver.js"></script>
<script src="/js/Global.js"></script>


<style type="text/css">
	body {
		overflow: hidden;
		color: #000;
		font-family:Monospace;
		font-size:13px;
		text-align:center;
		background-color: #000;
		margin: 0px;
	}
	.dg {margin-top: 5%;}
	.section-footer { display:  none;}
</style>
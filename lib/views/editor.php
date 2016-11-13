<div class="bg-inverse text-center center-vertically" role="banner">
  <div class="editor-container">
    <div id="threejs-demo"> </div>
	<div id="editor"> </div>
  </div>
</div>


<script>

var bodyMap = {};  //an object with a persistent rendering of the current model configuration as defined in the UI
var modelMap = {};  //an object iwth a persistent list of the models available for each attachment / category
modelMap.presets = {};  //object that contains the presets data
modelMap.mids = {}; //object that sorts the models by their model id, duplicate of the data in the attachment/category object, just organized differently
modelMap.tags = {}; //object that lists the model ids inside each tag id.  updated whenever a query is made against an empty tag

//works for things in a flat list with the tag table name currently
var getSimpleItems = function(url,target){
	$.getJSON(url, function( tags ){
		//Get all the Genre Tags.  These will be used as macro filters for all the other lists
		var slides = "";
		$.each( tags, function(k,v){
			slides += "<div class='mini-select col-md-2' data-tag-id='" +v.id+ "'> <img src='" +v.thumbnail+ "' alt='" + v.tag_hint + "'><span class='label'>"+ v.tag_label +"</span></div>\n" ;
		});

		$("#"+target).html(slides);

	});
};

var getModelsForTags = function(url, tid, cb) {
	
	//if the tag id isn't in the data model yet, then get it
	if (! (tid in modelMap.tags) ) {
		$.getJSON(url, function(tags){
			var modelsForTags = [];
		
			$.each(tags, function(k,v){
				modelsForTags.push(v.model_id);
			});

			modelMap.tags[tid] = modelsForTags;
			
		}).always(function(){
			//once the model is full, execute the callback function requested and exit
			if(cb) cb(tid);
			return;
		});			
	} else {
		//if we already have the tags, then just execute the callback funciton
		if(cb) cb(tid);	
	}
	
};

//works for models
var getTabbedItems = function(url,target,key) {
	
	$.getJSON(url, function( data ){
	
		
		var tabs = "<ul class='nav nav-tabs' id='"+target+"-tabs'>";
		var content = "<div class='tab-content clearfix'>";
		modelMap[key] = data[key];  //add or reset the attachment key for the persistent model, eg "head"

		$.each( data[key], function(k,v){
			//make a new tab
			var slides = "";

			tabs += "<li role='presentation' class='nav-item'><a class='nav-link' href='#panel-"+v[0].model_category+"' data-toggle='tab'>"+ v[0].model_category +"</a></li>";
			var panel = "<div class='tab-pane fade' id='panel-"+ v[0].model_category+"' role='tabpanel'>";

			$.each( v, function(kk,vv){
				//make a new slide
				slides += "<div class='mini-select col-md-3' data-model-id='" +vv.id+ "'> <img src='" +vv.photo_thumbnail+ "' alt='" + vv.model_name + "'><span class='label'>"+ vv.model_name +"</span></div>\n";
				modelMap.mids[vv.id] = vv;
			});

			content += panel += slides += "</div>";
		});

		tabs += "</ul>";
		content += "</div>";
		tabs += content;

		$("#"+target).html(tabs);
		$("#"+target + "-tabs li a").click(function (e) {
  			e.preventDefault();
  			$(this).tab('show');
		});
		$("#"+target + "-tabs li:first a").tab('show');
	});
};

//get the presests from the table and lays them out with some special rules
var getPresets = function() {
	$.getJSON("/api/v1/preset/all", function( presets ){
		//Get all the Presets.  These will sort into a morph target tab
		
		var tabs = "<ul class='nav nav-tabs' id='editor-presets-data-tabs'>";
		var content = "<div class='tab-content clearfix'>";
		modelMap.presets.morph = presets.morph;

		$.each( presets.morph, function(k,v){
			//make a new tab
			var slides = "";

			tabs += "<li role='presentation' class='nav-item'><a class='nav-link' href='#panel-"+v[0].preset_category+"' data-toggle='tab'>"+ v[0].preset_category +"</a></li>";
			var panel = "<div class='tab-pane fade' id='panel-"+ v[0].preset_category+"' role='tabpanel'>";

			$.each( v, function(kk,vv){
				//make a new slide
				slides += "<div class='mini-select col-md-3' data-tag-id='" +vv.id+ "'> <img src='" +vv.photo_thumbnail+ "' alt='" + vv.preset_name + "'><span class='label'>"+ vv.preset_name +"</span></div>\n";
			});

			content += panel += slides += "</div>";
			
		});

		tabs += "</ul>";
		content += "</div>";
		tabs += content;

		$("#editor-presets-data").html(tabs);
		$('#editor-presets-data-tabs li a').click(function (e) {
  			e.preventDefault();
  			$(this).tab('show');
		});
		$("#editor-presets-data-tabs li:first a").tab('show');
	});
};

$(document).ready( function(){
	//keep it all using the REST apis rather than a combination of internal and external functions
	//TODO: turn these into knockout modules if it makes sense

	//GET ALL GENRE TAGS
	getSimpleItems("/api/v1/tags/by/genre","editor-genre-data");

	//GET ALL PRESETS
	getPresets();

	//GET ALL HEAD MESHES
	getTabbedItems("/api/v1/model/by/head/mesh","editor-head-data","head");

	//GET ALL ARMS MESHES
	getTabbedItems("/api/v1/model/by/arms/mesh","editor-arms-data","arms");

	//GET ALL HANDS MESHES
	getTabbedItems("/api/v1/model/by/hands/mesh","editor-hands-data","hands");

	//GET ALL CHEST / UPPER BODY MESHES
	getTabbedItems("/api/v1/model/by/chest/mesh","editor-chests-data","chest");

	//GET ALL LEGS / LOWER BODY MESHES
	getTabbedItems("/api/v1/model/by/legs/mesh","editor-legs-data","legs");

	//GET ALL FEET and FOOTWare BODY MESHES
	getTabbedItems("/api/v1/model/by/feet/mesh","editor-feet-data","feet");

	//GET ALL FEET and FOOTWare BODY MESHES
	getTabbedItems("/api/v1/model/by/base/mesh","editor-bases-data","base");

	//GET ALL POSES
	getTabbedItems("/api/v1/model/by/pose/pose","editor-poses-data","pose");

	//DO SOMETHING IF YOU CLICK ON A MODEL
	$("#editor-accordion").on("click",".mini-select[data-model-id]", function(e){
		var mid = $(this).data("model-id");
		alert("You clicked model: " + mid );
		//console.log( modelMap.mids[mid] );

		$(this).toggleClass("ui-selected");

		//TODO: call a function that affects the scene, add or remove the model from the figure
		//TODO: call a function that updates the current bodyMap

	});

	//DO SOMETHING IF YOU CLICK A FILTER
	$("#editor-accordion").on("click",".mini-select[data-tag-id]", function(e){

		//Tag ID of the filter is recorded on the element
		var tid = $(this).data("tag-id");
		alert("You clicked to filter on: " + tid );

		//Give it a nice UI decoration so you know you clicked it
		$(this).toggleClass("ui-selected");

		//GET ALL THE MODEL IDs WITH THAT TAG (if you've already done that call, this function will use the cached result)
		var url = "/api/v1/model/tags/" + tid;
		getModelsForTags(url,tid,function(){

			//now that we have the list, toggle UI elements without this tag
			//console.log(modelMap.tags[tid]);

			//find all mini-select items in the UI then filter them down to ones that are not in the list from the modelMap.tags data model 
			$(".mini-select[data-model-id]").filter( function(){
				//if it's -1, it's not in the list of approved models to show and it should have it's visibility toggled
				//remember the ids are stored as strings right now because they're properties not array indecies
				return modelMap.tags[tid].indexOf( $(this).data('model-id').toString() ) == -1;
				
			}).toggleClass("hidden");
		});
	});



});
</script>



<div id="editor-accordion" class="col-md-4" role="tablist" aria-multiselectable="true">

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-genre">
      <h5>
        <a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-genre-data" aria-expanded="true" aria-controls="editor-genre-data"> Genre Filter </a>
      </h5>
    </div>
    <div id="editor-genre-data" class="collapse in scroll" role="tabpanel" aria-labelledby="editor-genre">
        <!--Filled by AJAX: getSimpleItems("/api/v1/tags/by/genre","#editor-genre-data"); -->
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-presets">
      <h5>
        <a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-presets-data" aria-expanded="true" aria-controls="editor-presets-data"> Figure Characteristics </a>
      </h5>
    </div>
    <div id="editor-presets-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-presets">
        <!--Filled by AJAX: getPresets(); -->
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-heads">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-head-data" aria-expanded="false" aria-controls="editor-head-data"> Heads </a>
      </h5>
    </div>
    <div id="editor-head-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-head">
      <div class="card-block">
         <!-- FILLED BY AJAX: getTabbedItems("/api/v1/model/by/head/mesh","#editor-head-data","head"); -->
      </div>
    </div>
  </div>
  
  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-arms">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-arms-data" aria-expanded="false" aria-controls="editor-arms-data"> Arms </a>
      </h5>
    </div>
    <div id="editor-arms-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-arms">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/arms/mesh","editor-arms-data","arms"); -->
      </div>
    </div>
  </div>

   <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-hands">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-hands-data" aria-expanded="false" aria-controls="editor-hands-data"> Hands &amp; Items </a>
      </h5>
    </div>
    <div id="editor-hands-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-hands">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/hands/mesh","editor-hands-data","hands"); -->
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-chests">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-chests-data" aria-expanded="false" aria-controls="editor-chests-data"> Upper Body </a>
      </h5>
    </div>
    <div id="editor-chests-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-chests">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/chests/mesh","editor-chests-data","chests"); -->
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-legs">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-legs-data" aria-expanded="false" aria-controls="editor-legs-data"> Lower Body </a>
      </h5>
    </div>
    <div id="editor-legs-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-legs">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/legs/mesh","editor-legs-data","legs"); -->
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-feet">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-feet-data" aria-expanded="false" aria-controls="editor-feet-data"> Feet & Footware </a>
      </h5>
    </div>
    <div id="editor-feet-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-feet">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/feet/mesh","editor-feet-data","feet"); -->
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-base">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-bases-data" aria-expanded="false" aria-controls="editor-bases-data"> Bases </a>
      </h5>
    </div>
    <div id="editor-bases-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-bases">
      <div class="card-block">
        <!-- getTabbedItems("/api/v1/model/by/base/mesh","editor-bases-data","base"); -->
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-poses">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-poses-data" aria-expanded="false" aria-controls="editor-poses-data"> Poses </a>
      </h5>
    </div>
    <div id="editor-poses-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-poses">
      <div class="card-block">
        List of Figure Poses
      </div>
    </div>
  </div>

  <div class="panel card clearfix">
    <div class="card-header" role="tab" id="editor-print">
      <h5>
        <a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-print-data" aria-expanded="false" aria-controls="editor-print-data"> Size, Print, Material </a>
      </h5>
    </div>
    <div id="editor-print-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-print">
      <div class="card-block">
        Size, Print, Material
      </div>
    </div>
  </div>

</div>

<!--Feature Specific Scripts (be sure they load after the js in the footer with document.ready-->
<script src="/vendor/threejs/build/three.js"></script>
<script src="/vendor/threejs/external/OrbitControls.js"></script>
<script src="/vendor/threejs/external/STLExporter.js"></script>

<script src="/js/bootstrap/tab.js"></script>

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

	#editor-accordion { top: 15%; right:  0; position: absolute; }
	#editor-accordion .card {background-color:  #7B7B73; }
	#editor-accordion .card .label {margin-bottom: 0; padding: 0 !important; margin-left: -5px; text-align: center; width: 100%;}
	#editor-accordion .card .scroll {max-height: 200px; overflow: scroll; }
	#editor-accordion .card .mini-select { cursor:  pointer; transition:  background-color 0.5s ease;  background-color: transparent; padding: 10px 10px 0 10px;}
	#editor-accordion .card .mini-select.hidden { display:none;}
	#editor-accordion .card .mini-select:hover { background: #ccc; }
	#editor-accordion .card-header { padding: 0.1rem 1.25rem; margin-bottom: 10px}
	#editor-accordion .card-header h5 { margin: 0 !important;}
	#editor-accordion .card-header a { display: block; padding: 0.1rem 1.25rem; margin: -0.1rem -1.25rem; border: none; outline: none;}
	#editor-accordion .ui-selected {box-shadow: 0px 0px 5px #fff; }
	#editor-accordion .ui-selected:after {
		background: rgba(0, 0, 0, 0) url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgd2lkdGg9IjM2My4wMjVweCIgaGVpZ2h0PSIzNjMuMDI0cHgiIHZpZXdCb3g9IjAgMCAzNjMuMDI1IDM2My4wMjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM2My4wMjUgMzYzLjAyNDsiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxnPg0KCQkJPHBhdGggc3R5bGU9ImZpbGw6IzAzMDMwMzsiIGQ9Ik0xODEuNTEyLDM2My4wMjRDODEuNDMsMzYzLjAyNCwwLDI4MS42MDEsMCwxODEuNTEzQzAsODEuNDI0LDgxLjQzLDAsMTgxLjUxMiwwDQoJCQkJYzEwMC4wODMsMCwxODEuNTEzLDgxLjQyNCwxODEuNTEzLDE4MS41MTNDMzYzLjAyNSwyODEuNjAxLDI4MS41OTUsMzYzLjAyNCwxODEuNTEyLDM2My4wMjR6IE0xODEuNTEyLDExLjcxDQoJCQkJQzg3Ljg4LDExLjcxLDExLjcxLDg3Ljg4NiwxMS43MSwxODEuNTEzczc2LjE3LDE2OS44MDIsMTY5LjgwMiwxNjkuODAyYzkzLjYzMywwLDE2OS44MDMtNzYuMTc1LDE2OS44MDMtMTY5LjgwMg0KCQkJCVMyNzUuMTQ1LDExLjcxLDE4MS41MTIsMTEuNzF6Ii8+DQoJCTwvZz4NCgk8L2c+DQoJPGc+DQoJCTxwb2x5Z29uIHN0eWxlPSJmaWxsOiMwMzAzMDM7IiBwb2ludHM9IjE0Ny45NTcsMjU4LjkzNSA4My4wNjgsMTk0LjA0NiA5MS4zNDgsMTg1Ljc2NyAxNDcuOTU3LDI0Mi4zNzUgMjcxLjE3MSwxMTkuMTY2IA0KCQkJMjc5LjQ1MSwxMjcuNDQ1IAkJIi8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=") no-repeat scroll 0 0 / contain ;content: "";display: block;height: 50%;left: 25%;position: absolute;top: 15%;width: 50%;}
	
</style>
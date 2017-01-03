<style type="text/css">

	body {overflow: hidden;color: #000;background-color: #000;margin: 0px;}

	select.form-control:not([size]):not([multiple]) {height: auto;}
	#editor-accordion .form-control {padding: 0.1rem;}
	#editor-accordion .card .scroll { max-height: none; overflow: hidden; font-size: 0.8rem;}
	.form-control {font-size: 0.8rem;}
	label {margin-bottom: 0.35rem;}

	.bg-inverse-custom { margin-top:  auto; }
	.container {max-width: 100%; width: 1140px;}
	.card-block span.filename {border: none; border-radius: 0; display: inline; font-size: 1em; height: auto; line-height: 1em; margin: auto; text-align: left; width: auto; color: white; font-weight: bold;}
</style>


<div class="bg-inverse text-center center-vertically" role="banner">
  <div class="editor-container">
	<div id="editor"> </div>
  </div>
</div>


<script>

s3FormDetails = {};

myModel = {};       //object that will have all our model modification methods in it
myModel.id = null;  //all the defaults
myModel.raw_data = "";  //this will hold the string data from the file the user wants to upload
myModel.data  = {}
myModel.data.model = null;
myModel.data.photo = null;
myModel.model_name = "";
myModel.model_category = "";
myModel.model_type = "";
myModel.model_attachment = "";
myModel.model_data = "";
myModel.model_story = "";
myModel.model_short_desc = "";
myModel.model_url = "";
myModel.photo_render = "";
myModel.photo_inspiration = "";
myModel.photo_thumbnail = "";
myModel.flag_chirality = "N";
myModel.flag_nsfw_sex = 0;
myModel.flag_nsfw_violence = 0;
myModel.flag_nsfw_other = 0;
myModel.flag_deleted = 0;
myModel.flag_hidden = 1;
myModel.flag_featured = 0;
myModel.flag_private = 1;
myModel.flag_date_created = Math.floor(Date.now() / 1000);
myModel.flag_date_updated = Math.floor(Date.now() / 1000);
myModel.count_downloads = 0;
myModel.count_views = 0;
myModel.editable = ["model_name","model_data","model_category","model_type","model_attachment","model_url","flag_chirality","model_story","model_short_desc","photo_thumbnail","photo_inspiration","photo_render","flag_nsfw_sex","flag_nsfw_violence","flag_nsfw_other","flag_private","flag_featured","flag_hidden","flag_deleted"]; //this isn't secure, it's convenient.  security is handled serverside

user = {};      //object that will have the (untrusted) user information in it

//for uploader
filesUploaded = [];
folders = [];

//SETUP THE myModel METHODS
myModel.id = <?php echo $model_id; ?>;
user.id = <?php echo $user_id; ?>;


//gets encrypted magic form data for uploading images and models
$.get("/api/v1/uploads",function(data){
 	s3FormDetails = data;
},"json");

myModel.create = function( cb ){

	//If the model is already there, just pass through with the callback
	if ( parseInt(myModel.id) ) {
		if (cb) {cb();}
		return;
	}

	//POST a new model to get an ID
	$.ajax({
		type: "POST",
		url: '/api/v1/model',
		data: {},
		success: function(data) {
		  //Set the new ID to the returned modelID
		  myModel.id = data.id;
		  uilog("New Entry Created");
		  if (cb) cb();
		},
		async: false,
		dataType: "json"
	});
};

myModel.get = function(){

	//GET an existing model
	$.ajax({
		type: "GET",
		url: "/api/v1/model/"+myModel.id,
		success: function(data) {

		  //go through each field in the editable list and stash the data in our model object
		  for (var i in myModel.editable) {
			k = myModel.editable[i];
			myModel[k] = data[k];
		  }
		  //make sure the UI matches the truth in the model object
		  uilog("Model Loaded");
		  myModel.refreshUI();
		},
		async: false,
		dataType: "json"
	});
};

myModel.uploadFile = function(form, bucket, url_property, cb) {
	//form = the form data that as the jquery.fileformuplaoder stored in it see
	//bucket = the subdirectory on S3 to store this in
	//url_property what property in myModel needs the url if this upload was successful
	//cb the callback function so this happens sequentially

	if (form) {
		var file = form.files[0];
		var __file_key = bucket + "/"+ user.id + "." + myModel.id + "." + file.name;

		var formData = new FormData();
	    formData.append('key', __file_key);
	    formData.append('AWSAccessKeyId', s3FormDetails.AWSAccessKeyId);
	    formData.append('acl', s3FormDetails.acl);
	    formData.append('policy', s3FormDetails.policy);
	    formData.append('signature', s3FormDetails.signature);
	    formData.append('Content-Type', file.type);
	    formData.append('success_action_redirect', s3FormDetails.success_action_redirect);
	    formData.append('file', file);

	    //send it off to S3
		$.ajax({
			url: s3FormDetails.url,
			type: "POST",
			async: false,
			data: formData,
			contentType: false,
			processData: false,
			success: function(){
				myModel[url_property] = "https://desktop-hero.s3.amazonaws.com/" + __file_key;
				uilog(file.name + " Uploaded");
				
				//if a callback fuction is specified, run it (see figure.save)
				if (cb) { cb(); }
			}
		});
	} else {
		if (cb) { cb(); }
	}
};


myModel.update = function(){

	//..upload the model if it's new, otherwise passthrough
	myModel.uploadFile(myModel.data.model,"models", "model_url", function(){

		//...then upload the inspiration if it's new, otherwise passthrough
		myModel.uploadFile(myModel.data.photo,"inspiration", "photo_inspiration", function(){
		
			//..then save all this stuff into our DB
			//PUT to update an existing model with new data from the myModel object
			//Filter the things out of model that we don't want to send to the server
			var out = {};
			for (var i in myModel){
				if (myModel.editable.indexOf(i) !== -1 ) {
					out[i] = myModel[i];
				}
			}

			$.ajax({
				type: "PUT",
				headers: {"X-HTTP-Method-Override": "PUT"},
				url: '/api/v1/model/' + myModel.id,
				contentType: "x-www-form-urlencoded",
				data: out,
				success: function(data) {
				  uilog("Model Data Sent To Server.");
				  myModel.refreshUI();
				},
				async: false,
				dataType: "json"
			});
		});
	});
};

myModel.delete = function(){

};

myModel.refreshUI = function(){

  //all text and text areas
  $("[data-bind]").each( function(i){
	var key = $(this).data('bind');
	$(this).val( myModel[key] );
  });

  //all photos
  $("[data-photo]").each( function(i){
	var key = $(this).data('photo');
	$(this).attr("src", myModel[key] );
  });

  $("[data-file]").each(function(i){
  	var key = $(this).data('file');
	$(this).html( myModel[key] );
  });

  //all file uploads should be blanked out
  $('[type="file"]').val("");

  //remove old file upload bars
  $('.progress-bar-area').empty();
};

myModel.screenCap = function(cb){
	//Take a screencap of the model for our purposes
	var data =  dataURItoBlob( window.view.renderer.domElement.toDataURL("image/png") );
	var __file_key = "captures/"+ user.id + "." + myModel.id + "screencap.png";

	//setup the form with the magic input
	var formData = new FormData();
	formData.append('key', __file_key);
	formData.append('AWSAccessKeyId', s3FormDetails.AWSAccessKeyId);
	formData.append('acl', s3FormDetails.acl);
	formData.append('policy', s3FormDetails.policy);
	formData.append('signature', s3FormDetails.signature);
	formData.append('Content-Type', "image/png");
	formData.append('success_action_redirect', s3FormDetails.success_action_redirect);
	formData.append('file', data);

	//send it off to S3
  	$.ajax({
		url: s3FormDetails.url,
		type: "POST",
		async: false,
		data: formData,
		contentType: false,
		processData: false,
		success: function(){
	  		myModel.photo_render = "https://desktop-hero.s3.amazonaws.com/" + __file_key;
	  		uilog("Screen Cap created");
	  
	  		//if a callback fuction is specified, run it (see myModel.save)
	  		if (cb) { cb(); }
		}
	});
};

//when you click the save button
myModel.save = function() {

	//if the myModel doesn't exist, it will create it, otherwise pass through
	myModel.create( function(){
		//then get and save a screencap to s3
		myModel.screenCap( function(){
			//then when that is done, call the update process
			myModel.update();
			uilog("Model Saved");
		});
	});
};

//Set the scene with the test data you've specified in the uploader
myModel.loadScene = function() {
	//SceneModel.boneGroupsToLoad = ['left arm','right arm','torso','head','neck','handheld'];
	//SceneModel.initialPose = 'amazing pose';

	SceneModel.boneGroupsToLoad = [$("#sample-bone-groups").val()];
	SceneModel.initialPose = $("#sample-pose").val();
	uilog("Scene updated with your model");
	//TODO: Load the model from the file you've selected.  I Don't know how to do this and SceneView-model.js confuses me a great deal.
	//THE MODEL IS STORED IN model.raw_data 
};

//Check to see if we are editing a model or creating a new one
if (myModel.id) {
	uilog("Geting your model!");
	//TODO: create load model process
	myModel.get();
	//Load it into the canvas
	uilog("Editing Model ID:" + myModel.id);
} else {
	uilog("Upload a new model!");
}


//works for things in a flat list with the tag table name currently
var getGenres = function(url,target){
	$.getJSON(url, function( tags ){
		//Get all the Genre Tags.  These will be used as macro filters for all the other lists
		var slides = "";
		$.each( tags, function(k,v){
		  slides += "<div class='mini-select col-md-3' data-tag-id='" +v.id+ "'> <img src='" +v.thumbnail+ "' alt='" + v.tag_hint + "'><span class='label'>"+ v.tag_label +"</span></div>\n" ;
		});
		$("#"+target).html(slides);
  	});
};





$(document).ready( function(){

	//ATTACH SPINNERS TO AJAX EVENTS
	$(document).ajaxSend(function () {
		loader.show();
	}).ajaxComplete(function () {
		loader.hide();
	});
	loader.hide();

	//keep it all using the REST apis rather than a combination of internal and external functions
	//TODO: turn these into knockout modules if it makes sense

	//Create a running narrative of what's happening for users in the UI console
	clearuilog();
	uilog( "User ID is: " + user.id);
	uilog( "Model ID is: " + myModel.id);

	//now that all the HTML is present, make sure to refresh the UI
	myModel.refreshUI();

	//DO SOMETHING IF YOU TYPE IN A FIELD
	//This just real time saves what you're typing into the object
	$("[data-bind]").on("keyup", function(){
		key = $(this).data("bind");
		value = $(this).val();
		myModel[key] = value;
	}).on("change", function(){
		key = $(this).data("bind");
		value = $(this).val();
		myModel[key] = value;
	});

	//ADJUST THE PANELS WHEN YOU SELECT A MODEL TYPE
	$("#model-type-select").on("change",function(){
		//only show the panel that pertains to your model type
		var val = $(this).val();
		$("[data-model-type]").hide();
		$("[data-model-type=" + val +"]").fadeIn();
	});
  
  	//HANDLE SELECTING A MODEL OR A SOURCE IMAGE (DON'T UPLOAD IT YET) 
	$("[data-upload]").fileupload({
		autoUpload: false
	}).on('fileuploadadd', function (e, data) {
		var whence = $(this).data('upload');

		var file = data.files[0];
		uilog("Selected file " + file.name + " Size: " + file.size + "bytes");
		
		switch (whence) {
			case "model":
				//store all this file upload data in our singleton
				myModel.data.model = data;

				$("[data-file=model_url]").html(file.name);
				myModel.model_url = file.name;

				//get the files data and read it		
				var reader = new FileReader();
				reader.readAsText(file);

				reader.onload = function(e){
					//when the file is done being read from the local file system store the string in our singleton
					myModel.raw_data = e.target.result;
					console.log(myModel.raw_data);

					//TODO: make this actually load it in the scene.  but basically take all the info we've provided and fire up the renderer
					myModel.loadScene();
				};
			break;

			case "image":
				//store all this file upload data in our singleton
				$("[data-file=photo_inspiration]").html(file.name);
				myModel.data.photo = data;
				myModel.photo_inspiration = file.name;

			break;
		}
	});
	

  /*
  var __file_key = "";  //need a global place to store the file name between async actions TODO: Make this better
  //data-folder="inspiration" data-upload="image" data-for="photo_inspiration"
  $("[xxxxxdata-upload]").fileupload({
	url: s3FormDetails.url,
	type: "POST",
	datatype: 'xml',
	add: function(e, data) {

	  // Show warning message if your leaving the page during an upload.
	  window.onbeforeunload = function () {
				return 'You have unsaved changes.';
			};

			// Give the file which is being uploaded it's current content-type (It doesn't retain it otherwise)
			// and give it a unique name (so it won't overwrite anything already on s3).
			var file = data.files[0];
			var folder = $(this).data('folder');

			__file_key = folder +"/"+ user.id + "." + Date.now() + '.' + file.name;

			data.formData = {
			  "AWSAccessKeyId" : s3FormDetails.AWSAccessKeyId,
			  "acl" : s3FormDetails.acl,
			  "policy" : s3FormDetails.policy,
			  "signature" : s3FormDetails.signature,
			  'key' : __file_key,
		'Content-Type' : file.type,
		'success_action_redirect' : s3FormDetails.success_action_redirect
	  };

			// Actually submit to form to S3.
			data.submit();

			// Show the progress bar
			// Uses the file size as a unique identifier
			var bar = $('<div class="progress" data-mod="'+file.size+'"><div class="bar"></div></div>');
			$('.progress-bar-area').append(bar);
			bar.slideDown('fast');

	},
	progress: function(e, data) {
	  var percent = Math.round((data.loaded / data.total) * 100);
			$('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', percent + '%').html(percent+'%');
	},
	fail: function (e, data) {
	  window.onbeforeunload = null;
	  $('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', '100%').addClass('red').html('');

	},
	done: function (e, data) {
	  window.onbeforeunload = null;

		  // Upload Complete, show information about the upload in a textarea
		  // from here you can do what you want as the file is on S3
		  // e.g. save reference to your server using another ajax call or log it, etc.
		  var original = data.files[0];
		  var property = $(this).data('for');
		  var type = $(this).data('upload');
		  model[property] = s3FormDetails.url + "/" + __file_key;
		  model.update();
		  uilog(type + " Uploaded: " + original.name + " [" + original.size +"bytes]");
	}
  });*/
});

</script>

<div id="body-accordion-container" class="col-md-3">
  <h2 class="text-white"> Model Information </h2>
  <div class="panel with-nav-tabs panel-primary">
	<div class="panel-heading">
		<ul class="nav nav-tabs">
		  <li class="nav-item"><a href="#tab1primary" class="nav-link active" data-toggle="tab">Mesh</a></li>
		  <li class="nav-item"><a href="#tab2primary" class="nav-link" data-toggle="tab">Pose</a></li>
		  <li class="nav-item"><a href="#tab3primary" class="nav-link" data-toggle="tab">Bone</a></li>
		</ul>
	</div>
	<div class="panel-body">
	  <div class="tab-content">
		<div class="tab-pane in active" id="tab1primary">
		  <div class="info-pane" id="mesh-info">
			<h5>Mesh Information</h5>

		  </div>
		</div>
		<div class="tab-pane" id="tab2primary">
		  <div class="info-pane" id="pose-info">
			<h5>Pose Information</h5>

		  </div>
		</div>
		<div class="tab-pane" id="tab3primary">
		  <div class="info-pane" id="bone-info">
			<h5>Bone Information</h5>

		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>




<div id="editor-accordion" class="col-md-3" role="tablist" aria-multiselectable="true">
  	<h2 class="text-white"> Model Upload</h2>
	<div class="panel card clearfix">
		<div class="card-header" role="tab" id="editor-model">
		 	<h5><a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-model-data" aria-expanded="true" aria-controls="editor-model-data"> Step 1: Choose Model </a></h5>
		</div>
		<div id="editor-model-data" class="collapse active scroll" role="tabpanel" aria-labelledby="editor-model">
			<div class='card-block'>
				<div class="form-group">
				    <label for="model-type-select">Model Type</label>
				    <select class="form-control" id="model-type-select" data-object='myModel' data-bind='model_type'>
					    <option value='mesh'>Mesh</option>
					    <option value='skeleton'>Skeleton</option>
					    <option value='pose'>Pose</option>
				    </select>
				</div>
			</div>
		</div>
	</div>

	<div class="panel card clearfix" data-model-type='mesh'>
		<div class="card-header" role="tab" id="editor-mesh">
			<h5><a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-mesh-data" aria-expanded="false" aria-controls="editor-mesh-data" > Step 2: Provide Mesh Info </a></h5>
		</div>
		<div id="editor-mesh-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-mesh">
			<div class='card-block'>

				<div class="form-group">
				    <label for="sample-bone-group">Sample Bone Group For Testing</label>
				    <select class="form-control" id="sample-bone-group">
					    <option value='left arm'>Left Arm</option>
					    <option value='right arm'>Right Arm</option>
					    <option value='head'>Head</option>
					    <option value='torso'>Torso</option>
					    <option value='neck'>Neck</option>
					    <option value='handheld'>Handheld</option>
				    </select>
				</div>
				<div class="form-group">
				    <label for="sample-pose">Sample Pose For Testing</label>
				    <select class="form-control" id="sample-pose">
					    <option value='amazing pose'>Amazing Pose</option>
				    </select>
				</div>

			  	<div class="form-group">
				    <label for="model_attachment">Mesh Attachment (Type)</label>
				    <select class="form-control" id="model_attachment" data-object='myModel' data-bind='model_attachment'>
					    <option value='head'>Head</option>
					    <option value='chest'>Chest</option>
					    <option value='shoulder'>Shoulder</option>
					    <option value='arm'>Arm</option>
					    <option value='hand'>Hand</option>
					    <option value='waist'>Waist</option>
					    <option value='hips'>Hips</option>
					    <option value='leg'>Leg</option>
					    <option value='knee'>Knee</option>
					    <option value='ankle'>Ankle</option>
					    <option value='foot'>Foot</option>
					    <option value='base'>Base</option>
				    </select>
				</div>

				<div class="form-group">
				    <label for="model_category">Mesh Purpose (Category)</label>
				    <select class="form-control" id="model_category" data-object='myModel' data-bind='model_category'>
				    	<optgroup label='Head'>
					    	<option value='head'>Head</option>
					    	<option value='hair'>Hair</option>
					    	<option value='glasses'>Glasses</option>
					    	<option value='facial-hair'>Facial Hair</option>
					    	<option value='jewelery'>Jewelery (Necklace)</option>
					    	<option value='earring'>Jewelery (Earing)</option>
					    	<option value='nosering'>Jewelery (Nose Ring)</option>
					    	<option value='headgear'>Headgear (Helmet, Hat)</option>
					    </optgroup>
					    <optgroup label='Chest'>
					    	<option value='chest'>Chest</option>
					    	<option value='clothing'>Clothing</option>
					    	<option value='armor'>Armor</option>
					    	<option value='capes'>Cape / Cloak</option>
					    	<option value='belt'>Belt / Bandolier</option>
					    	<option value='medals'>Medals / Insignia</option>
					    </optgroup>
					    <optgroup label='Shoulder'>
					    	<option value='Shoulder'>Shoulder</option>
					    	<option value='baldakin'>Baldakin / Pad</option>
					    	<option value='shoulder-pet'>Shoulder Pet</option>
					    </optgroup>
					    <optgroup label='Arm'>
					    	<option value='arm'>Arms</option>
					    	<option value='left-arms'>Left Arms</option>
					    	<option value='right-arms'>Right Arms</option>
					    	<option value='arm-clothing'>Clothing</option>
					    	<option value='arm-armor'>Armor</option>
					    	<option value='cuff'>Jewelery (Cuff)</option>
					    	<option value='bracelet'>Jewelery (Bracelet)</option>
					    </optgroup>
					    <optgroup label="Hands &amp; Held Items">
					    	<option value='hand'>Hands</option>
					    	<option value='left-hands'>Left Hands</option>
					    	<option value='right-hand'>Right Hands</option>
					    	<option value='glove'>Gloves / Gauntlet</option>
					    	<option value='swords'>Swords</option>
					    	<option value='swords'>Shields</option>
					    	<option value='guns'>Guns</option>
					    	<option value='bows'>Bows</option>
					    	<option value='exotic'>Exotics</option>
					    	<option value='items'>Items</option>
					    </optgroup>
					    <optgroup label="Waist &amp; Hips">
					    	<option value='hips'>Hips</option>
					    	<option value='loins'>Loins</option>
					    	<option value='pants'>Pants</option>
					    	<option value='skirts'>Skirts</option>
					    	<option value='Armor'>Armor</option>
					    	<option value='belts'>Belts &amp; Holsters</option>
					    	<option value='belly-ring'>Jewlery (Belly Ring)</option>
					    	<option value='worn-items'>Worn Items</option>
					    </optgroup>
					    <optgroup label="Legs">
					    	<option value='legs'>Legs</option>
					    	<option value='right-legs'>Right Legs</option>
					    	<option value='left-legs'>Left Legs</option>
					    	<option value='garter'>Belts &amp; Garters</option>
					    </optgroup>
					    <optgroup label="Knees &amp; Shins">
					    	<option value='knee'>Knees</option>
					    	<option value='shins'>Shins</option>
					    	<option value='left-shins'>Left Shins</option>
					    	<option value='right-shins'>Right Shins</option>
					    	<option value='anklet'>Jewlery (Anklet)</option>
					    	<option value='knee-pads'>Knee Pads</option>
					    </optgroup>
					    <optgroup label='Ankels &amp; Feet'>
					    	<option value='ankle'>Ankle</option>
					    	<option value='feet'>Feet</option>
					    	<option value='right-feet'>Right Feet</option>
					    	<option value='left-feet'>Left Feet</option>
					    	<option value='boots'>Boots</option>
					    	<option value='shoes'>Shoes &amp; Sandals</option>
					    </optgroup>
					    <optgroup label='Base'>
					    	<option value='base'>Base</option>
					    	<option value='terrain'>Terrain</option>
					    	<option value='pets'>Pets</option>
					    	<option value='ground-items'>Items</option>
					    </optgroup>
				    </select>
				</div>

				<div class="form-group">
				    <label for="exampleSelect1">Mesh Chirality</label>
				    <select class="form-control" id="model_chirality" data-object='myModel' data-bind='flag_chirality'>
					    <option value='N'>None</option>
					    <option value='R'>Right</option>
					    <option value='L'>Left</option>
				    </select>
				</div>

				
				<form enctype='multipart/form-data' id='model-file' data-upload="model">
					<div class="form-group">
						<label for="model-file-input">Model File</label>
					  	<input type="file" class="form-control-file" id="model-file-input" aria-describedby="fileHelp">
					  	Current File: <span class='filename' data-file='model_url'> </span>
					</div>
				</form>
			</div>
		</div>
  	</div>

  	<div class="panel card clearfix collapse" data-model-type='pose'>
		<div class="card-header" role="tab" id="editor-presets">
			<h5><a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-pose-data" aria-expanded="false" aria-controls="editor-pose-data" > Step 2: Provide Pose Info </a></h5>
		</div>
		<div id="editor-pose-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-pose">
			<div class='padder'>
		  	<!--Filled by AJAX: getPresets(); -->
		  	</div>
		</div>
  	</div>

  	<div class="panel card clearfix collapse" data-model-type='skeleton'>
		<div class="card-header" role="tab" id="editor-skeleton">
			<h5><a data-toggle="collapse" data-parent="#editor-accordion" href="#editor-skeleton-data" aria-expanded="false" aria-controls="editor-skeleton-data" > Step 2: Provide Skeleton Info </a></h5>
		</div>
		<div id="editor-skeleton-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-skeleton">
			<div class='card-block'>
		  	<!--Filled by AJAX: getPresets(); -->
		  	</div>
		</div>
  	</div>

  <div class="panel card clearfix">
	<div class="card-header" role="tab" id="editor-story">
	  <h5>
		<a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-story-data" aria-expanded="false" aria-controls="editor-story-data"> Step 3: Tell the Story </a>
	  </h5>
	</div>
	<div id="editor-story-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-story">
		<div class="card-block">
			<label>Describe Your Model</label>
			<textarea name="model_description" data-object="myModel" data-bind="model_short_desc"></textarea>

			<label>Tell The Story</label>
			<textarea name="model_story" data-object="myModel" data-bind="model_story"></textarea>
			
			<label>Inspiration Photo</label>
			<form enctype='multipart/form-data' id='inspiration-upload' data-folder="inspiration" data-upload="image" data-for="photo_inspiration">
				<input type="file" name="file" multiple>
			</form>
			Current File: <span class='filename' data-file='photo_inspiration'> </span>

			<img data-photo='photo_inspiration' class='figure-photo'>
		</div>
	</div>
  </div>
  
  <div class="panel card clearfix">
	<div class="card-header" role="tab" id="editor-tags">
	  <h5>
		<a class="collapsed" data-toggle="collapse" data-parent="#editor-accordion" href="#editor-tags-data" aria-expanded="false" aria-controls="editor-tags-data"> Step 4: Tagging </a>
	  </h5>
	</div>
	<div id="editor-tags-data" class="collapse scroll" role="tabpanel" aria-labelledby="editor-tags">
	  <div class="card-block">
	  <!-- getTabbedItems("/api/v1/model/by/arms/mesh","editor-arms-data","arms"); -->
	  </div>
	</div>
  </div>
</div>

<div id='status-box'>
  <h5 class='text-white float-left'>Console</h5>
  <!-- Progress Bars to show upload completion percentage -->
	<div class="progress-bar-area float-right"></div>
	<form method="POST" enctype="multipart/form-data" class="direct-upload hidden">
		<!--filled by JS as needed -->
	</form>

	<!-- This area will be filled with our results (mainly for debugging) -->
	<div>
		<textarea id="uiconsole"></textarea>
	</div>
</div>

<div id='loadingDiv'>
  <img src='/img/loading.gif'>
</div>

<footer class="footer">
	<div class="container">
	  <div class="input-group input-group-lg">
		<input type="text" class="form-control" placeholder="My Model's Name" aria-describedby="sizing-addon1" data-object="myModel" data-bind="model_name">
		<span class="input-group-btn">
			<button class="btn btn-secondary" type="button" onclick="myModel.save()">Save Model</button>
		  </span>
	</div>
	</div>    
</footer>

<!--Feature Specific Scripts (be sure they load after the js in the footer with document.ready-->
<script src="/vendor/threejs/build/three.js"></script>
<script src="/vendor/threejs/external/OrbitControls.js"></script>
<script src="/vendor/threejs/external/STLExporter.js"></script>

<script src="/js/bootstrap/tab.js"></script>

<script src="/js/ModelEditor.js"></script>
<script src="/js/UserSettings.js"></script>
<script src="/js/LocalDataSource.js"></script>
<script src="/js/SceneModel-model.js"></script>
<script src="/js/SceneView-model.js"></script>
<script src="/js/Character.js"></script>
<script src="/js/BoneGroup.js"></script>
<script src="/js/Pose.js"></script>
<script src="/js/Materials.js"></script>

<script src="/js/Event.js"></script>
<script src="/js/ObservableDict.js"></script>
<script src="/js/ObservableList.js"></script>

<script src="/js/FileSaver.js"></script>
<script src="/js/Global.js"></script>

<!-- Load the FileUpload Plugin (more info @ https://github.com/blueimp/jQuery-File-Upload) -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload.js"></script>



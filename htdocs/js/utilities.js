
// convert base64/URLEncoded data component to raw binary data held in a string
function dataURItoBlob(dataURI) {
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

//wraps console.log to also send output to the onscreen console
var uilog = function(msg) {
  var el = $("#uiconsole");
  el.val ( el.val() + "\n" + msg);
  console.log(msg);
};
var clearuilog = function() {
  var el = $("#uiconsole");
  el.val("");
};


//the ajax loader
var loader = {};
loader.count = 0;

loader.show = function(){
  $("#loadingDiv").show();
  loader.count++;
};
loader.hide = function(){
  loader.count--;
    if (loader.count <= 0) {
      $("#loadingDiv").hide();
      loader.count = 0; 
    }
};
THREE.SkinnedMesh.prototype.toJSON = function(){
	return {
		libraryName: this.libraryName,
		name: this.name
	};
}

THREE.Bone.prototype.rotateOnWorldAxis = function(axis, radians) {
    var rotWorldMatrix = new THREE.Matrix4();
    rotWorldMatrix.makeRotationAxis(axis.normalize(), radians);
    rotWorldMatrix.multiply(this.matrix);
    this.matrix = rotWorldMatrix;
    this.rotation.setFromRotationMatrix(this.matrix);
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
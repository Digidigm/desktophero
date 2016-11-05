THREE.SkinnedMesh.prototype.toJSON = function(){
	return {
		libraryName: this.libraryName,
		name: this.name
	};
}
/* A datasource that is a folder on the same server where DesktopHero is being hosted.
*/

function LocalDataSource(directoryURL){
	this.directoryURL = directoryURL;
}

LocalDataSource.prototype = {
	listMeshes: function(){
		// Fake data for now.
		return ['left arm',
				'right arm',
				'torso',
				'hat',
				'head',
				'tentacle',
				'neck',
				'handheld']
	}, 

	listPoses: function(){
		// Fake data for now.
		return ['rest',
				'silly']
	},

	listBoneGroups: function(){
		// Fake data for now.
		return ['left arm',
				'right arm',
				'torso',
				'hat',
				'head',
				'tentacle',
				'neck',
				'handheld']
	}, 

}
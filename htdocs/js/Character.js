function Character(){
	this.name = "New Character";
	this.boneGroups = new ObservableDict(this);

	this.nameChangedEvent = new Event(this);
}

Character.prototype = {
	addBoneGroup: function(name, boneGroup){
		this.boneGroups.put(name, boneGroup);
	},

	getCurrentPose: function(){
		return Pose.toPose(this.boneGroups);
	},

	loadPose: function(jsonString){
		var pose = Pose.fromJson(jsonString);

		// Find all bones in the character bone groups that have the same name
		// as a bone in the pose being loaded, and set position/rotation/scale
		// to match that bone.
		
		for (var i = 0; i < pose.poseBones.length; i++){
			var poseBone = pose.poseBones[i];

			for (var boneGroupName in this.boneGroups.dict){
				var boneGroup = this.boneGroups.get(boneGroupName);

				for (var j = 0; j < boneGroup.skeleton.bones.length; j++){
					var bone = boneGroup.skeleton.bones[j];

					if (bone.name === poseBone.name){
						bone.position.x = poseBone.position.x;
						bone.position.y = poseBone.position.y;
						bone.position.z = poseBone.position.z;

						bone.rotation.x = poseBone.rotation.x;
						bone.rotation.y = poseBone.rotation.y;
						bone.rotation.z = poseBone.rotation.z;

						bone.scale.x = poseBone.scale.x;
						bone.scale.y = poseBone.scale.y;
						bone.scale.z = poseBone.scale.z;
					}
				}
			}
		}
	},

	getName: function(){
		return this.name;
	},

	setName: function(name){
		this.name = name;
		this.nameChangedEvent.notify(this.name);
	}
}
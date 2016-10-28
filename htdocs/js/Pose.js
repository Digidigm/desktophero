function Pose(){

}

/* Pose String Format:

- bone group 1
	- bone 1
		- px py pz
		- rx ry rz
		- sx sy sz
	- bone 2 ...
- bone group 2 ...

*/
Pose.createPoseString = function(boneGroups){
	str = ""

	for (var boneGroupName in boneGroups.dict){
		str += boneGroupName + "\n";

		var boneGroup = boneGroups.get(boneGroupName);
		for (var i = 0; i < boneGroup.skeleton.bones.length; i++){
			var bone = boneGroup.skeleton.bones[i];
			if (bone.name.startsWith("#")){ // Ignore attach points
				continue;
			}

			str += "\t" + bone.name + "\n";
			
			// Print position
			str += "\t\tpos " + bone.position.x + "\n";
			str += "\t\tpos " + bone.position.y + "\n";
			str += "\t\tpos " + bone.position.z + "\n";

			// Print rotation
			str += "\t\trot " + bone.rotation.x + "\n";
			str += "\t\trot " + bone.rotation.y + "\n";
			str += "\t\trot " + bone.rotation.z + "\n";

			// Print scale
			str += "\t\tsca " + bone.scale.x + "\n";
			str += "\t\tsca " + bone.scale.y + "\n";
			str += "\t\tsca " + bone.scale.z + "\n";
		}
	}

	return str;
}
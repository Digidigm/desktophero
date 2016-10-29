function UserSettings(){
	this.libraries = new ObservableDict();
	this.libraries.put("Default", new LocalDataSource("/testlib"));
}
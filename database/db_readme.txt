The database is MySQL

Users are people who log in and can do things inside the application.  
Some users will have elevated privledges and administer the sytem via a backend.  User preferences are stored in the user table as json.

Figures are made up of models.
Models are meshes, bones, or poses.

Figures are what the users are creating in the editor.
Figures and models can be flagged with properties including things like NSFW.  The application will decide what to do with this data.

Tags are small bits of text that can be appended to models, figures, users, and others.  The display of the tag is handled by the ui but the tag can be associated with any type of object.
Tags should not trigger applicaiton behaviors.  If you want something to behave differently, make it a flag.

The gallery is a list of photos taken by users of figures.
The figure will have the owner-supplied picture associated with it, but other users may download, print, or pose models and their pictures become part of the gallery if they choose.

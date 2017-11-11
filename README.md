# DesktopHero
Open Source Character Designer for 3D Printing

See https://www.kickstarter.com/projects/263291121/desktophero-free-3d-printable-character-maker/

##Starting with Landio Template in Bootstrap 4
1.  The static information pages will be largely hand written html with some knockout for dynamic elements
2.  The current content is cribbed from the kickstarter campaign, please feel free to make nicer prettier things and commit them
3.  The marketing page will talk about the project, highlight featured artists, kickstarter folk, and stump for community involvement
4.  Go ahead and make things better here.  It's using landio and bootstrap4 so please just keep doing that
5.  We're avoiding using SASS and other preprocessors.  I know you hipster kids love your pre-compilers and pre-pre-tools and all that but there's really no need here.

##The WebAPI and database
1.  We're using PHP Slim as the microframework for RESTful things
2.  The database will largely serve as a way for people to save and share model configurations, to create your own personal library, and to allow people to share, like, and follow their friends
3.  The database will also let the users tag designs, components, and models so that we can make sure NSFW stuff doesn't get shown to the kiddies, so you can create themed groups, things like that
4.  The current model library will probably be registered in the database and model uploads and such will be handled via the API
5.  The database is MySQL, very skinny models if any at all, and no ORM.  Write your own darn queries, son.
6.  For the love of all that's holy, PHP and CSS are alraedy a templating language, we don't need to introduce a templating language written in a templating language so you can avoid writing some HTML directly.  Please just get in there and write make things.
7.  Database versioning will eventually be handled with liquibase once we get that set up.  For the short term db dumps will be committed and will need to be manually imported

##Knockout.js, jQuery, et al
1.  We will use Knockout for database driven content until it gets too cumbersome
2.  jQuery and any other little js library will be used to just make things fast and easy.  remember the goal here is to get models in the hands of kids and not reinvent web technologies.  fast, easy to use and easy to contribute to are the goals.

##Three.js
1.  I dont know much about this, part.  People who are in the know should enumerate what we're doing here.
2.  There's great examples of how all this stuff works here:  http://threejs.org/examples/#webgl_morphtargets_human

##Setup (Local)
1. Checkout the code
2. Point your vhost / server to the htdocs folder
3. Create a mysql database named "hero" with username "hero", password "hero" and full permissions or update config/environments.json with your favorite SQL database permissions
4. import the mysql dump from database/sample folder.  
5. fire up the servers 
6. If you like, login with test@test.com  / test

##Mise En Place
1.  We're using an .editorconfig, please abide
2.  Make sure we're not commiting cruft with your .gitignore, especially if you are working in a windows or mac local environment lets keep desktop files out
3.  We'll be doing unit tests for the apis and that's always a wonderful place to contribute if you're looking for something to do
4.  We'll drop all the example code from three.js and clean up git as soon as we have some working prototypes of everything and it's not needed for quick reference

# License
This project is licensed under the terms of the MIT License.

Copyright (c) 2017 Andrew Stockton

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

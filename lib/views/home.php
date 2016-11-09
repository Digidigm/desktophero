<header class="jumbotron bg-inverse text-center center-vertically" role="banner">
	<div class="container">
		<h1 class="display-3">Desktop Hero - 3D Yourself.</h1>
		<h2 class="m-b-lg">Craft your character for your personal journey, <em>absolutely free</em>, with <a href="/editor/" class="jumbolink">Desktop Hero</a>.</h2>
		<a class="btn btn-secondary-outline m-b-md" href="/editor/" role="button"><span class="icon-sketch"></span>Download your .STL or .OBJ and own it forever.</a>
		<ul class="list-inline social-share">
			<!--TODO: Change twitter icon to kickstarter icon -->
			<li><a class="nav-link" href="https://www.kickstarter.com/projects/263291121/desktophero-free-3d-printable-character-maker/description"><span class="icon-twitter"></span></a></li>
			<li><a class="nav-link" href="https://www.facebook.com/desktophero3D"><span class="icon-facebook"></span></a></li>
			<!-- TODO: upgrade the github icon to something prettier and probably SVG -->
			<li><a class="nav-link" href="https://github.com/stockto2/desktophero"><img src="/img/github-256.png" width="20px"></a></li>
		</ul>
	</div>
</header>
<section class="section-intro bg-faded text-center hidden-overflow">
	<div class="container">
		<h3 class="wp wp-1">Make, Outfit, Pose, and Print.</h3>
		<p class="lead wp wp-2">Craft memorable, emotive characters with our range of beautiful models.</p>
		<p> Have you ever made up a character in your head, and wished you could make that character real? Physically hold them in your hand?</p>
		<p>DesktopHero is a web app that lets you easily design your own characters for 3D printing. You start with a basic 3D figure - then add armor, clothes, hair, and weapons, crafting your hero onscreen.</p>
		<p>When you're done, you can download the file and get it 3D printed into a real, physical object - to paint, to hold, to use in games... to keep on your desk and stare at while you should be working... ;-) </p>

DesktopHero lets you turn your ideas into a physical reality, and we think you'll love it
		<img src="img/sample1.png" alt="iPad mock" class="img-responsive wp wp-3 center-block">
	</div>
</section>
<section class="section-features text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-block">
						<span class="icon-pen display-1"></span>
						<h4 class="card-title">250</h4>
						<h6 class="card-subtitle text-muted">Character Models</h6>
						<p class="card-text">Sed risus feugiat fusce eu sit conubia venenatis aliquet nisl cras eu adipiscing ac cras at sem cras per senectus eu parturient quam.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-block">
						<span class="icon-thunderbolt display-1"></span>
						<h4 class="card-title">160</h4>
						<h6 class="card-subtitle text-muted">Character Outfits and Poses</h6>
						<p class="card-text">Sed risus feugiat fusce eu sit conubia venenatis aliquet nisl cras eu adipiscing ac cras at sem cras per senectus eu parturient quam.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card m-b-0">
					<div class="card-block">
						<span class="icon-heart display-1"></span>
						<h4 class="card-title">Free</h4>
						<h6 class="card-subtitle text-muted">Forever and ever</h6>
						<p class="card-text">Sed risus feugiat fusce eu sit conubia venenatis aliquet nisl cras eu adipiscing ac cras at sem cras per senectus eu parturient quam.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id='about' class="section-video bg-inverse text-center wp wp-4">
	<h3 class="sr-only">Video</h3>
	<video id="demo_video" class="video-js vjs-default-skin vjs-big-play-centered" controls poster="img/video-poster.png" data-setup='{}'>
		<source src="https://ksr-video.imgix.net/projects/2480422/video-677362-h264_high.mp4" type='video/mp4'>
		<source src="https://ksr-video.imgix.net/projects/2480422/video-677362-h264_high.webm" type='video/webm'>
	</video>


</section>

<script>
$(document).ready( function(){
	//keep it all using the REST apis rather than a combination of internal and external functions
	//TODO: turn these into knockout modules
	$.getJSON("/api/v1/gallery/featured", function( featured ){

		var slides = "";
		var carousel = "";
		
		$.each( featured.featured, function(k,v){
			slides += "<a href='/editor/"+ v.figure_id +"'> <img src='"+ v.photo +"' alt='"+ v.caption +"' class='col-xs-3' ></a>\n";

			//four models per slide
			if (1+k % 4 === 4 ) {
				carousel += "<div class='carousel-item'>" + slides +"</div>\n";
				slides = "";
			}
		});

		//add any extras taht didn't even out to 4
		if (slides !== "") {
			carousel += "<div class='carousel-item'>" + slides +"</div>\n";
		}

		//re-initialize the gallery
		$("#carousel-gallery .carousel-inner").html( carousel );
		$("#carousel-gallery .carousel-inner .carousel-item").first().addClass('active');
		$("#carousel-gallery").carousel();
	});

});
</script>

<section id="carousel" class="section-pricing bg-faded text-center">
	<div class="container">
		<h3>Featured Creations</h3>
		<div id="carousel-gallery" class="carousel slide" data-ride="carousel" data-interval='5000'>
		<div class="carousel-inner" role="listbox">
			
		</div>
		<a class="left carousel-control" href="#carousel-gallery" role="button" data-slide="prev">
			<span class="icon-prev" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-gallery" role="button" data-slide="next">
			<span class="icon-next" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</section>


<section class="section-testimonials text-center bg-inverse">
	<div class="container">
		<h2>Thank You!</h2>
		<h3>Featured Kickstarter Supporters</h3>
		<div id="carousel-testimonials" class="carousel slide" data-ride="carousel" data-interval="0">
			<div class="carousel-inner" role="listbox">
				<div class="carousel-item active">
					<blockquote class="blockquote">
						<img src="img/face1.jpg" height="80" width="80" alt="Avatar" class="img-circle">
						<p class="h3">Good design at the front-end suggests that everything is in order at the back-end, whether or not that is the case.</p>
						<footer>Dmitry Fadeyev</footer>
					</blockquote>
				</div>
				<div class="carousel-item">
					<blockquote class="blockquote">
						<img src="img/face2.jpg" height="80" width="80" alt="Avatar" class="img-circle">
						<p class="h3">It’s not about knowing all the gimmicks and photo tricks. If you haven’t got the eye, no program will give it to you.</p>
						<footer>David Carson</footer>
					</blockquote>
				</div>
				<div class="carousel-item">
					<blockquote class="blockquote">
						<img src="img/face3.jpg" height="80" width="80" alt="Avatar" class="img-circle">
						<p class="h3">There’s a point when you’re done simplifying. Otherwise, things get really complicated.</p>
						<footer>Frank Chimero</footer>
					</blockquote>
				</div>
				<div class="carousel-item">
					<blockquote class="blockquote">
						<img src="img/face4.jpg" height="80" width="80" alt="Avatar" class="img-circle">
						<p class="h3">Designing for clients that don’t appreciate the value of design is like buying new tires for a rental car.</p>
						<footer>Joel Fisher</footer>
					</blockquote>
				</div>
				<div class="carousel-item">
					<blockquote class="blockquote">
						<img src="img/face5.jpg" height="80" width="80" alt="Avatar" class="img-circle">
						<p class="h3">Every picture owes more to other pictures painted before than it owes to nature.</p>
						<footer>E.H. Gombrich</footer>
					</blockquote>
				</div>
			</div>
			<ol class="carousel-indicators">
				<li class="active"><img src="img/face1.jpg" alt="Navigation avatar" data-target="#carousel-testimonials" data-slide-to="0" class="img-responsive img-circle"></li>
				<li><img src="img/face2.jpg" alt="Navigation avatar" data-target="#carousel-testimonials" data-slide-to="1" class="img-responsive img-circle"></li>
				<li><img src="img/face3.jpg" alt="Navigation avatar" data-target="#carousel-testimonials" data-slide-to="2" class="img-responsive img-circle"></li>
				<li><img src="img/face4.jpg" alt="Navigation avatar" data-target="#carousel-testimonials" data-slide-to="3" class="img-responsive img-circle"></li>
				<li><img src="img/face5.jpg" alt="Navigation avatar" data-target="#carousel-testimonials" data-slide-to="4" class="img-responsive img-circle"></li>
			</ol>
		</div>
	</div>
</section>
<section class="section-text">
	<div class="container">
		<h3 class="text-center">Who will you create today?</h3>
		<div class="row p-y-lg">
			<div class="col-md-5">
				<p class="wp wp-7">We are aware that similar services do exist out there on the internet. Here are the things that make DesktopHero stand out!</p>
				<p class="wp wp-7">It's Free and it's Yours. Once you design a character, you can download the file for free, then use it however you want - including commercially.</p>
			</div>
			<div class="col-md-5 col-md-offset-2 separator-x">
				<p class="wp wp-8">Make as Many as You Want. There is no limit to how many characters you can download! That means you can make multiple versions of a character with different weapons or clothing, or print an entire party of different characters! It's still free.</p>
				<p class="wp wp-8">It's Easy to Use. We've tested this on middle schoolers and adults alike - no artistic or 3d modeling skills required. Just use the buttons and sliders in the app to load assets and poses designed by our artists.</p>
			</div>
		</div>
	</div>
</section>
<section class="section-news">
	<div class="container">
		<h3 class="sr-only">News</h3>
		<div class="bg-inverse">
			<div class="row">
				<div class="col-md-6 p-r-0">
					<figure class="has-light-mask m-b-0 image-effect">
						<!--img src="https://images.unsplash.com/photo-1442328166075-47fe7153c128?q=80&fm=jpg&w=1080&fit=max" alt="Article thumbnail" class="img-responsive"-->
						<img src="/img/artist1.jpg" alt="Article thumbnail" class="img-responsive">
					</figure>
				</div>
				<div class="col-md-6 p-l-0">
					<article class="center-block">
						<span class="label label-info">Featured Designer: Larry Dixon</span>
						<br>
						<h5><a href="http://www.gryphonking.com/">Gaming legend, designer and artist Larry Dixon has stepped in and volunteered to do a number of designs for us! <span class="icon-arrow-right"></span></a></h5>
						<p class="m-b-0">
							<a href="http://www.gryphonking.com/"><span class="label label-default text-uppercase"><span class="icon-tag"></span> See his other work</span></a>
						</p>
					</article>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-push-6 p-l-0">
					<figure class="has-light-mask m-b-0 image-effect">
						<img src="https://images.unsplash.com/photo-1434394673726-e8232a5903b4?q=80&fm=jpg&w=1080&fit=max" alt="Article thumbnail" class="img-responsive">
					</figure>
				</div>
				<div class="col-md-6 col-md-pull-6 p-r-0">
					<article class="center-block">
						<span class="label label-info">Featured Model Designer</span>
						<br>
						<h5><a href="#">She's amazing and makes amazing meshes<span class="icon-arrow-right"></span></a></h5>
						<p class="m-b-0">
							<a href="#"><span class="label label-default text-uppercase"><span class="icon-tag"></span> See her other work</span></a>
						</p>
					</article>
				</div>
			</div>
		</div>
	</div>
</section>
<!--TODO: Wire up this form -->
<section class="section-signup bg-faded">
	<div class="container">
		<h3 class="text-center m-b-lg">Sign up to receive free updates as soon as they hit!</h3>
		<form>
			<div class="row">
				<div class="col-md-6 col-xl-3">
					<div class="form-group has-icon-left form-control-name">
						<label class="sr-only" for="inputName">Your name</label>
						<input type="text" class="form-control form-control-lg" id="inputName" placeholder="Your name">
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="form-group has-icon-left form-control-email">
						<label class="sr-only" for="inputEmail">Email address</label>
						<input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email address" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="form-group has-icon-left form-control-password">
						<label class="sr-only" for="inputPassword">Enter a password</label>
						<input type="password" class="form-control form-control-lg" id="inputPassword" placeholder="Enter a password" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Sign up for free!</button>
					</div>
				</div>
			</div>
			<label class="c-input c-checkbox">
				<input type="checkbox" checked>
				<!--TODO: add TOS and Privacy Policy -->
				<span class="c-indicator"></span> I agree to the <a href="#">terms of service</a>
			</label>
		</form>
	</div>
</section>
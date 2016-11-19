<!DOCTYPE html>
<html lang="en">
    <head>
         <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>DesktopHero - Make, Pose, and Print your own personal 3D Hero</title>
        <meta name="description" content="Make, Pose, and Print your own 3D miniatures that you can download and print on your personal 3d printer." />
        <meta name="keywords" content="3d printer, stl, hero, miniature, 32mm, gaming, rpg" />
        <meta name="author" content="Desktop Hero Open Source Community" />

        <!-- TODO: Update these to be pertinent to Desktop Hero -->
        <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="//img/favicon/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="img/favicon/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="img/favicon/manifest.json">
        <link rel="shortcut icon" href="img/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#663fb5">
        <meta name="msapplication-TileImage" content="/img/favicon/mstile-144x144.png">
        <meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
        <meta name="theme-color" content="#663fb5">
        <link rel="stylesheet" href="/css/animate.min.css">

        <!-- TODO: Build landio with the alpha6+ version of bootstrap so you don't have to include both -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/landio.css">

        
        <script src="/vendor/jquery/jquery.min.js"></script>
        <script src="/js/utilities.js"></script>
        <link href="/css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="main">
        <nav class="navbar navbar-dark bg-inverse bg-inverse-custom navbar-fixed-top">
          <div class="container">
            <a class="navbar-brand" href="/">
              <!-- TODO: Change LOGO to Desktop Hero -->
              <span class="icon-logo"></span>
            </a>
            <a class="navbar-toggler hidden-md-up float-right" data-toggle="collapse" href="#collapsingNavbar" aria-expanded="false" aria-controls="collapsingNavbar">
            &#9776;
          </a>
            <a class="navbar-toggler navbar-toggler-custom hidden-md-up float-right" data-toggle="collapse" href="#collapsingMobileUser" aria-expanded="false" aria-controls="collapsingMobileUser">
              <span class="icon-user"></span>
            </a>
            <div id="collapsingNavbar" class="collapse navbar-toggleable-custom" role="tabpanel" aria-labelledby="collapsingNavbar">
              <ul class="nav navbar-nav float-right">
                <li class="nav-item nav-item-toggable">
                  <a class="nav-link" href="/editor/">Make Your Hero</a>
                </li>
                 <li class="nav-item nav-item-toggable">
                  <a class="nav-link" href="/models/">Contribute Models</a>
                </li>
                <li class="nav-item nav-item-toggable">
                  <a class="nav-link" href="/#about">About DesktopHero</a>
                </li>
                <li class="nav-item nav-item-toggable">
                  <a class="nav-link" href="/#carousel">Character gallery</a>
                </li>
                <li class="nav-item nav-item-toggable">
                  <a class="nav-link" href="https://github.com/stockto2/desktophero" target="_blank">GitHub</a>
                </li>
                <li class="nav-item nav-item-toggable hidden-sm-up">
                  <form class="navbar-form">
                    <input class="form-control navbar-search-input" type="text" placeholder="Type your search &amp; hit Enter&hellip;">
                  </form>
                </li>
                <li class="navbar-divider hidden-sm-down"></li>
                <li class="nav-item dropdown nav-dropdown-search hidden-sm-down">
                  <a class="nav-link dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon-search"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-search" aria-labelledby="dropdownMenu1">
                    <form class="navbar-form">
                      <input class="form-control navbar-search-input" type="text" placeholder="Search models for keywords&hellip;">
                    </form>
                  </div>
                </li>
                <!-- TODO: Deduplicate this menu between mobile and desktop so the markup doesn't have to be made twice -->
                <!-- TODO: Make this logged in aware -->
                <!-- TODO: Make this nice for logged out users -->
                <li class="nav-item dropdown hidden-sm-down textselect-off">
                  <a class="nav-link dropdown-toggle nav-dropdown-user" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/img/face5.jpg" height="40" width="40" alt="Avatar" class="img-circle"> <span class="icon-caret-down"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-user dropdown-menu-animated" aria-labelledby="dropdownMenu2">
                    <div class="media">
                      <div class="media-left">
                        <img src="/img/face5.jpg" height="60" width="60" alt="Avatar" class="img-circle">
                      </div>
                      <div class="media-body media-middle">
                        <h5 class="media-heading">Firstname Lastname</h5>
                        <h6>hey@email.com</h6>
                      </div>
                    </div>
                    <a href="#" class="dropdown-item text-uppercase">View favorite models</a>
                      <a href="#" class="dropdown-item text-uppercase">Manage my models</a>
                      <a href="#" class="dropdown-item text-uppercase text-muted">Log out</a>
                      <a href="#" class="btn-circle has-gradient float-right m-b">
                        <span class="sr-only">Edit</span>
                        <span class="icon-edit"></span>
                      </a>
                  </div>
                </li>
              </ul>
            </div>
            <div id="collapsingMobileUser" class="collapse navbar-toggleable-custom dropdown-menu-custom p-x hidden-md-up" role="tabpanel" aria-labelledby="collapsingMobileUser">
              <div class="media m-t">
                <div class="media-left">
                  <img src="/img/face5.jpg" height="60" width="60" alt="Avatar" class="img-circle">
                </div>
                <div class="media-body media-middle">
                  <h5 class="media-heading">Firstname Lastname</h5>
                  <h6>hey@email.com</h6>
                </div>
              </div>
              <a href="#" class="dropdown-item text-uppercase">View favorite models</a>
              <a href="#" class="dropdown-item text-uppercase">Manage my models</a>
              <a href="#" class="dropdown-item text-uppercase text-muted">Log out</a>
              <a href="#" class="btn-circle has-gradient float-right m-b">
                <span class="sr-only">Edit</span>
                <span class="icon-edit"></span>
              </a>
            </div>
          </div>
        </nav>
        <!--header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
        <div class="container">
            <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../" class="navbar-brand">Home</a>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li>
                <a href="/page2/">Page 2</a>
                </li>
                <li class="active">
                <a href="/page3/">Page 3</a>
                </li>
                <li>
                <a href="/page4/">Page 4</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php if ($loggedin): ?>
            <div>you are logged in.</div>
            <li><a href="/logout"><button class="btn btn-default">Logout</button></a></li>
            <?php else: ?>
            <li><a href="/login"><button class="btn btn-default">Login</button></a></li>
            <?php endif ?>
            </ul>
            </nav>
        </div>
        </header>
        <div id="message-container"></div-->


        <!--div class="container page <?= str_replace('/', '_', $template) ?>" -->
            <?php require $template_dir . $template . '.php'; ?>
        <!--/div-->

        <footer class="section-footer bg-inverse" role="contentinfo">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-lg-5">
                <div class="media">
                  <div class="media-left">
                    <span class="media-object icon-logo display-1"></span>
                  </div>
                  <small class="media-body media-bottom">&copy; Desktop Hero 2016</small>
                </div>
              </div>
              <!--div class="col-md-6 col-lg-7">
              TODO: Add footer links
                <ul class="list-inline m-b-0">
                  <li class="active"><a href="http://tympanus.net/codrops/?p=25217">About Land.io</a></li>
                  <li><a href="ui-elements.html">UI Kit</a></li>
                  <li><a href="https://github.com/tatygrassini/landio-html" target="_blank">GitHub</a></li>
                  <li><a class="scroll-top" href="#totop">Back to top <span class="icon-caret-up"></span></a></li>
                </ul>
              </div -->
            </div>
          </div>
        </footer>

        <!--
        <script src="/vendor/knockoutjs/knockout-3.4.0.js"> </script>
        <script>
            /* object: "ko" provided by knockout script natively */
            ko.populate_property_by_api = function(url,func,data) {
                var cache = function (data) {
                    localStorage.setItem(url,data);
                    func(data);
                },
                cached = localStorage.getItem(url);
                if (!cached) {
                    $.ajax({
                        url: url,
                        data: data
                    }).done(cache);
                }
                else {
                    func(cached);
                }
            };
            ko.components.register('dental-subscribers', { require: 'modules/dentalsubscribers'});
            ko.components.register('person_info', { require: 'modules/person_info'});
            ko.components.register('claims', { require: 'modules/claims'});
            ko.components.register('claims_form', { require: 'modules/claims_form'});
            ko.applyBindings();
        </script>
        -->

        <!--3D Related Scripts -->
        <!--script src="/vendor/threejs/build/three.js"></script>
        <script src="/vendor/threejs/examples/js/loaders/collada/Animation.js"></script>
        <script src="/vendor/threejs/examples/js/loaders/collada/AnimationHandler.js"></script>
        <script src="/vendor/threejs/examples/js/loaders/collada/KeyFrameAnimation.js"></script>

        <script src="/vendor/threejs/examples/js/loaders/ColladaLoader.js"></script>

        <script src="/vendor/threejs/examples/js/Detector.js"></script>
        <script src="/vendor/threejs/examples/js/libs/stats.min.js"></script-->

        

        <!--Theme Scripts -->
        <!--TODO: Update bootstrap helper scripts with the rest of the Alpha6+ code -->
        <script src="/js/bootstrap/util.js"></script>
        <script src="/js/bootstrap/carousel.js"></script>
        <script src="/js/bootstrap/collapse.js"></script>
        <script src="/js/bootstrap/dropdown.js"></script>
        <script src="/js/bootstrap/modal.js"></script>
        <script src="/js/bootstrap/carousel.js"></script>

        <!-- TODO: Go through this script and pull out all the things we're not using -->
        <script src="/js/landio.js"></script>

        <!--Feature Specific Scripts -->
        <script src="/js/login.js"></script>

        <!--Utilities -->

        

    </body>
</html>

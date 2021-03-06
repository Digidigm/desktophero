<?php

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/',
    function () use ($app,$session){
        $app->render(
            'layouts/main.php',
            array(
                'componentjs' => "/components/twitterjs.php",
                'loggedin' => $session->get('loggedin'),
                'variable' => "value",
                'template_dir' => BASE_PATH . "./views/",
                'template' => 'home'
            ) //array of parameters for template
        );
   }
);
//forbidden route
$app->get(
    '/foo',
    function () use ($app){
        echo "this is protected by security";
    }
);
$app->get(
    '/models(/:mid)/?',
    function ($mid = 0) use ($app,$session){
        
        $app->render(
            'layouts/main.php',
            array(
                //TODO: make this the actual logged in user's id or 0 if you're logged out
                'user_id' => 0,
                'loggedin' => $session->get('loggedin'),
                'template_dir' => BASE_PATH . "./views/",
                'model_id' => $mid,
                'template' => 'models'
            ) //array of parameters for template
        );
    }
);
$app->get(
    '/editor(/:fid)/?',
    function ($fid = 0) use ($app,$session){
        $app->render(
            'layouts/main.php',
            array(
                //'componentjs' => "/components/twitterjs.php",
                'loggedin' => $session->get('loggedin'),
                //TODO: make this the actual logged in user's id or 0 if you're logged out
                'user_id' => 0,
                'template_dir' => BASE_PATH . "./views/",
                'template' => 'editor',
                'figure_id' => $fid
            ) //array of parameters for template
        );
    }
);
$app->get(
    '/page4/?',
    function () use ($app,$session){
        $app->render(
            'layouts/main.php',
            array(
                'componentjs' => "/components/twitterjs.php",
                'loggedin' => $session->get('loggedin'),
                'template_dir' => BASE_PATH . "./views/",
                'template' => 'page4'
            ) //array of parameters for template
        );
    }
);
// login form route
$app->get(
    '/login',
    function () use ($app,$session){
        $app->render(
            'layouts/main.php',
            array(
                'componentjs' => "/components/twitterjs.php",
                'loggedin' => $session->get('loggedin'),
                'template_dir' => BASE_PATH . "./views/",
                'template' => 'login'
            ) //array of parameters for template
        );
    }
);

// login form route
$app->get(
    '/logout',
    function () use ($app){
        session_unset();
        $app->deleteCookie("softpath_session");
        $app->redirect("/");
    }
);


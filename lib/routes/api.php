<?php
/*** TODO
 *
 *
 * CHECK THAT current session has a valid token and that user.id value
 * has rights to access the end point.
 * check that the session user has permission to access end point
 * this ACL check should be done in a before handler
 **/
$app->group('/api/v1', function () use ($app,$pdo,$config,$session) {
        $app->get(
            '/login',
            function () {
                echo "/api/v1/login";
            }
        );
        $app->post(
            '/login',
            function () use ($app,$pdo,$config,$session){
                $username = filter_var($app->request->params("username"), FILTER_VALIDATE_EMAIL);
                $password = filter_var($app->request->params("password"), FILTER_SANITIZE_STRING);
                //call WEB_VERIFY_USER

                 $user_query = 'SELECT user_id FROM users WHERE email_address = ? AND pass_phrase = SHA1(?);';
                 $stmt = $pdo->prepare($user_query);
                 $stmt->execute(array($username,$password));

                 //to debug a query:
                 //print_r($stmt->debugDumpParams() );

                 $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    $session->set('user.id',$result['user_id']);
                    $session->set('token',session_id());
                    $session->set('loggedin',true);
                    $session->set('expires', strtotime("+" . $config->session_expires));
                    $app->response->setStatus(200);
                    return;
                } else {
                    $app->response->setStatus(403);
                    print "failed to login";    
                    return;
                }
                
                
            }
        );
        $app->post(
            '/logout',
            function () use ($app){
                session_unset();
                $app->deleteCookie("softpath_session");
            }
        );

        /*USER ROUTES*/
        $app->get(
            '/user/:uid',
            function ($uid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/user/:uid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/user/1
                //Gets all of the data for a user and outputs JSON

                $user_query = "SELECT * FROM users WHERE user_id = ?";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);

                $stmt = $pdo->prepare($user_query);
                $stmt->execute(array($uid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $person = array();
                $person["user"] = $result;
                $person = json_encode($person);
                $app->response->setBody($person);
            }
        );
        $app->put(
            '/user/:uid',
            function ($uid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/user/:uid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/user/1
                //Updates supplied data for a user and then returns the updated user in JSON

                //TODO: Make UPDATE user PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $user_query = "UPDATE users set foo=bar, baz=bam, date_updated = unixtimestamp WHERE user_id = ?";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);

                $person = array();
                $person["user"] = "Not Yet Implemented: PUT user update";
                $person = json_encode($person);
                $app->response->setBody($person); 
            }
        );
        $app->post(
            '/user',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/user/:uid
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/user/
                //Creates a new user with the supplied data and then returns the new user in JSON

                //TODO: Make CREATE user POST route
                //TODO: Make post route work in self-subscription process
                //TODO: Check for dupilclate emails

                $user_query = "INSERT INTO users VALUES() FIELDS();";

                $person = array();
                $person["user"] = "Not Yet Implemented: POST user create";
                $person = json_encode($person);
                $app->response->setBody($person); 
            }
        );
        $app->delete(
            '/user/:uid',
            function ($uid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/user/:uid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/user/:uid
                //Set the user deleted flag to TRUE

                //TODO: Make delete user DEL route
                //TODO: Make sure only admins and users themselves can delete
                $user_query = "UPDATE users set flag_deleted = 1, date_updated = unixtimestamp WHERE user_id = ?";

                $person = array();
                $person["user"] = "Not Yet Implemented: DEL user delete";
                $person = json_encode($person);
                $app->response->setBody($person); 
            }
        );


        /*GALLERY ROUTES */
        $app->get(
            '/gallery(/:type)',
            function ($type = "featured") use ($app,$pdo,$config,$session) {
                //sets default type to featured, if it's not passed in

                $query = "SELECT * FROM gallery WHERE type = ? AND flag_deleted is null";
                $type = filter_var($type, FILTER_SANITIZE_STRING);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($type));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $gallery = array();
                
                $gallery[$type] = $result;
                $gallery = json_encode($gallery);
                $app->response->setBody($gallery);
            }
        );
        $app->put(
            '/gallery/:pid',
            function ($pid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/gallery/:pid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/gallery/1
                //Updates supplied data for a gallery photo and then returns the updated gallery entry in JSON

                //TODO: Make UPDATE gallery PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE gallery set foo=bar, baz=bam, date_updated = unixtimestamp WHERE id = ?";
                $uid = filter_var($pid, FILTER_SANITIZE_NUMBER_INT);

                $gallery = array();
                $gallery["item"] = "Not Yet Implemented: PUT user update";
                $gallery = json_encode($gallery);
                $app->response->setBody($gallery); 
            }
        );
        $app->post(
            '/gallery',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/gallery
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/gallery
                //Creates a new gallery item with the supplied data and then returns the new item in JSON

                //TODO: Make CREATE gallery item POST route
                //TODO: Check for dupilclate photo urls

                $query = "INSERT INTO gallery VALUES() FIELDS();";

                $gallery = array();
                $gallery["item"] = "Not Yet Implemented: POST photo create";
                $gallery = json_encode($gallery);
                $app->response->setBody($gallery); 
            }
        );
        $app->delete(
            '/gallery/:pid',
            function ($pid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/gallery/:pid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/gallery/:pid
                //Set the gallery item deleted flag to TRUE

                //TODO: Make delete gellery DEL route
                //TODO: Make sure only admins and users themselves can delete gallery items
                $query = "UPDATE gallery set flag_deleted = 1, date_updated = unixtimestamp WHERE id = ?";

                $gallery = array();
                $gallery["item"] = "Not Yet Implemented: DEL photo delete";
                $gallery = json_encode($gallery);
                $app->response->setBody($gallery); 
            }
        );

        /*MODEL ROUTES */
        $app->get(
            '/model/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:mid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/1234
                //Gets all of the data for a model and outputs json

                $query = "SELECT * FROM models WHERE id = ? AND flag_deleted is null";
                $type = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($mid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model = array();
                
                $model[] = $result;
                $model = json_encode($model);
                $app->response->setBody($model);
            }
        );

        $app->get(
            '/model/:type/:category',
            function ($type, $category) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/mesh/base
                //Gets much of the data for a set of models (meshes, poses, or skeletons) and outputs JSON

                //TODO: make it so you get get your own private models and not other peoples
                //TODO: make it so you don't get hidden models unless you're an admin

                $query = "SELECT id, user_id, model_name, model_short_desc, model_attachment, photo_render, photo_thumbnail, date_created, date_updated, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM models WHERE model_type = ? AND model_category = ? AND flag_deleted is null";
                $type = filter_var($type, FILTER_SANITIZE_STRING);
                $category = filter_var($category, FILTER_SANITIZE_STRING); 

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($type,$category));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model_gallery = array();
                
                $model_gallery[$type] = $result;
                $model_gallery = json_encode($model_gallery);
                $app->response->setBody($model_gallery);
            }
        );
        $app->put(
            '/model/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:pid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/model/1
                //Updates supplied data for a model id and then returns the updated model entry in JSON

                //TODO: Make UPDATE model PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE gallery set foo=bar, baz=bam WHERE id = ?";
                $uid = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);

                $model = array();
                $model["item"] = "Not Yet Implemented: PUT user update";
                $model = json_encode($model);
                $app->response->setBody($model); 
            }
        );
        $app->post(
            '/model',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/model
                //Creates a new model with the supplied data and then returns the new item in JSON

                //TODO: Make CREATE model POST route
                //TODO: Check for dupilclate model data urls

                $query = "INSERT INTO model VALUES() FIELDS();";

                $model = array();
                $model["item"] = "Not Yet Implemented: POST model create";
                $model = json_encode($model);
                $app->response->setBody($model); 
            }
        );
        $app->delete(
            '/model/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:mid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/model/:mid
                //Set the model deleted flag to TRUE

                //TODO: Make delete model DEL route
                //TODO: Make sure only admins and users themselves can delete model items
                $query = "UPDATE model set flag_deleted = 1 WHERE id = ?";

                $model = array();
                $model["item"] = "Not Yet Implemented: DEL model delete";
                $model = json_encode($model);
                $app->response->setBody($model); 
            }
        );

        /*figure ROUTES */
        $app->get(
            '/figure/user/:uid',
            function ($uid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/user/:uid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/user/1234
                //Gets all of the data for a figure based on a user id and outputs json

                $query = "SELECT * FROM figures WHERE user_id = ? AND flag_deleted is null";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($uid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = array();
                
                $figure[] = $result;
                $figure = json_encode($figure);
                $app->response->setBody($figure);
            }
        );
        $app->get(
            '/figure/keywords/:word1((/:word2)/:word3)',
            function ($word1, $word2 = "", $word3 = "") use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:word/:word/:word
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/keywords/knight/fancy
                //Gets all of the data for a figure based on niave searching and outputs json

                $word1 = filter_var($word1, FILTER_SANITIZE_STRING);
                $word2 = filter_var($word2, FILTER_SANITIZE_STRING);
                $word3 = filter_var($word3, FILTER_SANITIZE_STRING);

                $list = $word1;
                $list .= ($word2)? "|".$word2 : "";
                $list .= ($word3)? "|".$word3 : "";

                $query = "SELECT * FROM figures WHERE figure_story REGEXP :list OR figure_description REGEXP :list OR figure_automatic_description REGEXP :list AND flag_deleted is null";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":list",$list);
                $stmt->execute();

                //to debug a query:
                print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = array();
                
                $figure[] = $result;
                $figure = json_encode($figure);
                $app->response->setBody($figure);
            }
        );

        $app->get(
            '/figure/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/mesh/base
                //Gets much of the data for a set of figures (meshes, poses, or skeletons) and outputs JSON

                //TODO: make it so you get get your own private figures and not other peoples
                //TODO: make it so you don't get hidden figures unless you're an admin
                //TODO: make this work with UTF-8  http://hero.50.16.238.24.xip.io/api/v1/figure/16

                $query = "SELECT id, user_id, figure_name, photo_render, photo_thumbnail, date_created, date_updated, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM figures WHERE flag_deleted is null ORDER BY date_created DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                

                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_gallery = array();
                
                $figure_gallery["recent"] = $result;
                $figure_gallery = json_encode($figure_gallery);
                $app->response->setBody($figure_gallery);
            }
        );
        $app->get(
            '/figure/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:mid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/1234
                //Gets all of the data for a figure and outputs json

                $query = "SELECT * FROM figures WHERE id = ? AND flag_deleted is null";
                $type = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($mid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = array();
                
                $figure[] = $result;
                $figure = json_encode($figure);
                $app->response->setBody($figure);
            }
        );
        $app->put(
            '/figure/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:pid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/figure/1
                //Updates supplied data for a figure id and then returns the updated figure entry in JSON

                //TODO: Make UPDATE figure PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE gallery set foo=bar, baz=bam WHERE id = ?";
                $uid = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);

                $figure = array();
                $figure["item"] = "Not Yet Implemented: PUT user update";
                $figure = json_encode($figure);
                $app->response->setBody($figure); 
            }
        );
        $app->post(
            '/figure',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/figure
                //Creates a new figure with the supplied data and then returns the new item in JSON

                //TODO: Make CREATE figure POST route
                //TODO: Check for dupilclate figure data urls

                $query = "INSERT INTO figure VALUES() FIELDS();";

                $figure = array();
                $figure["item"] = "Not Yet Implemented: POST figure create";
                $figure = json_encode($figure);
                $app->response->setBody($figure); 
            }
        );
        $app->delete(
            '/figure/:mid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:mid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/figure/:mid
                //Set the figure deleted flag to TRUE

                //TODO: Make delete figure DEL route
                //TODO: Make sure only admins and users themselves can delete figure items
                $query = "UPDATE figure set flag_deleted = 1 WHERE id = ?";

                $figure = array();
                $figure["item"] = "Not Yet Implemented: DEL figure delete";
                $figure = json_encode($figure);
                $app->response->setBody($figure); 
            }
        );

        /* TODO
        
        TODO: GET / POST / PUT / DELETE ROUTES for tags
        TODO: GET / POST / PUT / DELETE ROUTES for tagging figures
        TODO: GET / POST / PUT / DELETE ROUTES for tagging models
        TODO: GET / POST / PUT / DELETE ROUTES for flagging models, figures NSFW and add them to the admin queue
        TODO: GET / POST / PUT / DELETE ROUTES for liking figures
        TODO: GET / POST / PUT / DELETE ROUTES for model presets

        */
});

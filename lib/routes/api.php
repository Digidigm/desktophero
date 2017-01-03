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

                /* RETURNS
                    {   
                        "user_id":INT,
                        "username":STRING,
                        "email_address":EMAIL STRING",
                        "pass_phrase":"a94a8fe5ccb19ba61c4c0873d391e987982fbbd3",
                        "birthdate":UNIXTIME,
                        "active":BOOL,
                        "preferences":JSON,
                        "first_name":STRING,
                        "last_name":STRING,
                        "token_facebook":STRING TOKEN,
                        "token_google":STRING TOKEN,
                        "photo":S3 URL,
                        "bio":TEXT
                    }
                */

                $user_query = "SELECT * FROM users WHERE user_id = ?";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);

                $stmt = $pdo->prepare($user_query);
                $stmt->execute(array($uid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $person = json_encode($result);
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
                $user_query = "UPDATE users set flag_deleted = true, date_updated = unixtimestamp WHERE user_id = ?";

                $person = array();
                $person["user"] = "Not Yet Implemented: DEL user delete";
                $person = json_encode($person);
                $app->response->setBody($person); 
            }
        );


        /*GALLERY ROUTES */
        $app->get(
            '/gallery/id/:id',
            function ($gid = 1) use ($app,$pdo,$config,$session) {
                //Example: GET http://hero.50.16.238.24.xip.io/api/v1/gallery/id/1
                //Gets the info for a single gallery item from the gallery item ID

                /*
                    {
                        "id":INT,
                        "created":UNIXTIME
                        "figure_id": INT,
                        "user_id": INT,
                        "type": STRING (basically ENUM [print|featured]),
                        "photo": S3 URL,
                        "thumbnail": S3 URL,
                        "caption": STRING,
                        "flag_nsfw":BOOL,
                        "flag_deleted":BOOL,
                        "flag_featured":BOOL
                    }
                */

                $query = "SELECT * FROM gallery WHERE id = ? AND flag_deleted is false";
                $gid = filter_var($gid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($gid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $gallery = json_encode($result[0]);
                $app->response->setBody($gallery);
            }
        );
        $app->get(
            '/gallery(/:type)',
            function ($type = "featured") use ($app,$pdo,$config,$session) {
                //sets default type to featured, if it's not passed in
                //Example: GET http://hero.50.16.238.24.xip.io/api/v1/gallery
                //Gets the all of the info for a list of gallery items based on their type


                /*
                    {"featured": [  {GALLERY ITEM} , {GALLERY ITEM} , {GALLERY ITEM} , {GALLERY ITEM}  ]}
                    See Gallery item above for details

                */

                $query = "SELECT * FROM gallery WHERE type = ? AND flag_deleted is false";
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
                $query = "UPDATE gallery set flag_deleted = true, date_updated = unixtimestamp WHERE id = ?";

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
                //Gets all of the data for a model based on the model id and outputs json

                /*
                    {
                        "id":"1",
                        "user_id": INT,
                        "model_name": STRING  //Human visible readable name
                        "model_data": JSON    //all the stuff we need to make it work
                        "model_story": TEXT,  //user provided story for the model
                        "model_short_desc": STRING   //user provided description of the model
                        "model_category": TEXT (basically ENUM for parts of the models)
                        "model_type": TEXT (basically ENUM for types of models: skeleton, mesh, pose, etc)
                        "model_url" : S3 URL //place where the actual model file is stored
                        "model_attachment": JSON (data about how to combine it with other models in the scene)
                        "photo_render": S3 URL   //screen cap of the model from three.js
                        "photo_inspiration": S3 URL   //upload from the user if they had something they were trying to create
                        "photo_thumbnail": S3 URL   //smaller vesion of the screen cap
                        "flag_chirality" : STRING // R, L, or N for the default chirality of the model right, left, not applicable
                        "flag_nsfw_sex": Bool,  //is the model naked or in an overtly sexually provacative pose
                        "flag_nsfw_violence": Bool,  //is the model gorey or horror-ish in a way that would scare kids (chest burster)
                        "flag_nsfw_other": Bool,  //is the model inappropriate for some other reason (obscene gesture, inappropraite racial stereotype, politically provockative)
                        "flag_deleted": Bool,  //things aren't deleted, theyre just hidde
                        "flag_hidden": Bool,  //when you're "done" the hidden flag is removed
                        "flag_featured": Bool,  //if we like your model, we can feature it
                        "flag_private": Bool,   //if you don't want others to see your model, you can keep it provate
                        "date_created": UNIXTIME,
                        "date_updated": UNIXTIME
                    }

                */

                $query = "SELECT * FROM models WHERE id = ? AND flag_deleted is false";
                $type = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($mid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model = json_encode($result[0]);
                $app->response->setBody($model);
            }
        );
        $app->get(
            '/model/tags/:tid',
            function ($tid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/tags/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/tags/1
                //Gets all of the models for a tag based on tag id and outputs json

                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */

                $query = "SELECT * FROM model_tags WHERE tag_id = ?";
                $tid = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($tid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model_tags = json_encode($result);
                $app->response->setBody($model_tags);
            }
        );
        
         $app->get(
            '/model/by/:attachment/:type',
            function ($attachment, $type) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/by/:attachment/:type
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/by/head/mesh
                //Gets much of the data for a set of models (meshes, poses, or skeletons) by the bone groups it cares about and outputs JSON,
                //so heads, hats, sunglasses, mousaches, bears are all --> head, even if they are different categories and sorts them by category

                //TODO: make it so you get get your own private models and not other peoples
                //TODO: make it so you don't get hidden models unless you're an admin

                /*
                    { "head" : {
                        "hats" : [ {MODEL} , {MODEL}, {MODEL} ],
                        "beards" : [ {MODEL} , {MODEL}, {MODEL} ],
                        "glasses" : [ {MODEL} , {MODEL}, {MODEL} ],
                        "faces" : [ {MODEL} , {MODEL}, {MODEL} ],
                        "hair" : [ {MODEL} , {MODEL}, {MODEL} ]
                        }
                    }
                    See model item above for details
                */

                $query = "SELECT id, user_id, model_name, model_short_desc, model_attachment, model_category, model_url, photo_render, photo_thumbnail, date_created, date_updated, flag_chirality, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM models WHERE model_type = ? AND model_attachment = ? AND flag_deleted is false ORDER BY model_category";
                $type = filter_var($type, FILTER_SANITIZE_STRING);
                $attachment = filter_var($attachment, FILTER_SANITIZE_STRING); 

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($type,$attachment));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model_gallery = array();
                
                $model_gallery[$attachment] = $result;
                $model_gallery = json_encode($model_gallery);
                $app->response->setBody($model_gallery);


                $presets = array();
                foreach($result as $k => $v) {
                    if ( ! isset( $presets[$v["model_attachment"]] )) {
                        $presets[$v["model_attachment"]] = array();    
                    }
                    if ( ! isset( $presets[$v["model_attachment"]][$v['model_category']] )) {
                        $presets[$v["model_attachment"]][$v['model_category']] = array();
                    }
                    $presets[$v["model_attachment"]][$v['model_category']][] = $v;
                }
                
                $presets = json_encode($presets);
                $app->response->setBody($presets);
            }
        );

        $app->get(
            '/model/:type/:category',
            function ($type, $category) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/mesh/base
                //Gets much of the data for a set of models (meshes, poses, or skeletons) and set of categories (head, body, legs, arms, etc) and outputs JSON

                //TODO: make it so you get get your own private models and not other peoples
                //TODO: make it so you don't get hidden models unless you're an admin

                /*
                    { "mesh" : [ {MODEL} , {MODEL}, {MODEL} ]}
                    See model item above for details

                */

                $query = "SELECT id, user_id, model_name, model_short_desc, model_attachment, model_url, photo_render, photo_thumbnail, date_created, date_updated, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM models WHERE model_type = ? AND model_category = ? AND flag_deleted is false";
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

                //TODO: Figure out why i have to do this.  Something is wierd.
                $request = $app->getInstance()->request();
                $body = $request->getBody();
                parse_str($body,$put);

                $model_id = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);
                $model_name = filter_var(                   $put['model_name'], FILTER_SANITIZE_STRING);
                $model_data = filter_var(                   $put['model_data'], FILTER_SANITIZE_STRING);
                $model_story = filter_var(                  $put['model_story'], FILTER_SANITIZE_STRING);
                $model_short_desc = filter_var(             $put['model_short_desc'], FILTER_SANITIZE_STRING);
                $model_category = filter_var(               $put['model_category'], FILTER_SANITIZE_STRING);
                $model_type = filter_var(                   $put['model_type'], FILTER_SANITIZE_STRING);
                $model_url = filter_var(                    $put['model_url'], FILTER_SANITIZE_STRING);
                $model_attachment = filter_var(             $put['model_attachment'], FILTER_SANITIZE_STRING);
                $photo_render = filter_var(                 $put['photo_render'], FILTER_SANITIZE_STRING);
                $photo_inspiration = filter_var(            $put['photo_inspiration'], FILTER_SANITIZE_STRING);
                $photo_thumbnail = filter_var(              $put['photo_thumbnail'], FILTER_SANITIZE_STRING);
                $flag_chirality = filter_var(               $put['flag_chirality'], FILTER_SANITIZE_NUMBER_INT);
                $flag_nsfw_sex = filter_var(                $put['flag_nsfw_sex'], FILTER_SANITIZE_NUMBER_INT);
                $flag_nsfw_violence = filter_var(           $put['flag_nsfw_violence'], FILTER_SANITIZE_NUMBER_INT);
                $flag_nsfw_other = filter_var(              $put['flag_nsfw_other'], FILTER_SANITIZE_NUMBER_INT);
                $flag_deleted = filter_var(                 $put['flag_deleted'], FILTER_SANITIZE_NUMBER_INT);
                $flag_hidden = filter_var(                  $put['flag_hidden'], FILTER_SANITIZE_NUMBER_INT);
                $flag_private = filter_var(                 $put['flag_private'], FILTER_SANITIZE_NUMBER_INT);
                $date_updated = time();

                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE models set `model_name`=:model_name, 
                                            `model_data`=:model_data, 
                                            `model_story`=:model_story,
                                            `model_short_desc`=:model_short_desc,
                                            `model_category`=:model_category,
                                            `model_type`=:model_type,
                                            `model_url`=:model_url, 
                                            `model_attachment`=:model_attachment, 
                                            `photo_render`=:photo_render,
                                            `photo_inspiration`=:photo_inspiration,
                                            `photo_thumbnail`=:photo_thumbnail,
                                            `flag_chirality`=:flag_chirality,
                                            `flag_nsfw_sex`=:flag_nsfw_sex,
                                            `flag_nsfw_violence`=:flag_nsfw_violence,
                                            `flag_nsfw_other`=:flag_nsfw_other,
                                            `flag_deleted`=:flag_deleted,
                                            `flag_hidden`=:flag_hidden,
                                            `flag_private`=:flag_private,
                                            `date_updated`= :date_updated
                                            WHERE id = :model_id";
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":model_name",        $model_name);
                $stmt->bindValue(":model_data",        $model_data);
                $stmt->bindValue(":model_story",       $model_story);
                $stmt->bindValue(":model_short_desc",  $model_short_desc);
                $stmt->bindValue(":model_category",    $model_category);
                $stmt->bindValue(":model_type",        $model_type);
                $stmt->bindValue(":model_url",         $model_url);
                $stmt->bindValue(":model_attachment",  $model_attachment);
                $stmt->bindValue(":photo_render",      $photo_render);
                $stmt->bindValue(":photo_inspiration", $photo_inspiration);
                $stmt->bindValue(":photo_thumbnail",   $photo_thumbnail);
                $stmt->bindValue(":flag_chirality",    $flag_chirality);
                $stmt->bindValue(":flag_nsfw_sex",     (int)$flag_nsfw_sex,PDO::PARAM_INT);
                $stmt->bindValue(":flag_nsfw_violence",(int)$flag_nsfw_violence,PDO::PARAM_INT);
                $stmt->bindValue(":flag_nsfw_other",   (int)$flag_nsfw_other,PDO::PARAM_INT);
                $stmt->bindValue(":flag_deleted",      (int)$flag_deleted,PDO::PARAM_INT);
                $stmt->bindValue(":flag_hidden",       (int)$flag_hidden,PDO::PARAM_INT);
                $stmt->bindValue(":flag_private",      (int)$flag_private,PDO::PARAM_INT);
                $stmt->bindValue(":date_updated",      (int)$date_updated,PDO::PARAM_INT);
                $stmt->bindValue(":model_id",          (int)$model_id, PDO::PARAM_INT);
                $stmt->execute();

                //TODO: make this handle not being successful
                $model = array();
                $model["result"] = "success";
                $model = json_encode($model);

                $arr = $stmt->errorInfo();
                print_r($arr);
                //print_r($stmt->debugDumpParams());

                $app->response->setBody($model); 
            }
        );
        $app->post(
            '/model',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/figure
                //Creates a new model with the supplied data and then returns the new item in JSON
                //This route doesn't take any parameters and only creates a stub entry that is updated or later deleted

                $query = "INSERT INTO models (`user_id`,`date_created`,`date_updated`,`flag_hidden`,`flag_private`) VALUES (0,'UNIX_TIMESTAMP(now())','UNIX_TIMESTAMP(now())',1,1);";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute();

                $model = array("id" => $pdo->lastInsertID() );
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
                $query = "UPDATE model set flag_deleted = true WHERE id = ?";

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
                //Gets all of the data for figures based on a user id and outputs json

                /*
                    [ {MODEL} , {MODEL}, {MODEL} ]
                    See model item above for details

                */

                $query = "SELECT * FROM figures WHERE user_id = ? AND flag_deleted is false";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($uid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = json_encode($result);
                $app->response->setBody($figure);
            }
        );
        $app->get(
            '/figure/featured',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/featured
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/featured
                //Gets all of the data for figures based on the featured flag

                /*
                    [ {MODEL} , {MODEL}, {MODEL} ]
                    See model item above for details

                */

                $query = "SELECT * FROM figures WHERE flag_featured = 1 AND flag_deleted is false";
                $uid = filter_var($uid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($uid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = json_encode($result);
                $app->response->setBody($figure);
            }
        );
        $app->get(
            '/figure/keywords/:word1((/:word2)/:word3)',
            function ($word1, $word2 = "", $word3 = "") use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:word/:word/:word
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/keywords/knight/fancy
                //Gets all of the data for a figure based on niave searching and outputs json

                 /*
                    [ {MODEL} , {MODEL}, {MODEL} ]
                    See model item above for details

                */

                $word1 = filter_var($word1, FILTER_SANITIZE_STRING);
                $word2 = filter_var($word2, FILTER_SANITIZE_STRING);
                $word3 = filter_var($word3, FILTER_SANITIZE_STRING);

                $list = $word1;
                $list .= ($word2)? "|".$word2 : "";
                $list .= ($word3)? "|".$word3 : "";

                $query = "SELECT * FROM figures WHERE figure_story REGEXP :list OR figure_description REGEXP :list OR figure_automatic_description REGEXP :list AND flag_deleted is false";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":list",$list);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure = json_encode($result);
                $app->response->setBody($figure);
            }
        );

        $app->get(
            '/figure/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/mesh/base
                //Gets some of the data for a set of figures (meshes, poses, or skeletons) and outputs JSON

                /*
                    { "recent" : [ {MODEL} , {MODEL}, {MODEL} ]}
                    See model item above for details

                */

                //TODO: make it so you get get your own private figures and not other peoples
                //TODO: make it so you don't get hidden figures unless you're an admin
                //TODO: make this work with UTF-8  http://hero.50.16.238.24.xip.io/api/v1/figure/16

                $query = "SELECT id, user_id, figure_name, photo_render, photo_thumbnail, date_created, date_updated, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM figures WHERE flag_deleted is false ORDER BY date_created DESC LIMIT :num";
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

                /*

                    {
                        "id":"1",
                        "user_id": INT,
                        "figure_name": STRING  //Human visible readable name
                        "figure_data": JSON    //all the stuff we need to make it work
                        "figure_story":  TEXT,  //user provided story for the model
                        "figure_description": STRING   //user provided description of the model
                        "figure_automatic_description": STRING   //computer provided description of the figure based on models and tags used
                        "photo_render": S3 URL   //screen cap of the model from three.js
                        "photo_inspiration": S3 URL   //upload from the user if they had something they were trying to create
                        "photo_thumbnail": S3 URL   //smaller vesion of the screen cap
                        "flag_nsfw_sex": Bool,  //is the model naked or in an overtly sexually provacative pose
                        "flag_nsfw_violence": Bool,  //is the model gorey or horror-ish in a way that would scare kids (chest burster)
                        "flag_nsfw_other": Bool,  //is the model inappropriate for some other reason (obscene gesture, inappropraite racial stereotype, politically provockative)
                        "flag_deleted": Bool,  //things aren't deleted, theyre just hidde
                        "flag_hidden": Bool,  //when you're "done" the hidden flag is removed
                        "flag_featured": Bool,  //if we like your model, we can feature it
                        "flag_private": Bool,   //if you don't want others to see your model, you can keep it provate
                        "date_created": UNIXTIME,
                        "date_updated": UNIXTIME
                        "count_downloads":"1",
                        "count_views":"3"
                    }
                */

                $query = "SELECT * FROM figures WHERE id = ? AND flag_deleted is false";
                $type = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($mid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result)) {
                    $figure = json_encode($result[0]);
                    $app->response->setBody($figure);    
                } else {
                    $app->response->setBody("error");
                }
                
            }
        );
        $app->put(
            '/figure/:fid',
            function ($fid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/:fid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/figure/1
                //Updates supplied data for a figure id and then returns the updated figure entry in JSON

                //TODO: Figure out why i have to do this.  Something is wierd.
                $request = $app->getInstance()->request();
                $body = $request->getBody();
                parse_str($body,$put);

                $figure_id = filter_var($fid, FILTER_SANITIZE_NUMBER_INT);
                $figure_name = filter_var(                  $put['figure_name'], FILTER_SANITIZE_STRING);
                $figure_data = filter_var(                  $put['figure_data'], FILTER_SANITIZE_STRING);
                $figure_story = filter_var(                 $put['figure_story'], FILTER_SANITIZE_STRING);
                $figure_description = filter_var(           $put['figure_description'], FILTER_SANITIZE_STRING);
                $figure_automatic_description = filter_var( $put['figure_automatic_description'], FILTER_SANITIZE_STRING);
                $photo_render = filter_var(                 $put['photo_render'], FILTER_SANITIZE_STRING);
                $photo_inspiration = filter_var(            $put['photo_inspiration'], FILTER_SANITIZE_STRING);
                $photo_thumbnail = filter_var(              $put['photo_thumbnail'], FILTER_SANITIZE_STRING);
                $flag_nsfw_sex = filter_var(                $put['flag_nsfw_sex'], FILTER_SANITIZE_NUMBER_INT);
                $flag_nsfw_violence = filter_var(           $put['flag_nsfw_violence'], FILTER_SANITIZE_NUMBER_INT);
                $flag_nsfw_other = filter_var(              $put['flag_nsfw_other'], FILTER_SANITIZE_NUMBER_INT);
                $flag_deleted = filter_var(                 $put['flag_deleted'], FILTER_SANITIZE_NUMBER_INT);
                $flag_hidden = filter_var(                  $put['flag_hidden'], FILTER_SANITIZE_NUMBER_INT);
                $flag_featured = filter_var(                $put['flag_featured'], FILTER_SANITIZE_NUMBER_INT);
                $flag_private = filter_var(                 $put['flag_private'], FILTER_SANITIZE_NUMBER_INT);
                $date_updated = time();

                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE figures set`figure_name`=:figure_name, 
                                            `figure_data`=:figure_data, 
                                            `figure_story`=:figure_story,
                                            `figure_description`=:figure_description,
                                            `figure_automatic_description`=:figure_automatic_description,
                                            `photo_render`=:photo_render,
                                            `photo_inspiration`=:photo_inspiration,
                                            `photo_thumbnail`=:photo_thumbnail,
                                            `flag_nsfw_sex`=:flag_nsfw_sex,
                                            `flag_nsfw_violence`=:flag_nsfw_violence,
                                            `flag_nsfw_other`=:flag_nsfw_other,
                                            `flag_deleted`=:flag_deleted,
                                            `flag_hidden`=:flag_hidden,
                                            `flag_featured`=:flag_featured,
                                            `flag_private`=:flag_private,
                                            `date_updated`= :date_updated
                                            WHERE id = :figure_id";
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":figure_name",       $figure_name);
                $stmt->bindValue(":figure_data",       $figure_data);
                $stmt->bindValue(":figure_story",      $figure_story);
                $stmt->bindValue(":figure_description",$figure_description);
                $stmt->bindValue(":figure_automatic_description",  $figure_automatic_description);
                $stmt->bindValue(":photo_render",      $photo_render);
                $stmt->bindValue(":photo_inspiration", $photo_inspiration);
                $stmt->bindValue(":photo_thumbnail",   $photo_thumbnail);
                $stmt->bindValue(":flag_nsfw_sex",     (int)$flag_nsfw_sex,PDO::PARAM_INT);
                $stmt->bindValue(":flag_nsfw_violence",(int)$flag_nsfw_violence,PDO::PARAM_INT);
                $stmt->bindValue(":flag_nsfw_other",   (int)$flag_nsfw_other,PDO::PARAM_INT);
                $stmt->bindValue(":flag_deleted",      (int)$flag_deleted,PDO::PARAM_INT);
                $stmt->bindValue(":flag_hidden",       (int)$flag_hidden,PDO::PARAM_INT);
                $stmt->bindValue(":flag_featured",     (int)$flag_featured,PDO::PARAM_INT);
                $stmt->bindValue(":flag_private",      (int)$flag_private,PDO::PARAM_INT);
                $stmt->bindValue(":date_updated",      (int)$date_updated,PDO::PARAM_INT);
                $stmt->bindValue(":figure_id",         (int)$figure_id, PDO::PARAM_INT);
                $stmt->execute();

                //TODO: make this handle not being successful
                $figure = array();
                $figure["result"] = "success";
                $figure = json_encode($figure);

                //$arr = $stmt->errorInfo();
                //print_r($arr);
                //print_r($stmt->debugDumpParams());

                $app->response->setBody($figure); 
            }
        );
        $app->post(
            '/figure',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/figure
                //Creates a new figure with the supplied data and then returns the new item in JSON
                //This route doesn't take any parameters and only creates a stub entry that is updated or later deleted

                //TODO: Make CREATE figure POST route
                //TODO: Check for dupilclate figure data url

                $query = "INSERT INTO figures (`user_id`,`date_created`,`date_updated`,`count_downloads`,`count_views`,`flag_hidden`,`flag_private`) VALUES (0,'UNIX_TIMESTAMP(now())','UNIX_TIMESTAMP(now())',0,0,1,1);";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute();

                $figure = array("id" => $pdo->lastInsertID() );
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
                $query = "UPDATE figure set flag_deleted = true WHERE id = ?";

                $figure = array();
                $figure["item"] = "Not Yet Implemented: DEL figure delete";
                $figure = json_encode($figure);
                $app->response->setBody($figure); 
            }
        );

        /*TAGS Routes */
        $app->get(
            '/tags/keywords/:word1((/:word2)/:word3)',
            function ($word1, $word2 = "", $word3 = "") use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:word/:word/:word
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/keywords/knight/fancy
                //Gets all of the data for tags based on niave searching of name, hint, and synonyms and outputs json
                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */


                $word1 = filter_var($word1, FILTER_SANITIZE_STRING);
                $word2 = filter_var($word2, FILTER_SANITIZE_STRING);
                $word3 = filter_var($word3, FILTER_SANITIZE_STRING);

                $list = $word1;
                $list .= ($word2)? "|".$word2 : "";
                $list .= ($word3)? "|".$word3 : "";

                $query = "SELECT * FROM tags WHERE tag_hint REGEXP :list OR tag_label REGEXP :list OR tag_synonyms REGEXP :list AND flag_deleted is false";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":list",$list);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $tags = json_encode($result);
                $app->response->setBody($tags);
            }
        );
        $app->get(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:mid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/1234
                //Gets all of the data for a tags and outputs json

                /*
                    {
                        "id": INT
                        "tag_hint": STRING - Typically of the CLASS:PROPERTY format to facilitate searching
                        "tag_label": STRING - Short label for use in the UI,
                        "tag_synonyms": STRING - comma separated list for use in searching,
                        "tag_type" : STRING - categorization, bascailly ENUM for genres, presets, user entered data, et al
                        "flag_nsfw": BOOL - is the tag objectionable,
                        "flag_approved": BOOL - admin approved for use,
                        "flag_deleted": BOOL - available,
                        "created_by": INT user_id,
                        "created": UNIXTIME
                        "thumbnail" : S3 Thumbnail image
                    }
                */

                $query = "SELECT * FROM tags WHERE id = ? AND flag_deleted is false";
                $type = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($tid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $tags = json_encode($result[0]);
                $app->response->setBody($tags);
            }
        );
        $app->get(
            '/tags/by/:type',
            function ($type) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/by/genre
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/by/genre
                //Gets all of the data for a tags in the tag type and outputs json


                $query = "SELECT * FROM tags WHERE tag_type = ? AND flag_deleted is false";
                $type = filter_var($type, FILTER_SANITIZE_STRING);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($type));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $tags = json_encode($result);
                $app->response->setBody($tags);
            }
        );
        $app->get(
            '/tags/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_tags/recent/10
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/tags/recent/10
                //Gets tags that have recently been added to the system (they may or may not have been associated with any figures or models yet)

                /*
                    {"recently_added_tags": [ {TAG}, {TAG}, {TAG} ] }
                */

                //TODO: make it so you don't get hidden figure_tags unless you're an admin

                $query = "SELECT * FROM tags ORDER BY created DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_tags_gallery = array();
                
                $figure_tags_gallery["recently_added_tags"] = $result;
                $figure_tags_gallery = json_encode($figure_tags_gallery);
                $app->response->setBody($figure_tags_gallery);
            }
        );
        $app->put(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:pid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/tags/1
                //Updates supplied data for a tags id and then returns the updated tags entry in JSON

                //TODO: Make UPDATE tags PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE gallery set foo=bar, baz=bam WHERE id = ?";
                $uid = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);

                $tags = array();
                $tags["item"] = "Not Yet Implemented: PUT user update";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );
        $app->post(
            '/tags',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/tags
                //Creates a new tags with the supplied data and then returns the new item in JSON

                //TODO: Make CREATE tags POST route
                //TODO: Check for dupilclate tags data urls

                $query = "INSERT INTO tags VALUES() FIELDS();";

                $tags = array();
                $tags["item"] = "Not Yet Implemented: POST tags create";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );
        $app->delete(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:mid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/tags/:mid
                //Set the tags deleted flag to TRUE

                //TODO: Make delete tags DEL route
                //TODO: Make sure only admins and users themselves can delete tags items
                $query = "UPDATE tags set flag_deleted = true WHERE id = ?";

                $tags = array();
                $tags["item"] = "Not Yet Implemented: DEL tags delete";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );

        /* FIGURE TAG ROUTES */
        $app->get(
            '/tags/figure/:fid',
            function ($fid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/figure/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/figure/1
                //Gets all of the tags for a figure based on a figure id and outputs json

                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */

                $query = "SELECT * FROM figure_tags WHERE figure_id = ?";
                $fid = filter_var($fid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($fid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_tags = json_encode($result);
                $app->response->setBody($figure_tags);
            }
        );
        $app->get(
            '/figure/tags/:tid',
            function ($tid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/tags/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/tags/1
                //Gets all of the figures for a tag based on tag id and outputs json

                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */

                $query = "SELECT * FROM figure_tags WHERE tag_id = ?";
                $tid = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($tid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_tags = json_encode($result);
                $app->response->setBody($figure_tags);
            }
        );

        $app->get(
            '/figure/tags/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_tags/recent/10
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/tags/recent/10
                //Gets tags that have recently been added to any figure

                 /*
                    {"recent_tags": [ {TAG}, {TAG}, {TAG} ] }
                */

                //TODO: make it so you don't get hidden figure_tags unless you're an admin

                $query = "SELECT * FROM figure_tags ORDER BY whence DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_tags_gallery = array();
                
                $figure_tags_gallery["recent_tags"] = $result;
                $figure_tags_gallery = json_encode($figure_tags_gallery);
                $app->response->setBody($figure_tags_gallery);
            }
        );
        $app->put(
            '/figure/tags/',
            function () use ($app,$pdo,$config,$session) {
                //NOT IMPLEMENTED.  Tags mappings should not be edited but deleted and recreated
                //TODO: Make this output the right HTTP code for NOT IMPLEMENTED
                $app->response->setBody("<h1>Not Implemented</h1>");
            }
        );
        $app->post(
            '/figure/tags/:fid/:tid',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_tags
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/figure_tags
                //Adds a tag to a figure

                //TODO: Make CREATE figure_tags POST route
                //TODO: Check for dupilclate figure_tags data urls

                $query = "INSERT INTO figure_tags VALUES() FIELDS();";

                $figure_tags = array();
                $figure_tags["item"] = "Not Yet Implemented: POST figure_tags create";
                $figure_tags = json_encode($figure_tags);
                $app->response->setBody($figure_tags); 
            }
        );
        $app->delete(
            '/figure/tags/:fid/:tid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_tags/:fid/:tid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/figure_tags/:fid/:tid
                //Deletes tag TID from figure FID

                //TODO: Make delete figure_tags DEL route
                //TODO: Make sure only admins and users themselves can delete figure_tags items
                $query = "DELETE FROM figure_tags set flag_deleted = true WHERE id = ? AND id = ?";

                $figure_tags = array();
                $figure_tags["item"] = "Not Yet Implemented: DEL figure_tags delete";
                $figure_tags = json_encode($figure_tags);
                $app->response->setBody($figure_tags); 
            }
        );

        /* MODEL TAG ROUTES */
        $app->get(
            '/tags/model/:fid',
            function ($fid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/model/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/model/1
                //Gets all of the tags for a model based on a model id and outputs json

                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */

                $query = "SELECT * FROM model_tags WHERE model_id = ?";
                $fid = filter_var($fid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($fid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model_tags = json_encode($result);
                $app->response->setBody($model_tags);
            }
        );
        
        //ROUTE FOR GET /MODEL/TAGS/:ID  moved to the model block above to avoid collisions

        $app->get(
            '/model/tags/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model_tags/recent/10
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/model/tags/recent/10
                //Gets tags that have recently been added to any model

                 /*
                    {"recent_tags": [ {TAG}, {TAG}, {TAG} ] }
                */

                //TODO: make it so you don't get hidden model_tags unless you're an admin

                $query = "SELECT * FROM model_tags ORDER BY whence DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $model_tags_gallery = array();
                
                $model_tags_gallery["recent_tags"] = $result;
                $model_tags_gallery = json_encode($model_tags_gallery);
                $app->response->setBody($model_tags_gallery);
            }
        );
        $app->put(
            '/model/tags/',
            function () use ($app,$pdo,$config,$session) {
                //NOT IMPLEMENTED.  Tags mappings should not be edited but deleted and recreated
                //TODO: Make this output the right HTTP code for NOT IMPLEMENTED
                $app->response->setBody("<h1>Not Implemented</h1>");
            }
        );
        $app->post(
            '/model/tags/:fid/:tid',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model_tags
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/model_tags
                //Adds a tag to a model

                //TODO: Make CREATE model_tags POST route
                //TODO: Check for dupilclate model_tags data urls

                $query = "INSERT INTO model_tags VALUES() FIELDS();";

                $model_tags = array();
                $model_tags["item"] = "Not Yet Implemented: POST model_tags create";
                $model_tags = json_encode($model_tags);
                $app->response->setBody($model_tags); 
            }
        );
        $app->delete(
            '/model/tags/:fid/:tid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model_tags/:fid/:tid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/model_tags/:fid/:tid
                //Deletes tag TID from model FID

                //TODO: Make delete model_tags DEL route
                //TODO: Make sure only admins and users themselves can delete model_tags items
                $query = "DELETE FROM model_tags set flag_deleted = true WHERE id = ? AND id = ?";

                $model_tags = array();
                $model_tags["item"] = "Not Yet Implemented: DEL model_tags delete";
                $model_tags = json_encode($model_tags);
                $app->response->setBody($model_tags); 
            }
        );


        /*TAGS Routes */
        $app->get(
            '/tags/keywords/:word1((/:word2)/:word3)',
            function ($word1, $word2 = "", $word3 = "") use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:word/:word/:word
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/keywords/knight/fancy
                //Gets all of the data for tags based on niave searching of name, hint, and synonyms and outputs json
                /*
                    [ {TAG}, {TAG}, {TAG} ]
                */


                $word1 = filter_var($word1, FILTER_SANITIZE_STRING);
                $word2 = filter_var($word2, FILTER_SANITIZE_STRING);
                $word3 = filter_var($word3, FILTER_SANITIZE_STRING);

                $list = $word1;
                $list .= ($word2)? "|".$word2 : "";
                $list .= ($word3)? "|".$word3 : "";

                $query = "SELECT * FROM tags WHERE tag_hint REGEXP :list OR tag_label REGEXP :list OR tag_synonyms REGEXP :list AND flag_deleted is false";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(":list",$list);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $tags = json_encode($result);
                $app->response->setBody($tags);
            }
        );
        $app->get(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:mid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/tags/1234
                //Gets all of the data for a tags and outputs json

                /*
                    {
                        "id": INT
                        "tag_hint": STRING - Typically of the CLASS:PROPERTY format to facilitate searching
                        "tag_label": STRING - Short label for use in the UI,
                        "tag_synonyms": STRING - comma separated list for use in searching,
                        "flag_nsfw": BOOL - is the tag objectionable,
                        "flag_approved": BOOL - admin approved for use,
                        "flag_deleted": BOOL - available,
                        "created_by": INT user_id,
                        "created": UNIXTIME
                    }
                */

                $query = "SELECT * FROM tags WHERE id = ? AND flag_deleted is false";
                $type = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($tid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $tags = json_encode($result[0]);
                $app->response->setBody($tags);
            }
        );
        $app->get(
            '/tags/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_tags/recent/10
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/tags/recent/10
                //Gets tags that have recently been added to the system (they may or may not have been associated with any figures or models yet)

                /*
                    {"recently_added_tags": [ {TAG}, {TAG}, {TAG} ] }
                */

                //TODO: make it so you don't get hidden figure_tags unless you're an admin

                $query = "SELECT * FROM tags ORDER BY created DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_tags_gallery = array();
                
                $figure_tags_gallery["recently_added_tags"] = $result;
                $figure_tags_gallery = json_encode($figure_tags_gallery);
                $app->response->setBody($figure_tags_gallery);
            }
        );
        $app->put(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:pid
                //Example:  PUT http://hero.50.16.238.24.xip.io/api/v1/tags/1
                //Updates supplied data for a tags id and then returns the updated tags entry in JSON

                //TODO: Make UPDATE tags PUT route
                //TODO: Make PUT route only work for Admins and the user himself
                $query = "UPDATE gallery set foo=bar, baz=bam WHERE id = ?";
                $uid = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);

                $tags = array();
                $tags["item"] = "Not Yet Implemented: PUT user update";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );
        $app->post(
            '/tags',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/tags
                //Creates a new tags with the supplied data and then returns the new item in JSON

                //TODO: Make CREATE tags POST route
                //TODO: Check for dupilclate tags data urls

                $query = "INSERT INTO tags VALUES() FIELDS();";

                $tags = array();
                $tags["item"] = "Not Yet Implemented: POST tags create";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );
        $app->delete(
            '/tags/:tid',
            function ($tid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/tags/:mid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/tags/:mid
                //Set the tags deleted flag to TRUE

                //TODO: Make delete tags DEL route
                //TODO: Make sure only admins and users themselves can delete tags items
                $query = "UPDATE tags set flag_deleted = true WHERE id = ?";

                $tags = array();
                $tags["item"] = "Not Yet Implemented: DEL tags delete";
                $tags = json_encode($tags);
                $app->response->setBody($tags); 
            }
        );

        /* FIGURE LIKES ROUTES */
        $app->get(
            '/likes/figure/:fid',
            function ($fid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/likes/figure/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/likes/figure/1
                //Gets all of the likes based on a figure id and outputs json

                /*
                    [ {LIKE}, {LIKE}, {LIKE} ]
                */

                //TODO: join the tables so you get some basic data from user and figure

                $query = "SELECT * FROM figure_likes WHERE figure_id = ?";
                $fid = filter_var($fid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($fid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_likes = json_encode($result);
                $app->response->setBody($figure_likes);
            }
        );
        $app->get(
            '/likes/user/:uid',
            function ($tid = 1) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure/likes/:fid
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/likes/1
                //Gets all of the likes from a user id and outputs json

                /*
                    [ {LIKE}, {LIKE}, {LIKE} ]
                */

                //TODO: join the tables so you get some basic data from user and figure

                $query = "SELECT * FROM figure_likes WHERE user_id = ?";
                $tid = filter_var($tid, FILTER_SANITIZE_NUMBER_INT);   

                $stmt = $pdo->prepare($query);
                $stmt->execute(array($tid));

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_likes = json_encode($result);
                $app->response->setBody($figure_likes);
            }
        );

        $app->get(
            '/likes/recent(/:num)',
            function ($num = 10) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_likes/recent/10
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/figure/likes/recent/10
                //Gets likes that have recently been added to any figure

                 /*
                    {"recent_likes": [ {LIKE}, {LIKE}, {LIKE} ] }
                */

                //TODO: make it so you don't get hidden figure_likes unless you're an admin
                //TODO: join the tables so you get some basic data from user and figure

                $query = "SELECT * FROM figure_likes ORDER BY whence DESC LIMIT :num";
                $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);  
                
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $figure_likes_gallery = array();
                
                $figure_likes_gallery["recent_likes"] = $result;
                $figure_likes_gallery = json_encode($figure_likes_gallery);
                $app->response->setBody($figure_likes_gallery);
            }
        );
        $app->put(
            '/figure/likes/',
            function () use ($app,$pdo,$config,$session) {
                //NOT IMPLEMENTED.  likes mappings should not be edited but deleted and recreated
                //TODO: Make this output the right HTTP code for NOT IMPLEMENTED
                $app->response->setBody("<h1>Not Implemented</h1>");
            }
        );
        $app->post(
            '/figure/likes/:fid/:tid',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_likes
                //Example:  POST http://hero.50.16.238.24.xip.io/api/v1/figure_likes
                //Adds a tag to a figure

                //TODO: Make CREATE figure_likes POST route
                //TODO: Check for dupilclate figure_likes data urls

                $query = "INSERT INTO figure_likes VALUES() FIELDS();";

                $figure_likes = array();
                $figure_likes["item"] = "Not Yet Implemented: POST figure_likes create";
                $figure_likes = json_encode($figure_likes);
                $app->response->setBody($figure_likes); 
            }
        );
        $app->delete(
            '/figure/likes/:fid/:tid',
            function ($mid) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/figure_likes/:fid/:tid
                //Example:  DEL http://hero.50.16.238.24.xip.io/api/v1/figure_likes/:fid/:tid
                //Deletes tag TID from figure FID

                //TODO: Make delete figure_likes DEL route
                //TODO: Make sure only admins and users themselves can delete figure_likes items
                $query = "DELETE FROM figure_likes set flag_deleted = true WHERE id = ? AND id = ?";

                $figure_likes = array();
                $figure_likes["item"] = "Not Yet Implemented: DEL figure_likes delete";
                $figure_likes = json_encode($figure_likes);
                $app->response->setBody($figure_likes); 
            }
        );

        $app->get(
            '/preset/all',
            function () use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/preset/morph/race
                //Gets much of the data for a set of models morph targets and outputs JSON

                /*  { 
                        morph: {
                            age: [ [preset],[preset],[preset],[preset],[preset],[preset] ],
                            stature: [ [preset],[preset],[preset],[preset],[preset],[preset] ],
                            ....
                        }
                    }                    

                */

                $query = "SELECT id, user_id, preset_name, preset_short_desc, preset_category, preset_type, photo_render, photo_thumbnail, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM model_presets WHERE flag_deleted is false ORDER BY preset_type,preset_category,ordinality";
                
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                //to debug a query:
                //print_r($stmt->debugDumpParams() );
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $presets = array();
                foreach($result as $k => $v) {
                    if ( ! isset( $presets[$v["preset_type"]] )) {
                        $presets[$v["preset_type"]] = array();    
                    }
                    if ( ! isset( $presets[$v["preset_type"]][$v['preset_category']] )) {
                        $presets[$v["preset_type"]][$v['preset_category']] = array();
                    }
                    $presets[$v["preset_type"]][$v['preset_category']][] = $v;
                }
                
                $presets = json_encode($presets);
                $app->response->setBody($presets);
            }
        );
        $app->get(
            '/preset/:type/:category',
            function ($type, $category) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/preset/morph/race
                //Gets much of the data for a set of models morph targets and outputs JSON

                //TODO: make it so you get get your own private models and not other peoples
                //TODO: make it so you don't get hidden models unless you're an admin

                /*
                    { "mesh" : [ {MODEL} , {MODEL}, {MODEL} ]}
                    See model item above for details

                */

                $query = "SELECT id, user_id, preset_name, preset_short_desc, preset_category, preset_type, photo_render, photo_thumbnail, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM model_presets WHERE preset_type = ? AND preset_category = ? AND flag_deleted is false ORDER By ordinality";
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
        $app->get(
            '/preset/all/:category',
            function ($type, $category) use ($app,$pdo,$config,$session) {
                // [[HOST]]/api/v1/model/:type/:category
                //Example:  GET http://hero.50.16.238.24.xip.io/api/v1/preset/morph/race
                //Gets much of the data for a set of models morph targets and outputs JSON

                //TODO: make it so you get get your own private models and not other peoples
                //TODO: make it so you don't get hidden models unless you're an admin

                /*
                    { "mesh" : [ {MODEL} , {MODEL}, {MODEL} ]}
                    See model item above for details

                */

                $query = "SELECT id, user_id, preset_name, preset_short_desc, preset_category, preset_type, photo_render, photo_thumbnail, flag_nsfw_sex, flag_nsfw_violence, flag_nsfw_other FROM models_presets WHERE preset_type = ? AND preset_category = ? AND flag_deleted is false";
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
        $app->get(
            '/uploads',
            function () use ($app,$pdo,$config,$session) {

                //TODO: Make sure this is only available to LOGGED IN users

                date_default_timezone_set("America/New_York");
                $awsKey = 'AKIAILPAAMGAY7QOWT7Q';
                $awsSecret = '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';
                $s3Bucket = 'desktop-hero';
                $region = '';
                $acl = 'public-read';
                $date = gmdate("Ymd\THis\Z");
                $shortDate = gmdate("Ymd");
                $url = "https://desktop-hero.s3.amazonaws.com";
                $expy = gmdate('Y-m-d\TG:i:s\Z', strtotime('+6 hours'));
                $redirect = "#";
                //$key is the name of the file based on the upload
                //$Content-Type is the type of the content based on the upload
                //These are filled in here with the signature so it knows to expect this part to be variable

                //DO NOT MODIFY THIS AT ALL, EVEN WHITESPACE
                $policy = "{
                    'expiration': '$expy',
                    'conditions': [
                        {
                            'acl': '$acl'
                        },
                        {
                            'success_action_redirect': '$redirect',
                        },
                        {
                            'bucket':'$s3Bucket',
                        },
                        [
                            'starts-with',
                            '\$key',
                            ''
                        ],
                        [
                            'starts-with',
                            '\$Content-Type',
                            ''
                        ]
                    ]
                }";
                $policyB64 = base64_encode($policy);
                $signature = base64_encode(hash_hmac( 'sha1', base64_encode(utf8_encode($policy)), $awsSecret, true));

                $return = array(
                    "url" => $url,
                    "key" => "filename",
                    "Content-Type" => "content/type",
                    "AWSAccessKeyId" => $awsKey,
                    "acl" => $acl,
                    "success_action_redirect" => $redirect,
                    "policy" => $policyB64,
                    "signature" => $signature
                );
                $app->response->setBody( json_encode($return) );
            }
        );

        /* TODO

        TODO: GET / POST / PUT / DELETE ROUTES for flagging models, figures NSFW and add them to the admin queue
        TODO: GET / POST / PUT / DELETE ROUTES for model presets

        */
});

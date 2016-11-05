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
        $app->get(
            '/person/:id',
            function ($id) use ($app,$pdo,$config,$session) {
                $person_query = "SELECT * FROM Person WHERE personNum = :id";
                $stmt = oci_parse($pdo,$person_query);
                oci_bind_by_name($stmt,":id",$id,10);
                oci_execute($stmt);
                $result = oci_fetch_assoc($stmt);
                $lc_result = array();
                foreach ($result as $k => $v) {
                    $lc_result[strtolower($k)] = $v;
                }
                $person["person"] = $lc_result;
                $person = json_encode($person);
                $app->response->setBody($person);
            }
        );
        $app->get(
            '/subscribers',
            function () use ($app,$pdo,$config,$session) {
                //CHECK THAT current session has a valid token and that user.id value
                //has rights to access the end point.
                //check that the session user has permission to access end point
                //this ACL check should be done in a before handler
                $subscriber_query = "SELECT subscriber_personnum person_num,socialsec social_sec, first firstname, last lastname, dentaleffective dental_effective,dentalexpires dental_expires, eprnum employer FROM L55.vw_dnt_subscribers_all OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
                $offset = 0;
                $limit = 10;
                $stmt = oci_parse($pdo,$subscriber_query);
                oci_bind_by_name($stmt,":offset",$offset);
                oci_bind_by_name($stmt,":limit",$limit);
                oci_execute($stmt);
                $results = array();
                while (( $row = oci_fetch_assoc($stmt)) != false){
                    $normal = array();
                    foreach($row as $k => $v) {    
                        $normal[strtolower($k)] = $v;
                    }
                    array_push($results,$normal);
                }
                $subscribers['subscribers'] = $results;
                $data = json_encode($subscribers); 
                $app->response->setBody($data);
            }
        );
        $app->get(
            '/interface/actions/subscriber',
            function () use ($app,$pdo,$config,$session) {
                $dummy_data = '
            {
                "actions" : ["Select an option","Person Info", "Person Health Info","Dependents","Claims","Subscriber Labels","No Action"]
            }
                ';
                $app->response->setBody($dummy_data);
            }
        );
        $app->get(
            '/interface/actions/main',
            function () use ($app,$pdo,$config,$session) {
                $dummy_data = '
            {
                "actions" :
           ["Select an option","Reimbursement Types","Dental Type Limits","Employer Limit Schedule","Vax Modality Update","Vax Claims","Check Management","-----","Exit Form", "No Action"]
            }
                ';
                $app->response->setBody($dummy_data);
            }
        );
});

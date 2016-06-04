<?php
    /**
     * Created by PhpStorm.
     * User: mitesh
     * Date: 20/5/16
     * Time: 6:13 PM
     */

    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    $request = file_get_contents('php://input');

    $post_data = json_decode($request); //pr($post_data);

    if(isset($post_data->key) && $post_data->key == KEY) {

        if(empty($post_data->data->username) || empty($post_data->data->password)) {
            $data['status'] = 'false'; //false
            $data['msg'] = 'Please provide valid credentials';
            $data['code'] = 505;

            die(json_encode($data));
        }

        $user_name = $post_data->data->username;
        $password = $account_obj->hashEmail($post_data->data->password);

        $check_result_id = $account_obj->checkLogin($user_name, $password);

        if($check_result_id == 404){
            $data['status'] = 'false'; //false
            $data['msg'] = 'Incorrect Username or Password.. Please try again';
        } else {
            $data['status'] = 'true'; //true
            $data['msg'] = 'Login Successful';
            $data['code'] = 200;
            $data['data']['user_details'] = $check_result_id;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;

    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
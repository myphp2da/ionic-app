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

        if(!isset($post_data->data)) {
            $data['status'] = 'false'; //false
            $data['msg'] = 'Please provide valid credentials';
            $data['code'] = 505;

            die(json_encode($data));
        }

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $activation = rand(10000000, 99999999);

        $customer_array = array(
            'fname' => $post_data->data->fname,
            'lname' => $post_data->data->lname,
            'email' => $post_data->data->email,
            'phone' => $post_data->data->phone,
            'password' => String::getHash($post_data->data->password),
            'activation' => $activation
        );

        $customer_id = $customer_obj->insertCustomer($customer_array);

        if($customer_id === false){
            $data['status'] = 'false'; //false
            $data['msg'] = 'ERROR! something went wrong. Please try again...';
        } else {
            $data['status'] = 'true'; //true
            $data['msg'] = 'Signup Successful';
            $data['code'] = 200;
            $data['user_id'] = $customer_id;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;

    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
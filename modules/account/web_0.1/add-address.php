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

        if(!isset($post_data->user) || !is_numeric($post_data->user)) {
            $data['status'] = 'false'; //false
            $data['msg'] = 'ERROR! no authenticated user provided';
            $data['code'] = 1005;

            die(json_encode($data));
        }

        if(!isset($post_data->area) || !is_numeric($post_data->area)) {
            $data['status'] = 'false'; //false
            $data['msg'] = 'ERROR! no area selected';
            $data['code'] = 1005;

            die(json_encode($data));
        }

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $address_array = array(
            'label' => $post_data->data->label,
            'fname' => $post_data->data->fname,
            'lname' => $post_data->data->lname,
            'address1' => $post_data->data->address_line_1,
            'address2' => $post_data->data->address_line_2,
            'area' => $post_data->area,
            'city' => $post_data->data->city,
            'state' => $post_data->data->state,
            'pincode' => $post_data->data->pincode,
            'customer' => $post_data->user
        );

        $address_id = $customer_obj->insertCustomerAddress($address_array);

        if($address_id === false){
            $data['status'] = 'false'; //false
            $data['msg'] = 'ERROR! something went wrong. Please try again...';
        } else {
            $data['status'] = 'true'; //true
            $data['msg'] = 'Customer address has been successfully added';
            $data['code'] = 200;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;
    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
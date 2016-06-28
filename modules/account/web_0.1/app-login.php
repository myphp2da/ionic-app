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
        $password = String::getHash($post_data->data->password);

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $user_details = $customer_obj->checkCustomerLogin($user_name, $password);

        if($user_details == 404){
            $data['status'] = 'false'; //false
            $data['msg'] = 'Incorrect Username or Password.. Please try again';
        } else {

            $addresses = $customer_obj->getCustomerAddresses($user_details['id']);

            if($addresses == 404){
                $data['status'] = 'false'; //false
                $data['msg'] = 'No address added by you yet.';
            } else {

                $address_data = array();
                foreach($addresses as $address) {

                    $address_array = array(
                        'id' => $address['id'],
                        'label' => $address['strLabel'],
                        'fname' => $address['strFirstName'],
                        'lname' => $address['strLastName'],
                        'address1' => $address['strAddressLine1'],
                        'address2' => $address['strAddressLine2'],
                        'area' => $address['idArea'],
                        'area_name' => $address['strArea'],
                        'city' => $address['strCity'],
                        'state' => $address['strState'],
                        'pincode' => $address['intPinCode']
                    );

                    $address_data[] = $address_array;
                }
            }

            $data['status'] = 'true'; //true
            $data['msg'] = 'Login Successful';
            $data['code'] = 200;
            $data['data']['user_details'] = $user_details;
            $data['data']['addresses'] = $address_data;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;

    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
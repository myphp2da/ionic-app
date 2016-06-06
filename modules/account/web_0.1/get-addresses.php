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

        if(!isset($post_data->customer) || !is_numeric($post_data->customer)) {
            $data['status'] = 'false'; //false
            $data['msg'] = 'ERROR! no authenticated customer provided';
            $data['code'] = 1005;

            die(json_encode($data));
        }

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $addresses = $customer_obj->getCustomerAddresses($post_data->customer);

        if($addresses == 404){
            $data['status'] = 'false'; //false
            $data['msg'] = 'No address added by you yet.';
        } else {

            $output = array();
            foreach($addresss as $address) {

                $address_array = array(
                    'id' => $address['id'],
                    'label' => $address['strLabel'],
                    'name' => $address['strFirstName'].' '.$address['strLastName'],
                    'address1' => $address['strAddressLine1'],
                    'address2' => $address['strAddressLine2'],
                    'area' => $address['strArea'],
                    'city' => $address['strCity'],
                    'state' => $address['strState'],
                    'pincode' => $address['pincode']
                );

                $output[] = $address_array;
            }

            $data['status'] = 'true'; //true
            $data['msg'] = 'Customer addresses have been successfully loaded';
            $data['code'] = 200;
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;

    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
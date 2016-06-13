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

    $post_data = json_decode($request);

    if(isset($post_data->key) && $post_data->key == KEY) {

        if(!isset($post_data->user) || !is_numeric($post_data->user)) {
            $data['status'] = 'false'; //False
            $data['msg'] = 'No user provided';
            die(json_encode($data));
        }

        $product = $product_obj->getCart($post_data->cart->id);

        if($product == 404){
            $data['status'] = 'false'; //False
            $data['msg'] = 'ERROR! something went wrong. Please try again...';
        } else {

            $update_array = array(
                'address' => $post_data->cart->idAddress,
                'slot' => $post_data->cart->strSlot,
                'payment' => $post_data->cart->strPayment,
                'status' => 1,
                'cart' => $post_data->cart->id
            );
            $update_cart = $product_obj->completeOrder($update_array);

            $data['status'] = 'true'; //True
            $data['msg'] = 'Order has been successfully completedq';
        }
    } else {
        $data['status'] = 'false'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    //Always Return JSON string to handle it in devices.
    header("Content-type: application/json");
    echo json_encode($data);
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

        if(!isset($post_data->cart) || !is_numeric($post_data->cart)) {
            $data['status'] = 'false'; //False
            $data['msg'] = 'No cart provided';
            die(json_encode($data));
        }

        $product = $product_obj->getCartProduct($post_data->cart, $post_data->data->product);

        if($product == 404){
            $data['status'] = 'false'; //False
            $data['msg'] = 'Selected product is not available in the cart';
        } else {

            $update_array = array(
                'quantity' => $post_data->data->quantity,
                'product' => $post_data->data->product,
                'cart' => $post_data->cart,
                'total_amount' => $post_data->data->total_price
            );
            $update_cart = $product_obj->updateCart($update_array);

            $data['status'] = 'true'; //True
            $data['msg'] = 'Cart has been successfully updated';
        }
    } else {
        $data['status'] = 'false'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    //Always Return JSON string to handle it in devices.
    header("Content-type: application/json");
    echo json_encode($data);
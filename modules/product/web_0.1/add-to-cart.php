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

        // Check if user ID available or not
        if(!isset($post_data->user) || !is_numeric($post_data->user)) {
            $data['status'] = 'False'; //False
            $data['msg'] = 'No user provided';
            die(json_encode($data));
        }

        // Create cart if cart ID is 0, otherwise use provided cart ID
        if(isset($post_data->cart) && $post_data->cart == 0) {
            $cart_id = $product_obj->createCart($post_data->user);
        } else {
            $cart_id = $post_data->cart;
        }

        // Check if product ID is provided or not
        if(!isset($post_data->item) || !is_numeric($post_data->item)) {
            $data['status'] = 'False'; //False
            $data['msg'] = 'No product provided';
            die(json_encode($data));
        }

        // Get all cart products
        $cart_products = $product_obj->getProductsByCartID($cart_id);

        $cart_products_array = $products_array = array();
        if($cart_products != 404) {
            foreach($cart_products as $cp) {
                $product_id = $cp['idProduct'];
                $products_array[] = $product_id;
                $cart_products_array[$product_id] = $cp;
            }
        }

        if($cart_products == 404 || !in_array($post_data->item, $products_array)) {
            $cart_product_array = array(
                'cart'         => $cart_id,
                'quantity'     => 2,
                'product'      => $post_data->item,
                'amount'       => 34,
                'total_amount' => 68
            );

            $cart_product = $product_obj->insertCartProduct($cart_product_array);
        } else {

            $available_product = $cart_products_array[$post_data->item];

            $cart_product_array = array(
                'cart'         => $cart_id,
                'quantity'     => 2,
                'product'      => $post_data->item,
                'amount'       => $available_product['decAmount'] + 34,
                'total_amount' => $available_product['decAmount'] + 68
            );

            $cart_product = $product_obj->updateCartProduct($cart_product_array);
        }

        if(!$cart_product){
            $data['status'] = 'False'; //False
            $data['msg'] = 'Sorry! Something went wrong. Please try again...';
        } else {
            $data['status'] = 'True'; //True
            $data['msg'] = 'Selected product has been successfully added to the cart';
            $data['cart'] = $cart_id;
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    echo json_encode($data);
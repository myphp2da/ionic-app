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
            $data['status'] = 'false'; //False
            $data['msg'] = 'No user provided';
            die(json_encode($data));
        }

        // Create cart if cart ID is 0, otherwise use provided cart ID
        if(!isset($post_data->cart) || $post_data->cart == 0) {
            $cart_id = $product_obj->createCart($post_data->user);
        } else {
            $cart_id = $post_data->cart;
        }

        // Check if product ID is provided or not
        if(!isset($post_data->item) || !is_numeric($post_data->item)) {
            $data['status'] = 'false'; //False
            $data['msg'] = 'No product provided';
            die(json_encode($data));
        }

        // Check if product quantity is provided or not
        if(!isset($post_data->quantity) || !is_numeric($post_data->quantity)) {
            $data['status'] = 'false'; //False
            $data['msg'] = 'No product quantity provided';
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

        $product_quantity = $product_obj->getProductQuantity($post_data->item, $post_data->quantity);

        if($cart_products == 404 || !in_array($post_data->item, $products_array)) {
            $cart_product_array = array(
                'cart'         => $cart_id,
                'quantity'     => $post_data->quantity,
                'total_quantity' => 1,
                'product'      => $post_data->item,
                'amount'       => $product_quantity['decPrice'],
                'total_amount' => $product_quantity['decPrice']
            );

            $cart_product = $product_obj->insertCartProduct($cart_product_array);
        } else {

            $available_product = $cart_products_array[$post_data->item];

            $cart_product_array = array(
                'cart'         => $cart_id,
                'quantity'     => $post_data->quantity,
                'total_quantity' => $available_product['intQuantity'] + 1,
                'product'      => $post_data->item,
                'total_amount' => $available_product['decPrice'] + $product_quantity['decPrice']
            );

            $cart_product = $product_obj->updateCartProduct($cart_product_array);
        }

        if(!$cart_product){
            $data['status'] = 'false'; //False
            $data['msg'] = 'Sorry! Something went wrong. Please try again...';
        } else {
            $data['status'] = 'true'; //True
            $data['msg'] = 'Selected product has been successfully added to the cart';
            $data['cart'] = $cart_id;
        }
    } else {
        $data['status'] = 'false'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    echo json_encode($data);
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

        if(!isset($post_data->user_id) || !is_numeric($post_data->user_id)) {
            $data['status'] = 'False'; //False
            $data['msg'] = 'No customer provided';

            die(json_encode($data));
        }

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $customer_details = $customer_obj->getCustomerByID($post_data->user_id);

        if($customer_details == 404) {
            $data['status'] = 'False'; //False
            $data['msg'] = 'No customer available for provided details';

            die(json_encode($data));
        }

        _subModule('product', 'order');
        $order_obj = new order();

        $product_url = UPLOAD_URL.'product/thumbs/';

        $orders = $order_obj->getProducts($query_string);

        if($orders == '404'){
            $data['status'] = 'False'; //False
            $data['msg'] = 'No order available';
        } else {

            $available_products  = array();
            foreach($products as $product) {
                $available_products[] = $product['id'];
            }

            $quantity_array = array();
            if(sizeof($available_products) > 0) {
                $product_quantities = $product_obj->getProductQuantities($available_products);

                if($product_quantities != 404) {
                    foreach($product_quantities as $pq) {
                        $product_id = $pq['idProduct'];
                        $quantity_array[$product_id][] = array(
                            'id' => $pq['idQuantity'],
                            'label' => $pq['strQuantity'],
                            'remarks' => $pq['strRemarks'],
                            'price' => $pq['decPrice']
                        );
                    }
                }
            }
            
            $output = array();
            foreach($products as $product) {

                $product_array = array(
                    'id' => $product['id'],
                    'title' => $product['strProduct'],
                    'photo' => !empty($product['strImageName']) ? $product_url.$product['strImageName'] : '',
                    'category' => $product['category_name']
                );

                if(isset($quantity_array[$product['id']])) {
                    $product_array['quantities'] = $quantity_array[$product['id']];
                }

                $output[] = $product_array;
            }

            $data['status'] = 'True'; //True
            $data['msg'] = 'Products have been successfully loaded';
            $data['category'] = $category;
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    echo json_encode($data);
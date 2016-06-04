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
            $data['status'] = 'False'; //False
            $data['msg'] = 'No cart provided';
            die(json_encode($data));
        }

        $product_url = UPLOAD_URL.'product/thumbs/';

        $products = $product_obj->getProductsByCartID($post_data->cart);

        if($products == '404'){
            $data['status'] = 'False'; //False
            $data['msg'] = 'No product available';
        } else {

            $output = array();
            foreach($products as $product) {

                $product_array = array(
                    'id' => $product['id'],
                    'title' => $product['strProduct'],
                    'price' => $product['decAmount'],
                    'quantity' => $product['intQuantity'],
                    'total_price' => $product['decTotalAmount'],
                    'remarks' => $product['strRemarks'],
                    'label' => $product['strQuantity'],
                    'photo' => $product_url.$product['strImageName']
                );

                $output[] = $product_array;
            }

            $data['status'] = 'True'; //True
            $data['msg'] = 'Products have been successfully loaded';
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    //Always Return JSON string to handle it in devices.
    header("Content-type: application/json");
    echo json_encode($data);
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

        $query_string = '1';
        if(isset($post_data->category) && is_numeric($post_data->category)) {
            $query_string .= " and p.idCategory = ".$post_data->category;
        }

        $product_url = UPLOAD_URL.'product/thumbs/';

        $products = $product_obj->getProducts($query_string);

        if($products == '404'){
            $data['status'] = 'False'; //False
            $data['msg'] = 'No product available';
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
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    //Always Return JSON string to handle it in devices.
    header("Content-type: application/json");
    echo json_encode($data);
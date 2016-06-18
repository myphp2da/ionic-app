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

        $output = array();

        $category_url = UPLOAD_URL.'category/thumbs/';

        _module('master');
        $master_obj = new master();

        $categories = $master_obj->getMasters(1, 'category', 'idParent');

        $category_array = $sub_categories = array();
        if($categories != 404){

            foreach($categories as $category) {
                $category_id = $category['id'];

                $data_array = array(
                    'id' => $category['id'],
                    'name' => $category['strCategory'],
                    'photo' => !empty($category['strImageName']) ? $category_url.$category['strImageName'] : ''
                );

                if($category['idParent'] == 0) {
                    $category_array[] = $data_array;
                } else {
                    $sub_categories[$category['idParent']] = $data_array;
                }
            }

            foreach($category_array as $category) {
                if(isset($sub_categories[$category['id']])) {
                    $category['sub_categories'][] = $sub_categories[$category['id']];

                    $output['categories'][] = $category;
                }
            }
        }

        $product_url = UPLOAD_URL.'product/thumbs/';

        $products = $product_obj->getProducts(1);

        if($products != 404){

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

            foreach($products as $product) {

                $product_array = array(
                    'id' => $product['id'],
                    'title' => $product['strProduct'],
                    'photo' => !empty($product['strImageName']) ? $product_url.$product['strImageName'] : '',
                    'category' => $product['strCategory']
                );

                if(isset($quantity_array[$product['id']])) {
                    $product_array['quantities'] = $quantity_array[$product['id']];
                }

                $output['products'][] = $product_array;
            }
        }

        $data['status'] = 'True'; //True
        $data['msg'] = 'Products have been successfully loaded';
        $data['data'] = $output;
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';
    }

    //Always Return JSON string to handle it in devices.
    header("Content-type: application/json");
    echo json_encode($data);
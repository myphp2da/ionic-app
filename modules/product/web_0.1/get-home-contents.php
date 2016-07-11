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
            $data['status'] = 'False'; //False
            $data['msg'] = 'ERROR! something went wrong. Please try again...';

            die(json_encode($data));
        }

        _subModule('account', 'customer');
        $customer_obj = new customer();

        $customer_details = $customer_obj->getCustomerByID($post_data->user);

        if($customer_details == 404) {
            $data['status'] = 'False'; //False
            $data['msg'] = 'ERROR! something went wrong. Please try again...';

            die(json_encode($data));
        }

        $last_check_date = $customer_details['dtiLastCheck'];

        $output = array();

        $category_url = UPLOAD_URL.'category/thumbs/';

        _subModule('master', 'area');
        $master_obj = new area();

        // Get all slots details
        $updated_slots = !empty($last_check_date) ? $master_obj->getMasterCount("dtiLastUpdated >= '".$last_check_date."'", 'slot') : 1;

        if($updated_slots > 0) {

            $slots = $master_obj->getMasters(1, 'slot');

            if($slots != 404) {

                foreach($slots as $slot) {
                    $data_array = array(
                        'id'    => $slot['id'],
                        'name'  => $slot['strSlot'],
                    );

                    $output['slots'][] = $data_array;
                }
            }
        }

        // Get all areas details
        $updated_areas = !empty($last_check_date) ? $master_obj->getMasterCount("dtiLastUpdated >= '".$last_check_date."'", 'area') : 1;

        if($updated_areas > 0) {

            $areas = $master_obj->getAreas();

            if($areas != 404) {

                foreach($areas as $area) {
                    $data_array = array(
                        'id'    => $area['id'],
                        'name'  => $area['strArea'],
                        'city'  => $area['strCity'],
                        'state' => $area['strState'],
                        'pincode' => $area['intPinCode']
                    );

                    $output['areas'][] = $data_array;
                }
            }
        }

        // Get all categories with subcategories
        $updated_categories = !empty($last_check_date) ? $master_obj->getMasterCount("dtiLastUpdated >= '".$last_check_date."'", 'category') : 1;

        if($updated_categories > 0) {

            $categories = $master_obj->getMasters(1, 'category', 'idParent');

            $category_array = $sub_categories = array();
            if($categories != 404) {

                foreach($categories as $category) {
                    $category_id = $category['id'];

                    $data_array = array(
                        'id'    => $category['id'],
                        'name'  => $category['strCategory'],
                        'photo' => !empty($category['strImageName']) ? $category_url . $category['strImageName'] : '',
                        'parent' => $category['idParent']
                    );

                    if($category['idParent'] == 0) {
                        $category_array[] = $data_array;
                    } else {
                        $sub_categories[$category['idParent']][] = $data_array;
                    }
                }

                foreach($category_array as $category) {
                    if(isset($sub_categories[$category['id']])) {
                        $category['sub_categories'] = $sub_categories[$category['id']];

                        $output['categories'][] = $category;
                    }
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
                    'category' => $product['category_name']
                );

                if(isset($quantity_array[$product['id']])) {
                    $product_array['quantities'] = $quantity_array[$product['id']];
                }

                $output['products'][] = $product_array;
            }
        }

        $customer_obj->updateLastCheck($post_data->user);

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
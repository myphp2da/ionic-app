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

        $orders = $order_obj->getOrdersByStatus(2);

        if($orders == '404'){
            $data['status'] = 'False'; //False
            $data['msg'] = 'No order available';
        } else {

            $output = array();
            foreach($orders as $order) {

                $order_array = array(
                    'id' => $order['id'],
                    'title' => $order['strProduct'],
                    'photo' => !empty($order['strImageName']) ? $order_url.$order['strImageName'] : '',
                    'total_products' => $order['intTotalProducts'],
                    'amount' => $order['dblAmount'],
                    'delivery' => $order['intDelivery'],
                    'order_no' => $order['strOrderNo'],
                    'order_date' => $order['dtiOrderDate']
                );

                $output[] = $order_array;
            }

            $data['status'] = 'True'; //True
            $data['msg'] = 'Orders have been successfully loaded';
            $data['category'] = $category;
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'False'; //False
        $data['msg'] = 'ERROR! Unauthorized access';

    }

    echo json_encode($data);
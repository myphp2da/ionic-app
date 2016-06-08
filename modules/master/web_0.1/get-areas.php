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

    $post_data = json_decode($request); //pr($post_data);

    if(isset($post_data->key) && $post_data->key == KEY) {

        _subModule('master', 'area');
        $area_obj = new area();

        $areas = $area_obj->getAreas(1);

        if($areas == 404){
            $data['status'] = 'false'; //false
            $data['msg'] = 'No area available';
        } else {

            $output = array();
            foreach($areas as $area) {

                $area_array = array(
                    'id' => $area['id'],
                    'name' => $area['strArea'],
                    'city' => $area['strCity'],
                    'state' => $area['strState'],
                    'pincode' => $area['intPinCode']
                );

                $output[] = $area_array;
            }

            $data['status'] = 'true'; //true
            $data['msg'] = 'Areas have been successfully loaded';
            $data['code'] = 200;
            $data['data'] = $output;
        }
    } else {
        $data['status'] = 'false'; //false
        $data['msg'] = 'ERROR! Unauthorized access';
        $data['code'] = 1001;

    }

    //Always Return JSON string to handle it in devices.
    echo json_encode($data);
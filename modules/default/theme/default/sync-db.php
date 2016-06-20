<?php
    /**
     * Created by PhpStorm.
     * User: mitesh
     * Date: 26/5/16
     * Time: 6:39 PM
     */

    _class('dbsync');
    $dbsync_obj = new dbsync();

    if(ENV == 1) {
        $sync = $dbsync_obj->encodeStructure();
        if($sync) {
            die('DB Structure has been stored to settings');
        }
    } else {
        $not_available = $dbsync_obj->checkStructure();
        pr($not_available);
    }
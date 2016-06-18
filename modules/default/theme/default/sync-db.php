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
        echo $dbsync_obj->encodeStructure();
    } else {
        $not_available = $dbsync_obj->checkStructure();
        pr($not_available);
    }
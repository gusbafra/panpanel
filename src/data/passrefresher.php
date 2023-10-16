<?php

/**
 * 
 * BEARER PASSWORD MANAGER AND REFRESHER
 * STATUS: // W O R K   I N   P R O G R E S S //
 * TYPE: CONTROLLER
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 */


 if (php_sapi_name() == 'cli') {   
    if (isset($_SERVER['TERM'])) {  
       exit(404);
    } else {   
       echo "Cronjob working just fine.";   
    }   
 } else { 
    exit(404);
 }


 require_once '../lib/utilities.php'; //Panel Utilities
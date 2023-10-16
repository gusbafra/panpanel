
<?php

/**
 * 
 * NATIVE DATABASE ORM
 * STATUS: WORKING
 * TYPE: CONTROLLER
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 */


if (@!defined('DBACCESS')) {
    exit('404');
}

require_once '../lib/classloader.php'; //Panel Classes
require_once '../lib/utilities.php'; //Panel Utilities



try {
    $MainDbConfig =  unserialize($_ENV['MainDatabase']);
    $MainDbAuth = $MainDbConfig['type'].":dbname=".$MainDbConfig['name'].";host=".$MainDbauthConfig['host'];
    $MainDbUser = $MainDbConfig['user'];
    $MainDbPass = $MainDbConfig['pass'];

    $maindb = new PDO($AuthMaindb, $MainDbUser, $MainDbPass);

    $maindb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $maindb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $errCode) {
 
    display_error("MAIN DATABASE[" . $errCode."]",3,true);
    exit('500');

}


//ORM CONNECTIONS
if($_ENV['DB1'] !== null){
    try {
        $DB1Config =  unserialize($_ENV['DB1']);
        $DB1Auth = $DB1Config['type'].":dbname=".$DB1Config['name'].";host=".$DB1Config['host'];
        $DB1User = $DB1Config['user'];
        $DB1Pass = $DB1Config['pass'];
    
        $DB1PDO = new PDO($DB1Auth, $DB1User, $DB1Pass);
    
        $DB1PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB1PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB1 = new db($DB1PDO,$DB1Pass,1);
    
    } catch (PDOException $errCode) {
     
        display_error("DB1[" . $errCode."]",3,true);
        exit('500');
    
    }
}

if($_ENV['DB1'] !== null){
    try {
        $DB1Config =  unserialize($_ENV['DB1']);
        $DB1Auth = $DB1Config['type'].":dbname=".$DB1Config['name'].";host=".$DB1Config['host'];
        $DB1User = $DB1Config['user'];
        $DB1Pass = $DB1Config['pass'];
    
        $DB1PDO = new PDO($DB1Auth, $DB1User, $DB1Pass);
    
        $DB1PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB1PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB1 = new db($DB1PDO,$DB1Pass,1);
    
    } catch (PDOException $errCode) {
     
        display_error("DB1[" . $errCode."]",3,true);
        exit('500');
    
    }
}

if($_ENV['DB1'] !== null){
    try {
        $DB1Config =  unserialize($_ENV['DB1']);
        $DB1Auth = $DB1Config['type'].":dbname=".$DB1Config['name'].";host=".$DB1Config['host'];
        $DB1User = $DB1Config['user'];
        $DB1Pass = $DB1Config['pass'];
    
        $DB1PDO = new PDO($DB1Auth, $DB1User, $DB1Pass);
    
        $DB1PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB1PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB1 = new db($DB1PDO,$DB1Pass,1);
    
    } catch (PDOException $errCode) {
     
        display_error("DB1[" . $errCode."]",3,true);
        exit('500');
    
    }
}

if($_ENV['DB2'] !== null){
    try {
        $DB2Config =  unserialize($_ENV['DB2']);
        $DB2Auth = $DB2Config['type'].":dbname=".$DB2Config['name'].";host=".$DB2Config['host'];
        $DB2User = $DB2Config['user'];
        $DB2Pass = $DB2Config['pass'];
    
        $DB2PDO = new PDO($DB2Auth, $DB2User, $DB2Pass);
    
        $DB2PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB2PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB2 = new db($DB2PDO,$DB2Pass,2);
    
    } catch (PDOException $errCode) {
     
        display_error("DB2[" . $errCode."]",3,true);
        exit('500');
    
    }
}


if($_ENV['DB3'] !== null){
    try {
        $DB3Config =  unserialize($_ENV['DB3']);
        $DB3Auth = $DB3Config['type'].":dbname=".$DB3Config['name'].";host=".$DB3Config['host'];
        $DB3User = $DB3Config['user'];
        $DB3Pass = $DB3Config['pass'];
    
        $DB3PDO = new PDO($DB3Auth, $DB3User, $DB3Pass);
    
        $DB3PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB3PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB3 = new db($DB3PDO,$DB3Pass,3);
    
    } catch (PDOException $errCode) {
     
        display_error("DB3[" . $errCode."]",3,true);
        exit('500');
    
    }
}

if($_ENV['DB4'] !== null){
    try {
        $DB4Config =  unserialize($_ENV['DB4']);
        $DB4Auth = $DB4Config['type'].":dbname=".$DB4Config['name'].";host=".$DB4Config['host'];
        $DB4User = $DB4Config['user'];
        $DB4Pass = $DB4Config['pass'];
    
        $DB4PDO = new PDO($DB4Auth, $DB4User, $DB4Pass);
    
        $DB4PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $DB4PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $DB4 = new db($DB4PDO,$DB4Pass,4);
    
    } catch (PDOException $errCode) {
     
        display_error("DB4[" . $errCode."]",3,true);
        exit('500');
    
    }
}


//ORM QUERIES

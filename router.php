<?php

/**
 * 
 * MAIN PROCEDURAL ROUTER
 * STATUS: WORKING
 * TYPE: CONTROLLER
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 **/


$request = substr(explode('?', $_SERVER['REQUEST_URI'])[0], 1);
@session_start();

define('SETUP_CHILD_ACCESS', true);
require_once "src/conf/setup.php";

if (empty($_ENV['Site_HTTPS'])) {
    if (!empty(file_get_contents('src/conf/integrity/.env'))) {
        echo "PANPANEL READY TO BE RECONFIGURATED.";

    } else {
        echo "PANPANEL NOT INSTALLED.";
        exit();
    }
}

include $_ENV['PANELTOROOT']."../public/arbitrary/header.html";

if (empty($_ENV['Site_REG'])) {
    $registerPage = 5;
} else {
    $registerPage = $_ENV['Site_REG'];

}


function httpError($http)
{
    if ($http !== 200) {
        require $_ENV['PANELTOROOT'].'../public/errors/' . http_response_code() . '.html';
        $request = 'HTTPERROR';
    }
    exit();
}


switch ($request) {
    case $_ENV['Site_LOG']:
        if (!isset($_SESSION['user_id']) || !isset($user)) {
            session_destroy();

            require $_ENV['PANELTOROOT']."../public/auth.html";

        } else {


            require "/user/panel.php";


        }
        break;
    case $registerPage:

        require $_ENV['PANELTOROOT']."../public/register.html";


        break;
    case 'utilities':
        require "/src/lib/utilities.php";
        break;
    default:
        http_response_code(404);
        break;

}
httpError(http_response_code());
include $_ENV['PANELTOROOT']."../public/arbitrary/footer.html";
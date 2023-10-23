<?php
$v = "v1";
define("API_V", $v);
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: https://www.example.com');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (token_security == true) {
        if (getBearerToken() !== sitekey) {
                $msg['msg'] = "Invalid Authorization";
                header("HTTP/1.0 503 Forbiden");
                $msg['msg'] = "503 Forbiden";
                echo json_encode($msg);
                die();
        }
}

$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['urlend'] = end($url);
$GLOBALS['urlprev'] = prev($url);

if ("$url[0]/$v" == "api/$v") {
        if (count($url) >= 4) {

                //get orders
                if ("{$url[2]}/$url[3]" == "get/orders") {
                        import("apps/api/$v/api.orders/get-orders-list.php");
                        return;
                }
                //404
                else {
                        header("HTTP/1.0 404 Not Found");
                        $msg['msg'] = "404, Page not found";
                        echo json_encode($msg);
                        return;
                }
        }
}

<?php
$headers = getallheaders();
$api_key = isset($headers['api_key']) ? $headers['api_key'] : null;
try {
    if (hash_equals(sitekey, $api_key)) {
        $orders = new Order_api;
        $orders->get_orders();
    }else{
        $_SESSION['msg'][] = "API KEY IS INVALID";
        $api['success'] = false;
        $api['data'] = null;
        $api['msg'] = msg_ssn(return: true);
        echo json_encode($api);
        exit;
    }
} catch (\Throwable $th) {
    $_SESSION['msg'][] = "Something went wrong";
    $api['success'] = false;
    $api['data'] = null;
    $api['msg'] = msg_ssn(return: true);
    echo json_encode($api);
    exit;
}

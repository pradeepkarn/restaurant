<?php 
try {
    extract(apache_request_headers());
    if (isset($API_KEY) && hash_equals(sitekey, $API_KEY)) {
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

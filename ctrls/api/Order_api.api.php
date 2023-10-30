<?php

class Order_api extends DB_ctrl
{
    public function get_orders($req = null)
    {
        $req = (object) ($_POST);
        $orders = new Dbobjects;
        $sql = "SELECT payment.*, 
        restaurant_listing.id as rest_id,
        restaurant_listing.rest_name, 
        restaurant_listing.rest_address, 
        restaurant_listing.latitude as rest_lat, 
        restaurant_listing.longitude as rest_lon, 
        buyer.username AS buyer, 
        buyer.first_name AS buyer_first_name, 
        buyer.last_name AS buyer_last_name, 
        driver.username AS driver,
        driver.lat AS driver_lat,
        driver.lon AS driver_lon
        FROM payment 
        JOIN restaurant_listing ON payment.rest_id = restaurant_listing.id
        LEFT JOIN pk_user AS buyer ON payment.user_id = buyer.id
        LEFT JOIN pk_user AS driver ON payment.deliver_by = driver.id;
        ";
        $ords =  $orders->show($sql);

        $ordsss = array_map(function ($ord) {
            if (!is_numeric($ord['rest_lat']) || !is_numeric($ord['rest_lon']) || !is_numeric($ord['driver_lat']) || !is_numeric($ord['driver_lon'])) {
                $driver_to_user = $ord['distance'];
            } else {
                $driver_from_restaurant = calculateDistance($ord['rest_lat'], $ord['rest_lon'], $ord['driver_lat'], $ord['driver_lon']);
                $driver_to_user = $driver_from_restaurant + $ord['distance'];
            }

            return array(
                'id' => $ord['id'],
                // 'driver_assigned' => $ord['deliver_by'] ? true : false,
                'orderid' => $ord['unique_id'],
                'created_at' => strtotime($ord['created_at']),
                'amount' => $ord['amount'],
                'payment_method' => $ord['payment_method'],
                // 'driver' => $ord['driver'],
                'buyer_id' => $ord['user_id'],
                'buyer' => $ord['buyer'],
                'buyer_name' => $ord['buyer_first_name'] . " " . $ord['buyer_last_name'],
                'isd_code' => intval($ord['isd_code']),
                'mobile' => intval($ord['mobile']),
                'locality' => $ord['locality'],
                'city' => $ord['city'],
                'state' => $ord['state'],
                'country' => $ord['country'],
                'landmark' => $ord['landmark'],
                'buyer_lat' => $ord['lat'],
                'buyer_lon' => $ord['lon'],
                'rest_lat' => $ord['rest_lat'],
                'rest_lon' => $ord['rest_lon'],
                'rest_id' => $ord['rest_id'],
                'rest_name' => $ord['rest_name'],
                'rest_address' => $ord['rest_address'],

                // 'driver_lat' => $ord['driver_lat'],
                // 'driver_lon' => $ord['driver_lon'],

                'user_to_rest' => round($ord['distance'] / 1000, 3),
                // 'driver_to_user' => $ord['deliver_by'] ? round($driver_to_user / 1000, 3) : 0,
                'distance_unit' => 'km'
            );
        }, $ords);
        if (count($ords) > 0) {
            $_SESSION['msg'][] = "Data found";
            $api['success'] = true;
            $api['data'] = $ordsss;
            $api['msg'] = msg_ssn(return: true);
            echo json_encode($api);
            exit;
        } else {
            $_SESSION['msg'][] = "Data not found";
            $api['success'] = false;
            $api['data'] = null;
            $api['msg'] = msg_ssn(return: true);
            echo json_encode($api);
            exit;
        }
        return $ordsss;
    }

    function send_single_order($payment_id)
    {

        $orders = new Dbobjects;
        $sql = "SELECT payment.*, 
    restaurant_listing.id as rest_id,
    restaurant_listing.rest_name, 
    restaurant_listing.rest_address, 
    restaurant_listing.latitude as rest_lat, 
    restaurant_listing.longitude as rest_lon, 
    buyer.username AS buyer, 
    buyer.first_name AS buyer_first_name, 
    buyer.last_name AS buyer_last_name, 
    driver.username AS driver,
    driver.lat AS driver_lat,
    driver.lon AS driver_lon
    FROM payment 
    JOIN restaurant_listing ON payment.rest_id = restaurant_listing.id
    LEFT JOIN pk_user AS buyer ON payment.user_id = buyer.id
    LEFT JOIN pk_user AS driver ON payment.deliver_by = driver.id WHERE payment.id = '$payment_id';
    ";
        try {
            $ord =  $orders->showOne($sql);
            $data = array(
                "success" => true,
                "data" => array(
                    'id' => $ord['id'],
                    'orderid' => $ord['unique_id'],
                    'created_at' => strtotime($ord['created_at']),
                    'amount' => $ord['amount'],
                    'payment_method' => $ord['payment_method'],
                    'buyer_id' => $ord['user_id'],
                    'buyer' => $ord['buyer'],
                    'buyer_name' => $ord['buyer_first_name'] . " " . $ord['buyer_last_name'],
                    'isd_code' => intval($ord['isd_code']),
                    'mobile' => intval($ord['mobile']),
                    'locality' => $ord['locality'],
                    'city' => $ord['city'],
                    'state' => $ord['state'],
                    'country' => $ord['country'],
                    'landmark' => $ord['landmark'],
                    'buyer_lat' => $ord['lat'],
                    'buyer_lon' => $ord['lon'],
                    'rest_lat' => $ord['rest_lat'],
                    'rest_lon' => $ord['rest_lon'],
                    'rest_id' => $ord['rest_id'],
                    'rest_name' => $ord['rest_name'],
                    'rest_address' => $ord['rest_address'],
                    'user_to_rest' => round($ord['distance'] / 1000, 3),
                    'distance_unit' => 'km'
                ),
                "msg" => "Data found"
            );

            $curl = curl_init();
            $sitekey = sitekey;
            curl_setopt_array($curl, array(
                CURLOPT_URL => DUNZO_SITE_API_END_POINT . "/api/orders/update-single-order",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "api_key: $sitekey",
                    'Content-Type: application/json',
                    'Cookie: PHPSESSID=kjadhkskcliuegcjggjgjjg; lang=en'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            exit;
        } catch (PDOException $th) {
            $data = array(
                "success" => false,
                "data" => null,
                "msg" => "Data found"
            );
            $curl = curl_init();
            $sitekey = sitekey;
            curl_setopt_array($curl, array(
                CURLOPT_URL => DUNZO_SITE_API_END_POINT . "/api/orders/update-single-order",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "api_key: $sitekey",
                    'Content-Type: application/json',
                    'Cookie: PHPSESSID=kjadhkskcliuegcjggjgjjg; lang=en'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            exit;
        }
    }

    function order_action()
    {
        try {

            try {
                $req = json_decode(file_get_contents('php://input'));
                if (!isset($req->action)) {
                    exit;
                }
                if ($req->action == 'accept') {
                    // accept the order
                } else {
                    // hide for me 
                }
            } catch (\Throwable $th) {
            }
        } catch (\Throwable $th) {
        }
    }
}

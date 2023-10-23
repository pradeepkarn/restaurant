<?php

class Order_api extends DB_ctrl
{
    public function get_orders($req = null)
    {
        $req = (object) ($_POST);
        $orders = new Dbobjects;
        $sql = "SELECT payment.*, 
        restaurant_listing.rest_name, 
        restaurant_listing.latitude as rest_lat, 
        restaurant_listing.longitude as rest_lon, 
        buyer.username AS buyer, 
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
                'driver_assigned' => $ord['deliver_by'] ? true : false,
                'orderid' => $ord['unique_id'],
                'driver_id' => $ord['deliver_by'],
                'driver' => $ord['driver'],
                'buyer_id' => $ord['user_id'],
                'buyer' => $ord['buyer'],

                'buyer_lat' => $ord['lat'],
                'buyer_lon' => $ord['lon'],

                'rest_lat' => $ord['rest_lat'],
                'rest_lon' => $ord['rest_lon'],

                'driver_lat' => $ord['driver_lat'],
                'driver_lon' => $ord['driver_lon'],

                'user_to_rest' => round($ord['distance'] / 1000, 3),
                'driver_to_user' => $ord['deliver_by'] ? round($driver_to_user / 1000, 3) : 0,
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
}

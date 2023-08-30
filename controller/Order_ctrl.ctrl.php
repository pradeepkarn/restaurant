<?php

class Order_ctrl
{
    public function place()
    {
        $req = (object) ($_POST);
        if ($req) {
            $arr = null;
            $placeOrder = new Model('payment');
            $addrs = (object) ($_POST);
            if (!isset($_POST['payment_mode'])) {
                $_SESSION['msg'][] = 'Please select payment mode';
                return false;
            }
            if ($_POST['payment_mode'] == '') {
                echo js_alert('Please select payment mode');
                return;
            }
            $dbobj = new Dbobjects;
            $sql = "select SUM(price*qty) as total_amt from customer_order where status = 'cart' and user_id = {$_SESSION['user_id']}";
            try {
                $total_amt = $dbobj->show($sql)[0]['total_amt'];
                $arr['amount'] = $total_amt;
            } catch (PDOException $e) {
                return false;
            }
            if (
                $addrs->name == '' ||
                $addrs->mobile == '' ||
                $addrs->address_name == '' ||
                $addrs->city == '' ||
                $addrs->state == '' ||
                $addrs->country == '' ||
                $addrs->zipcode == '' ||
                $addrs->isd_code == ''
            ) {
                $_SESSION['msg'][] = 'Please check your primary address and make sure you have entered all the details';
                return false;
            }
            $arr['user_id'] = $_SESSION['user_id'];
            $arr['fname'] = $addrs->fname;
            $arr['lname'] = $addrs->lname;
            $arr['mobile'] = $addrs->mobile;
            $arr['isd_code'] = $addrs->isd_code;
            $arr['locality'] = $addrs->locality;
            $arr['city'] = $addrs->city;
            $arr['state'] = $addrs->state;
            $arr['country'] = $addrs->country;
            $arr['zipcode'] = $addrs->zipcode;
            $arr['payment_method'] = sanitize_remove_tags($_POST['payment_mode']);

            $arr['unique_id'] = uniqid();

            $arr['status'] = 'paid';

            try {
                $pay = $placeOrder->store($arr);
            } catch (PDOException $th) {
                $_SESSION['msg'][] = $th;
                $pay = false;
            }
            if (intval($pay)) {
                $dbobj = new Dbobjects;
                $dbobj->tableName = 'customer_order';
                // Filter user cart
                $dbobj->filter(array('status' => 'cart', 'user_id' => $_SESSION['user_id']));
                // Update cart with payment data
                $dbobj->insertData['payment_id'] = $pay;
                $dbobj->insertData['status'] = 'paid';
                $dbobj->insertData['updated_at'] = date('Y-m-d H:i:s');
                // execute payment data
                $dbobj->update();
                $_SESSION['msg'][] = 'Order placed';
                $my_email = null;

                if (isset($_SESSION['user_id'])) {
                    $userid = $_SESSION['user_id'];
                    $invite = getData("pk_user", $userid);
                    $my_email = $invite != false ? $invite['email'] : null;
                }
                $to      = $my_email;
                $subject = "DOM SWISS: Order Placed";
                $txt = "You have successfully placed an order with id " . "{$arr['unique_id']}" . "";
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . email . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                if (mail($to, $subject, $txt, $headers)) {
                    $_SESSION['msg'][] = "Success: Email was sent!";
                } else {
                    $_SESSION['msg'][] = "Failure: Email was not sent!";
                }
                return true;
            } else {
                $_SESSION['msg'][] = 'Order not placed';
                return false;
            }
        }
    }
}

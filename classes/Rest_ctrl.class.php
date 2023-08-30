<?php
class Rest_ctrl
{
    public function register()
    {
        $files = new stdClass;
        $req = obj($_POST);
        if (
            isset($req->owner_email) && isset($req->password)
        ) {
            if (!filter_var($req->owner_email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg'][] = "Email must be a valid email";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            $paramObj = new stdClass;

            $db = new Dbobjects;
            $pdo = $db->dbpdo();
            $pdo->beginTransaction();
            $db->tableName = 'pk_user';
            if (count($db->filter(['email' => $req->owner_email])) > 0) {
                $olduser = obj($db->filter(['email' => $req->owner_email])[0]);
                $id = $olduser->id;
                if ($olduser->is_restaurant != 1) {
                    if (md5($req->password) != $olduser->password) {
                        $_SESSION['msg'][] = "You have already registered from this email so You need to provide your old password in password field because you are going to be a user as well.";
                        echo js_alert(msg_ssn(return: true));
                        return false;
                    }
                    $db->insertData['is_restaurant'] = 1;
                    $db->pk($id);
                    $db->update();
                    $pdo->commit();
                    $_SESSION['msg'][] = "Your account is upgraded as a user also";
                    echo js_alert(msg_ssn(return: true));
                    return true;
                } else {
                    $_SESSION['msg'][] = "You have already registered as a user";
                    echo js_alert(msg_ssn(return: true));
                    return false;
                }
            }
            $username = generate_username_by_email_trans($req->owner_email, $try = 100, $db = $db);
            if ($username == false) {
                $_SESSION['msg'][] = "please check email format";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            if (empty(str_replace(" ", "", $req->password))) {
                $_SESSION['msg'][] = "Password must not be blank.";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            $paramObj->email = $req->owner_email;
            $paramObj->username = $username;
            $paramObj->is_restaurant = 1;
            $paramObj->password = md5($req->password);
            $db->tableName = 'pk_user';
            $db->insertData = arr($paramObj);

            try {
                $id = $db->create();
                $user =  return_user_data_trans($id, $db);
                if (intval($id)) {
                    $db->tableName = 'pk_user';
                    $db->pk($id);
                    $token = uniqid() . bin2hex(random_bytes(8)) . "u" . $id;
                    $datetime = date('Y-m-d H:i:s');
                    $db->insertData['app_login_token'] = $token;
                    $db->insertData['app_login_time'] = $datetime;
                    $db->update();
                    $_SESSION['msg'][] = "Congratulations you have successfully registered as a Restaurant";
                    $pdo->commit();
                    $this->rest_listing($id);
                    echo js_alert(msg_ssn(return: true));
                    return true;
                } else {
                    $pdo->rollback();
                    $_SESSION['msg'][] = "User not Listed, something went wrong";
                    echo js_alert(msg_ssn(return: true));
                    return false;
                }
            } catch (PDOException $th) {
                $pdo->rollback();
                $_SESSION['msg'][] = "Data error";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
        } else {
            $_SESSION['msg'][] = "All fields are mandatory";
            echo js_alert(msg_ssn(return: true));
            return false;
        }
    }
    function rest_listing($id)
    {
        $arr = null;
        $restItem = new Model('restaurant_listing');
        $arr['user_id'] = $id;
        if (isset($_POST['rest_name']) && !empty($_POST['rest_name'])) {
            $arr['rest_name'] = $_POST['rest_name'];
        } else {
            echo js_alert('Restaurant Name Cannot Be Empty!');
            return;
        }
        if (isset($_POST['rest_address']) && !empty($_POST['rest_address'])) {
            $arr['rest_address'] = $_POST['rest_address'];
        } else {
            echo js_alert('Restaurant Address Cannot Be Empty!');
            return;
        }
        if (isset($_POST['rest_location']) && !empty($_POST['rest_location'])) {
            $arr['rest_location'] = $_POST['rest_location'];
        } else {
            echo js_alert('Restaurant Location Cannot Be Empty!');
            return;
        }
        if (isset($_POST['latitude']) && !empty($_POST['latitude'])) {
            $arr['latitude'] = $_POST['latitude'];
        } else {
            echo js_alert('Latitude Cannot Be Empty!');
            return;
        }
        if (isset($_POST['longitude']) && !empty($_POST['longitude'])) {
            $arr['longitude'] = $_POST['longitude'];
        } else {
            echo js_alert('Longitude Cannot Be Empty!');
            return;
        }
        if (isset($_POST['rest_mobile']) && !empty($_POST['rest_mobile'])) {
            $arr['rest_mobile'] = $_POST['rest_mobile'];
        } else {
            echo js_alert('Restaurant Mobile Number Cannot Be Empty!');
            return;
        }
        if (isset($_POST['rest_landline']) && !empty($_POST['rest_landline'])) {
            $arr['rest_landline'] = $_POST['rest_landline'];
        } else {
            echo js_alert('Restaurant Landline Number Cannot Be Empty!');
            return;
        }
        if (isset($_POST['owner_mobile']) && !empty($_POST['owner_mobile'])) {
            $arr['owner_mobile'] = $_POST['owner_mobile'];
        } else {
            echo js_alert('Owner Number Cannot Be Empty!');
            return;
        }
        if (isset($_POST['owner_name']) && !empty($_POST['owner_name'])) {
            $arr['owner_name'] = $_POST['owner_name'];
        } else {
            echo js_alert('Owner Name Cannot Be Empty!');
            return;
        }
        if (isset($_POST['owner_email']) && !empty($_POST['owner_email'])) {
            $arr['owner_email'] = $_POST['owner_email'];
        } else {
            echo js_alert('Owner Email Cannot Be Empty!');
            return;
        }
        if (isset($_POST['timings']) && !empty($_POST['timings'])) {
            $arr['timings'] = $_POST['timings'];
        } else {
            echo js_alert('Restaurant Timmings Cannot Be Empty!');
            return;
        }
        if (isset($_POST['priceforone']) && !empty($_POST['priceforone'])) {
            $arr['priceforone'] = $_POST['priceforone'];
        } else {
            echo js_alert('Price For One Person Cannot Be Empty!');
            return;
        }
        if (isset($_POST['food_time']) && !empty($_POST['food_time'])) {
            $arr['food_time'] = $_POST['food_time'];
        } else {
            echo js_alert('Please Enter Food Time!');
            return;
        }
        $arr['parent_id'] = $_POST['food_cat'];
        // For Image
        $rest_image = $_FILES['rest_banner_img']['name'][0];
        $temp_image = $_FILES['rest_banner_img']['tmp_name'][0];
        // myprint($_FILES);
        // return;
        $arr['banner'] = $rest_image;
        move_uploaded_file($temp_image, RPATH . "/media/images/pages/$rest_image");
        $id = $restItem->store($arr);
        if (intval($id)) {
            $restItemDetails = new Model('restaurant_details');
            for ($i = 0; $i < count($_FILES['rest_banner_img']['name']); $i++) {
                if ($_FILES['rest_banner_img']['name'][$i] === "") {
                    echo js_alert("Please select a valid file");
                    return;
                }

                $obj_grp = "restaurant_more_img";
                $obj_id = $id;

                $arr['content_group'] = "restaurant_more_img";
                $arr['restaurant_id'] = $id;
                $arr['status'] = "approved";

                // $arr['details'] = $_POST['food_img_name'][$i];

                $file_with_ext = $_FILES['rest_banner_img']['name'][$i];
                if (!empty($_FILES['rest_banner_img']['name'][$i])) {
                    $only_file_name = filter_name($file_with_ext);
                    $only_file_name = $only_file_name . "{$obj_id}{$obj_grp}_" . random_int(100000, 999999);
                    $target_dir = RPATH . "/media/images/pages/";
                    $file_ext_arr = explode(".", $file_with_ext);
                    $ext = end($file_ext_arr);
                    $target_file = $target_dir . "{$only_file_name}." . $ext;

                    $allowed_mime_types = [
                        "application/pdf",
                        "image/png",
                        "image/jpeg",
                        "image/jpg",
                        "video/mp4",
                    ];

                    if (in_array($_FILES['rest_banner_img']['type'][$i], $allowed_mime_types)) {
                        if (move_uploaded_file($_FILES['rest_banner_img']['tmp_name'][$i], $target_file)) {
                            $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                            $filename = $only_file_name . "." . $ext;
                            $arr['content'] = $filename;
                            $restItemDetails->store($arr);
                        }
                    } else {
                        $_SESSION['msg'][] = "$file_with_ext is an invalid file";
                    }
                }
            }
            echo js_alert(msg_ssn(return:true));
            echo RELOAD;
            return;
        } else {
            $_SESSION['msg'][] = "Restaurant Not listed";
            echo js_alert(msg_ssn(return:true));
            // echo RELOAD;
            return;
        }
    }

    function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = false;
            $req = obj($_POST);
            $db = new Dbobjects;
            $db->tableName = 'pk_user';
            $user_email = $db->filter(['email' => $req->email, 'password' => md5($req->password),'is_restaurant'=>1]);
            if (count($user_email) == 1) {
                $user = $user_email[0];
            } else {
                $user_username = $db->filter(['username' => $req->email, 'password' => md5($req->password),'is_restaurant'=>1]);
                if (count($user_username) == 1) {
                    $user = $user_username[0];
                }
            }
            if ($user != false) {
                $_SESSION['user_id'] = $user['id'];
                $cookie_name = "remember_token";
                $cookie_value = bin2hex(random_bytes(32)) . "_uid_" . $user['id'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 12), "/"); // 86400 = 1 day
                $db = new Model('pk_user');
                $db->show($_SESSION['user_id']);
                $arr = null;
                $arr['remember_token'] = $cookie_value;
                $db->update($_SESSION['user_id'], $arr);
                $arr = null;
                // $GLOBALS['msg_signin'][] = "Login Success";
                $_SESSION['msg'][] = "Login Success";
                echo js_alert(msg_ssn(return:true));
                return $user;
            } else {
                // $GLOBALS['msg_signin'][] = "Invalid credentials";
                $_SESSION['msg'][] = "Invalid credentials";
                echo js_alert(msg_ssn(return:true));
                return false;
            }
        }
    }
}

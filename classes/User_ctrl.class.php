<?php
class User_ctrl
{
    public function register()
    {
        $files = new stdClass;
        $req = obj($_POST);
        $files = obj($_FILES);
        if (
            isset($req->first_name) && isset($req->last_name)
            && isset($req->mobile) && isset($req->email)
            && isset($req->password)
        ) {
            if (empty($req->first_name)) {
                $_SESSION['msg'][] = "First name must not be empty";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            if (!filter_var($req->email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg'][] = "Email must be a valid email";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            if (!intval($req->mobile)) {
                $_SESSION['msg'][] = "Mobile number must be numeric";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            $paramObj = new stdClass;

            $db = new Dbobjects;
            $pdo = $db->dbpdo();
            $pdo->beginTransaction();
            $db->tableName = 'pk_user';
            if (count($db->filter(['email' => $req->email])) > 0) {
                $olduser = obj($db->filter(['email' => $req->email])[0]);
                $id = $olduser->id;
                if ($olduser->is_user != 1) {
                    if (md5($req->password) != $olduser->password) {
                        $_SESSION['msg'][] = "You have already registered from this email so You need to provide your old password in password field because you are going to be a user as well.";
                        echo js_alert(msg_ssn(return: true));
                        return false;
                    }
                    $db->insertData['is_user'] = 1;
                    ########################### uploads #################
                    if (isset($files->profile_img)) {
                        $imgfl = obj($files->profile_img);
                        if ($imgfl->error == 0) {
                            $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                            $imgname = uniqid('profile_') . "_" . $id . "." . $ext;
                            move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "images/profiles/$imgname");
                            $db->insertData['image'] = $imgname;
                            if (file_exists(MEDIA_ROOT . "images/profiles/$olduser->image") && $olduser->image != '') {
                                unlink(MEDIA_ROOT . "images/profiles/$olduser->image");
                            }
                        }
                    }
                    $db->pk($id);
                    $db->update();
                    $pdo->commit();
                    ######################### uploads ####################
                    $_SESSION['msg'][] = "Your account is upgraded as a user also";
                    echo js_alert(msg_ssn(return: true));
                    return true;
                } else {
                    $_SESSION['msg'][] = "You have already registered as a user";
                    echo js_alert(msg_ssn(return: true));
                    return false;
                }
            }
            $username = generate_username_by_email_trans($req->email, $try = 100, $db = $db);
            if ($username == false) {
                $_SESSION['msg'][] = "please check email format";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            if (count($db->filter(['mobile' => $req->mobile])) > 0) {
                $_SESSION['msg'][] = "This number is already registered, please provide other number";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            if (empty(str_replace(" ", "", $req->password))) {
                $_SESSION['msg'][] = "Password must not be blank.";
                echo js_alert(msg_ssn(return: true));
                return false;
            }
            $paramObj->mobile = intval($req->mobile);
            $paramObj->email = $req->email;
            $paramObj->username = $username;
            // $paramObj->national_id = $req->national_id;
            $paramObj->is_user = 1;
            $paramObj->password = md5($req->password);
            $paramObj->name = $req->first_name . " " . $req->last_name;
            $paramObj->first_name = $req->first_name;
            $paramObj->last_name = $req->last_name;
            $db->tableName = 'pk_user';
            $db->insertData = arr($paramObj);
            try {
                $id = $db->create();
                $user =  return_user_data_trans($id, $db);
                if (intval($id)) {
                    // Uploads
                    if (isset($files->profile_img)) {
                        $imgfl = obj($files->profile_img);
                        if ($imgfl->error == 0) {
                            $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                            $imgname = uniqid('profile_') . "_" . $id . "." . $ext;
                            move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "images/profiles/$imgname");
                            $db->insertData['image'] = $imgname;
                        }
                    }

                    // uploads end
                    $db->tableName = 'pk_user';
                    $db->pk($id);
                    $token = uniqid() . bin2hex(random_bytes(8)) . "u" . $id;
                    $datetime = date('Y-m-d H:i:s');
                    $db->insertData['app_login_token'] = $token;
                    $db->insertData['app_login_time'] = $datetime;
                    $db->update();
                    $_SESSION['msg'][] = "Congratulations you have successfully registered as a user";
                    $pdo->commit();
                    echo js_alert(msg_ssn(return: true));
                    return true;
                } else {
                    $pdo->rollback();
                    $_SESSION['msg'][] = "User not created, something went wrong";
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
            $_SESSION['msg'][] = "All fields (First name, Last name, Mobile, Email, Password and National Id) are mandatory";
            echo js_alert(msg_ssn(return: true));
            return false;
        }
    }
    function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = false;
            $req = obj($_POST);
            $db = new Dbobjects;
            $db->tableName = 'pk_user';
            $user_email = $db->filter(['email' => $req->email, 'password' => md5($req->password), 'is_user' => 1]);
            if (count($user_email) == 1) {
                $user = $user_email[0];
            } else {
                $user_username = $db->filter(['username' => $req->email, 'password' => md5($req->password), 'is_user' => 1]);
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

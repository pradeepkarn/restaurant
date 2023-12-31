
<?php
if (session_status() === PHP_SESSION_NONE) {
  @ob_start();
  @session_start();
}
require_once(__DIR__ . "/config.php");
define("direct_access", 1);
import("/includes/class-autoload.inc.php");
import("functions.php");
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$home = home;
define('RELOAD', js("location.reload();"));
define('URL', $url);
$acnt = new Account;
$acnt = $acnt->getLoggedInAccount();
define('USER', $acnt);
$checkaccess = ['admin', 'subadmin', 'salesman', 'whmanager'];
if (authenticate() == true) {
  if (isset(USER['user_group'])) {
    $pass = in_array(USER['user_group'], $checkaccess);
    define('PASS', $pass);
  } else {
    $pass = false;
    define('PASS', $pass);
  }
} else {
  $pass = false;
  define('PASS', $pass);
}
// Login via cookie
if (isset($_COOKIE['remember_token'])) {
  $acc = new Account;
  $acc->loginWithCookie($_COOKIE['remember_token']);
}
//login via cookie ends
switch ($path) {
  case '':
    // if (isset($_POST['submit'])) {
    // }

    import("apps/view/pages/home.php");
    break;
  case 'logout':
    if (authenticate() == true) {
      setcookie("remember_token", "", time() - (86400 * 30 * 12), "/"); // 86400 = 1 day
      // Finally, destroy the session.
      if (session_status() !== PHP_SESSION_NONE) {
        session_destroy();
      }
    }
    if (isset($_COOKIE['remember_token'])) {
      unset($_COOKIE['remember_token']);
    }
    header("Location:/" . home);
    break;
  case 'admin-logout':
    if (authenticate() == true) {
      setcookie("remember_token", "", time() - (86400 * 30 * 12), "/"); // 86400 = 1 day
      // Finally, destroy the session.
      if (session_status() !== PHP_SESSION_NONE) {
        session_destroy();
      }
    }
    if (isset($_COOKIE['remember_token'])) {
      unset($_COOKIE['remember_token']);
    }
    header("Location:/" . home . "/login");
    break;
  default:
    if ($url[0] == "cart") {
      import("apps/view/pages/cart.php");
      return;
    }
    if ($url[0] == "checkout") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        echo go_to("login");
        return;
      }
      import("apps/view/pages/checkout.php");
      return;
    }
    // if ($url[0] == "food-listing") {
    //   if (authenticate() == false) {
    //     echo js_alert('Please login first');
    //     echo go_to("login");
    //     return;
    //   }
    //   import("apps/view/pages/food-listing.php");
    //   return;
    // }
    if ($url[0] == "food-listing") {
      $userObj = new Model('restaurant_listing');
      if ($userObj->filter_index(array('is_listed' => true, 'user_id' => $_SESSION['user_id']))) {
        import("apps/view/pages/food-listing.php");
        return;
      }
      echo js_alert('Please Register Your Restaurant First!');
      echo go_to("restaurant-listing");
      return;
    }
    if ($url[0] == "food") {
      import("apps/view/pages/food.php");
      return;
    }
    if ($url[0] == "partner") {
      import("apps/view/pages/partner.php");
      return;
    }
    if ($url[0] == "product") {
      import("apps/view/pages/product.php");
      return;
    }
    if ($url[0] == "create-menu") {
      import("apps/view/pages/create-menu.php");
      return;
    }
    if ($url[0] == "upload-menu-ajax") {
      // myprint($_POST);
      // return;
      $arr = null;
      $itemMenu = new Model('menu_listing');
      $arr['user_id'] = $_SESSION['user_id'];
      $arr['rest_id'] = $_POST['rest_name'];
      $arr['menu_name'] = $_POST['menu_name'];
      $arr['description'] = $_POST['menu_desc'];
      $arr['is_listed'] = true;

      if (!isset($_POST['menu_name']) || empty($_POST['menu_name'])) {
        echo js_alert('Menu Name Cannot Be Empty');
        return;
      }

      // For Image
      $menu_image = $_FILES['menu_img']['name'][0];
      $temp_image = $_FILES['menu_img']['tmp_name'][0];

      if (empty($menu_image)) {
        echo js_alert('Menu Image Cannot Be Empty');
        return;
      }
      // myprint($_FILES);
      // return;
      $arr['banner'] = $menu_image;
      move_uploaded_file($temp_image, RPATH . "/media/images/menu/$menu_image");
      // myprint($menu_image);
      // return;
      try {
        $id = $itemMenu->store($arr);
        if (intval($id)) {
          $menuItemDetails = new Model('content_details');
          for ($i = 0; $i < count($_FILES['menu_img']['name']); $i++) {
            if ($_FILES['menu_img']['name'][$i] === "") {
              echo js_alert("Please select a valid file");
              return;
            }

            $obj_grp = "menu_more_img";
            $obj_id = $id;

            $arr['content_group'] = "menu_more_img";
            $arr['content_id'] = $id;
            $arr['status'] = "approved";

            // $arr['details'] = $_POST['food_img_name'][$i];

            $file_with_ext = $_FILES['menu_img']['name'][$i];
            if (!empty($_FILES['menu_img']['name'][$i])) {
              $only_file_name = filter_name($file_with_ext);
              $only_file_name = $only_file_name . "{$obj_id}{$obj_grp}_" . random_int(100000, 999999);
              $target_dir = RPATH . "/media/images/menu/";
              $file_ext_arr = explode(".", $file_with_ext);
              $ext = end($file_ext_arr);
              $target_file = $target_dir . "{$only_file_name}." . $ext;

              $allowed_mime_types = [
                "image/png",
                "image/jpeg",
                "image/jpg",
              ];

              if (in_array($_FILES['menu_img']['type'][$i], $allowed_mime_types)) {
                if (move_uploaded_file($_FILES['menu_img']['tmp_name'][$i], $target_file)) {
                  $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                  $filename = $only_file_name . "." . $ext;
                  $arr['content'] = $filename;
                  $menuItemDetails->store($arr);
                }
              } else {
                $_SESSION['msg'][] = "$file_with_ext is an invalid file";
              }
            }
          }
          echo js_alert('Menu uploaded successfully');
          echo RELOAD;
          return;
        } else {
          echo js_alert('Menu not uploaded');
        }
      } catch (PDOException $th) {
        echo js_alert('Menu not uploaded');
        // throw $th;
      }
      return;
    }
    if ($url[0] == "my-restaurant") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        echo go_to("login");
        return;
      }
      import("apps/view/pages/my-restaurant.php");
      return;
    }
    if ($url[0] == "restaurant-listing") {
      // if (authenticate() == false) {
      //   echo js_alert('Please login first');
      //   echo go_to("login");
      //   return;
      // }
      import("apps/view/pages/restaurant-listing.php");
      return;
    }
    if ($url[0] == "shop") {
      import("apps/view/pages/shop.php");
      return;
    }
    if ($url[0] == "categories") {
      import("apps/view/pages/categories.php");
      return;
    }
    if ($url[0] == "categories") {
      import("apps/view/pages/categories.php");
      return;
    }
    if ($url[0] == "user-dashboard") {
      if (authenticate()) {
        if (USER['is_user'] == 1) {
          import("apps/view/pages/user-dashboard.php");
          return;
        }
      }
      echo js_alert("Login to continue!");
      echo go_to("login");
      return;
    }
    if ($url[0] == "user-orders") {
      import("apps/view/pages/user-orders.php");
      return;
    }
    if ($url[0] == "user-orders-details") {
      import("apps/view/pages/user-orders-details.php");
      return;
    }
    if ($url[0] == "track-orders") {
      import("apps/view/pages/track-orders.php");
      return;
    }
    if ($url[0] == "all-restaurants") {
      import("apps/view/pages/all-restaurants.php");
      return;
    }
    if ($url[0] == "register") {
      import("apps/view/pages/register.php");
      return;
    }

    ############################### Driver area starts ############################
    // Driver registration template page
    if ($url[0] == "driver-registration") {
      import("apps/view/pages/drivers/register.php");
      return;
    }
    if ($url[0] == "driver-register-ajax") {
      $drvr = new Driver_ctrl;
      $reply = $drvr->register();
      if ($reply == true) {
        echo go_to('driver-login');
        exit;
      }
      return;
    }
    // Driver login template page
    if ($url[0] == "driver-login") {
      $home = home;
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          header("Location:/$home");
          return;
        }
      }
      import("apps/view/pages/drivers/login.php");
      return;
    }
    if ($url[0] == "driver-login-ajax") {
      $drvr = new Driver_ctrl;
      if ($drvr->login()) {
        echo go_to('driver-dashboard');
        exit;
      }
      return;
    }

    if ($url[0] == "driver-dashboard") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/driver-dashboard.php");
          return;
        }
      }
      echo go_to('driver-login');
      return;
    }

    #################################### user area starts #############################

    if ($url[0] == "register-ajax") {
      $drvr = new User_ctrl;
      $reply = $drvr->register();
      if ($reply == true) {
        echo go_to('login');
        exit;
      }
      return;
    }

    if ($url[0] == "login") {
      if (authenticate()) {
        if (USER['is_user'] == 1) {
          header("Location:/$home");
          return;
        }
      }
      import("apps/view/pages/login.php");
      return;
    }
    if ($url[0] == "login-ajax") {
      $drvr = new User_ctrl;
      if ($drvr->login()) {
        echo go_to('');
        exit;
      }
      return;
    }
    ################################################################################################

    if ($url[0] == "restaurant-list-ajax") {

      $rest_list = new Rest_ctrl;
      $reply = $rest_list->register();
      echo go_to('restaurant-login');
      exit;
    }


    // Restaurant login template page
    if ($url[0] == "restaurant-login") {
      $home = home;
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          header("Location:/$home");
          return;
        }
      }
      import("apps/view/pages/restaurant/login.php");
      return;
    }


    if ($url[0] == "restaurant-dashboard") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/restaurant-dashboard.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "restaurant-orders") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "my-accepted-orders") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/accepted-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "my-cancelled-orders") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/cancelled-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "my-delivered-orders") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/delivered-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "my-listed-foods") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/my-listed-foods.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "edit-my-listed-food") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/edit-my-listed-food.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "restaurant-login-ajax") {
      $rstrnt = new Rest_ctrl;
      if ($rstrnt->login()) {
        echo go_to('restaurant-dashboard');

        exit;
      }
      return;
    }

    // Admin Dashboard ######################################################## Admin ##################
    if ($url[0] == "admin-login") {
      import("apps/admin/pages/admin-login.php");
      return;
    }
    if ($url[0] == "admin-login-ajax") {

      // echo go_to("index");
      if (ad_login()) {
        if (is_superuser()) {
          echo go_to("sitepanel");
          return;
        } else {
          echo go_to("");
        }
      } else {
        msg_ssn();
      }
      return;
    }
    if ($url[0] == "sitepanel") {
      if (is_superuser()) {
        import("apps/admin/pages/dashboard.php");
        return;
      }
      echo go_to("");
      return;
    }
    if ($url[0] == "restaurant-info") {
      if (is_superuser()) {
        import("apps/admin/pages/restaurant-info.php");
        return;
      }
      echo go_to("");
      return;
    }
    if ($url[0] == "restaurant-list") {
      if (is_superuser()) {
        import("apps/admin/pages/restaurant-list.php");
        return;
      }
      echo go_to("");
      return;
    }
    // new orders
    if ($url[0] == "new-orders") {
      if (is_superuser()) {
        import("apps/admin/pages/meal_orders/new.php");
        return;
      }
      echo go_to("");
      return;
    }
    // assigned orders
    if ($url[0] == "assigned-orders") {
      if (is_superuser()) {
        import("apps/admin/pages/meal_orders/assigned.php");
        return;
      }
      echo go_to("");
      return;
    }
    // delivered orders
    if ($url[0] == "delivered-orders") {
      if (is_superuser()) {
        import("apps/admin/pages/meal_orders/delivered.php");
        return;
      }
      echo go_to("");
      return;
    }
    // cancelled orders
    if ($url[0] == "cancelled-orders") {
      if (is_superuser()) {
        import("apps/admin/pages/meal_orders/cancelled.php");
        return;
      }
      echo go_to("");
      return;
    }
    if ($url[0] == "registered-users") {
      if (is_superuser()) {
        import("apps/admin/pages/registered-users.php");
        return;
      }
      echo go_to("");
      return;
    }
    if ($url[0] == "registered-riders") {
      if (is_superuser()) {
        import("apps/admin/pages/registered-riders.php");
        return;
      }
      echo go_to("");
      return;
    }
    if ($url[0] == "add-food-category") {
      if (is_superuser()) {
        import("apps/admin/pages/add-food-category.php");
        return;
      }
      echo go_to("");
      return;
    }
    ########################################################################################## Admin ends #################
    if ($url[0] == "restaurant-settings") {
      if (authenticate()) {
        if (USER['is_restaurant'] == 1) {
          import("apps/view/pages/restaurant/settings.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    ############################################## driver
    if ($url[0] == "driver-settings") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/settings.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "all-new-orders") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/new-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "all-accepted-orders") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/accepted-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "all-delivered-orders") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/delivered-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "all-cancelled-orders") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          import("apps/view/pages/drivers/cancelled-order-list.php");
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "accept-order-by-driver") {
      if (authenticate()) {
        if (USER['is_driver'] == 1) {
          $post = obj($_POST);
          $db = new Dbobjects;
          $reply = $db->dbpdo()->exec("update payment set deliver_by = '$post->deliver_by' where id = '$post->payment_id' and (deliver_by > 0 OR deliver_by='');");
          if ($reply) {
            echo js_alert("Order accepted");
            echo RELOAD;
          }
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    ######################################### driver or restaurant
    if ($url[0] == "change-accepted-order-status-by-driver") {
      if (authenticate()) {
        if (USER['is_driver'] == 1 || USER['is_restaurant'] == 1) {
          $post = obj($_POST);
          $db = new Dbobjects;
          switch ($post->action) {
            case 'cancelled':
              if (USER['is_restaurant'] == 1) {
                $reply = $db->dbpdo()->exec("update payment set deliver_by = '0', is_cancelled=1 where id = '$post->payment_id';");
              } else {
                // $reply = $db->dbpdo()->exec("update payment set deliver_by = '$post->deliver_by', is_cancelled=1 where id = '$post->payment_id' and (deliver_by > 0 OR deliver_by='');");
                $reply = false;
              }
              break;
            case 'delivered':
              $reply = $db->dbpdo()->exec("update payment set deliver_by = '$post->deliver_by', is_delivered=1 where id = '$post->payment_id' and (deliver_by > 0 OR deliver_by='');");
              break;
            case 'release':
              $reply = $db->dbpdo()->exec("update payment set deliver_by = '0', is_cancelled=0 where id = '$post->payment_id' and (deliver_by > 0 OR deliver_by='');");
              break;
            default:
              $reply = false;
              break;
          }
          if ($reply) {
            echo js_alert("Order status changed");
            echo RELOAD;
          } else {
            echo js_alert("No change");
          }
          return;
        }
      }
      echo go_to('restaurant-login');
      return;
    }
    if ($url[0] == "update-my-profile") {
      if (authenticate()) {
        $db = new Dbobjects;
        $db->tableName = 'pk_user';
        $db->insertData['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : USER['first_name'];
        $db->insertData['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : USER['last_name'];
        $db->insertData['zipcode'] = isset($_POST['zipcode']) ? $_POST['zipcode'] : USER['zipcode'];
        $loc = isset($_POST['address']) ? $_POST['address'] : USER['address'];
        $db->insertData['address'] = $loc;
        $lat = isset($_POST['lat']) ? $_POST['lat'] : USER['lat'];
        $lon = isset($_POST['lon']) ? $_POST['lon'] : USER['lon'];
        $db->insertData['lat'] = $lat;
        $db->insertData['lon'] = $lon;
        $user = obj(USER);
        $db->pk(USER['id']);
        $upadate = $db->update();
        if ($upadate) {
          echo js_alert('Updated');
          if (USER['is_restaurant'] == 1) {
            $db->show("update restaurant_listing set latitude ='$lat', longitude='$lon', rest_location='$loc' where user_id = '{$user->id}';");
          }
          echo RELOAD;
          return;
        }
      } else {
        echo js_alert('You are not logged in');
        return;
      }
      return;
    }
    if ($url[0] == "edit-food-category") {
      if (is_superuser()) {
        import("apps/admin/pages/edit-food-category.php");
        return;
      }
      echo go_to("");
    }
    if ($url[0] == "food-category-table") {
      if (is_superuser()) {
        import("apps/admin/pages/food-category-table.php");
        return;
      }
      echo go_to("");
    }
    if ($url[0] == "upload-category-ajax") {
      // myprint($_POST);
      $arr = null;
      $itemCategory = new Model('content');
      $arr['created_by'] = $_SESSION['user_id'];
      $arr['title'] = $_POST['food_title'];
      $arr['content_info'] = $_POST['food_description'];
      $arr['slug'] = generate_slug($_POST['food_slug']);
      $arr['content_group'] = 'listing_category';
      $arr['status'] = 'listed';
      // For Image
      $category_image = $_FILES['food_category_image']['name'];
      $temp_image = $_FILES['food_category_image']['tmp_name'];
      $arr['banner'] = $category_image;
      move_uploaded_file($temp_image, RPATH . "/media/images/pages/$category_image");

      if ($arr['title'] == "") {
        echo js_alert('Category name is required');
        return;
      }
      if ($arr['content_info'] == "") {
        echo js_alert('Category description is required');
        return;
      }

      $id = $itemCategory->store($arr);
      // myprint($id);
      if (intval($id)) {
        echo js_alert('Category uploaded successfully');
        echo RELOAD;
        return;
      } else {
        echo js_alert('Category not uploaded');
      }
    }

    if ($url[0] == "update-category-ajax") {
      // myprint($_FILES);
      $data = (object) ($_POST);
      //  myprint($data);
      updateCategory();
      echo js_alert('Food Category updated successfully');
      echo RELOAD;
      return;
    }
    if ($url[0] == "delete-food-cat") {
      $id = $_GET['cid'];
      // myprint($id);
      (new Model('content'))->destroy($id);
      echo js_alert('Category deleted successfully');
      echo go_to("food-category-table");
      return;
    }

    if ($url[0] == "orders-history") {
      if (is_superuser()) {
        import("apps/admin/pages/orders-history.php");
        return;
      }
      echo go_to("");
    }
    if ($url[0] == "order-info") {
      if (is_superuser()) {
        import("apps/admin/pages/order-info.php");
        return;
      }
      echo go_to("");
    }

    if ($url[0] == "upload-food-ajax") {
      // myprint($_POST);
      // return;
      $arr = null;
      $foodItem = new Model('content');
      $arr['created_by'] = $_SESSION['user_id'];
      $arr['vendor_id'] = $_POST['rst_name'];
      $arr['parent_id'] = $_POST['food_cat'];
      $arr['title'] = $_POST['food_name'];
      $arr['price'] = $_POST['food_price'];
      $arr['content'] = $_POST['food_desc'];
      $arr['content_info'] = $_POST['food_ingridients'];
      $arr['other_content'] = $_POST['food_info'];
      $arr['content_group'] = 'food_listing_category';
      $arr['status'] = 'listed';
      // For Image
      $food_image = $_FILES['food_img']['name'][0];
      $temp_image = $_FILES['food_img']['tmp_name'][0];
      // myprint($_FILES);
      // return;
      $arr['banner'] = $food_image;
      move_uploaded_file($temp_image, RPATH . "/media/images/pages/$food_image");

      if ($arr['title'] == "") {
        echo js_alert('Food name is required');
        return;
      }
      if ($arr['content_info'] == "") {
        echo js_alert('Food description is required');
        return;
      }


      $id = $foodItem->store($arr);
      // myprint($id);
      if (intval($id)) {
        $foodItemDetails = new Model('content_details');
        for ($i = 0; $i < count($_FILES['food_img']['name']); $i++) {
          if ($_FILES['food_img']['name'][$i] === "") {
            echo js_alert("Please select a valid file");
            return;
          }

          $obj_grp = "product_more_img";
          $obj_id = $id;

          $arr['content_group'] = "product_more_img";
          $arr['content_id'] = $id;
          $arr['status'] = "approved";

          // $arr['details'] = $_POST['food_img_name'][$i];

          $file_with_ext = $_FILES['food_img']['name'][$i];
          if (!empty($_FILES['food_img']['name'][$i])) {
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

            if (in_array($_FILES['food_img']['type'][$i], $allowed_mime_types)) {
              if (move_uploaded_file($_FILES['food_img']['tmp_name'][$i], $target_file)) {
                $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                $filename = $only_file_name . "." . $ext;
                $arr['content'] = $filename;
                $foodItemDetails->store($arr);
              }
            } else {
              $_SESSION['msg'][] = "$file_with_ext is an invalid file";
            }
          }
        }
        echo js_alert('Food Item uploaded successfully');
        echo RELOAD;
        return;
      } else {
        echo js_alert('Food Item not uploaded');
      }
      return;
    }
    if ($url[0] == "update-food-ajax") {
      // myprint($_POST);
      // return;
      $arr = null;
      $foodItem = new Model('content');
      $foodid = $_POST['food_id'];
      $arr['parent_id'] = $_POST['food_cat'];
      $arr['title'] = $_POST['food_name'];
      $arr['price'] = $_POST['food_price'];
      $arr['content'] = $_POST['food_desc'];
      $arr['content_info'] = $_POST['food_ingridients'];
      $arr['other_content'] = $_POST['food_info'];
      $arr['content_group'] = 'food_listing_category';
      $arr['status'] = 'listed';
      // For Image
      $food_image = $_FILES['food_img']['name'][0];
      $temp_image = $_FILES['food_img']['tmp_name'][0];
      // myprint($_FILES);
      // return;
      $arr['banner'] = $food_image;
      move_uploaded_file($temp_image, RPATH . "/media/images/pages/$food_image");

      if ($arr['title'] == "") {
        echo js_alert('Food name is required');
        return;
      }
      if ($arr['content_info'] == "") {
        echo js_alert('Food description is required');
        return;
      }


      $id = $foodItem->update($foodid, $arr);
      echo RELOAD;
      return;
      // myprint($id);
      if (intval($id)) {
        $foodItemDetails = new Model('content_details');
        for ($i = 0; $i < count($_FILES['food_img']['name']); $i++) {
          if ($_FILES['food_img']['name'][$i] === "") {
            echo js_alert("Please select a valid file");
            return;
          }

          $obj_grp = "product_more_img";
          $obj_id = $id;

          $arr['content_group'] = "product_more_img";
          $arr['content_id'] = $id;
          $arr['status'] = "approved";

          // $arr['details'] = $_POST['food_img_name'][$i];

          $file_with_ext = $_FILES['food_img']['name'][$i];
          if (!empty($_FILES['food_img']['name'][$i])) {
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

            if (in_array($_FILES['food_img']['type'][$i], $allowed_mime_types)) {
              if (move_uploaded_file($_FILES['food_img']['tmp_name'][$i], $target_file)) {
                $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                $filename = $only_file_name . "." . $ext;
                $arr['content'] = $filename;
                $foodItemDetails->store($arr);
              }
            } else {
              $_SESSION['msg'][] = "$file_with_ext is an invalid file";
            }
          }
        }
        echo js_alert('Food Item uploaded successfully');
        echo RELOAD;
        return;
      } else {
        echo js_alert('Food Item not uploaded');
      }
    }

    if ($url[0] == "update-restaurant-ajax") {
      // myprint($_POST);
      // return;
      if (isset($_POST['restaurant_id'])) {
        $myobj = new Dbobjects;
        $myobj->tableName = "restaurant_listing";
        $id = $_POST['restaurant_id'];
        $myobj->pk($id);
        $myobj->insertData['is_listed'] = $_POST['rs_status'];
        // myprint($data);
        $myobj->update();
        echo go_to("restaurant-list");
      }
      exit;
    }

    if ($url[0] == "send-add-item-ajax") {
      if (isset($_POST['item_id']) && filter_var($_POST['item_id'], FILTER_VALIDATE_INT)) {
        $prodid = $_POST['item_id'];
        $restid = $_POST['rest_id'];
        $product = (new Model('content'))->show($prodid);
        if ($product == false) {
          die();
        } else {
          if (add_to_cart(id: $prodid, rest_id: $restid) == false) {
            echo swt_alert_err('Product is out of stock');
            return;
          }
          if (isset($_POST['page']) && $_POST['page'] == "home") {
            echo "<h3>Added in cart <i class='fa-solid fa-check'></i></h3>";
            return;
          }
          echo swt_alert_suc('Item added successfully');
        }
      }
      die();
    }
    if ($url[0] == "add-item-ajax") {
      if (isset($_POST['rest_id']) && isset($_POST['item_id']) && filter_var($_POST['item_id'], FILTER_VALIDATE_INT)) {
        $prodid = $_POST['item_id'];
        $restid = $_POST['rest_id'];
        $product = (new Model('content'))->show($prodid);
        if ($product == false) {
          die();
        } else {
          $cart_add = add_to_cart(id: $prodid, action: 'add_to_cart', rest_id: $restid);
          if ($cart_add == false) {
            echo swt_alert_err('Product is out of stock');
            return;
          } else if ($cart_add === "vendor_changed") {
            echo js_alert('Your cart is reset.');
            echo RELOAD;
            return;
          }
          if (isset($_POST['page']) && $_POST['page'] == "home") {
            echo "<h3>Added in cart <i class='fa-solid fa-check'></i></h3>";
            return;
          }
          echo RELOAD;
          // echo swt_alert_suc('Item added successfully');
        }
      }
      return;
    }

    if ($url[0] == "purchase-decrease-qty-ajax") {

      if (isset($_POST['item_id']) && filter_var($_POST['item_id'], FILTER_VALIDATE_INT)) {
        $prodid = $_POST['item_id'];
        $product = (new Model('content'))->show($prodid);
        if ($product == false) {
          die();
        } else {
          if (isset($_SESSION['cart'])) {
            remove_from_cart($prodid);
            echo js('location.reload();');
            return;
          }
        }
      }
      die();
    }
    if ($url[0] == "purchase-increase-qty-ajax") {

      if (isset($_POST['item_id']) && filter_var($_POST['item_id'], FILTER_VALIDATE_INT)) {
        $prodid = $_POST['item_id'];
        $restid = $_POST['rest_id'];
        $product = (new Model('content'))->show($prodid);
        if ($product == false) {
          die();
        } else {
          if (add_to_cart(id: $prodid, action: 'add_to_cart', rest_id: $restid) == false) {
            echo js_alert('Product is out of stock');
            return;
          }
          if (isset($_POST['page']) && $_POST['page'] == "home") {
            echo "<h3>Added in cart <i class='fa-solid fa-check'></i></h3>";
            return;
          }
          echo swt_alert_suc('Item added successfully');
        }
      }
      die();
    }

    ################## Order Placement ################################
    if ($url[0] == 'api') {
      import('apps/api/index.php');
      return;
    }
    if ($url[0] == "place-order-ajax") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        return;
      }
      $req = (object) ($_POST);
      if ($req) {
        $arr = null;
        $placeOrder = new Model('payment');
        $addrs = (object) ($_POST);
        if (!isset($_POST['payment_mode'])) {
          $_SESSION['msg'][] = 'Please select payment mode';
          return false;
        }
        if (!isset($addrs->lat) || !isset($addrs->lon) || !isset($addrs->address)) {
          $_SESSION['msg'][] = 'Location is compulsory';
          return false;
        }
        if (empty($addrs->lat) || empty($addrs->lon) || empty($addrs->address)) {
          $_SESSION['msg'][] = 'Location is compulsory';
          return false;
        }
        if ($_POST['payment_mode'] == '') {
          echo js_alert('Please select payment mode');
          return;
        }
        try {
          $arr['amount'] = $addrs->total_amount;
        } catch (PDOException $e) {
          return false;
        }
        if (
          $addrs->fname == '' ||
          $addrs->mobile == '' ||
          $addrs->locality == '' ||
          $addrs->city == '' ||
          $addrs->state == '' ||
          $addrs->country == '' ||
          $addrs->zipcode == '' ||
          $addrs->isd_code == ''
        ) {
          // $_SESSION['msg'][] = 'Please check your primary address and make sure you have entered all the details';
          echo js_alert('All Fields are required');
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
        $arr['rest_id'] = $addrs->restaurant_id;
        $restcord = (object)(new Dbobjects)->showOne("select latitude,longitude from restaurant_listing where id = '$addrs->restaurant_id';");
        $arr['landmark'] = isset($addrs->address) ? $addrs->address : null;
        $arr['lat'] = isset($addrs->lat) ? $addrs->lat : null;
        $arr['lon'] = isset($addrs->lon) ? $addrs->lon : null;
        $distance = calculateDistance($restcord->latitude, $restcord->longitude, $arr['lat'], $arr['lon']);
        if (!is_numeric($distance)) {
          echo js_alert('Invalid location');
          return;
        }
        $arr['distance'] = $distance;
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
          $custOrder = new Model('customer_order');
          $user_id = $_SESSION['user_id'];
          $payment_id = $pay;

          // Iterate over each product
          for ($i = 0; $i < count($_POST['food_id']); $i++) {
            $arr = array(
              'user_id' => $user_id,
              'payment_id' => $payment_id,
              'item_id' => $_POST['food_id'][$i],
              'rest_id' => $_POST['rest_id'][$i],
              'qty' => $_POST['qty'][$i],
              'price' => $_POST['price'][$i],
              'status' => 'paid',
              'updated_at' => date('Y-m-d H:i:s')
            );
            // execute payment data
            $paid = $custOrder->store($arr);
          }
          try {
            (new Order_api)->send_single_order($payment_id);
          } catch (PDOException $th) {
            
          }
          echo js_alert('Order placed');
          session_destroy();
          echo go_to("");

          $my_email = null;
        } else {
          // $_SESSION['msg'][] = 'Order not placed';
          echo js_alert('Order not placed');
          return false;
        }
      }
      return;
    }

    ################## Order Placement ends ################################

    else {
      import("apps/view/pages/404.php");
      return;
    }
    break;
}

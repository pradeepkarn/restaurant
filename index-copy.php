<?php
require_once(__DIR__ . "/config.php");
import("/includes/class-autoload.inc.php");
import("functions.php");
import("functions.php");
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
define("direct_access", 1);
// $GLOBALS['row_id'] = end($url);
// $GLOBALS['tableName'] = prev($url);
// $GLOBALS['url_last_param'] = end($url);
// $GLOBALS['url_2nd_last_param'] = prev($url);
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


$context = array();
// Login via cookie
if (isset($_COOKIE['remember_token'])) {
  $acc = new Account;
  $acc->loginWithCookie($_COOKIE['remember_token']);
}
//login via cookie ends

switch ($path) {
  case '':
    if (isset($_POST['submit'])) {
    }

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
    header("Location:/" . home ."/login");
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
    if($url[0] == "upload-menu-ajax"){
      // myprint($_POST);
      // return;
      $arr = null;
      $itemMenu = new Model('menu_listing');
      $arr['user_id'] = $_SESSION['user_id'];
      $arr['rest_id'] = $_POST['rest_name'];
      $arr['menu_name'] = $_POST['menu_name'];
      $arr['is_listed'] = true;
      
      if (!isset($_POST['food_name']) && empty($_POST['food_name'])) {
        echo js_alert('You dont have food to upload');
        return;
      }
      $jsn['food'] = $_POST['food_name'];
      $arr['jsn'] = json_encode($jsn);
      try {
        $id = $itemMenu->store($arr);
        //  myprint($id);
      if (intval($id)) {
        echo js_alert('menu uploaded successfully');
        echo RELOAD;
        }else{
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
      if (authenticate() == false) {
        echo js_alert('Please login first');
        echo go_to("login");
        return;
      }
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
    if ($url[0] == "all-restaurants") {
      import("apps/view/pages/all-restaurants.php");
      return;
    }
    if ($url[0] == "register") {
      import("apps/view/pages/register.php");
      return;
    }
    if ($url[0] == "register-ajax") {

      if (register()) {
        echo js_alert('Registration successfully');
        echo go_to("login");
      } else {
        msg_ssn();
      }
      return;
    }

    if ($url[0] == "login") {
      import("apps/view/pages/login.php");
      return;
    }
    if ($url[0] == "login-ajax") {

      // echo go_to("index");
      if (login()) { 
        echo go_to("");
      } else {
        msg_ssn();
      }
      return;
    }

    if ($url[0] == "restaurant-list-ajax") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        return;
      }
      // myprint($_SESSION['user_id']);
      // myprint($_POST);
      $arr = null;
      $restItem = new Model('restaurant_listing');
      $arr['user_id'] = $_SESSION['user_id'];
      if (isset($_POST['rest_name']) && !empty($_POST['rest_name'])) {
        $arr['rest_name'] = $_POST['rest_name'];
      }else{
        echo js_alert('Restaurant Name Cannot Be Empty!');
        return;
      }
      if (isset($_POST['rest_address']) && !empty($_POST['rest_address'])) {
        $arr['rest_address'] = $_POST['rest_address'];
      }else{
        echo js_alert('Restaurant Address Cannot Be Empty!');
        return;
      }
      if (isset($_POST['rest_location']) && !empty($_POST['rest_location'])) {
        $arr['rest_location'] = $_POST['rest_location'];
      }else{
        echo js_alert('Restaurant Location Cannot Be Empty!');
        return;
      }
      if (isset($_POST['latitude']) && !empty($_POST['latitude'])) {
        $arr['latitude'] = $_POST['latitude'];
      }else{
        echo js_alert('Latitude Cannot Be Empty!');
        return;
      }
      if (isset($_POST['longitude']) && !empty($_POST['longitude'])) {
        $arr['longitude'] = $_POST['longitude'];
      }else{
        echo js_alert('Longitude Cannot Be Empty!');
        return;
      }
      if (isset($_POST['rest_mobile']) && !empty($_POST['rest_mobile'])) {
        $arr['rest_mobile'] = $_POST['rest_mobile'];
      }else{
        echo js_alert('Restaurant Mobile Number Cannot Be Empty!');
        return;
      }
      if (isset($_POST['rest_landline']) && !empty($_POST['rest_landline'])) {
        $arr['rest_landline'] = $_POST['rest_landline'];
      }else{
        echo js_alert('Restaurant Landline Number Cannot Be Empty!');
        return;
      }
      if (isset($_POST['owner_mobile']) && !empty($_POST['owner_mobile'])) {
        $arr['owner_mobile'] = $_POST['owner_mobile'];
      }else{
        echo js_alert('Owner Number Cannot Be Empty!');
        return;
      }
      if (isset($_POST['owner_name']) && !empty($_POST['owner_name'])) {
        $arr['owner_name'] = $_POST['owner_name'];
      }else{
        echo js_alert('Owner Name Cannot Be Empty!');
        return;
      }
      if (isset($_POST['owner_email']) && !empty($_POST['owner_email'])) {
        $arr['owner_email'] = $_POST['owner_email'];
      }else{
        echo js_alert('Owner Email Cannot Be Empty!');
        return;
      }
      if (isset($_POST['timings']) && !empty($_POST['timings'])) {
        $arr['timings'] = $_POST['timings'];
      }else{
        echo js_alert('Restaurant Timmings Cannot Be Empty!');
        return;
      }
      if (isset($_POST['priceforone']) && !empty($_POST['priceforone'])) {
        $arr['priceforone'] = $_POST['priceforone'];
      }else{
        echo js_alert('Price For One Person Cannot Be Empty!');
        return;
      }
      if (isset($_POST['food_time']) && !empty($_POST['food_time'])) {
        $arr['food_time'] = $_POST['food_time'];
      }else{
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
      move_uploaded_file($temp_image, RPATH."/media/images/pages/$rest_image");
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
              $only_file_name = $only_file_name."{$obj_id}{$obj_grp}_".random_int(100000, 999999);
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
                      $filename = $only_file_name.".".$ext;
                      $arr['content'] = $filename;
                      $restItemDetails->store($arr);
                  }
              } else {
                  $_SESSION['msg'][] = "$file_with_ext is an invalid file";
              }
          }
      }
        echo js_alert('Restaurant Listed Successfully!');
        echo RELOAD;
        return;
      }else{
        echo js_alert('Restaurant Not Listed!');
        echo RELOAD;
        return;
      }
    }


    // Admin Dashboard
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
        }else{
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
      }echo go_to("");
    } 
    if ($url[0] == "restaurant-info") {
      if (is_superuser()) {
      import("apps/admin/pages/restaurant-info.php");
      return;
      }echo go_to("");
    }
    if ($url[0] == "restaurant-list") {
      if (is_superuser()) {
      import("apps/admin/pages/restaurant-list.php");
      return;
      }echo go_to("");
    }
    if ($url[0] == "add-food-category") {
      if (is_superuser()) {
      import("apps/admin/pages/add-food-category.php");
      return;
      }echo go_to("");
    }
    if ($url[0] == "edit-food-category") {
      if (is_superuser()) {
      import("apps/admin/pages/edit-food-category.php");
      return;
      }echo go_to("");
    }
    if ($url[0] == "food-category-table") {
      if (is_superuser()) {
      import("apps/admin/pages/food-category-table.php");
      return;
      }echo go_to("");
    }
    if($url[0]=="upload-category-ajax"){
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
      move_uploaded_file($temp_image, RPATH."/media/images/pages/$category_image");

      if ($arr['title']=="") {
        echo js_alert('Category name is required');
        return;
      }
      if ($arr['content_info']=="") {
        echo js_alert('Category description is required');
        return;
      }
      
      $id = $itemCategory->store($arr);
      // myprint($id);
      if (intval($id)) {
        echo js_alert('Category uploaded successfully');
        echo RELOAD;
        return;
        }else{
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
    if ($url[0] == "delete-food-cat"){
      $id = $_GET['cid'];
      // myprint($id);
      (new Model('content'))->destroy($id);
      echo js_alert('Category deleted successfully');
      echo go_to("food-category-table");
      return;
    }

    if($url[0]=="upload-food-ajax"){
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
      move_uploaded_file($temp_image, RPATH."/media/images/pages/$food_image");

      if ($arr['title']=="") {
        echo js_alert('Food name is required');
        return;
      }
      if ($arr['content_info']=="") {
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
              $only_file_name = $only_file_name."{$obj_id}{$obj_grp}_".random_int(100000, 999999);
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
                      $filename = $only_file_name.".".$ext;
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
        }else{
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
      if (authenticate() == false) {
        if (isset($_POST['item_id']) && filter_var($_POST['item_id'],FILTER_VALIDATE_INT)) {
          $prodid = $_POST['item_id'];
          $product = (new Model('content'))->show($prodid);
          if ($product==false) {
              die();
          }
          else{
              if(add_to_cart($prodid)==false){
                  echo swt_alert_err('Product is out of stock');
                  return;
              }
              if(isset($_POST['page']) && $_POST['page']=="home"){
                  echo "<h3>Added in cart <i class='fa-solid fa-check'></i></h3>";
                  return;
              }
              echo swt_alert_suc('Item added successfully');
          }
      }
      die();
    }
      // myprint($_POST);
      // return;
      $arr = null;
      $itemObj = new Model('content');
      $item = (object) $itemObj->show($_POST['item_id']);
      // myprint($item);
      $arr['item_id'] = $item->id;
      $arr['price'] = $_POST['price'];
      $arr['qty'] = $_POST['qty'];
      if ($arr['qty'] < 0 || $arr['price'] < 0) {
        echo js_alert('Price and quantity must be greater than zero(0)');
        return;
      }
      if ($arr['qty'] < 1) {
        echo js_alert('Quantity must be greater than or equals to 1');
        return;
      }
      // $arr['user_id'] = $_SESSION['user_id'];
      $arr['rest_id'] = $_POST['rest_id'];
      $arr['payment_id'] = 0;
      $arr['status'] = "cart";
      $new_my_order_id = (new Model('customer_order'))->store($arr);
      if (intval($new_my_order_id) && $new_my_order_id > 0) {
        echo swt_alert_suc('Item added successfully');
        // echo RELOAD;
        return;
      } else {
        echo swt_alert_err('Item not added');
        return;
      }
    }

    if ($url[0] == "purchase-decrease-qty-ajax") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        return;
      }
      $data = (object) ($_POST);
      $id = $data->cart_id;
      $qty = $data->qty - 1;

      $arr = null;
      $arr['qty'] = $qty;
      $arr['price'] = $data->price;
      $cart = new Model('customer_order');
      if ($qty == 0 || $qty < 0) {
        $cart->destroy($id, $arr);
        echo RELOAD;
        return;
      }
      $cart->update($id, $arr);
      echo RELOAD;
      return;
    }
    if ($url[0] == "purchase-increase-qty-ajax") {
      if (authenticate() == false) {
        echo js_alert('Please login first');
        return;
      }
      $data = (object) ($_POST);
      // myprint($data);
      $id = $data->cart_id;
      $qty = $data->qty + 1;
      $arr = null;
      $arr['qty'] = $qty;
      $arr['price'] = $data->price;
      $cart = new Model('customer_order');
      if ($qty == 0 || $qty < 0) {
        $cart->destroy($id);
        echo RELOAD;
        return;
      }
      echo RELOAD;
      $cart->update($id, $arr);
      return;
    }

    ################## Order Placement ################################
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
                // $_SESSION['msg'][] = 'Order placed';
                echo js_alert('Order placed');
                echo go_to("");
                $my_email = null;
            } else {
                // $_SESSION['msg'][] = 'Order not placed';
                echo js_alert('Order not placed');
                return false;
            }
        }
    }

    ################## Order Placement ends ################################

    else {
      import("apps/view/pages/404.php");
      return;
    }
    break;
}


<?php 
function login(){
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $account = new Account();
    $user = $account->login($_POST['email'], $_POST['password']);
    if ($user != false) {
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
      return $user;
    } else {
      // $GLOBALS['msg_signin'][] = "Invalid credentials";
      $_SESSION['msg'][] = "Invalid credentials";
      return false;
    }
  }
}
function ad_login(){
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $account = new Account();
    $user = $account->login($_POST['email'], $_POST['password']);
    if ($user != false) {
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
      return $user;
    } else {
      // $GLOBALS['msg_signin'][] = "Invalid credentials";
      $_SESSION['msg'][] = "Invalid credentials";
      return false;
    }
  }
}
function register(){
  
  if (isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['cnf_password'])) {

    $email = generate_dummy_email($_POST['email']);
    if (isset($_POST['email'])) {
      $email = sanitize_remove_tags($_POST['email']);
    }

    $password = sanitize_remove_tags($_POST['password']);
    $cnf_password = sanitize_remove_tags($_POST['cnf_password']);


    $arr['email'] = $email;
    $arr['password'] = md5($password);

    if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
      $arr['first_name'] = sanitize_remove_tags($_POST['first_name']);
    }else{
      $_SESSION['msg'][] = "First Name cannot be empty!";
      return;
    }
    if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
      $arr['last_name'] = sanitize_remove_tags($_POST['last_name']);
    }else{
      $_SESSION['msg'][] = "Last Name cannot be empty!";
      return;
    }
    //email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
      $_SESSION['msg'][] = "Invalid Email, please try with correct email";
      return;
    }
    //check regtered email
    $user_by_email = (new Model('pk_user'))->exists(['email' => $email]);
    if ($user_by_email != false) {
      $_SESSION['msg'][] = "User Email is already registered, please try again";
      return false;
    }
    //mobile
    if (isset($_POST['mobile'])) {
      if (filter_var($_POST['mobile'], FILTER_VALIDATE_INT) == false) {
        $_SESSION['msg'][] = "Invalid mobile";
        return;
      }
      $user_by_mobile = (new Model('pk_user'))->exists(['mobile' => $_POST['mobile']]);
      if ($user_by_mobile != false) {
        $_SESSION['msg'][] = "Mobile number is already registered";
        return;
      }
      $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
    }
    
    //empty pass
    if (($_POST['password']) == "") {
      $_SESSION['msg'][] = "Empty password is not allowed";
      return false;
    }
    //valid pass
    if (($password != $_POST['password'])) {
      $_SESSION['msg'][] = "Invalid characters used in password";
      return false;
    }
    //pass match
    if ($password != $cnf_password) {
      $_SESSION['msg'][] = "Password did not match";
      return false;
    }
    //if evrything valid then
    $dbcreate = new Model('pk_user');
    $arr['user_group'] = 'customer';
    $userid = $dbcreate->store($arr);
    if ($userid == false) {
      $_SESSION['msg'][] = "Registration Not Success";
      return false;
    }
    if (intval($userid)) {
      $_SESSION['msg'][] = "Registration successfull";
      return $userid;
    } else {
      $_SESSION['msg'][] = "Registration Not Success";
      return false;
    }

    // echo go_to("login");
    return true;
  } else {
    $_SESSION['msg'][] = "Missing required field";
    return false;
  }
  
}

function register_restaurant(){
  $restUser = new Model('pk_user');
      if (isset($_POST['owner_pass']) && isset($_POST['owner_cnf_pass'])) {

        $email = generate_dummy_email($_POST['owner_email']);
        if (isset($_POST['owner_email'])) {
          $email = sanitize_remove_tags($_POST['owner_email']);
        }
    
        if (isset($_POST['owner_email']) && !empty($_POST['owner_email'])) {
          $arr['email'] = $_POST['owner_email'];
        }else{
          echo js_alert('Owner Email Address Cannot Be Empty!');
          return;
        }

        $password = sanitize_remove_tags($_POST['owner_pass']);
        $cnf_password = sanitize_remove_tags($_POST['owner_cnf_pass']);
    
    
        $arr['email'] = $email;
        $arr['password'] = md5($password);
      }

      if ($password != $cnf_password) {
        $_SESSION['msg'][] = "Password did not match";
        return false;
      }
      //if evrything valid then
    $dbcreate = new Model('pk_user');
    $arr['user_group'] = 'rest_owner';
    $arr['is_restaurant'] = true;
    $userid = $dbcreate->store($arr);
    if ($userid == false) {
      // $_SESSION['msg'][] = "Registration Not Success";
      return false;
    }
}

function is_superuser(){
  $account = new Account();
  return $account->is_superuser();
}

function authenticate(){
  $account = new Account();
  return $account->authenticate();
}
function myprint($data=null)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}
function pkAjax($button,$url,$data,$response,$event='click',$method="post",$progress=false,$return=false)
{
  $progress_code = "";
  if ($progress==true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $home = home;
  $ajax = "<script>
  $(document).ready(function() {
      $('{$button}').on('{$event}',function(event) {
          event.preventDefault();
          if (typeof tinyMCE != 'undefined') {
            tinyMCE.triggerSave();
          }
          $.ajax({
              $progress_code
              url: '/{$home}{$url}',
              method: '$method',
              data: $('{$data}').serializeArray(),
              dataType: 'html',
              success: function(resultValue) {
                  $('{$response}').html(resultValue)
              }
          });
      });
  });
  </script>";
  if ($return==true) {
    return $ajax;
  }
  echo $ajax;
}
function pkAjax_form($button,$data,$response,$event='click',$progress=false)
{
  $progress_code = "";
  if ($progress==true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $ajax = "<script>
  $(document).ready(function (e) {
    $('{$data}').on('submit',(function(e) {
        e.preventDefault();
        if (typeof tinyMCE != 'undefined') {
          tinyMCE.triggerSave();
        }
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          $progress_code
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(resultValue){
              $('{$response}').html(resultValue)
            }
        });
    }));
    $('{$button}').on('{$event}', function() {
      $('{$data}').submit();
  });
});
</script>";
  echo $ajax;
}
function get_content_by_slug($slug)
{
  $obj = new Model('content');
  $cont =  $obj->filter_index(array('slug'=>$slug,'content_group'=>'page'));
  if(count($cont)==1) {
    return $cont[0];
  }else{
    return false;
  }

}
function generate_username_by_email($email,$try=100)
{
  if(filter_var($email,FILTER_VALIDATE_EMAIL)==true) {
      $db = new Model('pk_user');
      $arr['email'] = sanitize_remove_tags($email);
      $emailarr = explode("@",$arr['email']);
      $username = $emailarr[0];
      $dbusername = $db->exists(array('username'=>$username));
      if ($dbusername == true) {
          $i = 1;
          while ($dbusername == true) {
              $dbusername = $db->exists(array('username'=>$username.$i));
              if ($dbusername==false) {
                  return $username.$i;
              }
              if ($i==$try) {
                  break;
              }
              $i++;
          }
      }
      else{
          return $username;
      }
  }
  else{
    return false;
  }
}
function generate_dummy_email($prefix=null)
{
  return rand(1000,9999)."_".uniqid($prefix)."@example.com";
}
// function bsmodal($id="",$title="",$body="",$btn_id,$btn_text="Action",$btn_class="btn btn-primary",$size="modal-sm",$modalclasses="")
// {
// $str = "
// <div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
// <div class='modal-dialog $size'>
// <div class='modal-content'>
// <div class='modal-header'>
//     <h5 class='modal-title'>$title</h5>
//     <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
// </div>
// <div class='modal-body'>
// $body
// </div>
// <div class='modal-footer'>
//     <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
//     <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
// </div>
// </div>
// </div>
// </div>";
// return $str;
// }
// function popmodal($id="",$title="",$body="",$btn_id,$btn_text="Action",$btn_class="btn btn-primary",$size="modal-sm",$close_btn_class="")
// {
// $str = "
// <div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
// <div class='modal-dialog $size'>
// <div class='modal-content'>
// <div class='modal-header'>
//     <h5 class='modal-title'>$title</h5>
//     <button type='button' class='$close_btn_class btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
// </div>
// <div class='modal-body'>
// $body
// </div>
// <div class='modal-footer'>
//     <button type='button' class='$close_btn_class btn btn-secondary' data-bs-dismiss='modal'>Close</button>
//     <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
// </div>
// </div>
// </div>
// </div>";
// return $str;
// }
function generate_slug($slug,$try=1000)
{
  if($slug!=="") {
      $db = new Model('content');
      $slug= str_replace(" ","-",sanitize_remove_tags($slug));
      $dbslug = $db->exists(array('slug'=>$slug));
      if ($dbslug == true) {
          $i = 1;
          while ($dbslug == true) {
              $dbslug = $db->exists(array('slug'=>$slug.$i));
              if ($dbslug==false) {
                  return $slug.$i;
              }
              if ($i==$try) {
                  return false;
                  break;
              }
              $i++;
          }
      }
      else{
          return $slug;
      }
  }
  else{
    return false;
  }
}
function ajaxLoad($loadId){
$ajax= "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').css('display', 'block');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').css('display', 'none');
});
});
</script>";
echo $ajax;
}
function ajaxLoadModal($loadId){
$ajax= "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').modal('show');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').modal('hide');
});
});
</script>";
echo $ajax;
}
function ajaxActive($qry){
$ajax= "<script>
$(document).ready(function() {
  $('{$qry}').css({'visibility':'hidden'});
  $(document).ajaxStart(function(){
  $('{$qry}').css({'visibility':'visible'});
});
$(document).ajaxComplete(function(){
  $('{$qry}').css({'visibility':'hidden'});
});
});
</script>";
echo $ajax;
}
function removeSpace($str)
{
$str = str_replace(" ","_",sanitize_remove_tags($str));
$str = str_replace("/","_",$str);
$str = str_replace("\\","_",$str);
$str = str_replace("&","_",$str);
$str = str_replace(";","",$str);
$str = str_replace(";","",$str);
$str = strtolower($str);
return $str;
}
function filter_name($file_with_ext="")
{
$only_file_name = pathinfo($file_with_ext, PATHINFO_FILENAME);
$only_file_name =  sanitize_remove_tags(str_ireplace(" ","_",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace("(","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace(")","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace("'","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace("\"","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace("&","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace(";","",$only_file_name));
$only_file_name =  sanitize_remove_tags(str_ireplace("#","",$only_file_name));
return $only_file_name;
}
function getAccessLevel()
{
if (isset($_SESSION['user_id'])) {
  $db = new Dbobjects();
  $db->tableName = "pk_user";
  $qry['id'] = $_SESSION['user_id'];
  $db->insertData = $qry;
  if (count($db->filter($qry)) != 0) {
     return $db->pk($_SESSION['user_id'])['access_level'];
  }
    else{
      false;
  }
}
  else{
      false;
  }
}
function updateMyProfile()
{
if (isset($_SESSION['user_id'])) {
  $db = new Mydb('pk_user');
  if (isset($_POST['update_profile_by_admin'])) {
    $qry['id'] = $_POST['update_profile_by_admin'];
  }
  else{
    $qry['id'] = $_SESSION['user_id'];
  }
  if (isset($_POST['password']) && ($_POST['password']!="")) {
    $qry['password'] = md5($_POST['password']);
  }

  
  if (count($db->filterData($qry)) > 0) {
    if (isset($_POST['update_my_profile'])) {
      $upqry['name'] = sanitize_remove_tags($_POST['my_name']);
      $upqry['mobile'] = sanitize_remove_tags($_POST['my_mobile']);
      $upqry['updated_at'] = date('y-m-d h:m:s');
      $db->updateData($upqry);
    }
     
  }
    else{
      false;
  }
}
  else{
      false;
  }
}

function getTableRowById($tablename,$id)
{
  $db = new Mydb($tablename);
  $qry['id'] =$id;
  if (count($db->filterData($qry)) > 0) {
     return $db->pkData($id);
  }
  else{
      false;
  }
}
function check_slug_globally($slug=null)
{
$count = 0;
$var = ['categories','content'];
  for ($i=0; $i < count($var); $i++) { 
      $db = new Dbobjects();
      $db->tableName = $var[$i];
      $qry['slug'] = $slug;
      $count += count($db->filter($qry));
  }
  return $count;
}

function all_books($ord="DESC",$limit=100,$post_cat="",$catid="")
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'book';
  if ($post_cat!="") {
    $arr['post_category'] = $post_cat;
  }
  if ($catid!="") {
    $arr['parent_id'] = $catid;
  }
  $novels = $novelobj->filter_index($arr,$ord,$limit);
  if($novels==false){
        $novels = array();
  }
  return $novels;
}
function all_cats()
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'listing_category';
  $novels = $novelobj->filter_index($arr);
  if($novels==false){
        $novels = array();
  }
  return $novels;
}
function js_alert($msg="")
{
  return "<script>alert('{$msg}');</script>";
}
function swt_alert_suc($msg = "")
{
    return "<script>Swal.fire({
        text: '$msg',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(function() {
        location.reload();
    });</script>";
}
function swt_alert_err($msg="")
{
  return "<script>Swal.fire({
    text: '$msg',
    icon: 'error',
    confirmButtonText: 'OK'
  })</script>";
}


function js($msg="")
{
  return "<script>{$msg}</script>";
}
function matchData($var1="null",$var2="null",$print="Pradeep Karn")
{
  if($var1 == $var2){ echo $print; }
}
function views($post_category='general',$cont_type='post')
{
$views = array();
  $db = new Mydb('content');
  $data = $db->filterData(['post_category'=>$post_category,'content_type'=>$cont_type]);
  foreach ($data as $key => $value) {
    $views[] = $value['views'];
  }
  $views = array_sum($views);
  return $views;
}
function pk_excerpt($string=null,$limit=50,$strip_tags=true)
{
if ($strip_tags===true) {
  $string = strip_tags($string);
}
if (strlen($string) > $limit) {
    // truncate string
    $stringCut = substr($string, 0, $limit);
    $endPoint = strrpos($stringCut, ' ');
    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string = $string."...";
}
return $string;
}
function filterUnique($table,$col,$ord="DESC")
{
    $db = new Mydb($table);
    if(count($db->filterDistinct($col))>0){
      return $db->filterDistinct($col,$ord,100000);
    }
    else{
      return false;
    }
}
//categories start
function create_category(){

global $conn;
$parent_id= legal_input($_POST['parent_id']);
$category_name= legal_input($_POST['category_name']);
$catdb = new Model('content');
$arr['title'] = $category_name;
$arr['parent_id'] = $parent_id;
$new_cat_id = $catdb->store($arr);
// $query=$conn->prepare("INSERT INTO categories (parent_id, category_name) VALUES (?,?)");
// $query->bind_param('is',$parent_id,$category_name);
// $exec= $query->execute();
if($new_cat_id!=false){
  return $new_cat_id;
}else{
  return false;
}
}

function multilevel_categories($parent_id=0,$radio=true,$category_group="listing_category"){
$catdb = new Model('content');
$exec = $catdb->filter_index(array('parent_id'=>$parent_id,'content_group'=>$category_group));
$catData=[];
if($exec!=false){
foreach ($exec as $key => $row) 
{
  $catData[]=[
    'id'=>$row['id'],
    'parent_id'=>$row['parent_id'],
    'category_name'=>$row['title'],
    'nested_categories'=>multilevel_categories($row['id'],$radio,$category_group),
    'radio'=>$radio
  ];  
}

return $catData;
  
}else{
return $catData=[];
}
}

function display_list($nested_categories)
{
$rd = null;
$home = home;
$list = '<ul class="list-none">';
foreach($nested_categories as $nested){
if ($nested['radio']==true) {
    $rd = '<input type="radio" name="parent_id" value='.$nested['id'].'> ';
}
$list .= '<li>'.$rd."<a href='/{$home}/admin/categories/edit/{$nested['id']}' class='text-deco-none'>".$nested['category_name'].'</a></li>';
if( ! empty($nested['nested_categories'])){
$list .= display_list($nested['nested_categories']);
}
}
$list .= '</ul>';
return $list;
}

function display_option($nested_categories,$mark=' ')
{
$option = null;
foreach($nested_categories as $nested){

$option .= '<option value="'.$nested['id'].'">'.$mark.$nested['category_name'].'</option>';

if( ! empty($nested['nested_categories'])){
$option .= display_option($nested['nested_categories'],$mark.'-');
}
} 
return $option;
}
function getData($table,$id)
{
return (new Model($table))->show($id);
}
// convert illegal input to legal input
function legal_input($value) {
$value = trim($value);
$value = stripslashes($value);
$value = htmlspecialchars($value);
return $value;
}
function getCatTree($parent_id){
$db = new Model('content');
$listings = $db->filter_index(array('content_group'=>'listing_category','parent_id'=>$parent_id),$ord="DESC",$limit="1000",$change_order_by_col="");
if ($listings==false) {
  $listings = array();
}
$listing_data = array();
foreach ($listings as $key => $uv) {           
        $listing_data[] = array(
            'id'=>$uv['id'],
            'title'=>$uv['title'],
            'info'=>$uv['content_info'],
            'description'=>$uv['content'],
            'image' => "/media/images/pages/".$uv['banner'],
            'category' => ($uv['parent_id']==0)?'Main':getData('content',$uv['parent_id'])['title'],
            'status' => $uv['status'],
            'child'=>getCatTree($uv['id'])
        );
    }
    return $listing_data;
}
//cart count
$GLOBALS['cart_cnt'] = 0;
// if (authenticate()===true) {
//    $cartObj = new Model('my_order');
//    $mycart = $cartObj->filter_index(array('user_id'=>$_SESSION['user_id'],'status'=>'cart'));
//    if ($mycart==false) {
//     $mycart = array();
//    }
//    $GLOBALS['cart_cnt'] = count($mycart);
// }

if(isset($_SESSION['cart'])){
$GLOBALS['cart_cnt'] = count($_SESSION['cart']);
}
function change_my_banner($contentid,$banner,$banner_name="img")
{
  if (isset($banner)) {
      $file = $banner;
      $media_folder = "images/pages";
      $imgname = $banner_name;
      $media = new Media();
      $page = new Dbobjects();
      $page->tableName = 'content';
      $pobj = $page->pk($contentid);
      $target_dir = RPATH."/media/images/pages/";
      if($pobj['banner']!=""){
          if(file_exists($target_dir.$pobj['banner'])){
              unlink($target_dir.$pobj['banner']);
              $_SESSION['msg'][] = "Old image was replaced";
          }
      }
      $file_ext = explode(".",$file["name"]);
      $ext = end($file_ext);
      $page->insertData['banner'] = $imgname.".".$ext;
      $page->update();
      $media->upload_media($file,$media_folder,$imgname,$file['type']);
   
  }
}

function user_data_by_token($token,$col='email')
{
    $user = new Model('pk_user');
    $arr['app_login_token'] = $token;
    $user = $user->filter_index($arr);
    if (!count($user)>0) {
        return false;
    }else{
        return $user[0][$col];
    }
}

function nested_array_unique($nested_array) {
  $flattened = array_map('serialize', $nested_array);
  $flattened = array_unique($flattened);
  return array_map('unserialize', $flattened);
}

function num_to_words($number){
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
//  echo $result . "Rupees  " . $points . " Paise";
  return $result;
	
}


function msg_ssn($var = 'msg', $return = false)
{
  if (isset($_SESSION[$var])) {
    if ($return == true) {
      $returnmsg = null;
      foreach ($_SESSION[$var] as $msg) {
        $returnmsg .= "{$msg}\\n";
      }
      unset($_SESSION[$var]);
      return $returnmsg;
    }
    foreach ($_SESSION[$var] as $msg) {
      echo "{$msg}<br>";
    }
    unset($_SESSION[$var]);
  }
}
function usersignup(){
  if(isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['cnf_password'])){
    
    $email = generate_dummy_email($_POST['mobile']);
    if (isset($_POST['email'])) {
        $email = sanitize_remove_tags($_POST['email']);
    }
    
    $password = sanitize_remove_tags($_POST['password']);
    $cnf_password = sanitize_remove_tags($_POST['cnf_password']);

    
    $arr['email'] = $email;
    $arr['password'] = md5($password);
    //name
    if (isset($_POST['name'])) {
        if(strlen(sanitize_remove_tags($_POST['name']))<2){
            $_SESSION['msg'][] = "Invalid name";
            return;
        }
        $arr['name'] = sanitize_remove_tags($_POST['name']);
    }
    if (isset($_POST['ref'])) {
      if(filter_var($_POST['ref'],FILTER_VALIDATE_INT)==false){
          $_SESSION['msg'][] = "Invalid refrence";
          return;
      }
      if (getData("pk_user",$_POST['ref'])==false) {
          $_SESSION['msg'][] = "Invalid refrence";
          return;
      }
      $arr['ref'] = sanitize_remove_tags($_POST['ref']);
  }
    if (isset($_POST['company_name'])) {
        if(strlen(sanitize_remove_tags($_POST['company_name']))<2){
            $_SESSION['msg'][] = "Invalid Company name";
            return;
        }
        $arr['company_name'] = sanitize_remove_tags($_POST['company_name']);
    }
    if (isset($_POST['city'])) {
        if(strlen(sanitize_remove_tags($_POST['city']))<2){
            $_SESSION['msg'][] = "Invalid city name";
            return;
        }
        $arr['city'] = sanitize_remove_tags($_POST['city']);
    }
    if (isset($_POST['address'])) {
        if(strlen(sanitize_remove_tags($_POST['address']))<2){
            $_SESSION['msg'][] = "Invalid Address";
            return;
        }
        $arr['address'] = sanitize_remove_tags($_POST['address']);
    }
         //email
    if(filter_var($email,FILTER_VALIDATE_EMAIL)==false){
        $_SESSION['msg'][] = "Invalid Email, please try with correct email";
        return;
    }
    //check regtered email
    $user_by_email = (new Model('pk_user'))->exists(['email'=>$email]);
    if ($user_by_email!=false) {
        $_SESSION['msg'][] = "User Email is already registered, please try again";
        return;
    }
        //mobile
        if (isset($_POST['mobile'])) {
        if(filter_var($_POST['mobile'],FILTER_VALIDATE_INT)==false){
            $_SESSION['msg'][] = "Invalid mobile";
            return;
        }
        $user_by_mobile = (new Model('pk_user'))->exists(['mobile'=>$_POST['mobile']]);
        if ($user_by_mobile!=false) {
            $_SESSION['msg'][] = "Mobile number is already registered";
            return;
        }
        $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
        }
        //national id number
        if (isset($_POST['national_id'])) {
            if($_POST['national_id']==""){
                $_SESSION['msg'][] = "Empty National Id Number";
                return;
            }
            $user_by_national_id = (new Model('pk_user'))->exists(['national_id'=>$_POST['national_id']]);
            if ($user_by_national_id!=false) {
                $_SESSION['msg'][] = "Your National Id is already regsitered";
                return;
            }
        $arr['national_id'] = sanitize_remove_tags($_POST['national_id']);
        }
        //username
    
    if (isset($_POST['username'])) {
        $username = str_replace(" ","",sanitize_remove_tags($_POST['username']));
        $arr['username'] = $username;
        if ((strlen($username)<3) || (strlen($username)>16)) {
            $_SESSION['msg'][] = "Username must be between 3 to 16 characters";
            return;
        }
        //check regtered username
        $user_by_username = (new Model('pk_user'))->exists(['username'=>$username]);
        if ($user_by_username!=false) {
          $_SESSION['msg'][] = "Username is not available";
            return;
        }
    }
    else{
       $arr['username'] = generate_username_by_email($email,$try=500);
    }
    
   
    //empty pass
    if (($_POST['password'])=="") {
         $_SESSION['msg'][] = "Empty password is not allowed";
        return;
    }
    //valid pass
    if (($password!=$_POST['password'])) {
         $_SESSION['msg'][] = "Invalid characters used in password";
        return;
    }
    //pass match
    if ($password!=$cnf_password) {
         $_SESSION['msg'][] = "Password did not match";
        return;
    }
        //if evrything valid then
        $dbcreate = new Model('pk_user');
        $arr['user_group'] = 'customer';
        $userid = $dbcreate->store($arr);
        if ($userid==false) {
             $_SESSION['msg'][] = "User not created";
            return;
        }
        if ($userid==0) {
             $_SESSION['msg'][] = "User not created";
            return;
        }
          login();
         $_SESSION['msg'][] = "User created successfully";
        return;
    }
    else{
         $_SESSION['msg'][] = "Missing required field";
        return;
    }
}

function go_to($link="")
{
    $home = home;
    $var = <<<RED
            <script>
                location.href="/$home/$link";
            </script>
            RED;
    return $var;
}


function updatePage()
{
    if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $cat = $db->pk($_POST['page_id']);
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = $_POST['page_content'];
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['page_content_category'])) {
            $db->insertData['category'] = sanitize_remove_tags($_POST['page_content_category']);
        }
        $db->insertData['status'] = $_POST['page_status'];
        // $db->insertData['content_type'] = $_POST['page_content_type'];
        
        // $db->insertData['banner'] = $_POST['page_banner'];
        // $db->insertData['post_category'] = $_POST['post_category'];
        if (isset($_POST['price'])) {
            $db->insertData['price'] = sanitize_remove_tags($_POST['price']);
        }
        // if (isset($_POST['price_bulk_qty']) && isset($_POST['bulk_qty']) && isset($_POST['discount_amt'])) {
        //     $blk_price = sanitize_remove_tags($_POST['price_bulk_qty']);
        //     $blk_qty = sanitize_remove_tags($_POST['bulk_qty']);
        //     $blk_dic = sanitize_remove_tags($_POST['discount_amt']);
        //     $price = $blk_price/$blk_qty;
        //     $dic = $blk_dic/$blk_qty;
        //     $db->insertData['price'] = $price;
        //     $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
        //     $db->insertData['discount_amt'] = $dic;
        // }else{
        //     $db->insertData['price'] = 1;
        //     $db->insertData['bulk_qty'] = 1;
        //     $db->insertData['discount_amt'] = 0;
        // }
        // if (isset($_POST['discount_amt'])) {
        //     $db->insertData['discount_amt'] = sanitize_remove_tags($_POST['discount_amt']);
        // }
        if (isset($_POST['qty'])) {
            $db->insertData['qty'] = sanitize_remove_tags($_POST['qty']);
        }
        // if (isset($_POST['bulk_qty'])) {
        //     $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
        //     if ($_POST['bulk_qty']==0 || $_POST['bulk_qty']==null) {
        //         $db->insertData['bulk_qty'] = 1;
        //     }
        // }else{
        //     $db->insertData['bulk_qty'] = 1;
        // }
        if (isset($_POST['brand'])) {
            $db->insertData['brand'] = sanitize_remove_tags($_POST['brand']);
        }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = sanitize_remove_tags($_POST['tax']);
        }
        // if (isset($_POST['color'])) {
        //     $color = sanitize_remove_tags($_POST['color']);
        //     $db->insertData['color'] =  $color;
        //     if ($color!="") {
        //         updateColorList($id=$cat['id'], $color=sanitize_remove_tags($_POST['color']));
        //     }
        // }
        if (isset($_POST['related_product_id'])) {
            $db->insertData['json_obj'] = json_encode(array('related_products'=>$_POST['related_product_id']));
        }else{
            $db->insertData['json_obj'] = json_encode(array('related_products'=>array()));
        }
        if (isset($_POST['grouped_content'])) {
            $db->insertData['grouped_content'] = $_POST['grouped_content'];
        }
        $db->insertData['content_info'] = $_POST['page_content_info'];
        $db->insertData['update_date'] = date("Y-m-d h:i:sa", time());
        $author = new Mydb('pk_user');
        // $auth_user = $author->pkData($_SESSION['user_id'])['id'];
        // $db->insertData['created_by'] = $auth_user;
        // $db->insertData['author'] = $_POST['page_author'];;
        if (isset($_POST['page_show_title']) && $_POST['page_show_title']==="on") {
            $db->insertData['show_title'] = 1;
        }
        else{
            $db->insertData['show_title'] = 0;
        }
        if (check_slug_globally($_POST['slug'])==0) {
            $db->insertData['slug'] = $_POST['slug'];
        }
        if(isset($_FILES['banner'])){
          $fl = (object)($_FILES['banner']);
          if ($fl->error==0 && $fl->name!="") {
            $tmp_img = $fl->tmp_name;
            $clean_filename = uniqid('banner_').preg_replace('/[^a-zA-Z0-9\-_.]/', '', str_replace(' ', '-', $fl->name));
            $dir = MEDIA_ROOT."/images/pages/".$clean_filename;
            $oldpath = MEDIA_ROOT."/images/pages/".$cat['banner'];
            $uploadreply = move_uploaded_file($tmp_img,$dir);
            if($uploadreply==true){
              if ($cat['banner']!="" && file_exists($oldpath)) {
                unlink($oldpath);
            }
            $db->insertData['banner'] = $clean_filename;
            }
          }
         }
        if(isset($_POST['banner_base64']) && $_POST['banner_base64']!=""){
            $name = uniqid('banner_').time();
            $imgname = upload_base64($_POST['banner_base64'],RPATH.'/media/images/pages/',$name);
            $oldpath = RPATH.'/media/images/pages/'.$cat['banner'];
            if ($cat['banner']!="" && file_exists($oldpath)) {
                unlink($oldpath);
            }
            $db->insertData['banner'] = $imgname;
        }
        return $db->updateTransaction();
    }
}

function updateCategory(){

  if (isset($_POST['food_cat_id'])) {
    $db = new Dbobjects();
    $db->tableName = "content";
    $cat = $db->pk($_POST['food_cat_id']);
    $db->insertData['title'] = $_POST['food_title'];

    $db->insertData['content_info'] = $_POST['food_description'];

    if (check_slug_globally($_POST['food_slug'])==0) {
      $db->insertData['slug'] = $_POST['food_slug'];
  }
   if(isset($_FILES['banner'])){
    $fl = (object)($_FILES['banner']);
    if ($fl->error==0 && $fl->name!="") {
      $tmp_img = $fl->tmp_name;
      $clean_filename = uniqid('banner_').preg_replace('/[^a-zA-Z0-9\-_.]/', '', str_replace(' ', '-', $fl->name));
      $dir = MEDIA_ROOT."/images/pages/".$clean_filename;
      $oldpath = MEDIA_ROOT."/images/pages/".$cat['banner'];
      $uploadreply = move_uploaded_file($tmp_img,$dir);
      if($uploadreply==true){
        if ($cat['banner']!="" && file_exists($oldpath)) {
          unlink($oldpath);
      }
      $db->insertData['banner'] = $clean_filename;
      }
    }
   }
  if(isset($_POST['banner_base64']) && $_POST['banner_base64']!=""){
      $name = uniqid('banner_').time();
      $imgname = upload_base64($_POST['banner_base64'],RPATH.'/media/images/pages/',$name);
      $oldpath = RPATH.'/media/images/pages/'.$cat['banner'];
      if ($cat['banner']!="" && file_exists($oldpath)) {
          unlink($oldpath);
      }
      $db->insertData['banner'] = $imgname;
  }
  return $db->update();
  }
}

function addContent($type="product")
{
    if (isset($_POST['add_new_content'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = 'Write your content here';
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['status'])) {
            $db->insertData['status'] = $_POST['status'];
        }else{
            $db->insertData['status'] = 'draft';
        }
        // if (isset($_POST['price'])) {
        //     $db->insertData['price'] = sanitize_remove_tags($_POST['price']);
        // }
        if (isset($_POST['price_bulk_qty']) && isset($_POST['bulk_qty']) && isset($_POST['discount_amt'])) {
            $blk_price = sanitize_remove_tags($_POST['price_bulk_qty']);
            $blk_qty = sanitize_remove_tags($_POST['bulk_qty']);
            $blk_dic = sanitize_remove_tags($_POST['discount_amt']);
            $price = $blk_price/$blk_qty;
            $dic = $blk_dic/$blk_qty;
            $db->insertData['price'] = $price;
            $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
            $db->insertData['discount_amt'] = $dic;
        }else{
            $db->insertData['price'] = 1;
            $db->insertData['bulk_qty'] = 1;
            $db->insertData['discount_amt'] = 0;
        }
        // if (isset($_POST['discount_amt'])) {
        //     $db->insertData['discount_amt'] = sanitize_remove_tags($_POST['discount_amt']);
        // }
        if (isset($_POST['qty'])) {
            $db->insertData['qty'] = sanitize_remove_tags($_POST['qty']);
        }
        // if (isset($_POST['bulk_qty'])) {
        //     $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
        //     if ($_POST['bulk_qty']==0 || $_POST['bulk_qty']==null) {
        //         $db->insertData['bulk_qty'] = 1;
        //     }
        // }else{
        //     $db->insertData['bulk_qty'] = 1;
        // }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = sanitize_remove_tags($_POST['tax']);
        }
        if (isset($_POST['brand'])) {
            $db->insertData['brand'] = sanitize_remove_tags($_POST['brand']);
        }
        if (isset($_POST['color'])) {
            $db->insertData['color_list'] = json_encode([$_POST['color']]);
            if ($_POST['color']=="") {
                $db->insertData['color_list'] = json_encode(['white']);
            }
        }
        if (isset($_POST['grouped_content'])) {
            $db->insertData['grouped_content'] = $_POST['grouped_content'];
        }
        if (isset($_POST['related_product_id'])) {
            $db->insertData['json_obj'] = json_encode(array('related_products'=>$_POST['related_product_id']));
        }
        else{
            $db->insertData['json_obj'] = json_encode(array('related_products'=>array()));
        }
        $db->insertData['slug'] = $_POST['slug'];
        $db->insertData['content_group'] = $type;
        $db->insertData['content_type'] = "product";
        $db->insertData['created_by'] = $_SESSION['user_id'];
        $slug = generate_slug($_POST['slug']);
        if (check_slug_globally($slug)==0) {
            $db->insertData['slug'] = $slug;
            return $db->create();
        }
        else{
            $_SESSION['msg'][] = "Please change slug";
            return false;
        }
    }
}

function cart_items($user_id)
{
  $obj = new Model('customer_order');
  $item = $obj->filter_index(array('status' => 'cart', 'user_id' => $user_id));
  return count($item);
}

function upload_base64($base64string='',$uploadpath = RPATH.'/media/images/pages/',$name="bnr") {
  $uploadpath   = $uploadpath;
  $parts        = explode(";base64,", $base64string);
  $imageparts   = explode("image/", @$parts[0]);
  $imagetype    = $imageparts[1];
  $imagebase64  = base64_decode($parts[1]);
  $file         = $uploadpath . $name . '.png';
  file_put_contents($file, $imagebase64);
  return $name.".png";
}
function uploadBanner($banner_name)
{
  if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
      $file = $_FILES['banner'];
      $media_folder = "images/pages";
      $imgname = $banner_name;
      $media = new Media();
      $page = new Dbobjects();
      $page->tableName = 'content';
      $page->pk($_POST['update_banner_page_id']);
      $file_ext = explode(".",$file["name"]);
      $ext = end($file_ext);
      $page->insertData['banner'] = $imgname.".".$ext;
      $page->update();
      $media->upload_media($file,$media_folder,$imgname,$file['type']);
  }
}
function obj($arr)
{
  return (object) $arr;
}
function arr($obj)
{
  return (array) $obj;
}

function add_to_cart($id,$action="add_to_cart")
{
    $live_stock = check_stock_minus_hold($id);
    // echo js_alert($live_stock);
    //$_SESSION['cart'] = null;
    if (isset($_SESSION['cart'][$id])) {
        if ($action=='buy_now') {
            return;
        }
        else{
            if ($live_stock>=1) {
                $_SESSION['cart'][$id]['id'] = $id;
                $_SESSION['cart'][$id]['qty'] += 1;
                return true;
            }
            else{
                return false;
            }
            
        }
        
    }
    else{
        if ($live_stock>=1) {
            $_SESSION['cart'][$id]['id'] = $id;
            $_SESSION['cart'][$id]['qty'] = 1;
            return true;
        }
        else{
            return false;
        }
        
    }
}
function remove_from_cart($id){
  if (isset($_SESSION['cart'][$id])) {
      if ($_SESSION['cart'][$id]['qty']>1) {
          $_SESSION['cart'][$id]['id'] = $id;
          $_SESSION['cart'][$id]['qty'] -= 1;
      }
      else{
          unset($_SESSION['cart'][$id]);
      }
  }
  if (count($_SESSION['cart'])==0) {
      unset($_SESSION['cart']);
  }
}
function check_stock_minus_hold($prodid){
  $item = new Mydb('content');
  $prod = $item->pkData($prodid);
  $old_hold_obj = (new Model('customer_order'))->filter_index(array('item_id'=>$prod['id'],'status'=>'hold'));
  $old_hold_db_qty = 0;
  if ($old_hold_obj!=false) {
      foreach ($old_hold_obj as $key => $hldqty) {
      $hldqtyar[] = $hldqty['qty'];
      }
      $old_hold_db_qty = array_sum($hldqtyar);
  }
  else{
      $old_hold_db_qty = 0;
  }
  $prod_qty_minus_hold_qty = $prod['qty'] - $old_hold_db_qty;
  return $prod_qty_minus_hold_qty;
}
function remove_from_cart_api($id){
    if (isset($_SESSION['cart'][$id])) {
        if ($_SESSION['cart'][$id]['qty']>1) {
            $_SESSION['cart'][$id]['id'] = $id;
            $_SESSION['cart'][$id]['qty'] -= 1;
        }
        else{
            unset($_SESSION['cart'][$id]);
        }
    }
    if (count($_SESSION['cart'])==0) {
        unset($_SESSION['cart']);
    }
}
function check_stock_api($prodid){
    $item = new Model('content');
    $prod = $item->show($prodid);
    // $old_hold_obj = (new Model('customer_order'))->filter_index(array('item_id'=>$prod['id'],'status'=>'hold'));
    // $old_hold_db_qty = 0;
    // if ($old_hold_obj!=false) {
    //     foreach ($old_hold_obj as $key => $hldqty) {
    //     $hldqtyar[] = $hldqty['qty'];
    //     }
    //     $old_hold_db_qty = array_sum($hldqtyar);
    // }
    // else{
    //     $old_hold_db_qty = 0;
    // }
    // $prod_qty_minus_hold_qty = $prod['qty'] - $old_hold_db_qty;
    $prod_qty = $prod['qty'];
    return $prod_qty;
}







function save_cart_to_db_api($customer_email, $cart_arr)
{
    if (isset($cart_arr)) {
        $lastid = array();
        foreach (array_keys($cart_arr) as $key => $pid) {
            $id =  $cart_arr[$pid]['id'];
            $qty = $cart_arr[$pid]['qty'];
            $db = new Model('content');
            $prod = $db->show($id);
            if ($prod != false) {
                $cartObj = new Model('customer_order');
                $store_ary['item_id'] = $prod['id'];
                $store_ary['status'] = 'cart';
                $store_ary['customer_email'] = $customer_email;
                //check item in cart
                $if_exists = $cartObj->filter_index($store_ary);
                
                $store_ary['price'] = $_POST['price']; //vat implemented 28-02-2023
                
                if ($if_exists == false) {
                    $store_ary['qty'] = $qty;
                    $lastid[] = $cartObj->store($store_ary);
                } else if (count($if_exists) > 0) {
                    $update_ary['qty'] = $qty + $if_exists[0]['qty'];
                    // $update_ary['qty'] = $qty;


                    
                    $cartObj->update($if_exists[0]['id'], $update_ary);
                    $lastid[] = $if_exists[0]['id'];
                }
                $update_ary = null;
                $store_ary = null;
            }
        }

        $cartObj = new Model('customer_order');
        $get_cart['customer_email'] = $customer_email;
        $get_cart['status'] = 'cart';
        $get_cart_arr = $cartObj->filter_index($get_cart);
        $resp = array();
        foreach ($get_cart_arr as $key => $cv) {
            $resp[] = array(
                "id" => $cv['id'],
                "payment_id" => $cv['payment_id'],
                "item_id" => $cv['item_id'],
                "qty" => $cv['qty'],
                "price" => $cv['price'],
                "status" => $cv['status'],
                "customer_email" => $cv['customer_email'],
                "shipping_status" => $cv['shipping_status'],
                "shipping_id" => $cv['shipping_id'],
                "remark" => $cv['remark'],
                "is_paid" => $cv['is_paid'],
            );
        }
        return $resp;
    } else {
        return false;
    }
}

function return_user_data_trans($id,$db) {
  $ru = new stdClass;
  $db->tableName = 'pk_user';
  $user = $db->pk($id);
  $u = obj($user);
  $ru->id = $u->id;
  $ru->first_name = $u->first_name;
  $ru->last_name = $u->last_name;
  $ru->mobile = intval($u->mobile);
  $ru->email = $u->email;
  $ru->gender = $u->gender;
  $ru->dob = $u->dob;
  $ru->image = ($u->image!='') ? '/media/images/profiles/'.$u->image : null;
  $ru->token = $u->app_login_token;
  return $ru;
}
function generate_username_by_email_trans($email, $try = 100, $db = null)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
    if ($db == null) {
      $db = new Dbobjects;
    }
    $db->tableName = 'pk_user';
    $arr['email'] = sanitize_remove_tags($email);
    $emailarr = explode("@", $arr['email']);
    $username = $emailarr[0];
    $dbusername = $db->filter(array('username' => $username));
    if (count($dbusername) > 0) {
      $i = 1;
      while (count($dbusername) > 0) {
        $dbusername = $db->filter(array('username' => $username . $i));
        if (count($dbusername) > 0) {
          return $username . $i;
        }
        if ($i == $try) {
          break;
        }
        $i++;
      }
    } else {
      return $username;
    }
  } else {
    return false;
  }
}
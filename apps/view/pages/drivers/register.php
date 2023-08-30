<?php
import("apps/view/inc/header.php");
?>


<div class="container-fluid">
  <div class="row">
    <div class="col-6 text-center">
      <div class="rg_box">
        <a href="/<?php echo home; ?>"><img src="/<?php echo STATIC_URL ?>/view/assets/img/logo1copy.png" class="img-fluid" width="250px" height="45px" alt="" srcset=""></a>
        <div class="bd_1 mt-3 mb-4"></div>
        <h5>Register with us as a delivery partner </h5>
        <div class="text-center">
          <i style="font-size: 60px;" class="bi bi-truck"></i>
        </div>
        <form id="user_sign_form" action="/<?php echo home; ?>/driver-register-ajax" method="POST">
          <div class="row mt-4">
            <div class="col-md-12 mb-3">
              <label for="profimg">Profile Image</label>
              <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="profimg" name="profile_img">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="validationDefault01" name="first_name" placeholder="First Name">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="validationDefault02" name="last_name" placeholder="Last Name">
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" class="form-control" id="validationDefault03" name="email" placeholder="Email">
            </div>
            <div class="col-md-6 mb-3">
              <input type="number" class="form-control" id="validationDefault04" name="mobile" placeholder="Phone Number">
            </div>
            <div class="col-md-6 mb-3">
              <input type="password" class="form-control" id="validationDefault05" name="password" placeholder="Password">
            </div>
            <div class="col-md-6 mb-3">
              <input type="password" class="form-control" id="validationDefault06" name="cnf_password" placeholder="Confirm Password">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="validationDefault08" name="national_id" placeholder="National Id Number">
            </div>
            <div class="col-md-6 mb-3">
              <input accept="application/pdf" type="file" class="form-control" id="validationDefault08" name="national_id_doc">
            </div>

            <div id="res"></div>
            <div class="col-md-12 mt-4">
              <button id="mysignup_btn" class="rg_btn">Register Now!</button>
            </div>
            <div class="text-center mt-2 smt_txt">
              <small>Already have an acccount? <strong><a href="">Sign In</a></strong></small>
            </div>
            <div class="copy pt-2" style="color: #999;">© 2023 Deal City</div>
          </div>
        </form>
        <?php pkAjax_form("#mysignup_btn", "#user_sign_form", "#res", 'click');
        ajaxActive(".spinner-border");
        ?>
      </div>
    </div>
    <div class="col-6 rg_right pe-0">
      <img src="/<?php echo STATIC_URL ?>/view/assets/img/register-page-bg.jpg" class="img-fluid" width="100%" alt="" srcset="">
    </div>
  </div>
</div>


<?php
import("apps/view/inc/footer.php");
?>
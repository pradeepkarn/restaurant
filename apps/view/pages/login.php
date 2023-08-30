<?php
import("apps/view/inc/header.php");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4 text-center">
            <div class="rg_box">
                <a href="/<?php echo home; ?>"><img src="/<?php echo STATIC_URL ?>/view/assets/img/logo1copy.png" class="img-fluid" width="250px" height="45px" alt="" srcset=""></a>
                <div class="bd_1 mt-3 mb-4"></div>
                <h5>Login With Deal City</h5>
                <form id="user_login_form" action="/<?php echo home; ?>/login-ajax" method="POST">
                <div class="row mt-4">
                    <div class="col-md-12 mb-3">
                      <input type="email" class="form-control" id="validationDefault03" name="email" placeholder="Email">
                    </div>
                    <div class="col-md-12 mb-3">
                      <input type="password" class="form-control" id="validationDefault05" name="password" placeholder="Password">
                    </div>
                    <div id="result"></div>
                    <div class="col-md-12 mt-4">
                      <button name="login_btn" id="mylogin_btn" class="rg_btn">Login</button>
                    </div>
                    <div class="text-center mt-2 smt_txt">
                        <small>Don't have an acccount? <strong><a href="">Sign Up</a></strong></small>
                    </div>
                    <div class="copy pt-2" style="color: #999;">© 2023 Deal City</div>
                </div>
                </form>
            </div>
        </div>
        <?php pkAjax_form("#mylogin_btn","#user_login_form","#result"); ?>
        <div class="col-8 rg_right pe-0">
            <img src="/<?php echo STATIC_URL ?>/view/assets/img/register-page-bg.jpg" class="img-fluid" width="100%" alt="" srcset="">
        </div>
    </div>
</div>


<?php
import("apps/view/inc/footer.php");
?>
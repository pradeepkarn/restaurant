<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>My Restaurants</h2>
            <p>Home / <span>My Restaurants</span></p>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <div class="col-12 ps-4 coup_form">
            <div class="row g-3 mb-2">
                <div class="col-12 coupon_cl">
                    <h4 class="m-0">My Restaurants</h4>
                </div>
                <div class="row">
                
                <?php
                        $userObj = new Model('restaurant_listing');
                        $restaurant_list = $userObj->filter_index(array('is_listed' => true, 'user_id' => $_SESSION['user_id']));
                        ?>
                        <?php
                        foreach ($restaurant_list as $rl) {
                            $rl = (object) $rl;
                        ?>
                        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3 mt-3">
        <div class="rest">
            <a href="/<?php echo home . "/create-menu/?rid=" . $rl->id; ?>">
                <div class="dt">
                    <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rl->banner; ?>" class="w-100" alt="" srcset="">
                </div>
                <div class="newbox">
                    <div class="lr">
                        <h4><?php echo $rl->rest_name; ?></h4>
                        <h6>Burgers</h6>
                    </div>
                    <p><i class="bi bi-bicycle"> </i><?php echo $rl->priceforone; ?> | <?php echo $rl->food_time; ?></i></p>
                </div>
            </a>
            </div>
           
        </div>
                            <!-- <option selected value="<?php echo $rl->id; ?>"><?php echo $rl->rest_name; ?></option> -->
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
import("apps/view/inc/footer.php");
?>
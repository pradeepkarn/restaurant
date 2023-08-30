<?php
$home = home;
if (!isset($_GET['rid'])) {
    header("Location: /$home");
    exit;
}
if (!intval($_GET['rid'])) {
    header("Location: /$home");
    exit;
}
$prod = getData('restaurant_listing', $_GET['rid']);
$fid = $_GET['rid'];
$pr = $prod['parent_id'];
if ($prod == false) {
    header("Location: /$home");
    exit;
}

$rn = obj($prod);


?>

<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");
?>


<?php
if (authenticate()) {
    $count = cart_items(USER['id']);
} else {
    $count = 0;
}

?>

<div class="container">
            <div class="row justify-content-center cart_container">
                <div class="col-5">
                <?php if($GLOBALS['cart_cnt']>0){
                    ?>
                    <div class="cart_popup">
                        <p class="mb-0"><?php echo $GLOBALS['cart_cnt']; ?> Item</p>
                        <a href="/<?php echo home; ?>/cart">View Cart <i class="bi bi-bag-check"></i></a>
                    </div>
                    <?php 
                }
                    ?>
                </div>
            </div>
        </div>


<div style="border-top: 2px solid rgb(232, 232, 232);"></div>


<div class="container">
    <div class="row justify-content-center mt-5 mb-4">
        <div class="col-6">
            <a class="example-image-link" href="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" alt="" /></a>
        </div>
        <div class="col-2 p-0">
            <div class="row">
                <div class="col-12 pb-2">
                    <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" alt="" /></a>
                </div>
                <div class="col-12">
                    <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="col-2">
            <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg2.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg2.jpg" alt="" /></a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 pr1">
            <h2><?php echo $rn->rest_name; ?></h2>
            <!-- <p>Burger, Wraps, Fast Food, Desserts, Beverages</p> -->
            <span><?php echo $rn->rest_address; ?></span>
            <div class="opd">
                <p><span>Timings </span>- <?php echo $rn->timings; ?></p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-10">
            <div class="nav_tabs">
            <button class="btn tablinks1" onclick="openProfile(event, 'orderonline')" id="defaultOpen1">Order Online</button>
                <button class="btn tablinks1" onclick="openProfile(event, 'overview')" id="defaultOpen1">Overview</button>
                <button class="btn tablinks1" onclick="openProfile(event, 'photos')" id="defaultOpen1">Photos</button>

                <button class="btn tablinks1" onclick="openProfile(event, 'menu')" id="defaultOpen1">Menu</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div id="overview" class="tabcontent1 mt-4 mb-5">
                <h5 class="pb-3">About this place</h5>
                <h6 class="">Known For</h6>
                <?php 
                        $db = new Mydb('content');
                        $prod = $db->pkData($pr);
                        ?>
                <p><?php echo $prod['title'] ?></p>
                <div class="row">
                    <div class="col-5 rs_list">
                        <div class="globe1">
                            <div class="gb_im1">
                                <img src="/<?php echo STATIC_URL ?>/view/assets/img/kn1.jpg" height="42px" width="42px" alt="" srcset="">
                            </div>
                            <div class="gb-txt1 ps-3">
                                <p>RESTAURANT SAFETY MEASURE</p>
                                <span>Well Sanitized Kitchen</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 rs_list">
                        <div class="globe1">
                            <div class="gb_im1">
                                <img src="/<?php echo STATIC_URL ?>/view/assets/img/kn2.jpg" height="42px" width="42px" alt="" srcset="">
                            </div>
                            <div class="gb-txt1 ps-3">
                                <p>RESTAURANT SAFETY MEASURE</p>
                                <span>Daily Temp. Checks</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <h4>Menu</h4>
                    </div>
                    <?php

$userObj = new Model('menu_listing');
$rid = $_GET['rid'];
//   myprint($rid);
$menu_list = $userObj->filter_index(array('rest_id' => $rid));
foreach ($menu_list as $ml) {
    $ml = (object) $ml;
?>
<div class="col-4">
<img src="/<?php echo MEDIA_URL ?>/images/menu/<?php echo $ml->banner; ?>" class="img-fluid" alt="" srcset="" style="height: 175px !important; object-fit:cover;">
<h5 class="mt-2"><?php echo $ml->menu_name; ?></h5>
</div>
<?php 
}
?>
                </div>

            </div>

        </div>
        <div class="col-3"></div>
    </div>




    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="orderonline" class="tabcontent1 mt-4 mb-5">
                <h4 class="pb-3">Order Online</h4>
                <!-- <div class="row">
                        <div class="col-2 pe-0">
                            <div class="free_dev">
                                <p>Free Delivery</p>
                                <span>on orders above ₹199</span>
                            </div>
                        </div>
                        <div class="col-2 pe-0">
                            <div class="free_dev">
                                <p>Free Veg Surprise</p>
                                <span>on orders above ₹199</span>
                            </div>
                        </div>
                        <div class="col-2 pe-0">
                            <div class="free_dev">
                                <p>Free Delivery</p>
                                <span>exclusively for you</span>
                            </div>
                        </div>
                    </div> -->
                <h4 class=" pt-4 pb-3">Today's Exclusive Dishes</h4>
                <?php

                $userObj = new Model('content');
                $rid = $_GET['rid'];
                //   myprint($rid);
                $restaurant_list = $userObj->filter_index(array('vendor_id' => $rid), $ord = 'DESC', $limit = 3);
                foreach ($restaurant_list as $rl) {
                    $rl = (object) $rl;
                ?>
                    <form id="select-prod-form2<?php echo $rl->id; ?>" action="/<?php echo home; ?>/add-item-ajax" method="POST">
                        <div class="row mt-4 mb-3">
                            <div class="col-xxl-2 col-xl-2 col-lg-12 col-md-12 col-sm-12 mb-3">
                                <img style="width: 130px; height: 130px; object-fit: contain;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rl->banner; ?>" alt="" srcset="">
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-3 onl_or">
                                <a href="/<?php echo home . "/food/?fid=" . $rl->id; ?>">
                                    <h5><?php echo $rl->title ?></h5>
                                </a>
                                <input type="hidden" value="1" scope="any" min="1" name="qty" class="form-control my-2">
                                <input type="hidden" value="<?php echo $rl->id; ?>" name="item_id" class="form-control my-2">
                                <input type="hidden" value="<?php echo $rid; ?>" name="rest_id" class="form-control my-2">
                                <input type="hidden" value="<?php echo $rl->price; ?>" name="price" class="form-control my-2">
                                <!-- <span>Not eligible for coupons</span>
                                <div class="rating_i pt-2 pb-2">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div> -->
                                <span class="pr_ice">₹<?php echo $rl->price; ?></span>
                                <p><?php echo $rl->content; ?></p>
                                <button id="select-prod-btn<?php echo $rl->id; ?>" class="btn btn-warning">Add To Cart</button>
                            </div>
                        </div>
                    </form>
                    <?php pkAjax_form("#select-prod-btn1{$rl->id}", "#select-prod-form2{$rl->id}", "#inv"); ?>

                <?php
                }
                ?>
                <div id="inv"></div>
                <a href="/<?php echo home . "/shop/?rid=" . $rid; ?>" class="btn btn-outline-success">View More</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="photos" class="tabcontent1 mt-4 mb-5">
                <h5 class="pb-3">McDonald's Photos</h5>
                <div class="row">
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m2.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m2.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m3.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m3.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m4.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m4.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m5.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m5.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m6.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m6.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m7.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m7.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m8.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m8.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m9.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m9.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m10.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m10.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m11.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m11.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m12.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m12.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m13.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m13.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m14.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m14.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m15.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m15.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m16.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m16.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m17.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m17.jpg" alt="" /></a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/m18.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/m18.jpg" alt="" /></a>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="menu" class="tabcontent1 mt-4 mb-5">
                <h5 class="pb-3">Menu</h5>
                <div class="row">
                <?php

$userObj = new Model('menu_listing');
$rid = $_GET['rid'];
//   myprint($rid);
$menu_list = $userObj->filter_index(array('rest_id' => $rid));
foreach ($menu_list as $ml) {
    $ml = (object) $ml;
?>
<div class="col-4">
<a class="example-image-link" href="/<?php echo MEDIA_URL ?>/images/menu/<?php echo $ml->banner; ?>" data-lightbox="example-set2" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo MEDIA_URL ?>/images/menu/<?php echo $ml->banner; ?>" style="height: 290px !important; object-fit:cover;" alt="" /></a>
<h5 class="mt-2"><?php echo $ml->menu_name; ?></h5>
</div>
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
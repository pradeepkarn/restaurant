<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid food_banner">
    <div class="container" style="overflow: hidden;">
        <h2 class="pb-4">Inspiration for your first order</h2>
        <div class="row">
            <div #swiperRef="" class="swiper-container mySwiper">
                <div class="swiper-wrapper">
                    <?php

                    $userObj = new Model('content');
                    $food_category = $userObj->filter_index(array('content_group' => 'listing_category'));
                    ?>
                    <?php
                    foreach ($food_category as $fc) {
                        $fc = (object) $fc;
                    ?>
                        <div class="swiper-slide">
                            <div class="content text-center">
                                <a href="/<?php echo home . "/categories/?cid=" . $fc->id; ?>"><img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $fc->banner; ?>" width="150px" height="150px" alt="" srcset=""></a>
                                <div class="box text-center">
                                    <h5 class="pt-3"><?php echo $fc->title; ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
                <!-- Previous and Next buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid free_del">
    <div class="container">
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 pb-2 ship_box">
                <div class="sh_box">
                    <i class="fa-solid fa-truck"></i>
                    <h3>Free Shipping</h3>
                </div>
                <p>Sign up for updates and get free shipping</p>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 pb-2 ship_box">
                <div class="sh_box">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h3>Fast Delivery</h3>
                </div>
                <p>We deliver goods around the world</p>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 pb-2 ship_box">
                <div class="sh_box">
                    <i class="fa-solid fa-burger"></i>
                    <h3>Best Quality</h3>
                </div>
                <p>We are international chain of restaurants.</p>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 pb-2 ship_box">
                <div class="sh_box">
                    <i class="fa-solid fa-store"></i>
                    <h3>Our Store</h3>
                </div>
                <p>You can see our “here and now” products</p>
            </div>
        </div>
    </div>
</div>



<div class="container mt-5 mb-5">
    <h2 class="pb-3">Best Food in Delhi NCR</h2>
    <div class="row">
    <?php
              
              $userObj = new Model('restaurant_listing');
              $restaurant_list = $userObj->filter_index(array('is_listed' => true), $ord='DESC', $limit = 6);
              foreach ($restaurant_list as $rl) {
                $rl = (object) $rl;
                $pr = $rl->parent_id;
              ?>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="rest">
            <a href="/<?php echo home . "/product/?rid=" . $rl->id; ?>">
                <div class="dt">
                    <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rl->banner; ?>" class="w-100" alt="" srcset="">
                </div>
                <div class="newbox">
                    <div class="lr">
                        <h4><?php echo $rl->rest_name; ?></h4>
                        <?php 
                        $db = new Mydb('content');
                        $prod = $db->pkData($pr);
                        ?>
                        <h6><?php echo $prod['title'] ?></h6>
                    </div>
                    <p><i class="bi bi-bicycle"> </i><?php echo $rl->priceforone; ?> | <?php echo $rl->food_time; ?></i></p>
                </div>
            </a>
            </div>
           
        </div>
        <?php 
              }
        ?>
        <div class="col-12 text-center mt-3">
            <a href="/<?php echo home; ?>/all-restaurants" class="btn btn-danger">View More</a>
        </div>
    </div>
</div>


<div class="container-fluid reserve_cl">
    <div class="container">
        <div class="row d-flex align-items-center pt-5 pb-5">
            <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12 book_tb">
                <h3 class="pb-3">Do you have any dinner plan today? Reserve your table</h3>
                <p>Make online reservations, read restaurant reviews from dinners,
                    and earn points towards free meals. OpenTable is a real time
                    online reservation.</p>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 text-center reserve_form">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-xl-10 col-lg-12 col-md-12 col-sm-12 ps-5 pe-5">
                        <div class="form-box">
                            <i class="fa-solid fa-utensils"></i>
                            <h2>Reservation</h2>
                            <h6 class="pb-4">Book Your Table</h6>
                            <div class="mb-3">
                                <select class="form-select" id="validationCustom1" required>
                                    <option selected disabled value="">Choose Restaurant</option>
                                    <option>KFC</option>
                                    <option>Bikkgane Biryani</option>
                                    <option>McDonald's</option>
                                    <option>Domino's Pizza</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="validationCustom1" required>
                                    <option>1 People</option>
                                    <option>2 People</option>
                                    <option>3 People</option>
                                    <option>4 People</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="date" class="form-control" id="validationCustom2" value="Mark">
                            </div>
                            <div class="mb-3">
                                <input type="time" value="00:00" class="form-control" id="validationCustom3">
                            </div>
                            <button class="btn btn-warning mt-3">BOOK A TABLE</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<?php
import("apps/view/inc/footer.php");
?>
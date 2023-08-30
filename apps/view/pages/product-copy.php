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
$prod = getData('restaurant_listing',$_GET['rid']);
$fid = $_GET['rid'];
if ($prod==false) {
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
<div style="border-top: 2px solid rgb(232, 232, 232);"></div>


<div class="container">
    <div class="row justify-content-center mt-5 mb-4">
        <div class="col-6">
            <a class="example-image-link" href="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rn->banner; ?>" alt=""/></a>
        </div>
        <div class="col-2 p-0">
            <div class="row">
                <div class="col-12 pb-2">
                    <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" alt=""/></a>
                </div>
                <div class="col-12">
                    <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg.jpg" alt=""/></a>
                </div>
            </div>
        </div>
        <div class="col-2">
            <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/bg2.jpg" style="width: 100% !important;" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/bg2.jpg" alt=""/></a>
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
                    <button class="btn tablinks1" onclick="openProfile(event, 'overview')" id="defaultOpen1">Overview</button>

                    <button class="btn tablinks1" onclick="openProfile(event, 'orderonline')" id="defaultOpen1">Order Online</button>

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
                    <p>Classic Burgers and Fries</p>
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
    $rid = $_GET['rid'];
    $myordersObj = new Model('menu_listing');
    $cart_list = $myordersObj->filter_index(array('is_listed' => true, 'rest_id' => $rid));
    $menuCounter = 1;

    foreach ($cart_list as $cv) :
        $cv = (object) $cv;
    ?>

    <div class="col-5">
        <div class="menu-container">
            <div class="menu-header"><?php echo $cv->menu_name; ?></div>
            <?php
            // Decode the JSON data in the second list
            $decoded_json = json_decode($cv->jsn, true);
            if ($decoded_json !== null) {
                $userObj = new Model('content');
                foreach ($decoded_json['food'] as $food_id) {
                    // Fetch the name of the item from the "content" table based on the ID
                    $rid = $_GET['rid'];
                    $restaurant_list = $userObj->filter_index(array('vendor_id' => $rid, 'id' => $food_id));
                    if (!empty($restaurant_list)) {
                        $item = $restaurant_list[0];
                        ?>

                        <div class="menu-item">
                            <div class="item-name"><?php echo $item['title']; ?></div>
                            <div class="item-description"><?php echo $item['content']; ?></div>
                            <div class="item-price">Rs <?php echo $item['price']; ?></div>
                        </div>
                        <!-- Add more menu items here -->

            <?php
                    }
                }
            }
            ?>
        </div>
    </div>

    <?php
        // Increase the menu counter
        $menuCounter++;
    endforeach;
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
              $restaurant_list = $userObj->filter_index(array('vendor_id' => $rid), $ord='DESC', $limit = 3);
              foreach ($restaurant_list as $rl) {
                $rl = (object) $rl;
              ?>
              <form id="select-prod-form2<?php echo $rl->id; ?>" action="/<?php echo home; ?>/send-add-item-ajax" method="POST">
                        <div class="row mt-4 mb-3">
                            <div class="col-2">
                                <img style="width: 130px; height: 130px; object-fit: contain;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rl->banner; ?>" alt="" srcset="">
                            </div>
                            <div class="col-6 onl_or">
                                <a href="/<?php echo home . "/food/?fid=" . $rl->id; ?>"><h5><?php echo $rl->title ?></h5></a>
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
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
                            </div>
                            <div class="col-2 mb-3">
                                <a class="example-image-link" href="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" data-lightbox="example-set1" data-title="Click the right half of the image to move forward."><img class="example-image" style="width: 100% !important; object-fit: cover; height: 100%;" src="/<?php echo STATIC_URL ?>/view/assets/img/onlinefood.jpg" alt=""/></a>
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
    $rid = $_GET['rid'];
    $myordersObj = new Model('menu_listing');
    $cart_list = $myordersObj->filter_index(array('is_listed' => true, 'rest_id' => $rid));
    $menuCounter = 1;

    foreach ($cart_list as $cv) :
        $cv = (object) $cv;
    ?>

    <div class="col-4">
        <div class="menu-container">
            <div class="menu-header"><?php echo $cv->menu_name; ?></div>
            <?php
            // Decode the JSON data in the second list
            $decoded_json = json_decode($cv->jsn, true);
            if ($decoded_json !== null) {
                $userObj = new Model('content');
                foreach ($decoded_json['food'] as $food_id) {
                    // Fetch the name of the item from the "content" table based on the ID
                    $rid = $_GET['rid'];
                    $restaurant_list = $userObj->filter_index(array('vendor_id' => $rid, 'id' => $food_id));
                    if (!empty($restaurant_list)) {
                        $item = $restaurant_list[0];
                        ?>

                        <div class="menu-item">
                            <div class="item-name"><?php echo $item['title']; ?></div>
                            <div class="item-description"><?php echo $item['content']; ?></div>
                            <div class="item-price">Rs <?php echo $item['price']; ?></div>
                        </div>
                        <!-- Add more menu items here -->

            <?php
                    }
                }
            }
            ?>
        </div>
    </div>

    <?php
        // Increase the menu counter
        $menuCounter++;
    endforeach;
    ?>
                        </div>
                        
                    
                </div>
            </div>
        </div>

    </div>
    
    <?php
import("apps/view/inc/footer.php");
?>
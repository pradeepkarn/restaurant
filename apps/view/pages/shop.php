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
?>

<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

    <div class="container-fluid checkout_banner mt-5">
        <div class="row">
            <div class="col-12 text-center pt-5 pb-5 check_new">
                <h2>Shop</h2>
                <p>Home / <span>Shop</span></p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12">
                <div class="row">
                <?php
              
              $userObj = new Model('content');
              $rid = $_GET['rid'];
            //   myprint($rid);
              $restaurant_list = $userObj->filter_index(array('vendor_id' => $rid));
              foreach ($restaurant_list as $rl) {
                $rl = (object) $rl;
                // myprint($_SESSION['user_id']);
              ?>
                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <a href="/<?php echo home . "/food/?fid=" . $rl->id; ?>">
                    <form id="select-prod-form<?php echo $rl->id; ?>" action="/<?php echo home; ?>/send-add-item-ajax" method="POST">
                        <div class="product_block">
                            <div class="product_transition">
                                <div class="product_imgg text-center">
                                    <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rl->banner; ?>" width="80%" class="img-fluid" alt="" srcset="">
                                </div>
                            </div>
                            <input type="hidden" value="1" scope="any" min="1" name="qty" class="form-control my-2">
                        <input type="hidden" value="<?php echo $rl->id; ?>" name="item_id" class="form-control my-2">
                        <input type="hidden" value="<?php echo $rid; ?>" name="rest_id" class="form-control my-2">
                        <input type="hidden" value="<?php echo $rl->price; ?>" name="price" class="form-control my-2">
                            <div class="product_caption">
                                <!-- <div class="str_di">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div> -->
                                <a href="/<?php echo home . "/food/?fid=" . $rl->id; ?>"><?php echo $rl->title; ?></a>
                                <div class="sht_des">
                                    <p><?php echo $rl->content; ?></p>
                                </div>
                                <div class="prc_cart">
                                    <h4>Rs <?php echo $rl->price; ?></h4>
                                    <button id="select-prod-btn<?php echo $rl->id; ?>" class="ct_tag_btn"><i class="bi bi-basket-fill me-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php pkAjax_form("#select-prod-btn{$rl->id}", "#select-prod-form{$rl->id}", "#inv"); ?>
                    </a>
                    </div>
                    <?php 
              }
                    ?>
                    <div id="inv"></div>
                    
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="side_cat">
                    <h4
                        style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px; font-size: 20px; margin-bottom: 0;">
                        Categories</h4>
                    <div class="prd_cat">
                        <ul>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-burger"></i>Burger</a>
                                <span>(9)</span>
                            </li>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-martini-glass"></i>Cold Drink</a>
                                <span>(20)</span>
                            </li>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-mug-hot"></i>Hot Drinks</a>
                                <span>(5)</span>
                            </li>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-cookie"></i>Cookie</a>
                                <span>(6)</span>
                            </li>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-pizza-slice"></i>Pizza</a>
                                <span>(14)</span>
                            </li>
                            <li class="llc">
                                <a href=""><i class="fa-solid fa-burger"></i>Uncategorized</a>
                                <span>(0)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
import("apps/view/inc/footer.php");
?>

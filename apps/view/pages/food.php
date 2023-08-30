<?php 
$home = home;
if (!isset($_GET['fid'])) {
   header("Location: /$home");
   exit;
}
if (!intval($_GET['fid'])) {
    header("Location: /$home");
    exit;
}
$prod = getData('content',$_GET['fid']);
$fid = $_GET['fid'];
if ($prod==false) {
    header("Location: /$home");
    exit;
 }
 if ($prod['content_group']!='food_listing_category') {
    header("Location: /$home");
    exit;
 }
 $fl = obj($prod);
 $parent_id = $fl->parent_id;
$parent_prod = getTableRowById('content', $parent_id);
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
                <!-- <h2><?php echo $fl->title; ?></h2> -->
                <p>Home / <span><?php echo $fl->title; ?></span></p>
            </div>
        </div>
    </div>

    <div class="container">
    <form id="select-prod-form1<?php echo $fl->id; ?>" action="/<?php echo home; ?>/send-add-item-ajax" method="POST">
        
        <div class="row mt-5 mb-5">
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="owl-carousel owl-theme" id="owl_load-1">
                    <div class="item">
                        <div class="side_img">
                            <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $fl->banner; ?>" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 ps-5">
                <div class="food_txt">
                    <h1><?php echo $fl->title; ?></h1>
                    <div class="rating_i pt-2 pb-4">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p><?php echo $fl->content; ?>
                    </p>
                    <h2>Rs <?php echo $fl->price; ?></h2>
                    
                        <input type="hidden" value="<?php echo $fl->id; ?>" name="item_id" class="form-control my-2">
                        <input type="hidden" value="<?php echo $fid; ?>" name="rest_id" class="form-control my-2">
                        <input type="hidden" value="<?php echo $fl->price; ?>" name="price" class="form-control my-2">
                    <div class="add_cart_btn pt-4 pb-4">
                        <div class="inc_btn quantity">
                            <!-- <button type="button" class="decrease">-</button> -->
                            <input type="hidden" autocomplete="off" name="qty" class="no-arrows" min="1" max step="1" value="1"
        placeholder inputmode="numeric">
                            <!-- <button type="button" class="btn-plus">+</button> -->
                        </div>
                        <button id="select-prod-btn1<?php echo $fl->id; ?>" class="btn btn-warning ct_btn ms-4"><i class="bi bi-basket-fill me-1"></i> ADD TO
                            CART</button>
                    </div>
                    <div class="add_cart_btn pt-4 pb-4">
                        <?php 
                        if ($prod) {
                            $fl = obj($prod);
                        
                            // Access the parent_id property from the $fl object
                            $parent_id = $fl->parent_id;
                        
                            // Retrieve the parent item using parent_id
                            $parent_prod = getTableRowById('content', $parent_id);
                        
                            if ($parent_prod) {
                                // Check if the parent item has a valid title property
                                if (isset($parent_prod['title']) && $parent_prod['title'] !== null) {
                                    ?>
                                    <p>Category: <?php ?>  <span><?php echo $parent_prod['title']; ?></span></p>
                                    <?php 
                                } else {
                                    echo "Parent item title is not available.";
                                }
                            } else {
                                echo "Parent item not found.";
                            }
                        } else {
                            echo "Item not found.";
                        }
                        ?>
                        
                    </div>
                    <div class="add_cart_btn pt-4 pb-4">
                        <ul>
                            <li>Free global shipping on all orders</li>
                            <li>30 days easy returns if you change your mind</li>
                            <li>Order before noon for same day dispatch</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <button class="btn btn-warning dsp_btn">Description</button>
            </div>
        </div>
        <div class="row justify-content-center pt-4 pb-4">
            <div class="col-9 des_txt">
                <p><?php echo $fl->content; ?></p>
            </div>
        </div>
    </form>
    <?php pkAjax_form("#select-prod-btn1{$fl->id}", "#select-prod-form1{$fl->id}", "#inv1"); ?>
    </div>
<div id="inv1"></div>
        
    <script>
    // Product Quantity
    $('.inc_btn button').on('click', function () {
        var button = $(this);
        var inputElement = button.parent().find('input');
        var oldValue = parseFloat(inputElement.val());

        if (button.hasClass('btn-plus')) {
            var newVal = isNaN(oldValue) ? 1 : oldValue + 1;
        } else {
            var newVal = isNaN(oldValue) || oldValue <= 1 ? 1 : oldValue - 1;
        }

        inputElement.val(newVal);
    });
</script>

    <?php
import("apps/view/inc/footer.php");
?>
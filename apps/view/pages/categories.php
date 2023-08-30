<?php
$home = home;
if (!isset($_GET['cid'])) {
   header("Location: /$home");
   exit;
}
if (!intval($_GET['cid'])) {
    header("Location: /$home");
    exit;
}
$prod = getData('restaurant_listing',$_GET['cid']);
myprint($prod);
$rlid = $_GET['cid'];

 
 $rn = obj($prod);
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
                <h2>Categories</h2>
                <p>Home / <span>Categories</span></p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-12">
                <div class="row">
                <?php
              
              $userObj = new Model('restaurant_listing');
              $rid = $_GET['cid'];
            //   myprint($rid);
              $restaurant_list = $userObj->filter_index(array('parent_id' => $rid, 'is_listed' => true));
              foreach ($restaurant_list as $rl) {
                $rl = (object) $rl;
                $pr = $rl->parent_id;
                // myprint($_SESSION['user_id']);
              ?>
                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
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
                    
                    
                </div>
            </div>
            
        </div>
    </div>

    <?php
import("apps/view/inc/footer.php");
?>

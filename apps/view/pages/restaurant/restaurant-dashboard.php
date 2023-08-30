<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Restaurant Dashboard</h2>
            <p>Home / <span>Restaurant Dashboard</span></p>
        </div>
    </div>
</div>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">


        <ul class="list-unstyled components">
            <li class="active">
                <a href="#">My Restaurant</a>

            </li>
            <li>
                <a href="#">Favourites</a>
            </li>
            <li>
                <a href="#">Payments</a>
            </li>
            <li>
                <a href="#">Addresses</a>
            </li>
            <li>
                <a href="#">Settings</a>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-danger mb-3">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>My Restaurant</h4>
                </div>
            </div>
            <div class="row mt-4">
                
                <?php
                        $userObj = new Model('restaurant_listing');
                        $restaurant_list = $userObj->filter_index(array('is_listed' => true, 'user_id' => $_SESSION['user_id']));
                        ?>
                        <?php
                        foreach ($restaurant_list as $rl) {
                            $rl = (object) $rl;
                            $pr = $rl->parent_id;
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
                            <!-- <option selected value="<?php echo $rl->id; ?>"><?php echo $rl->rest_name; ?></option> -->
                        <?php
                        }
                        ?>
                        
                </div>

            
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>


<?php
import("apps/view/inc/footer.php");
?>
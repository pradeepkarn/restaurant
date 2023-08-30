<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");


?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>My Dashboard</h2>
            <p>Home / <span>My Dashboard</span></p>
            <!-- <?php myprint($_SESSION['user_id']) ?> -->
        </div>
    </div>
</div>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">


        <ul class="list-unstyled components">
            <li class="active">
                <a href="#">Orders</a>

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
                    <h4>Order History</h4>
                </div>
            </div>
            <div class="row mt-4">
                <?php

                $userObj = new Model('payment');
                $order_details = $userObj->filter_index(array('user_id' => $_SESSION['user_id']));



                ?>
                <?php
                foreach ($order_details as $od) {
                    $od = (object) $od;
                    // Convert the database datetime to the desired format
                    $paymentDatetime = new DateTime($od->created_at); // Assuming 'payment_datetime' is the column name in the database
                    $formattedDatetime = $paymentDatetime->format('F j, Y \a\t h:i A');
                    $restaurant = $od->rest_id;
                    $restaurant_prod = getTableRowById('restaurant_listing', $restaurant);
                ?>
                    <div class="col-4 mb-4">
                        <div class="card">
                            <div class="card-header ord_head">
                                <div class="ord1">
                                    <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $restaurant_prod['banner']; ?>" height="45px" width="48px" alt="" srcset="" style="object-fit: cover;">
                                    <div class="ordd1 ms-3">
                                        <p class="mb-0"><?php echo $restaurant_prod['rest_name']; ?></p>
                                        <span><?php echo $restaurant_prod['rest_address']; ?></span>
                                    </div>
                                </div>
                                <div class="ord2">
                                    <!-- <p>Delivered</p> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="ord_num mb-2">
                                    <p class="mb-0">Order Number</p>
                                    <span class="mb-0"><?php echo $od->unique_id; ?></span>
                                </div>
                                <div class="ord_num mb-2">
                                    <p class="mb-0">Total Amount</p>
                                    <span class="mb-0">₹<?php echo $od->amount; ?></span>
                                </div>
                                <div class="ord_num mb-2">
                                    <p class="mb-0">Items</p>
                                    <?php
                                    $payObj = new Model('customer_order');
                                    $pay_details = $payObj->filter_index(array('payment_id' => $od->id));
                                    $fl = obj($pay_details);

                                    // Check if there are any payment details
                                    if (!empty($pay_details)) {
                                        $firstPayDetail = (object) $pay_details[0]; // Get the first payment detail

                                        $food = $firstPayDetail->item_id;
                                        $food_prod = getTableRowById('content', $food, $ord = "DESC", $limit = 0);
                                    ?>
                                        <span class="mb-0"><?php echo $firstPayDetail->qty; ?> X <?php echo $food_prod['title']; ?>....</span>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="ord_num mb-2">
                                    <p class="mb-0">Ordered On</p>
                                    <span class="mb-0"><?php echo $formattedDatetime; ?></span>
                                </div>
                                <div style="margin-top: 80px;" class="spce_div"></div>
                                <div class="ord_view_det mt-5 mb-1">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $od->id; ?>">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo $od->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Orders details</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body mod_or">
                                    <div class="orrrd">
                                        <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $restaurant_prod['banner']; ?>" height="45px" width="48px" alt="" srcset="" style="object-fit: cover;">
                                        <div class="ordd1 ms-3">
                                            <p class="mb-0"><?php echo $restaurant_prod['rest_name']; ?></p>
                                            <span><?php echo $restaurant_prod['rest_location']; ?></span>
                                        </div>
                                    </div>
                                    <p style="cursor: pointer;" class="mb-0 mt-2 sum_down">Download Summary <i class="bi bi-download"></i></p>
                                </div>
                                <div class="modal-body">
                                    <div class="ord_del">
                                        <p class="">This order was delivered</p>
                                        <h5>Order History</h5>
                                    </div>
                                    <?php
                                    $payObj = new Model('customer_order');
                                    $pay_details = $payObj->filter_index(array('payment_id' => $od->id));
                                    $fl = obj($pay_details);


                                    foreach ($pay_details as $pd) {
                                        $pd = (object) $pd;
                                        $food = $pd->item_id;
                                        $food_prod = getTableRowById('content', $food);
                                    ?>
                                        <div class="ord_mod_det mb-3">
                                            <h6 class="mb-0"><?php echo $food_prod['title']; ?></h6>
                                            <div class="ord_moddd">
                                                <p class="mb-0"><?php echo $pd->qty; ?> X <?php echo $food_prod['price']; ?></p>
                                                <p class="mb-0">₹<?php echo $pd->price; ?></p>
                                            </div>
                                            <span>Quantity: <?php echo $pd->qty; ?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="modal-body mod_ord_tot">
                                    <div class="mod_totl">
                                        <p><strong>Grand Total</strong></p>
                                        <p><strong>₹<?php echo $od->amount; ?></strong></p>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <h6>Order details</h6>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0">Order Id</p>
                                        <span><?php echo $od->unique_id; ?></span>
                                    </div>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0">Payment</p>
                                        <span><?php echo $od->status; ?> : <?php echo $od->payment_method; ?></span>
                                    </div>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0">Date</p>
                                        <span><?php echo $formattedDatetime; ?></span>
                                    </div>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0">Phone Number</p>
                                        <span><?php echo $od->mobile; ?></span>
                                    </div>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0">Deliver to</p>
                                        <span><?php echo $od->locality; ?>, <?php echo $od->city; ?>, <?php echo $od->zipcode; ?></span>
                                    </div>
                                    <div class="ord_iddd mb-3">
                                        <p class="mb-0"><?php echo $restaurant_prod['rest_name']; ?></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Model Ends -->

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
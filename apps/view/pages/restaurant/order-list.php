<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");
?>
<style>
    table tr th,
    table tr td {
        padding: 5px;
    }

    .food-img {
        border-radius: 5px;
        width: 50px;
        height: 50px;
        object-fit: contain;
    }
</style>
<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Restaurant Dashboard</h2>
            <p>Home / <span>Orders</span></p>
        </div>
    </div>
</div>

<div class="wrapper">
    <!-- Sidebar  -->
    <?php import("apps/view/pages/restaurant/inc.php"); ?>

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
                    <h4>My Orders</h4>


                    <?php
                    $db = new Dbobjects;
                    $db->tableName = 'restaurant_listing';
                    $my_rest = $db->filter(['user_id' => $_SESSION['user_id']]);
                    $payObj = new Model('payment');

                    ?>

                    <?php
                    foreach ($my_rest as $rest) {
                        $rest = obj($rest);
                        $payment_list = $payObj->filter_index(array('rest_id' => $rest->id));
                    ?>

                        <?php
                        foreach ($payment_list as $pl) {
                            $pl = (object) $pl;
                            $buyer = (object)$db->showOne("select * from pk_user where id = $pl->user_id");
                            $dtme = new DateTime($pl->created_at);
                            $ordered_at = $dtme->format('F j, Y \a\t h:i A');
                        ?>
                            <table class="table table-bordered table-success">

                                <thead>
                                    <tr>
                                        <th>
                                            View
                                        </th>
                                        <th>
                                            DBID
                                        </th>
                                        <th>
                                            Order Id
                                        </th>
                                        <th>
                                            Ordered at
                                        </th>
                                        <th>
                                            Order By
                                        </th>
                                        <th>
                                            Customer Name
                                        </th>
                                        <th>
                                            Payment Method
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#orderDetailsModal<?php echo $pl->id; ?>">View Details</button>
                                            
                                        </td>
                                        <td>
                                            <?php echo $pl->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $pl->unique_id; ?>
                                        </td>
                                        <td>
                                            <?php echo $ordered_at; ?>
                                        </td>
                                        <td>
                                            <?php echo $buyer->email; ?>
                                        </td>
                                        <td>
                                            <?php echo $pl->fname; ?> <?php echo $pl->lname; ?>
                                        </td>

                                        <td>
                                            <?php echo $pl->payment_method; ?>
                                        </td>
                                        <td>
                                            <?php echo $pl->amount; ?>
                                        </td>
                                    </tr>
                                    <table class="table table-primary table-bordered">
                                        <tr>
                                            <th>Food ID</th>
                                            <th>Food</th>
                                            <th>Qty</th>
                                            <th>Cost/Item</th>
                                            <th>Total</th>
                                        </tr>
                                        <?php
                                        $cart = $db->show("select * from customer_order where payment_id = $pl->id");
                                        foreach ($cart as $cv) {
                                            $cv = obj($cv);
                                            $food = (object) $db->showOne("select * from content where id = $cv->item_id");

                                        ?>
                                            <tr>
                                                <td><?php echo $food->id; ?></td>

                                                <td>
                                                    <p><?php echo $food->title; ?></p>
                                                    <img class="food-img" src="/<?php echo MEDIA_URL . "/images/pages/" . $food->banner; ?>" alt="<?php echo $food->title; ?>">
                                                </td>
                                                <td><?php echo $cv->qty; ?></td>
                                                <td><?php echo $cv->price; ?></td>
                                                <td><?php echo round(($cv->price * $cv->qty), 2); ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </table>







                                    <!-- Modal -->
                                    <div class="modal fade" id="orderDetailsModal<?php echo $pl->id; ?>" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="border: none;">
                                                    <h1 class="modal-title fs-5" id="orderDetailsModalLabel">Orders details</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body mod_or">
                                                    <div class="orrrd">
                                                        <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rest->banner; ?>" height="45px" width="48px" alt="" srcset="" style="object-fit: cover;">
                                                        <div class="ordd1 ms-3">
                                                            <p class="mb-0"><?php echo $rest->rest_name; ?></p>
                                                            <span><?php echo $rest->rest_location; ?></span>
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
                                                    $pay_details = $payObj->filter_index(array('payment_id' => $pl->id));
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
                                                                <p class="mb-0">₹<?php echo round(($pd->price*$pd->qty),2); ?></p>
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
                                                        <p><strong>₹<?php echo $pl->amount; ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Order details</h6>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0">Order Id</p>
                                                        <span><?php echo $pl->unique_id; ?></span>
                                                    </div>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0">Payment</p>
                                                        <span><?php echo $pl->status; ?> : <?php echo $pl->payment_method; ?></span>
                                                    </div>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0">Date</p>
                                                        <span><?php echo $ordered_at; ?></span>
                                                    </div>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0">Phone Number</p>
                                                        <span><?php echo $pl->mobile; ?></span>
                                                    </div>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0">Deliver to</p>
                                                        <span><?php echo $pl->locality; ?>, <?php echo $pl->city; ?>, <?php echo $pl->zipcode; ?></span>
                                                    </div>
                                                    <div class="ord_iddd mb-3">
                                                        <p class="mb-0"><?php echo $rest->rest_name; ?></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Model Ends -->


















                                <?php
                            } ?>
                                </tbody>
                            </table>
                        <?php
                    }
                        ?>



                </div>
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
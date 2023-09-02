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
            <h2>Driver Dashboard</h2>
            <p>Home / <span>Orders</span></p>
        </div>
    </div>
</div>

<div class="wrapper">
    <!-- Sidebar  -->
    <?php import("apps/view/pages/drivers/inc.php"); ?>

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
                    $me = obj(USER);
                    $db = new Dbobjects;
                    $db->tableName = 'payment';
        
                    $payment_list = $db->show("SELECT * FROM `payment` WHERE deliver_by = '$me->id' and is_cancelled = 1;");

                    foreach ($payment_list as $pl) {
                        $pl = (object) $pl;
                        $rest = (object)$db->showOne("select * from restaurant_listing where id = $pl->rest_id");
                        $me_from_rest = calculateDistance($rest->latitude, $rest->longitude, $me->lat, $me->lon);
                        $me_from_rest_km = $me_from_rest > 0 ? round(($me_from_rest / 1000), 2) : null;

                        $customer_from_rest_km = $pl->distance > 0 ? round(($pl->distance / 1000), 2) : 0;
                        $me_from_customer_km = $me_from_rest_km + $customer_from_rest_km;

                        $buyer = (object)$db->showOne("select * from pk_user where id = $pl->user_id");
                        $dtme = new DateTime($pl->created_at);
                        $ordered_at = $dtme->format('F j, Y \a\t h:i A');
                    ?>
                        <table class="table table-success table-striped">

                            <thead>
                                <tr>
                                    <th colspan="8">
                                        Restaurant Name: <?php echo $rest->rest_name; ?> [<?php echo $rest->id; ?>] <br>
                                        <div class="bg-warning">My distance from this restaurant : <?php echo $me_from_rest_km; ?> KM</div>
                                    </th>
                                </tr>
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
                                        <button type="button" class="btn btn-warning my-2" data-bs-toggle="modal" data-bs-target="#acceptOrderModal<?php echo $pl->id; ?>">Release</button>
                                 
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
                                <tr>
                                    <td class="text-center" colspan="8">
                                        <b>Restaurant Address:</b> <?php echo $rest->rest_location; ?> <br>
                                        <i class="fas fa-arrow-down"></i> <b><?php echo $customer_from_rest_km; ?>KM</b> <br>
                                        <b>User Address:</b> <?php echo $pl->landmark; ?> <br>
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







                                <!-- Modal accept order by driver-->
                                <div class="modal fade" id="acceptOrderModal<?php echo $pl->id; ?>" tabindex="-1" aria-labelledby="acceptOrderModalLabel<?php echo $pl->id; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="border: none;">
                                                <h1 class="modal-title fs-5" id="acceptOrderModalLabel<?php echo $pl->id; ?>">Orders details</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body mod_or">
                                                <div id="res<?php echo $pl->id; ?>"></div>
                                                <div class="orrrd">
                                                    <img src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $rest->banner; ?>" height="45px" width="48px" alt="" srcset="" style="object-fit: cover;">
                                                    <div class="ordd1 ms-3">
                                                        <p class="mb-0"><?php echo $rest->rest_name; ?></p>
                                                        <span><?php echo $rest->rest_location; ?></span>
                                                    </div>
                                                </div>
                                                <h3 class="my-2">Me from restaurant : <?php echo $me_from_rest_km; ?>KM</h3>
                                                <h3 class="my-2">Customer from restaurant : <?php echo $customer_from_rest_km; ?>KM</h3>
                                                <h3 class="my-2">Me from customer : <?php echo $me_from_customer_km; ?>KM</h3>
                                                <input type="hidden" class='<?php echo "accept-order-data{$pl->id}"; ?>' name="payment_id" value="<?php echo $pl->id; ?>">
                                                <input type="hidden" class='<?php echo "accept-order-data{$pl->id}"; ?>' name="deliver_by" value="<?php echo $me->id; ?>">
                                                <select name="action" class="<?php echo "accept-order-data{$pl->id}"; ?> my-3 form-select">
                                                    <option value="release">Release</option>
                                                </select>
                                                <button id="accept-this-order<?php echo $pl->id; ?>" class="btn btn-primary" type="button">Confirm</button>
                                                <?php pkAjax("#accept-this-order{$pl->id}", "/change-accepted-order-status-by-driver", ".accept-order-data{$pl->id}", "#res{$pl->id}"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Model Ends -->



















                            <?php
                        } ?>
                            </tbody>
                        </table>




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
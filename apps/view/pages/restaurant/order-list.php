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

                    <table class="table table-bordered table-success">
                        <thead>
                            <tr>
                                <th>
                                    Order Id
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
                        <?php
                        $db = new Dbobjects;
                        $db->tableName = 'restaurant_listing';
                        $my_rest = $db->filter(['user_id' => $_SESSION['user_id']]);
                        $payObj = new Model('payment');

                        ?>

                        <?php
                        foreach ($my_rest as $rest) {
                            $payment_list = $payObj->filter_index(array('rest_id' => $rest['id']));
                        ?>
                            <tbody>
                                <?php
                                foreach ($payment_list as $pl) {
                                    $pl = (object) $pl;
                                    $buyer = (object)$db->showOne("select * from pk_user where id = $pl->user_id");
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $pl->id; ?>
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
                                            <th>Food Name</th>
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
                                                <td><?php echo $food->title; ?></td>
                                                <td><?php echo $cv->qty; ?></td>
                                                <td><?php echo $cv->price; ?></td>
                                                <td><?php echo round(($cv->price*$cv->qty),2); ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </table>

                                <?php
                                } ?>
                            </tbody>
                        <?php
                        }
                        ?>


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
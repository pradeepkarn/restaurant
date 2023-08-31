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
            <p>Home / <span>My listed foods</span></p>
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
                    <h4>My Foods</h4>


                    <?php
                    $db = new Dbobjects;
                    $db->tableName = 'restaurant_listing';
                    $my_rest = $db->filter(['user_id' => $_SESSION['user_id']]);
                    $foodObj = new Model('content');

                    ?>

                    <?php
                    foreach ($my_rest as $rest) {
                        $arr = null;
                        $rest = obj($rest);
                        $arr['vendor_id'] = $rest->id;
                        $arr['content_group'] = 'food_listing_category';

                        $food_list = $foodObj->filter_index($arr);
                    ?>
                        <table class="table table-info table-striped">

                            <thead>
                                <tr>
                                    <th>
                                        Edit
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Order Id
                                    </th>

                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Created at
                                    </th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($food_list as $fl) {
                                $fl = (object) $fl;

                                $dtme = new DateTime($fl->created_at);
                                $created_at = $dtme->format('F j, Y \a\t h:i A');
                            ?>

                                <tbody>
                                    <tr>
                                        <td>
                                            <a target="_blank" href="/<?php echo home."/edit-my-listed-food/?food_id=$fl->id"; ?>" class="btn btn-outline-danger">Edit</button>
                                        </td>
                                        <td>
                                            <?php echo $fl->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $fl->title; ?>
                                        </td>
                                        <td>
                                            <?php echo $fl->price; ?>
                                        </td>
                                        <td>
                                            <?php echo $created_at; ?>
                                        </td>


                                    </tr>



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
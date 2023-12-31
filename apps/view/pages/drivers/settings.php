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
            <p>Home / <span>Settings</span></p>
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
                    <div id="res"></div>
                    <h4>Settings</h4>
                    <?php
                    $db = new Dbobjects;
                    $db->tableName = 'pk_user';
                    $me = (object)$db->pk($_SESSION['user_id']);
                    ?>


                    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
                    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css" />
                    <style>
                        /* Add some basic CSS styles */
                        body {
                            font-family: Arial, sans-serif;
                        }

                        #coordinates {
                            margin-top: 20px;
                        }
                    </style>

                    <form id="location-form">
                    </form>

                    <!-- Display the selected location's coordinates -->
                    <div id="coordinates"></div>
                    <div id="map"></div>


                    <form id="update-profile-form" action="/<?php echo home . "/update-my-profile"; ?>">
                        <div class="card">
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <label for="">Address(auto filled by map)</label>
                                    <input id="set-location" type="text" readonly class="form-control my-2" name="address" value="<?php echo $me->address; ?>">
                                </div>
                                <div class="col-md-6">
                                    <input id="lat_save" type="text" placeholder="Latitude" class="form-control" name="lat" value="<?php echo $me->lat; ?>">
                                </div>
                                <div class="col-md-6">
                                    <input id="lon_save" type="text" placeholder="Longitude" class="form-control" name="lon" value="<?php echo $me->lon; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Owner first name</label>
                                    <input type="text" class="form-control my-2" name="first_name" value="<?php echo $me->first_name; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Owner last name</label>
                                    <input type="text" class="form-control my-2" name="last_name" value="<?php echo $me->last_name; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="text" readonly disabled class="form-control my-2" name="email" value="<?php echo $me->email; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="">Zip</label>
                                    <input id="set-zip" type="text" class="form-control my-2" name="zipcode" value="<?php echo $me->zipcode; ?>">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="update-profile-btn">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php pkAjax_form("#update-profile-btn", "#update-profile-form", "#res"); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
import("apps/view/inc/api.mapbox.js.php");
?>


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
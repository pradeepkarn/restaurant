<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Driver Dashboard</h2>
            <p>Home / <span>Driver Dashboard</span></p>
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
                    <h4>My Restaurant</h4>
                    <?php 
                    // $metre = calculateDistance(26.180006936125913, 86.0077261820532, 26.16225054639407, 85.89607136588411);
                    // echo $metre;
                    ?>

                </div>
            </div>
            <div class="row mt-4"></div>


        </div>
    </div>
</div>


</div>
</div>
<!-- Model Ends -->




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
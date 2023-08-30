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
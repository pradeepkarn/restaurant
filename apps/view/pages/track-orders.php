<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Track Orders</h2>
            <p>Home / <span>Track Orders</span></p>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center pb-4">
        <div class="col-10">
        <ol class="progtrckr" data-progtrckr-steps="4">
    <li class="progtrckr-done">Confirm</li>
    <li class="progtrckr-done">On its Way</li>
    <li class="progtrckr-todo">Out For Delivery</li>
    <li class="progtrckr-todo">Delivered</li>
</ol>
        </div>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-12">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62466.34445608096!2d37.85909472181666!3d0.5478102006096021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182780d08350900f%3A0x403b0eb0a1976dd9!2sKenya!5e0!3m2!1sen!2sin!4v1689310560593!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6">
                    <img src="/<?php echo STATIC_URL; ?>/view/assets/img/r5.png" style="object-fit: cover;" class="img-fluid" alt="" srcset="">
                </div>
                <div class="col-6">
                    <h6 class="mb-0">Birthday Cake</h6>
                    <p>From <span class="track_res">ABC Restaurant</span></p>
                    <h6>Quantity 1</h6>
                </div>
            </div>
        </div>
        
    </div>
</div>



<?php
import("apps/view/inc/footer.php");
?>


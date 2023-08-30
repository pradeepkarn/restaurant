<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>My Order Details</h2>
            <p>Home / <span>My Order Details</span></p>
        </div>
    </div>
</div>


<div class="container mt-5 mb-5">
      <form action="" method="POST">
        <div class="row">
            <div class="col-6 coup_form">
                <div class="row g-3">
                    <div class="col-md-6 mb-4">
                      <label for="validationDefault01" class="form-label">First name</label>
                      <input type="text" class="form-control" disabled value="Pulkit" id="validationDefault01" name="fname">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="validationDefault02" class="form-label">Last name</label>
                      <input type="text" class="form-control" disabled value="Chadha" id="validationDefault02" name="lname">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                      <label for="validationDefault01" class="form-label">Street address</label>
                      <input type="text" class="form-control" disabled value="Testing Address" id="validationDefault05" name="locality">
                    </div>
                    </div>
                <div class="row g-3">
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">State</label>
                      <input type="text" class="form-control" disabled value="Delhi" id="validationDefault07" name="state">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Town / City</label>
                      <input type="text" class="form-control" disabled value="New Delhi" id="validationDefault07" name="city">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Country (optional)</label>
                      <input type="text" class="form-control" disabled value="india" id="validationDefault08" name="country">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Postcode</label>
                      <input type="text" class="form-control" disabled value="114466" id="validationDefault09" name="zipcode">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">ISD Code</label>
                      <input type="text" class="form-control" disabled value="91" id="validationDefault10" name="isd_code">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Phone</label>
                      <input type="text" class="form-control" disabled value="8477466445" id="validationDefault10" name="mobile">
                    </div>
                </div>
            </div>
            <div class="col-6 ps-5">
                <div class="order_box">
                    <h3>Your order</h3>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Product</th>
                            <th scope="col" class="text-end">Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <tr>
                            <td>VM McEgg x 1 x 1</td>
                            <td class="text-end"><strong>Rs 116</strong></td>
                          </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Subtotal</strong></td>
                                <td class="text-end"><strong>Rs 116</strong></td>
                            </tr>
                            <tr class="order_total">
                                <td><strong>Total</strong></td>
                                <td class="text-end order_total1">Rs 116</td>
                            </tr>
                        </tfoot>
                      </table>
                      
                </div>
            </div>
        </div>
      </form>
    </div>



<?php
import("apps/view/inc/footer.php");
?>


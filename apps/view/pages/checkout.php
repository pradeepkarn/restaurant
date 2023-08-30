<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

    <div class="container-fluid checkout_banner mt-5">
        <div class="row">
            <div class="col-12 text-center pt-5 pb-5 check_new">
                <h2>Checkout</h2>
                <p>Home / <span>Checkout</span></p>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 coupon_cl">
                <p class="m-0">If you have a coupon code, please apply it below.</p>
            </div>
            <div class="col-6 p-0 coup_form">
                <div class="col mt-4">
                    <input type="text" class="form-control" id="validationCustom01" value="Coupon Code">
                  </div>
            </div>
            <div class="col-6 mt-4">
                <button class="btn btn-warning">Apply Coupon</button>
            </div>
        </div>
    </div>
    <div class="container mb-5">
      <form id="place-item-form" action="/<?php echo home; ?>/place-order-ajax" method="POST">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 coup_form mb-3">
                <div class="row g-3">
                    <div class="col-md-6 mb-4">
                      <label for="validationDefault01" class="form-label">First name</label>
                      <input type="text" class="form-control" id="validationDefault01" name="fname">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="validationDefault02" class="form-label">Last name</label>
                      <input type="text" class="form-control" id="validationDefault02" name="lname">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                      <label for="validationDefault01" class="form-label">Street address</label>
                      <input type="text" class="form-control" id="validationDefault05" name="locality">
                    </div>
                    </div>
                <div class="row g-3">
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">State</label>
                      <input type="text" class="form-control" id="validationDefault07" name="state">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Town / City</label>
                      <input type="text" class="form-control" id="validationDefault07" name="city">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Country (optional)</label>
                      <input type="text" class="form-control" id="validationDefault08" name="country">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Postcode</label>
                      <input type="text" class="form-control" id="validationDefault09" name="zipcode">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">ISD Code</label>
                      <input type="text" class="form-control" id="validationDefault10" name="isd_code">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label for="validationDefault01" class="form-label">Phone</label>
                      <input type="text" class="form-control" id="validationDefault10" name="mobile">
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 ps-5 chk_part">
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
                        <?php
                         $total_qty = array();
                         $total_cost = array();
                        if (isset($_SESSION['cart'])) {
                            
                            // for ($i=0; $i < count($_SESSION['cart']); $i++) { 
                            //     echo $_SESSION['cart']['46']['id'] ;
                            // }
                           
                            $db = new Mydb('content');
                            foreach (array_keys($_SESSION['cart']) as $key => $value) { 
                                $id =  $_SESSION['cart'][$value]['id'];
                                $qty = $_SESSION['cart'][$value]['qty'];
                                $total_qty[] = $qty;
                                $db = new Mydb('content');
                                $prod = $db->pkData($id);
                               
                                $net_price = $prod['price'];
                                $cost = $qty*$net_price;
                                $total_cost[] = $cost;
                                ?>
                          <tr>
                          <input type="hidden" name="restaurant_id" value="<?php echo $prod['vendor_id']; ?>">
                          <input type="hidden" name="rest_id[]" value="<?php echo $prod['vendor_id']; ?>">
                          <input type="hidden" name="food_id[]" value="<?php echo $prod['id']; ?>">
                          <input type="hidden" name="qty[]" value="<?php echo $qty; ?>">
                          <input type="hidden" name="price[]" value="<?php echo $cost; ?>">
                            <td><?php echo $prod['title']; ?> x <?php echo $qty; ?></td>
                            <td class="text-end"><strong>Rs <?php echo $cost; ?></strong></td>
                          </tr>
                          <?php 
                }}
                          ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Subtotal</strong></td>
                                <td class="text-end"><strong>Rs <?php echo array_sum($total_cost); ?></strong></td>
                            </tr>
                            <tr>
                                <td><strong>Shipping</strong></td>
                                <td class="text-end">Enter your address to view shipping options.</td>
                            </tr>
                            <tr class="order_total">
                                <td><strong>Total</strong></td>
                                <td class="text-end order_total1">Rs <?php echo array_sum($total_cost); ?></td>
                            </tr>
                        </tfoot>
                      </table>
                      <ul class="p-0">
                        <li class="nb_li mb-4">
                            <div class="form-check nb_label">
                                <input class="form-check-input" type="radio" name="payment_mode" value="Bank Transfer" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Direct bank transfer
                                </label>
                                <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                              </div>
                        </li>
                        <li class="nb_li mb-4">
                            <div class="form-check nb_label">
                                <input class="form-check-input" type="radio" name="payment_mode" value="Check" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Check payments
                                </label>
                                <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                              </div>
                        </li>
                        <li class="nb_li mb-4">
                            <div class="form-check nb_label">
                                <input class="form-check-input" type="radio" checked name="payment_mode" value="COD" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Cash on delivery
                                </label>
                                <p>Pay with cash upon delivery.</p>
                              </div>
                        </li>
                        <li class="nb_li mb-4">
                            <div class="form-check nb_label">
                                <input class="form-check-input" type="radio" name="payment_mode" value="Paypal" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  PayPal
                                </label>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                              </div>
                        </li>
                      </ul>
                      <p class="pay_cl">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
                      <div id="check"></div>
                      <div class="col-12 text-center pt-3">
                      <?php
                if(array_sum($total_cost)> 0){

               
                ?>
                <button id="placeord_btn" class="btn btn-warning">PROCEED TO PAY</button>
                  <?php 
                   }
                  ?>
                        
                      </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="total_amount" value="<?php echo array_sum($total_cost); ?>">
      </form>
    </div>
    <?php
          pkAjax_form("#placeord_btn", "#place-item-form", "#check");
          ajaxActive('#spinn');
          ?>

    
    <?php
import("apps/view/inc/footer.php");
?>
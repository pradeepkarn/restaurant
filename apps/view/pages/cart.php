<?php
import("apps/view/inc/header.php");
?>

<?php
import("apps/view/inc/navbar.php");
?>

    <div class="container-fluid checkout_banner mt-5">
        <div class="row">
            <div class="col-12 text-center pt-5 pb-5 check_new">
                <h2>Cart</h2>
                <p>Home / <span>Cart</span></p>
            </div>
        </div>
    </div>

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-4">
        <div id="res"></div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">PRODUCT</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody class="cart_tbl">
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
                    <td><img style="margin-right: 10px;" src="/<?php echo MEDIA_URL ?>/images/pages/<?php echo $prod['banner']; ?>" width="100px" height="100px" alt="" srcset=""> <strong><?php echo $prod['title']; ?></strong></td>
                    <td><strong>Rs <?php echo $cost; ?></strong></td>
                    <td>
                    <div class="input-group product_data mb-3" style="width: 130px;">
                      <input type="hidden" class="qty<?php echo $id; ?>" name="cart_id" value="<?php echo $id; ?>">
                      <input type="hidden" class="qty<?php echo $id; ?>" name="price" value="<?php echo $cost; ?>">
                      <input type="hidden" name="rest_id" value="<?php echo $prod['vendor_id']; ?>">
                      <button id="decrease-btn<?php echo $id; ?>" class="input-group-text decrement-btn<?php echo $prod['id']; ?>">-</button>
                      <script>
                                    $(document).ready(function(){
                                        $(".decrement-btn<?php echo $prod['id']; ?>").click(function(){
                                            $.ajax({
                                                url: "/<?php echo home; ?>/purchase-decrease-qty-ajax",
                                                method: "post",
                                                data: {item_id: '<?php echo $prod['id']; ?>'},
                                                dataType: "html",
                                                success: function(resultValue) {
                                                    // $('#show-cart').html(resultValue)
                                                    location.reload();
                                                }
                                            });
                                        });
                                    })
                                </script>
                      <input type="text" class="form-control text-center input-qty bg-white qty<?php echo $id; ?>" aria-label="Amount (to the nearest dollar)" name="qty" value="<?php echo $qty; ?>">
                      <button id="increament-btn<?php echo $id; ?>" class="input-group-text increment-btn<?php echo $prod['id']; ?>">+</button>
                      <script>
                                    $(document).ready(function(){
                                        $(".increment-btn<?php echo $prod['id']; ?>").click(function(){
                                            $.ajax({
                                                url: "/<?php echo home; ?>/purchase-increase-qty-ajax",
                                                method: "post",
                                                data: {item_id: '<?php echo $prod['id']; ?>',action: 'add_to_cart'},
                                                dataType: "html",
                                                success: function(resultValue) {
                                                    // $('#show-cart').html(resultValue)
                                                    location.reload();
                                                }
                                            });
                                        });
                                    })
                                </script>
                    </div>
                    <?php
                    
                    pkAjax("#increament-btn{$id}", "/purchase-increase-qty-ajax", ".qty{$id}", "#res");
                    ?>
                    </td>
                    <td><strong>Rs <?php echo $cost; ?></strong></td>
                  </tr>
                  
                  <?php
                            }
                          }
                  ?>
                </tbody>
              </table>
        </div>
              <div class="cp_code">
                  <input type="text" class="coup_n" placeholder="Coupon code">
                  <button class="btn btn-warning coup_btn">APPLY COUPON</button>
              </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <div class="order_box">
                <h5><strong>CART TOTALS</strong></h5>
                <table class="table">
                    <thead></thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Subtotal</strong></td>
                            <td class="text-end"><strong>Rs <?php echo array_sum($total_cost); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Shipping</strong></td>
                            <td class="text-end" style="width: 60%;">Enter your address to view shipping options.</td>
                        </tr>
                        <tr class="order_total">
                            <td><strong>Total</strong></td>
                            <td class="text-end order_total1">Rs <?php echo array_sum($total_cost); ?></td>
                        </tr>
                       
                    </tfoot>
                  </table>
                  <div class="col-12 text-center pt-3">
                <?php
                if(array_sum($total_cost)> 0){

               
                ?>
                    <a href="/<?php echo home; ?>/checkout" class="btn btn-warning">PROCEED TO CHECKOUT</a>
                  <?php 
                   }
                  ?>
                  </div>
            </div>
        </div>
    </div>
</div>





        <?php
import("apps/view/inc/footer.php");
?>
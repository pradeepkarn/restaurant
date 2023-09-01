<?php
$ol_list = getData('payment',$_GET['oid']);
$ol = obj($ol_list);

$userObj = new Model('payment');
$order_details = $userObj->filter_index(array('id' => $_GET['oid']));
?>


<?php
import("apps/admin/inc/header.php");
?>

<body class="g-sidenav-show bg-gray-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <?php
  import("apps/admin/inc/sidebar.php");
  ?>
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php
    import("apps/admin/inc/topbar.php");
    ?>
    <!-- End Navbar -->
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Order Information</p>
                <button class="btn btn-primary btn-sm ms-auto">Settings</button>
              </div>
            </div>
            <form id="rest_form" action="" method="POST">
            <?php
                foreach ($order_details as $od) {
                    $od = (object) $od;
                    // Convert the database datetime to the desired format
                    $paymentDatetime = new DateTime($od->created_at); // Assuming 'payment_datetime' is the column name in the database
                    $formattedDatetime = $paymentDatetime->format('F j, Y \a\t h:i A');
                    $restaurant = $od->rest_id;
                    $restaurant_prod = getTableRowById('restaurant_listing', $restaurant);
                ?>
            <div class="card-body">
              <p class="text-uppercase text-sm">Owner Information</p>
                <div class="info_txt">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner First name</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->fname ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Last name</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->fname ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Mobile</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->mobile ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Country</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->country ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">State</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->state ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">City</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->city ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Address</label>
                        <input class="form-control" type="text" disabled value="<?php echo $ol->locality ?>">
                      </div>
                    </div>
                  </div>

                  

                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Restaurant Information</p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Name</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['rest_name']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Address</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['rest_address']; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Loaction</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['rest_location']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Latitude</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['latitude']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Longitude</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['longitude']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Mobile</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['rest_mobile']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Landline</label>
                        <input class="form-control" type="text" disabled value="<?php echo $restaurant_prod['rest_landline']; ?>">
                      </div>
                    </div>
                  </div>


                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Food Information</p>
                  <div class="row">
                    <div class="col">
                        <ul><?php
                foreach ($order_details as $od) {
                    $od = (object) $od;
                    // Convert the database datetime to the desired format
                    $paymentDatetime = new DateTime($od->created_at); // Assuming 'payment_datetime' is the column name in the database
                    $formattedDatetime = $paymentDatetime->format('F j, Y \a\t h:i A');
                    $restaurant = $od->rest_id;
                    $restaurant_prod = getTableRowById('restaurant_listing', $restaurant);
                ?>
                
                <div class="ord_num mb-2">
                <?php
                                    $payObj = new Model('customer_order');
                                    $pay_details = $payObj->filter_index(array('payment_id' => $od->id));
                                    $fl = obj($pay_details);


                                    foreach ($pay_details as $pd) {
                                        $pd = (object) $pd;
                                        $food = $pd->item_id;
                                        $food_prod = getTableRowById('content', $food);
                                    ?>
                                    <li>
                                        <div class="ord_mod_det mb-3">
                                            <p class="mb-0"><strong>Item Name:</strong> <?php echo $food_prod['title']; ?></p>
                                            <p class="mb-0"><strong>Ouantity:</strong> <?php echo $pd->qty; ?></p>
                                            <p class="mb-0"><strong>Price:</strong> ₹<?php echo $food_prod['price']; ?></p>
                                            <?php 
                                                $ml_amount = $pd->qty * $pd->price;
                                                ?>
                                            <p class="mb-0"><strong>Total:</strong> ₹<?php echo $ml_amount; ?></p>
                                        </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <p class="mb-0"><strong>Grand Total:</strong> ₹<?php echo $ol->amount ?></p>
                                    <p class="mb-0"><strong>Payment Mode:</strong> <?php echo $ol->payment_method ?></p>
                                    <p class="mb-0"><strong>Payment ID:</strong> <?php echo $ol->unique_id ?></p>
                                    <p class="mb-0"><strong>Date:</strong> <?php echo $formattedDatetime; ?></p>
                                </div>
                
                            
                            <?php 
                }
                            ?>
                        </ul>
                    </div>
                  </div>



                </div>
              
              <!-- <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Restaurant Status</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Status</label>
                    <select class="form-control" name="rs_status" id="exampleFormControlSelect1"> -->
                      <!-- <option <?php echo $rl->is_listed == $rl->is_listed ? 'selected' : null; ?> value="<?php echo $rl->is_listed?>"><?php echo $rl->is_listed == 0 ? 'Unpublished' : 'Published'?></option> -->
                      <!-- <option <?php echo $rl->is_listed == 0 ? 'selected' : null; ?> value="0">Unpublished</option>
<option <?php echo $rl->is_listed == 1 ? 'selected' : null; ?> value="1">Published</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="rest"></div>
              <input type="hidden" name="restaurant_id" value="<?php echo $rl->id; ?>">
              <button type="button" id="uprest_btn" class="btn btn-primary btn-sm">Change Status</button>
            </div>
            </form>
          </div>
        </div> -->
        
        
        
      </div>
      <?php 
      }
      ?>
      
      <?php
      import("apps/admin/inc/footer.php");
      ?>
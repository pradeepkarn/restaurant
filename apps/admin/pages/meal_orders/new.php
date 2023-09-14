<?php
import("apps/admin/inc/header.php");
?>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php
  import("apps/admin/inc/sidebar.php");
  ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php
    import("apps/admin/inc/topbar.php");
    ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Meal orders</h6>
            </div>
            <div class="card-body pb-2">
              <div class="table-responsive">
                <table class="table table-bordered border-success">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order By</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Restaurant</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Status</th>
                      <th class="text-secondary opacity-7">View</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   
                    $db = new Dbobjects;
                    $orders = $db->show("select * from payment where is_delivered=0 and is_cancelled=0 and (deliver_by=0 OR deliver_by='');");
                    //   $userObj = new Model('restaurant_listing');
                    //   $restaurant_list = $userObj->filter_index(array('is_active' => true));
                    foreach ($orders as $ol) {
                      $ol = obj($ol);
                      $rl = (object)$db->showOne("select * from restaurant_listing where id = {$ol->rest_id}");
                      $odtls = food_order_details(pl: $ol, db: $db, rest: $rl);
                      $cust_dist = isset($odtls->customer_from_rest_km)?$odtls->customer_from_rest_km:null;
                      // myprint($odtls);
                    ?>
                    
                      <tr>
                        <td>
                          <?php echo $ol->id; ?>
                        </td>
                        <td>
                          <?php echo $odtls->buyer->first_name; ?>
                          <?php echo $odtls->buyer->email; ?>
                          <?php echo $odtls->buyer->mobile; ?>
                        </td>
                        <td>
                          <div class="d-flex px-2 py-1">

                            <div class="d-flex flex-column justify-content-center">
                              <p class="text-xs text-secondary mb-0"><?php echo $rl->rest_name; ?></p>
                              <p class="text-xs text-secondary mb-0">Mobile: <?php echo $rl->rest_mobile; ?></p>
                            </div>
                          </div>
                        </td>

                        <td class="align-middle">
                          <?php echo $ol->amount; ?>
                        </td>

                        <td class="align-middle">
                          <?php echo $ol->status; ?>
                        </td>
                        <td class="align-middle">
                          <a href="/<?php echo home . "/restaurant-info/?rid=" . $rl->id; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            View
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>Customer from restaurant: <?php echo $cust_dist; ?>KM</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
      import("apps/admin/inc/footer.php");
      ?>
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
              <h6>User Orders</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Restaurant Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Amount</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Number</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                        $db = new Dbobjects;
                        $db->tableName = 'restaurant_listing';
                        $my_rest = $db->filter(['is_listed' => true]);
                        $payObj = new Model('payment');

                        ?>

                        <?php
                        foreach ($my_rest as $rest) {
                            $payment_list = $payObj->filter_index(array('rest_id' => $rest['id']));
                        ?>
                        <?php
                                foreach ($payment_list as $pl) {
                                    $pl = (object) $pl;
                                    $buyer = (object)$db->showOne("select * from pk_user where id = $pl->user_id");
                                ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $pl->fname; ?></h6>
                            <!-- <p class="text-xs text-secondary mb-0"></p> -->
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $pl->lname; ?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $rest['rest_name']; ?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Rs <?php echo $pl->amount; ?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $pl->unique_id; ?></p>
                      </td>
                      
                      
                      <td class="align-middle">
                        <a href="/<?php echo home . "/order-info/?oid=" . $pl->id; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          View
                        </a>
                      </td>
                    </tr>
                    <?php 
              }
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
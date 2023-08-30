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
              <h6>Restaurant table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Owner</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Restaurant</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
              
              $userObj = new Model('restaurant_listing');
              $restaurant_list = $userObj->filter_index(array('is_active' => true));
              foreach ($restaurant_list as $rl) {
                $rl = (object) $rl;
              ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="/<?php echo STATIC_URL ?>/admin/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $rl->owner_name; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $rl->owner_email; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $rl->rest_name; ?></p>
                        <p class="text-xs text-secondary mb-0"><?php echo $rl->rest_mobile; ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        
                        <!-- <span class="badge badge-sm bg-gradient-success">Published</span> -->
                         
                          <span class="badge badge-sm <?php echo $rl->is_listed == 0 ? 'bg-gradient-secondary' : 'bg-gradient-success'; ?>"><?php echo $rl->is_listed == 0 ? 'Unpublished' : 'Published'?></span>
                          
                        
                      </td>
                      
                      <td class="align-middle">
                        <a href="/<?php echo home . "/restaurant-info/?rid=" . $rl->id; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          View
                        </a>
                      </td>
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
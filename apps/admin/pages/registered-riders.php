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
              <h6>Registered Riders List</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mobile</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
              
              $userObj = new Model('pk_user');
              $user_list = $userObj->filter_index(array('is_active' => true , 'is_driver' => true));
              foreach ($user_list as $ul) {
                $ul = (object) $ul;
              ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $ul->first_name; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $ul->email; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $ul->mobile; ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        
                        <span class="badge badge-sm bg-gradient-success">Listed</span>
                         
                          
                          
                        
                      </td>
                      
                      <td class="align-middle">
                        <a href="" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
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
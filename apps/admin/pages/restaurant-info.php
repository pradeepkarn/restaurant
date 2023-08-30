<?php
$restaurant_list = getData('restaurant_listing',$_GET['rid']);
$rl = obj($restaurant_list);
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
    <div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="/<?php echo STATIC_URL ?>/admin/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                Sayo Kravits
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                Public Relations
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                    <i class="ni ni-app"></i>
                    <span class="ms-2">App</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-email-83"></i>
                    <span class="ms-2">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-settings-gear-65"></i>
                    <span class="ms-2">Settings</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Restaurant Information</p>
                <button class="btn btn-primary btn-sm ms-auto">Settings</button>
              </div>
            </div>
            <form id="rest_form" action="/<?php echo home; ?>/update-restaurant-ajax" method="POST">
            <div class="card-body">
              <p class="text-uppercase text-sm">Owner Information</p>
                <div class="info_txt">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Full name</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->owner_name; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Email address</label>
                        <input class="form-control" type="email" disabled value="<?php echo $rl->owner_email; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Owner Mobile</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->owner_mobile; ?>">
                      </div>
                    </div>
                  </div>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Restaurant Information</p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Name</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->rest_name; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Address</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->rest_address; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Loaction</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->rest_location; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Latitude</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->latitude; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Longitude</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->longitude; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Mobile</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->rest_mobile; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Restaurant Landline</label>
                        <input class="form-control" type="text" disabled value="<?php echo $rl->rest_landline; ?>">
                      </div>
                    </div>
                  </div>

                </div>
              
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Restaurant Status</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Status</label>
                    <select class="form-control" name="rs_status" id="exampleFormControlSelect1">
                      <!-- <option <?php echo $rl->is_listed == $rl->is_listed ? 'selected' : null; ?> value="<?php echo $rl->is_listed?>"><?php echo $rl->is_listed == 0 ? 'Unpublished' : 'Published'?></option> -->
                      <option <?php echo $rl->is_listed == 0 ? 'selected' : null; ?> value="0">Unpublished</option>
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
        </div>
        <?php pkAjax_form("#uprest_btn", "#rest_form", "#rest"); ?>
        
        <!-- <div class="col-md-4">
          <div class="card card-profile">
            <img src="/<?php echo STATIC_URL ?>/admin/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-4 col-lg-4 order-lg-2">
                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                  <a href="javascript:;">
                    <img src="/<?php echo STATIC_URL ?>/admin/img/team-2.jpg" class="rounded-circle img-fluid border border-2 border-white">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
              <div class="d-flex justify-content-between">
                <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i class="ni ni-email-83"></i></a>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-center">
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">22</span>
                      <span class="text-sm opacity-8">Friends</span>
                    </div>
                    <div class="d-grid text-center mx-4">
                      <span class="text-lg font-weight-bolder">10</span>
                      <span class="text-sm opacity-8">Photos</span>
                    </div>
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">89</span>
                      <span class="text-sm opacity-8">Comments</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center mt-4">
                <h5>
                  Mark Davis<span class="font-weight-light">, 35</span>
                </h5>
                <div class="h6 font-weight-300">
                  <i class="ni location_pin mr-2"></i>Bucharest, Romania
                </div>
                <div class="h6 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i>University of Computer Science
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      
      <?php
      import("apps/admin/inc/footer.php");
      ?>
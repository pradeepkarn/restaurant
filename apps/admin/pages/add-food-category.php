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
                <p class="mb-0">Add Food Category</p>
                <!-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
              </div>
            </div>
            <form id="cat_form" action="/<?php echo home; ?>/upload-category-ajax" method="POST">
            <div class="card-body">
              <p class="text-uppercase text-sm">Food Information</p>
                <div class="info_txt">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Title</label>
                        <input class="form-control" type="text" name="food_title" value="">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Description</label>
                        <textarea class="form-control" rows="10" name="food_description" aria-label="With textarea"></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Slug</label>
                        <input class="form-control" type="text" name="food_slug" value="">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Banner</label>
                        <input class="form-control" type="file" name="food_category_image" value="">
                      </div>
                    </div>
                  </div>
                
                </div>
              
              <div id="fcat"></div>
              <button type="button" id="upcat_btn" class="btn btn-primary btn-sm">Upload</button>
            </div>
            </form>
          </div>
        </div>
        <?php pkAjax_form("#upcat_btn", "#cat_form", "#fcat"); ?>
        
        
      </div>
      
      <?php
      import("apps/admin/inc/footer.php");
      ?>
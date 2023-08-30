<?php
$home = home;
if (!isset($_GET['cid'])) {
   header("Location: /$home");
   exit;
}
if (!intval($_GET['cid'])) {
    header("Location: /$home");
    exit;
}
$fcat = getData('content',$_GET['cid']);
if ($fcat==false) {
    header("Location: /$home");
    exit;
 }
 if ($fcat['content_group']!='listing_category') {
    header("Location: /$home");
    exit;
 }
 $fc = obj($fcat);
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
                <p class="mb-0">Edit Food Category</p>
                <!-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
              </div>
            </div>
            <form id="upcat_form" action="/<?php echo home; ?>/update-category-ajax" method="POST">
            <div class="card-body">
              <p class="text-uppercase text-sm">Food Information</p>
                <div class="info_txt">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Title</label>
                        <input class="form-control" type="text" name="food_title" value="<?php echo $fc->title; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Description</label>
                        <textarea class="form-control" rows="10" name="food_description" aria-label="With textarea"><?php echo $fc->content_info; ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Category Image</label>
                        <img id="banner" style="width:100%; height:250px; object-fit:contain;" src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $fc->banner; ?>" alt="<?php echo $fc->title; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Slug</label>
                        <input class="form-control" type="text" name="food_slug" value="<?php echo $fc->slug; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Banner</label>
                        <input class="form-control" id="image-input" type="file" name="banner" value="">
                      </div>
                    </div>
                  </div>
                
                </div>
              
              <div id="upfcat"></div>
              <input type="hidden" name="food_cat_id" value="<?php echo $fc->id; ?>">
              <button type="button" id="updcat_btn" class="btn btn-primary btn-sm">Update</button>
            </div>
            </form>
          </div>
        </div>
        <?php pkAjax_form("#updcat_btn", "#upcat_form", "#upfcat"); ?>
        
        <script>
    const imageInputPost = document.getElementById('image-input');
    const imagePost = document.getElementById('banner');

imageInputPost.addEventListener('change', (event) => {
  const file = event.target.files[0];
  const fileReader = new FileReader();

  fileReader.onload = () => {
    imagePost.src = fileReader.result;
  };

  fileReader.readAsDataURL(file);
});

</script>
        
      </div>
      
      <?php
      import("apps/admin/inc/footer.php");
      ?>
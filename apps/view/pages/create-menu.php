<?php
$prod = getData('restaurant_listing',$_GET['rid']);
$fid = $_GET['rid'];
if ($prod==false) {
    header("Location: /$home");
    exit;
 }
 
 $rn = obj($prod);
?>


<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Create Menu</h2>
            <p>Home / <span>Create Menu</span></p>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <div class="col-8 ps-4 coup_form">
            <div class="row g-3 mb-2">
            <div id="up_menu"></div>
                <div class="col-12 coupon_cl">
                    <h4 class="m-0">Create Menu</h4>
                </div>
                <form id="menu_up_form" action="/<?php echo home; ?>/upload-menu-ajax" method="POST" enctype="multipart/form-data">
                <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Restaurant Name</label>
                    <input type="text" disabled value="<?php echo $rn->rest_name; ?>" name="restaurant" class="form-control" id="validationDefault05">
                    <input type="hidden" value="<?php echo $rn->id; ?>" name="rest_name" class="form-control" id="validationDefault05">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Menu Name</label>
                    <input type="text" placeholder="Menu Name" name="menu_name" class="form-control" id="validationDefault05">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="validationDefault01" class="form-label">Menu Description</label>
                    <textarea type="text" placeholder="Menu Description" name="menu_desc" rows="5" class="form-control" id="validationDefault07"></textarea>
                </div>
                
              <p class="mb-0"><strong>Upload Menu Image</strong></p>
              <div class="myclone">
                        <div class="clone-child">
                        <div class="row mt-4 mb-4">
                        <div class="col-md-7 mb-1 veri_d">
                                <input type="file" class="form-control" name="menu_img[]" id="validationDefault02">
                            </div>
                            <div class="col-md-5 mb-1 rg_file">
                                <button type="button" onclick="duplicateMenuImage()" class="btn btn-primary me-3">Add More</button>
                                <!-- <button type="button" class="btn btn-primary me-3">Verify</button> -->
                            </div>
                        </div>
                        </div>
                        </div>
                
                </div>
                
                <button class="btn btn-outline-primary" id="menu_up_btn">UPLOAD</button>
                </form>

            </div>
            <?php pkAjax_form("#menu_up_btn", "#menu_up_form", "#up_menu"); ?>
        </div>
    </div>
</div>

<script>
    function duplicateMenuImage() {
    const parentDiv = document.getElementsByClassName('myclone')[0];
    const formClone = parentDiv.children[0].cloneNode(true);
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.classList.add('btn', 'btn-danger');
    deleteButton.onclick = function() {
        parentDiv.removeChild(formClone);
    };
    formClone.getElementsByClassName('rg_file')[0].appendChild(deleteButton); // Append the "Delete" button to col-md-5
    parentDiv.appendChild(formClone);
}
</script>

<?php
import("apps/view/inc/footer.php");
?>
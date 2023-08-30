<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>

<div class="container-fluid checkout_banner mt-5">
    <div class="row">
        <div class="col-12 text-center pt-5 pb-5 check_new">
            <h2>Food Listing</h2>
            <p>Home / <span>Food Listing</span></p>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <div class="col-8 ps-4 coup_form">
            <div class="row g-3 mb-2">
                <div class="col-12 coupon_cl">
                    <h4 class="m-0">Food Listing</h4>
                </div>
                <form id="food_up_form" action="/<?php echo home; ?>/upload-food-ajax" method="POST" enctype="multipart/form-data">
                <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault01" class="form-label">Restaurant Name</label>
                    <select class="form-select" name="rst_name" id="validationDefault04">
                        <?php
                        $userObj = new Model('restaurant_listing');
                        $restaurant_list = $userObj->filter_index(array('is_listed' => true, 'user_id' => $_SESSION['user_id']));
                        ?>
                        <?php
                        foreach ($restaurant_list as $rl) {
                            $rl = (object) $rl;
                        ?>
                            <option selected value="<?php echo $rl->id; ?>"><?php echo $rl->rest_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="validationDefault01" class="form-label">Food Category</label>
                    <select class="form-select" name="food_cat" id="validationDefault04">
                        <?php
                        $userObj = new Model('content');
                        $food_category = $userObj->filter_index(array('content_group' => 'listing_category'));
                        ?>
                        <?php
                        foreach ($food_category as $fc) {
                            $fc = (object) $fc;
                        ?>
                            <option selected value="<?php echo $fc->id; ?>"><?php echo $fc->title; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Item Name</label>
                    <input type="text" placeholder="Item Name" name="food_name" class="form-control" id="validationDefault05">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Item Price</label>
                    <input type="text" placeholder="Item Price" name="food_price" class="form-control" id="validationDefault06">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="validationDefault01" class="form-label">Item Description</label>
                    <textarea type="text" placeholder="Item Description" name="food_desc" rows="5" class="form-control" id="validationDefault07"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Ingridients (Optional)</label>
                    <input type="text" name="food_ingridients" placeholder="Ingridients (Optional)" class="form-control" id="validationDefault08">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01" class="form-label">Dietary Information (optional)</label>
                    <input type="text" name="food_info" placeholder="Dietary Information (optional)" class="form-control" id="validationDefault09">
                </div>
                <div class="col-md-12">
                    <label for="validationDefault01" class="form-label">Food Images</label>
                    <div class="myclone">
                        <div class="clone-child">
                            <input type="file" name="food_img[]" class="form-control" id="validationDefault05">
                            <button id="" type="button" onclick="duplicateTextarea();" class="btn btn-primary my-3">Add More</button>
                        </div>
                    </div>
                </div>
                </div>
                <div id="up_food"></div>
                <button class="btn btn-outline-success" id="foodup_btn">UPLOAD</button>
                </form>

            </div>
            <?php pkAjax_form("#foodup_btn", "#food_up_form", "#up_food"); ?>
        </div>
    </div>
</div>


<script>
    function duplicateTextarea() {
        const parentDiv = document.getElementsByClassName('myclone')[0];
        const formClone = parentDiv.children[0].cloneNode(true);
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('btn', 'btn-danger', 'my-3');
        deleteButton.onclick = function() {
            parentDiv.removeChild(formClone);
        };
        formClone.appendChild(deleteButton);
        parentDiv.appendChild(formClone);
    }
</script>

<?php
import("apps/view/inc/footer.php");
?>
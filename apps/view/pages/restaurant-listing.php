<?php
import("apps/view/inc/header.php");
?>
<?php
import("apps/view/inc/navbar.php");
?>
<div style="border-top: 2px solid rgb(232, 232, 232);"></div>


<div class="container mt-5 mb-5">
    <div class="row justify-content-center rs_ls">
        <div class="col-2">
            <div class="main_lft mb-5">
                <div class="lft_box mb-4">
                    <h6>Restaurant Information</h6>
                    <p>Restaurant name, address, contact no., owner details</p>
                </div>
                <div class="lft_box mb-4">
                    <h6>Restaurant Type & Timings</h6>
                    <p>Establishment & cuisine type, opening hours</p>
                </div>
                <div class="lft_box mb-4">
                    <h6>Upload Images</h6>
                    <p>Menu, restaurant, food images</p>
                </div>
            </div>
            <div class="main_lft mb-5">
                <div class="lft_box mb-1">
                    <h6>2. Register for Online ordering</h6>
                </div>
            </div>
        </div>
        <div class="col-7">
            <h1 class="mb-5 rest_in">Restaurant Information</h1>
            <form id="rest_list_form" action="/<?php echo home; ?>/restaurant-list-ajax" method="POST">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed a_first" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Restaurant details
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="col-md-12 mb-4">
                            <input type="text" class="form-control" name="rest_name" id="validationDefault01" placeholder="Resturant name">
                          </div>
                          <div class="col-md-12 mb-4">
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
                          <div class="col-md-12 mb-4">
                            <input type="text" class="form-control" name="rest_address" id="validationDefault02" placeholder="Resturant complete address">
                          </div>
                          <div class="loc_pr">
                            <p class="mb-2">Please place the pin accurately at your outlet’s location on the map</p>
                            <span>This will help your customers and Deal City riders to locate your store</span>
                          </div>
                          <div class="col-md-12 mt-4 mb-4">
                            <input type="text" class="form-control" name="rest_location" id="validationDefault02" placeholder="Enter your restaurant’s locality, eg. Sector 43, Gurgaon">
                          </div>
                          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62466.34445608096!2d37.85909472181666!3d0.5478102006096021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182780d08350900f%3A0x403b0eb0a1976dd9!2sKenya!5e0!3m2!1sen!2sin!4v1689310560593!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                          <div class="dec text-center pt-3 pb-3">
                            <p>or directly enter the co-ordinates</p>
                          </div>
                          <div class="row">
                              <div class="col-md-6 mb-1">
                                <input type="text" class="form-control" name="latitude" id="validationDefault02" placeholder="Latitude">
                              </div>
                              <div class="col-md-6 mb-1">
                                <input type="text" class="form-control" name="longitude" id="validationDefault02" placeholder="Longitude">
                              </div>
                          </div>
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed a_first" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Contact number at restaurant
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse show" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-9 mb-1">
                              <input type="number" class="form-control" name="rest_mobile" id="validationDefault02" placeholder="Mobile number at restaurant">
                            </div>
                            <div class="col-md-3 mb-1 veri_d">
                                <button type="button" class="btn btn-secondary">Verify</button>
                            </div>
                        </div>
                        <div class="dec text-center pt-4 pb-4">
                            <p class="m-0">or want to share landline number</p>
                          </div>
                          <div class="row">
                            <div class="col-md-9 mb-1">
                              <input type="number" class="form-control" name="rest_landline" id="validationDefault02" placeholder="STD code | Landline number">
                            </div>
                            <div class="col-md-3 mb-1 veri_d">
                                <button type="button" class="btn btn-secondary">Verify</button>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed a_first" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Restaurant owner details
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse show" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-9 mb-1">
                              <input type="number" class="form-control" name="owner_mobile" id="validationDefault02" placeholder="Mobile number of owner">
                            </div>
                            <div class="col-md-3 mb-1 veri_d">
                                <button type="button" class="btn btn-secondary">Verify</button>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-md-6 mb-1">
                              <input type="text" class="form-control" name="owner_name" id="validationDefault02" placeholder="Restaurant owner full name">
                            </div>
                            <div class="col-md-6 mb-1 veri_d">
                                <input type="text" class="form-control" name="owner_email" id="validationDefault02" placeholder="Restaurant owner email address">
                            </div>
                            <div class="col-md-6 mb-1 mt-3 veri_d">
                                <input type="password" class="form-control" name="password" id="validationDefault02" placeholder="Restaurant Password">
                            </div>
                            <div class="col-md-6 mb-1 mt-3 veri_d">
                                <input type="password" class="form-control" name="owner_cnf_pass" id="validationDefault02" placeholder="Confirm Restaurant Password">
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed a_first" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Restaurant Price and Timings
                      </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse show" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                              <input type="text" class="form-control" name="timings" id="validationDefault02" placeholder="Restaurant opening and closing timings Eg. 10:00 AM To 11:00 PM">
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-md-6 mb-1">
                              <input type="text" class="form-control" name="priceforone" id="validationDefault02" placeholder="Price for one Eg. ₹250 for one">
                            </div>
                            <div class="col-md-6 mb-1 veri_d">
                                <input type="text" class="form-control" name="food_time" id="validationDefault02" placeholder="Time to make food Eg. 25-35 min">
                            </div>
                        </div>
                        <div class="myclone">
                        <div class="clone-child">
                        <div class="row mt-4 mb-4">
                        <div class="col-md-7 mb-1 veri_d">
                                <input type="file" class="form-control" name="rest_banner_img[]" id="validationDefault02">
                            </div>
                            <div class="col-md-5 mb-1 rg_file">
                                <button type="button" onclick="duplicateImagefile();" class="btn btn-primary me-3">Add More</button>
                                <!-- <button type="button" class="btn btn-primary me-3">Verify</button> -->
                            </div>
                        </div>
                        </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  
            </div>
            <p class="pay_cl">Deal City may disclose the information provided by you, including but not limited to the contact number and email address of the authorised persons, with third party service providers for provision of Deal City services</p>
            <div id="listrs"></div>
            <button id="myrest_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <?php pkAjax_form("#myrest_btn", "#rest_list_form", "#listrs"); ?>
</div>

<script>
    function duplicateImagefile() {
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
<?php 
    headerAdmin($data);
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="free-tab" data-bs-toggle="tab" data-bs-target="#free" type="button" role="tab" aria-controls="free" aria-selected="true">Free shipping</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="flat-tab" data-bs-toggle="tab" data-bs-target="#flat" type="button" role="tab" aria-controls="flat" aria-selected="true">Flat rate</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="city-tab" data-bs-toggle="tab" data-bs-target="#city" type="button" role="tab" aria-controls="city" aria-selected="false">Per city</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane show active" id="free" role="tabpanel" aria-labelledby="free-tab">
                        <div class="mt-3 container">
                            <h3 class="text-primary">Free shipping</h3>
                            <p>Give free shipping to your buyers at your own cost. Recommended to gain customer fidelity and increase your sales.</p>
                            <form>
                                <input type="hidden" class="idShipping" name="idShipping" value="1">
                                <?php if($_SESSION['permitsModule']['u']){?>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btnShipping">Save</button>
                                </div>
                                <?php }?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="flat" role="tabpanel" aria-labelledby="flat-tab">
                        <div class="mt-3 container">
                            <h3 class="text-primary">Flat rate</h3>
                            <p>The shipping value is the same for all cities and countries.</p>
                            <form>
                                <input type="hidden" class="idShipping" name="idShipping" value="2">
                                <div class="mb-3">
                                    <label for="intValue" class="form-label">Shipping value</label>
                                    <input type="number" class="form-control" id="intValue" name="intValue" value="<?=$data['flat']?>" placeholder="<?=MS." 0 ".MD?>">
                                </div>
                                <?php if($_SESSION['permitsModule']['u']){?>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btnShipping">Save</button>
                                </div>
                                <?php }?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="city" role="tabpanel" aria-labelledby="city-tab">
                        <div class="mt-3 container">
                            <h3 class="text-primary">Rate per city</h3>
                            <p>You can put a shipping cost depending of the country, state and city.</p>
                            <form>
                                <input type="hidden" class="idShipping" name="idShipping" value="3">
                                <?php if($_SESSION['permitsModule']['w']){?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Country</label>
                                            <select class="form-control" aria-label="Default select example" id="countryList" name="countryList" required>
                                                <option selected value="0">Select</option>
                                                <?php foreach ($data['countries'] as $countries) {?>
                                                    
                                                <option value="<?=$countries['id']?>"><?=$countries['name']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">State</label>
                                            <select class="form-control" aria-label="Default select example" id="stateList" name="stateList" required>
                                                <option selected value="0">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">City</label>
                                            <select class="form-control" aria-label="Default select example" id="cityList" name="cityList" required>
                                                <option selected value="0">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleFormControlInput1" class="form-label">Value</label>
                                        <div class="mb-3 d-flex">
                                            <input type="number" class="form-control" id="valueCity" name="intValue" placeholder="<?=MS." 0 ".MD?>">
                                            <button type="button" class="btn btn-primary" id="addCity">+</button>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="scroll-y ps-2 pe-2">
                                    <table class="table text-center items align-middle">
                                        <tbody id="listItem">
                                            <?php if($data['ShippingCities']!==""){?>
                                                <?=$data['ShippingCities']?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if($_SESSION['permitsModule']['u']){?>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary btnShipping">Save</button>
                                </div>
                                <?php }?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
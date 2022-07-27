<?php
    headerPage($data);
    $products = $data['products'];
?>
    <div id="modalItem"></div>
    <main id="<?=$data['page_name']?>">
        <div class="popup">
            <div class="popup-close">X</div>
            <div class="popup-info">
                <img src="" alt="">
                <div class="h-100">
                    <a href="product.html">Product 1</a>
                    <p>Has been added to your cart</p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center text-center mt-3">
                <a href="<?=base_url()?>/shop/cart" class="btnc w-50 p-1 btnc-primary me-4">View Cart</a>
                <div class="btnc w-50 h-100 p-1 btnc-primary c-p" id="btnCheckOutPopup">Checkout</div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 mb-5">
                <h1 class="text-center">My wishlist</h1>
                <div class="col-lg-12 mt-5">
                    <table class="table table-borderless text-center table-cart">
                        <thead class="position-relative af-b-line">
                          <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i=0; $i < count($products) ; $i++) { 
                                    $idProduct = openssl_encrypt($products[$i]['idproduct'],METHOD,KEY);
                                    $price ='<p class="m-0 fs-5 t-p"><strong>'.formatNum($products[$i]['price']).'</strong></p>';
                                    $btnAdd ='<button type="button" class="btn btn-primary product-card-add" data-id="'.$idProduct.'">Add to cart</a>';
                                    $discount="";
                                    $rate="";

                                    if($products[$i]['status'] == 1 && $products[$i]['stock']>0){
                                        if($products[$i]['discount']>0){
                                            $price = '<p class="m-0 fs-5"><strong class="t-p">'.formatNum($products[$i]['priceDiscount']).' </strong><span class="text-decoration-line-through t-s fs-6">'.formatNum($products[$i]['price']).'</span></p>';
                                            $discount ='<div class="position-absolute top-0 end-0 border border-primary t-p pe-1 ps-1 fw-bold bg-w">-'.$products[$i]['discount'].'%</div>';
                                        }
                                    }else if($products[$i]['status'] == 1 && $products[$i]['stock']==0){
                                        $btnAdd="";
                                        $price='<p class="m-0 fs-5 text-danger">Sold out</p>';
                                    }else{
                                        $btnAdd ="";
                                        $price="";
                                    }
                            ?>
                          <tr data-id="<?=$idProduct?>">
                            <td>
                                <div class="position-relative">
                                    <img src="<?= $products[$i]['url']?>"  class="p-2" height="100px" width="100px" alt="<?= $products[$i]['name']?>">
                                    <div class="btn-del top-0 start-0">x</div>
                                    <?=$discount?>
                                </div>
                            </td>
                            <td>
                                <a href="<?=base_url()."/shop/product/".$products[$i]['route']?>"><?= $products[$i]['name']?></a>
                            </td>
                            <td><?=$price?></td>
                            <td>
                                <div class="wishlist-actions">
                                    <button type="button" class="btn me-2 quickView border border-dark" data-id="<?=$idProduct?>">Quick view</button>
                                    <?=$btnAdd?>
                                </div>
                            </td>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>
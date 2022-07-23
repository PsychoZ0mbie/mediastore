<?php
    headerPage($data);
    $qtyCart = 0;
    $total = 0;
    $arrProducts = array();
    if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
        $arrProducts = $_SESSION['arrCart'];
        foreach ($arrProducts as $product) {
            $qtyCart += $product['qty'];
            if($product['discount']>0){
                $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
            }else{
                $total+=$product['qty']*$product['price'];
            }
        }
    }
?>
    <main id="cart">
        <div class="container">
            <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop">Shop</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </nav>
            <?php if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){?>
            <div class="row mb-5">
                <div class="col-lg-8 mt-5">
                    <table class="table table-borderless text-center table-cart">
                        <thead class="position-relative af-b-line">
                          <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                                for ($i=0; $i <count($arrProducts) ; $i++) { 
                                    $discount="";
                                    $price="";
                                    $priceHtml="";
                                    $totalPerProduct=0;

                                    if($arrProducts[$i]['discount']>0){
                                        $price = $arrProducts[$i]['price']-($arrProducts[$i]['price']*($arrProducts[$i]['discount']*0.01));
                                        $priceHtml = formatNum($price).' <span class="text-decoration-line-through t-p"> '.formatNum($arrProducts[$i]['price']).'</span>';
                                    }else{
                                        $price = $arrProducts[$i]['price'];
                                        $priceHtml = formatNum($arrProducts[$i]['price']);
                                    }
                                    if($arrProducts[$i]['discount']>0){
                                        $discount ='<div class="position-absolute top-0 end-0 border border-primary t-p pe-1 ps-1 fw-bold bg-w">-'.$arrProducts[$i]['discount'].'%</div>';
                                    }

                                    $totalPerProduct = formatNum($price*$arrProducts[$i]['qty']);
                            ?>     
                          <tr>
                            <td>
                                <div class="position-relative">
                                    <img src="<?=$arrProducts[$i]['image']?>"  class="p-2" height="100px" width="100px" alt="<?=$arrProducts[$i]['name']?>">
                                    <div class="btn-del top-0 start-0">x</div>
                                    <?=$discount?>
                                </div>
                            </td>
                            <td>
                                <a href="<?=$arrProducts[$i]['url']?>"><?=$arrProducts[$i]['name']?></a>
                            </td>
                            <td><?=$priceHtml?></td>
                            <td>
                                <div class="product-cant">
                                    <div class="decrement"><i class="fas fa-minus"></i></div>
                                    <input class="cant me-2 ms-2" type="number" min="1" max="<?=$arrProducts[$i]['stock']?>" data-id="<?=$arrProducts[$i]['idproduct']?>" value="<?=$arrProducts[$i]['qty']?>">
                                    <div class="increment"><i class="fas fa-plus"></i></div>
                                </div>
                            </td>
                            <td class="totalPerProduct"><?=$totalPerProduct?></td>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                </div>
                <div class="col-lg-4 mt-5 ">
                    <h3 class="t-p">RESUME</h3>
                    <div class="mb-3 position-relative pb-1 af-b-line">
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0 fw-bold">Subtotal</p>
                            <p class="m-0" id="subtotal"><?=formatNum($total)?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0 fw-bold">Total</p>
                            <p class="m-0 fw-bold" id="totalProducts"><?=formatNum($total)?></p>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="button-addon2">
                        <button class="btn btnc-primary" type="button" id="button-addon2">+</button>
                    </div>
                    <a href="checkout.html" class="w-100 btn btnc-primary">Proceed to checkout</a>
                </div>
            </div>
            <?php }else {?>
                <div class="d-flex justify-content-center align-items-center p-5 text-center">
                    <div>
                        <p>No products in your cart.</p>
                        <a href="<?=base_url()?>/shop" class="btn btnc-primary">Go shopping now</a>
                    </div>
                </div>
            <?php }?>
        </div>
    </main>
<?php
    footerPage($data);
?>
<?php
    headerPage($data);
    $qtyCart = 0;
    $total = $data['total']['total'];
    $subtotal = $data['total']['subtotalCoupon'] >0 ? $data['total']['subtotalCoupon'] : $data['total']['subtotal'];
    $subtotalCoupon = $data['total']['subtotal'];
    $arrProducts = array();
    $arrShipping = $data['shipping'];

?>
    <main id="cart">
        <div class="container">
            <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop">Shop</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </nav>
            <?php if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){ $arrProducts = $_SESSION['arrCart'];?>
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
                    <?php if(!isset($_SESSION['couponInfo'])){?>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="formCoupon">
                                <div class="input-group">
                                    <input type="text" id="txtCoupon" name="txtCoupon" class="form-control" placeholder="Your coupon code" aria-label="Coupon code" aria-describedby="button-addon2">
                                    <button class="btn btnc-primary" type="button" id="btnCoupon">+</button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="alertCoupon" role="alert"></div>
                            </form>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="col-lg-4 mt-5 ">
                    <h3 class="t-p">RESUME</h3>
                    <div class="mb-3 position-relative pb-1 af-b-line">
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0 fw-bold">Subtotal:</p>
                            <p class="m-0" id="subtotal"><?=formatNum($subtotal)?></p>
                        </div>
                        <?php if(isset($_SESSION['couponInfo'])){?>
                        
                        <div class="mb-3">
                            <p class="m-0 fw-bold">Coupon:</p>
                            <div class="d-flex justify-content-between ">
                                <p class="m-0"><?=$_SESSION['couponInfo']['code']?></p>
                                <p class="m-0">-<?=$_SESSION['couponInfo']['discount']?>%</p>
                            </div>
                            <button type="button" class="btn t-p p-0" id="removeCoupon">Remove coupon</button>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0 fw-bold">Subtotal:</p>
                            <p class="m-0" id="subtotalCoupon"><?=formatNum($subtotalCoupon)?></p>
                        </div>
                        <?php }?>
                        
                        <p class="m-0 fw-bold">Shipping:</p>
                        <?php if($arrShipping['id']!=3){?>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0"><?=$arrShipping['name']?>:</p>
                            <p class="m-0"><?=formatNum($arrShipping['value'])?></p>
                        </div>
                        <?php }else{?>
                            <label for="exampleFormControlInput1" class="form-label"><?=$arrShipping['name']?>:</label>
                            <select class="form-select" aria-label="Default select example" id="selectCity" name="selectCity">
                                <option value ="0" selected>Select a city</option>
                                <?php for ($i=0; $i < count($arrShipping['cities']); $i++) { ?>
                                <option value="<?=$arrShipping['cities'][$i]['id']?>"><?=$arrShipping['cities'][$i]['city']." - ".formatNum($arrShipping['cities'][$i]['value'])?></option>
                                <?php }?>
                            </select>
                        <?php }?>
                        <div class="d-flex justify-content-between mb-3 mt-3">
                            <p class="m-0 fw-bold">Total</p>
                            <p class="m-0 fw-bold" id="totalProducts"><?=formatNum($total)?></p>
                        </div>
                    </div>
                    <!--<div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="button-addon2">
                        <button class="btn btnc-primary" type="button" id="button-addon2">+</button>
                    </div>-->
                    <?php if(isset($_SESSION['login']) && isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){ ?>
                    <a href="<?=base_url()?>/shop/checkout" class="mb-3 w-100 btn btnc-primary">Checkout</a>
                    <?php }else{ ?>
                    <button type="button" onclick="openLoginModal();" class="mb-3 w-100 btn btnc-primary">Checkout</button>
                    <?php }?>
                    <a href="<?=base_url()?>/shop" class="w-100 btn btn-dark">Continue shopping</a>
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
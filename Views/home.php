<?php
    headerPage($data);
    $slider = $data['slider'];
    $categories1 = $data['category1'];
    $categories2 = $data['category2'];
    $products = $data['products'];
    $popProducts = $data['popProducts'];
    //dep($products);exit;
?>
    <div id="modalItem"></div>
    <div id="modalPoup"></div>
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
                <?php if(isset($_SESSION['login']) && isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){ ?>
                <a href="<?=base_url()?>/shop/checkout" class="btnc w-50 p-1 btnc-primary">Checkout</a>
                <?php }else{ ?>
                    <div type="button" onclick="openLoginModal();" class="btnc w-50 h-100 p-1 btnc-primary">Checkout</div>
                <?php }?>
            </div>
        </div>
        <section>
            <div id="carouselExampleControls" class="carousel slide main-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                <?php
                    for ($i=0; $i < count($slider) ; $i++) { 
                        $route = base_url()."/shop/product/".$slider[$i]['route'];
                        $routeC = base_url()."/shop/category/".$slider[$i]['routec'];
                        if($i == 0){
                ?>
                <div class="carousel-item active">
                    <img src="<?=$slider[$i]['url']?>" alt="<?=$slider[$i]['name']?>">
                    <div class="carousel-info">
                        <h2><a href="<?=$routeC?>" class="text-decoration-none t-p"><?=$slider[$i]['category']?></a></h2>
                        <h3>GET THE <?=$slider[$i]['name']?> </h3>
                        <h4>With <strong class="t-p"><?=$slider[$i]['discount']?>%</strong> discount!</h4>
                        <p class="mb-3"><strong><?=$slider[$i]['priceDiscount']?></strong> <span><?=$slider[$i]['price']?></span></p>
                        <a href="<?=$route?>" class="btnc btnc-primary">Shop Now</a>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="carousel-item">
                    <img src="<?=$slider[$i]['url']?>" alt="<?=$slider[$i]['name']?>">
                    <div class="carousel-info">
                        <h2><a href="<?=$routeC?>" class="text-decoration-none t-p"><?=$slider[$i]['category']?></a></h2>
                        <h3>GET THE <?=$slider[$i]['name']?> </h3>
                        <h4>With <strong class="t-p"><?=$slider[$i]['discount']?>%</strong> discount!</h4>
                        <p class="mb-3"><strong><?=$slider[$i]['priceDiscount']?></strong> <span><?=$slider[$i]['price']?></span></p>
                        <a href="<?=$route?>" class="btnc btnc-primary">Shop Now</a>
                    </div>
                </div>
                <?php } }?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <section>
            <div class="container mt-5 mb-5">
                <h3 class="t-p"><strong>CATEGORIES</strong></h3>
                <div class="row">
                    <?php 
                        for ($i=0; $i < count($categories1); $i++) { 
                            $route = base_url()."/shop/category/".$categories1[$i]['route'];
                            $url = media()."/images/uploads/".$categories1[$i]['picture'];
                        
                    ?>
                    <div class="col-md-4">
                        <a href="<?=$route?>" class="text-decoration-none">
                            <div class="category">
                                <img src="<?=$url?>" alt="<?=$categories1[$i]['name']?>">
                                <div class="category-info">
                                    <h3><strong><?=$categories1[$i]['name']?></strong></h3>
                                </div>
                                <a href="<?=$route?>" class="category-btn"><strong>Shop now</strong></a>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="t-p"><strong>NEW PRODUCTS</strong></h3>
                <div class="row mt-5">
                <?php
                    for ($i=0; $i < count($products) ; $i++) { 
                        $idProduct = openssl_encrypt($products[$i]['idproduct'],METHOD,KEY);
                        $favorite = '';
                        $routeP = base_url()."/shop/product/".$products[$i]['route'];
                        $routeC = base_url()."/shop/category/".$products[$i]['routec'];
                        $price ='<p class="m-0 fs-5 product-price"><strong>'.formatNum($products[$i]['price']).'</strong></p>';
                        $btnAdd ='<button type="button" class="btn btn-primary product-card-add" data-id="'.$idProduct.'">Add to cart</a>';
                        $discount="";
                        $rate="";
                        if($products[$i]['favorite']== 0){
                            $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                        }else{
                            $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 active"><i class="fas fa-heart text-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                        }
                        if($products[$i]['status'] == 1 && $products[$i]['stock']>0){
                            if($products[$i]['discount']>0){
                                $price = '<p class="m-0 fs-5 product-price"><strong>'.formatNum($products[$i]['priceDiscount']).'</strong><span>'.formatNum($products[$i]['price']).'</span></p>';
                                $discount ='<p class="product-discount">-'.$products[$i]['discount'].'%</p>';
                            }
                        }else if($products[$i]['status'] == 1 && $products[$i]['stock']==0){
                            $btnAdd="";
                            $price='<p class="m-0 fs-5 product-price text-danger">Sold out</p>';
                        }else{
                            $btnAdd ="";
                            $price="";
                        }
                        for ($j=0; $j < 5; $j++) { 
                            if($products[$i]['rate']!=null && $j >= intval($products[$i]['rate'])){
                                $rate.='<i class="far me-1 fa-star"></i>';
                            }else if($products[$i]['rate']==null){
                                $rate.='<i class="far me-1 fa-star"></i>';
                            }else{
                                $rate.='<i class="fas me-1 fa-star"></i>';
                            }
                        }
                ?> 
                <div class="col-md-3" data-id="<?=$idProduct?>">
                    <div class="product-card">
                        <?=$discount?>
                        <div class="product-img">
                            <img src="<?=$products[$i]['url']?>" alt="<?=$products[$i]['name']?>">
                            <?=$btnAdd?>
                        </div>
                        <div class="product-info">
                            <a class="m-0 product-category fw-bold" href="<?=$routeC?>"><?=$products[$i]['category']?></a>
                            <a href="<?=$routeP?>">
                                <h3 class="product-title fw-bold"><?=$products[$i]['name']?></h3>
                                <?=$price?>
                            </a>
                        </div>
                        <div class="product-rate">
                            <?=$rate?>
                        </div>
                        <div class="product-btns">
                            <?=$favorite?>
                            <button type="button" class="btn quickView pe-2 ps-2" data-id="<?=$idProduct?>"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></button>
                        </div>
                    </div>
                </div>
                <?php  }?>
                </div>
            </div>
        </section>
        <section>
            <div class="container mt-4 mb-4">
                <div class="row">
                    <?php 
                        for ($i=0; $i < count($categories2) ; $i++) { 
                            $route = base_url()."/shop/category/".$categories2[$i]['route'];
                            $url = media()."/images/uploads/".$categories2[$i]['picture'];
                            
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="more-category">
                            <img src="<?=$url?>" alt="<?=$categories2[$i]['name']?>">
                            <div class="more-category-info">
                                <a href="<?=$route?>"><h3><strong><?=$categories2[$i]['name']?></strong></h3></a>
                                <p>Browse all our categories</p>
                                <a href="<?=$route?>" class="btn btn-primary">Shop by <?=$categories2[$i]['name']?></a>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>
        <section>
            <?php if(count($popProducts)){?>
            <div class="container">
                <h3 class="t-p"><strong>TOP RATED</strong></h3>
                <div class="row mt-5">
                <?php
                    for ($i=0; $i < count($popProducts) ; $i++) { 
                        if($popProducts[$i]['rate']<4){
                            continue;
                        }else{
                            $idProduct = openssl_encrypt($popProducts[$i]['idproduct'],METHOD,KEY);
                            $favorite = '';
                            $routeP = base_url()."/shop/product/".$popProducts[$i]['route'];
                            $routeC = base_url()."/shop/category/".$popProducts[$i]['routec'];
                            $price ='<p class="m-0 fs-5 product-price"><strong>'.formatNum($popProducts[$i]['price']).'</strong></p>';
                            $btnAdd ='<button type="button" class="btn btn-primary product-card-add" data-id="'.$idProduct.'">Add to cart</a>';
                            $discount="";
                            $rate="";
                            if($popProducts[$i]['favorite']== 0){
                                $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                            }else{
                                $favorite = '<button type="button" class="btn addWishList pe-2 ps-2 active"><i class="fas fa-heart text-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></button>';
                            }
                            if($popProducts[$i]['status'] == 1 && $popProducts[$i]['stock']>0){
                                if($popProducts[$i]['discount']>0){
                                    $price = '<p class="m-0 fs-5 product-price"><strong>'.formatNum($popProducts[$i]['priceDiscount']).'</strong><span>'.formatNum($popProducts[$i]['price']).'</span></p>';
                                    $discount ='<p class="product-discount">-'.$popProducts[$i]['discount'].'%</p>';
                                }
                            }else if($popProducts[$i]['status'] == 1 && $popProducts[$i]['stock']==0){
                                $btnAdd="";
                                $price='<p class="m-0 fs-5 product-price text-danger">Sold out</p>';
                            }else{
                                $btnAdd ="";
                                $price="";
                            }
                            for ($j=0; $j < 5; $j++) { 
                                if($j >= intval($popProducts[$i]['rate'])){
                                    
                                    $rate.='<i class="far me-1 fa-star"></i>';
                                }else{
                                    $rate.='<i class="fas me-1 fa-star"></i>';
                                }
                            }
                        }
                ?> 
                <div class="col-md-3" data-id="<?=$idProduct?>">
                    <div class="product-card">
                        <?=$discount?>
                        <div class="product-img">
                            <img src="<?=$popProducts[$i]['url']?>" alt="<?=$popProducts[$i]['name']?>">
                            <?=$btnAdd?>
                        </div>
                        <div class="product-info">
                            <a class="m-0 product-category fw-bold" href="<?=$routeC?>"><?=$popProducts[$i]['category']?></a>
                            <a href="<?=$routeP?>">
                                <h3 class="product-title fw-bold"><?=$popProducts[$i]['name']?></h3>
                                <?=$price?>
                            </a>
                        </div>
                        <div class="product-rate">
                            <?=$rate?>
                        </div>
                        <div class="product-btns">
                            <?=$favorite?>
                            <button type="button" class="btn quickView pe-2 ps-2" data-id="<?=$idProduct?>"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></button>
                        </div>
                    </div>
                </div>
                <?php  }?>
                </div>
            </div>
            <?php }?>
        </section>
    </main>
    <section>
        <div class="main-suscribe mt-5 mb-5">
            <form>
                <h2 class="t-w text-center mb-3"><strong>Suscribe now and get a 15% discount coupon</strong></h2>
                <p class="t-w text-center">Receive updates on new arrivals, special offers and our promotions</p>
                <div class="mb-3">
                    <input type="email" class="form-control text-center" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email">
                </div>
                <button type="submit" class="btn btn-primary btnc-primary w-100">Suscribe</button>
            </form>
        </div>
    </section>
<?php
    footerPage($data);
?>
    
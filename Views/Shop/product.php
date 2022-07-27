<?php
    headerPage($data);
    $review = $data['review'];
    $reviews = $data['reviews'];
    $product = $data['product'];
    $products = $data['products'];
    //dep($product['reviews']);
    $status="";
    $rate = "";
    $price ='<p class="fs-3"><strong>'.formatNum($product['price']).'</strong></p>';
    $btns ='
    <div class="product-cant me-3">
        <div class="decrement"><i class="fas fa-minus"></i></div>
        <input class="cant me-2 ms-2" type="number" min="1" max="'.$product['stock'].'" value="1">
        <div class="increment"><i class="fas fa-plus"></i></div>
        <button type="button" class="ms-3" data-id="'.openssl_encrypt($product['idproduct'],METHOD,KEY).'" id="addProduct"><i class="fas fa-shopping-cart me-2"></i> Add</button>
    </div>
    ';
    $discount="";
    $favorite="";

    if($product['favorite']==1){
        $favorite = '<button type="button" class="c-p btn"><i class="fas fa-heart product-addwishlist me-1 text-danger active"></i> <a href="'.base_url().'/shop/wishlist"class="c-p">Check wishlist</a></button>';
    }else{
        $favorite = '<button type="button" class="c-p btn"><i class="far fa-heart product-addwishlist me-1"></i> <a class="c-d">Add to wishlist</a></button>';
    }
    if($product['status'] == 1 && $product['stock']>0){
        if($product['discount']>0){
            $price = '<p class="m-0 fs-5 product-price"><strong>'.formatNum($product['priceDiscount']).'</strong><span>'.formatNum($product['price']).'</span></p>';
            $discount ='<p class="product-discount">-'.$product['discount'].'%</p>';
        }
    }else if($product['status'] == 1 && $product['stock']==0){
        $btnAdd="";
        $price='<p class="m-0 fs-5 product-price text-danger">Sold out</p>';
    }else{
        $btnAdd ="";
        $price="";
    }
    if($product['status']==1 && $product['stock']>0){
        $status ='<p class="text-secondary m-0">Stock: ('.$product['stock'].') units</p>';
        if($product['discount']>0){
            $discount = '<p class="product-discount">-'.$product['discount'].'%</p>';
            $price = '
            <p class="m-0 text-decoration-line-through t-p">'.formatNum($product['price']).'</p>
            <p class="fs-3"><strong>'.formatNum($product['priceDiscount']).'</strong></p>';
        }
    }else if($product['stock']==0 && $product['status']==1){
        $status =`<p class="text-danger fw-bold">Sold out.</p>`;
        $btns="";  
        $price= "";  
    }else{
        $status ='<p class="text-danger fw-bold">Currently unavailable.</p>';
        $price= "";
        $btns=""; 
    }
    for ($i = 0; $i < 5; $i++) {
        if($product['rate']>0 && $i >= intval($product['rate'])){
            $rate.='<i class="far fa-star"></i>';
        }else if($product['rate'] == 0){
            $rate.='<i class="far fa-star"></i>';
        }else{
            $rate.='<i class="fas fa-star"></i>';
        }
    }
    //dep($product['routec']);exit;
    
?>
    <div id="modalItem"></div>
    <main id="product">
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
                <?php if(isset($_SESSION['login']) && !empty($_SESSION['arrCart'])){ ?>
                <a href="<?=base_url()?>/shop/checkout" class="btnc w-50 p-1 btnc-primary">Checkout</a>
                <?php }else{ ?>
                    <div type="button" onclick="openLoginModal();" class="btnc w-50 h-100 p-1 btnc-primary">Checkout</div>
                <?php }?>
            </div>
        </div>
        <div class="container mt-4 mb-4">
            <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop">Shop</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Product</li>
                  <li class="breadcrumb-item active" aria-current="page"><?=$product['name']?></li>
                </ol>
            </nav>
            <div class="row ps-2 pe-2 pb-4">
                <div class="col-md-6">
                    <div class="product-image">
                        <?=$discount?>
                        <img src="<?=$product['image'][0]['url']?>" alt="<?=$product['name']?>">
                    </div>
                    <div class="product-image-slider">
                        <div class="slider-btn-left"><i class="fas fa-angle-left"></i></div>
                        <div class="product-image-inner">
                            <?php
                                for ($i=0; $i < count($product['image']); $i++) { 
                                    if($i == 0){
                                        $active="active";
                                    }else{
                                        $active="";
                                    }
                            ?>
                            <div class="product-image-item <?=$active?>">
                                <img src="<?=$product['image'][$i]['url']?>" alt="<?=$product['name']?>">
                            </div>
                            <?php }?>
                        </div>
                        <div class="slider-btn-right"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
                <div class="col-md-6 product-data">
                    <h1><strong><?=$product['name']?></strong></h1>
                    <div class="product-rate text-start mt-1">
                        <?=$rate?>
                        (<?=$product['reviews']?> reviews)
                        
                    </div>
                    <?=$status?>
                    <?=$price?>
                    <p class="mb-3" id="description"><?=$product['shortdescription']?></p>
                    <p class="m-0">SKU: <strong><?=$product['reference']?></strong></p>
                    <a href="<?=base_url()."/shop/category/".$product['routec']?>" class="m-0">Category: <strong><?=$product['category']?></strong></a>
                    <div class="mt-4 mb-4 d-flex align-items-center">
                        <?=$btns?>
                    </div>
                    <div class="alert alert-warning d-none" id="alert" role="alert">
                        Oops! Not enought stock, try with less or check your cart if you have added all our units before.
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <ul class="product-social">
                            <li title="Share on facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li title="Share on twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li title="Share on linkedin"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li title="Share on telegram"><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
                        </ul>
                        <?=$favorite?>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item position-relative" role="presentation">
                  <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="true">Description</button>
                </li>
                <li class="nav-item position-relative" role="presentation">
                  <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">Reviews (<?=$product['reviews']?>)</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                    <?=$product['description']?>
                </div>
                <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                    <div class="review-general">
                        <div class="row mb-3">
                            <div class="col-md-3 text-center">
                                <h2 class="fs-5"><strong>Reviews for <?=$product['name']?></strong></h2>
                                <p class="fs-1 fw-bold t-p" id="avgRate"><?=$product['rate']?><span class="fs-6">/ 5</span></p>
                                <div class="product-rate mb-3">
                                    <?=$rate?>
                                </div>
                                <p class="fw-bold">Average raiting</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row h-75 mb-4 mt-4">
                                    <div class="col-lg-3 col-5 t-p d-flex justify-content-between flex-column align-items-center">
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <span>(<?=$product['reviews'] == 0 ? 0 : $review['five']?>)</span>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span>(<?=$product['reviews'] == 0 ? 0 : $review['four']?>)</span>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span>(<?=$product['reviews'] == 0 ? 0 : $review['three']?>)</span>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span>(<?=$product['reviews'] == 0 ? 0 : $review['two']?>)</span>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span>(<?=$product['reviews'] == 0 ? 0 : $review['one']?>)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-7 d-flex justify-content-between flex-column">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $product['reviews'] == 0 ? 0 : ($review['five']/$product['reviews'])*100 ?>%" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['five']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?=$product['reviews'] == 0 ? 0 : ($review['four']/$product['reviews'])*100 ?>%" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['four']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?=$product['reviews'] == 0 ? 0 : ($review['three']/$product['reviews'])*100 ?>%" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['three']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?=$product['reviews'] == 0 ? 0 : ($review['two']/$product['reviews'])*100 ?>%" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['two']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?=$product['reviews'] == 0 ? 0 : ($review['one']/$product['reviews'])*100 ?>%" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['one']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <p class="fs-4 fw-bold">Filters</p>
                        <div class="col-md-6 mb-3">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchReview" name="searchReview">        
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3 d-flex align-items-center">
                                    <label for="selectSort" class="form-label m-0 me-4">Sort by:</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" aria-label="Default select example" id="sortReviews">
                                        <option value="1">Most recent</option>
                                        <option value="2">Most relevant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="comment-list mt-3">
                        <?php 
                            if(!empty($reviews)){
                                for ($i=0; $i < count($reviews) ; $i++) { 
                                    $image = media()."/images/uploads/".$reviews[$i]['image'];
                                    $name = $reviews[$i]['firstname']." ".$reviews[$i]['lastname'];
                                    $rateComment ="";
                                    for ($j = 0; $j < 5; $j++) {
                                        if($j >= intval($reviews[$i]['rate'])){
                                            $rateComment.='<i class="far fa-star"></i>';
                                        }else{
                                            $rateComment.='<i class="fas fa-star"></i>';
                                        }
                                    }

                            
                        ?>
                        <li class="comment-block" data-name="<?=$name?>">
                            <div class="comment-img">
                                <img src="<?=$image?>" alt="<?=$name?>">
                                <div class="product-rate text-center mt-2 mb-2">
                                    <?=$rateComment?>
                                </div>
                                <p class="text-center fw-bold"><?=$reviews[$i]['date']?></p>
                            </div>
                            <div class="comment-feedb">
                                <p><?=$reviews[$i]['description']?></p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h3><?=$name?></h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <?php if(isset($_SESSION['login']) && $_SESSION['idUser'] == $reviews[$i]['personid']){ ?>
                                        <a href="#formReview" data-id="<?=$reviews[$i]['id']?>" onclick="editReview(<?=$reviews[$i]['id']?>)" title="edit" class="btn text-dark editComment"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn text-dark" onclick="deleteReview(<?=$reviews[$i]['id']?>)" title="delete"><i class="fas fa-trash"></i></button>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } }?>
                    </ul>
                    <div class="d-flex justify-content-center mb-3">
                        <form id="formReview" class="w-100">
                            <input type="hidden" name="idReview" id="idReview" value="">
                            <input type="hidden" name="intRate" id="intRate" value="0">
                            <input type="hidden" name="idProduct" id="idProduct" value="<?=openssl_encrypt($product['idproduct'],METHOD,KEY)?>">
                            <h3 class="mb-3 text-center">Add your review</h3>
                            <div class="d-flex justify-content-center">
                                <div class="review-rate mb-3">
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="txtReview" name="txtReview" rows="5" placeholder="Your review"></textarea>
                            </div>
                            <div class="alert alert-danger d-none" id="alertReview" role="alert"></div>
                            <button type="submit" class="btn btnc-primary" id="addReview">Post review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <div class="container">
                <h3 class="t-p"><strong>RELATED PRODUCTS</strong></h3>
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
    </main>
<?php
    footerPage($data);
?>
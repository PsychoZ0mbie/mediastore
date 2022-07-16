<?php
    headerPage($data);
    $review = $data['review'];
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
        $favorite = '<button type="button" class="c-p quickModal btn"><i class="fas fa-heart product-addwishlistModal me-1 text-danger active"></i> <a href="'.base_url().'/shop/wishlist"class="c-p">Check wishlist</a></button>';
    }else{
        $favorite = '<button type="button" class="c-p quickModal btn"><i class="far fa-heart product-addwishlistModal me-1"></i> <a class="c-d">Add to wishlist</a></button>';
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
    <div id="modalLogin"></div>
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
                <a href="<?=base_url()?>/shop/checkout" class="btnc w-50 p-1 btnc-primary">Checkout</a>
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
                                $active="";
                                for ($i=0; $i < count($product['image']); $i++) { 
                                    if($i == 0){
                                        $active="active";
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
                    <div class="product-rate text-start mt-1" title="<?=$product['rate']?>">
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
                                <p class="fs-1 fw-bold t-p"><?=$product['rate']?><span class="fs-6">/ 5</span></p>
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
                                            (<?=$product['reviews'] == 0 ? 0 : $review['five']?>)
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            (<?=$product['reviews'] == 0 ? 0 : $review['four']?>)
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            (<?=$product['reviews'] == 0 ? 0 : $review['three']?>)
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            (<?=$product['reviews'] == 0 ? 0 : $review['two']?>)
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            (<?=$product['reviews'] == 0 ? 0 : $review['one']?>)
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
                                            <div class="progress-bar" role="progressbar" style="width: <?=$product['reviews'] == 0 ? 0 : ($review['one']/$product['reviews'])*100 ?>" aria-valuenow="<?=$product['reviews'] == 0 ? 0 : ($review['one']/$product['reviews'])*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="comment-list">
                        <li class="comment-block">
                            <div class="comment-img">
                                <img src="https://t4.ftcdn.net/jpg/02/45/56/35/360_F_245563558_XH9Pe5LJI2kr7VQuzQKAjAbz9PAyejG1.jpg" alt="">
                                <div class="product-rate text-center mt-2 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-center fw-bold">29 June 2022</p>
                            </div>
                            <div class="comment-feedb">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae, deserunt tenetur voluptate quos eligendi sunt alias tempora dolores vitae a dolorum possimus inventore facere, ullam, pariatur repellat provident aliquid error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, officia nesciunt! Eius quam repellendus, voluptate beatae officia asperiores maiores vitae ea facilis sequi, at a ipsa sapiente ipsam in nulla?</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h3>John Doe</h3>
                                    <p class="m-0 t-p c-p btnAnswer">Show answer <i class="fas fa-angle-down"></i></p>
                                </div>
                            </div>
                            <div class="comment-answer">
                                <p class="m-0">Thanks! Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis perferendis quas optio expedita, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam est animi nostrum aliquid. Cumque, praesentium impedit hic cupiditate ipsum corrupti laboriosam tempora. Similique esse excepturi dicta in qui beatae magni. quidem numquam minima animi adipisci nobis minus consectetur maxime, non eaque maiores molestias, doloribus suscipit aliquid temporibus. Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero eligendi sint itaque tenetur in a cum illum repellendus? Expedita, voluptates. Cum nostrum eum illo cumque vitae iusto eos, nobis libero. consectetur adipisicing elit. Quas ullam deserunt non voluptas quos quisquam? Fugit eveniet mollitia possimus dolorem odio aliquam. Corrupti eveniet beatae nam quasi mollitia soluta excepturi.</p>
                            </div>
                        </li>
                        <li class="comment-block">
                            <div class="comment-img">
                                <img src="data:image/jpeg;base64,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" alt="">
                                <div class="product-rate text-center mt-2 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-center fw-bold">20 June 2022</p>
                            </div>
                            <div class="comment-feedb">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae, deserunt tenetur voluptate quos eligendi sunt alias tempora dolores vitae a dolorum possimus inventore facere, ullam, pariatur repellat provident aliquid error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, officia nesciunt! Eius quam repellendus, voluptate beatae officia asperiores maiores vitae ea facilis sequi, at a ipsa sapiente ipsam in nulla?</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h3>Jane Doe</h3>
                                    <p class="m-0 t-p c-p btnAnswer">Show answer <i class="fas fa-angle-down"></i></p>
                                </div>
                            </div>
                            <div class="comment-answer">
                                <p class="m-0">Thanks! Lconsectetur adipisicing elit. Ullamoriosam tempora. Similique esse excepturi dicta in qui beatae magni. quidem numquam minima animi adipisci nobis minus consectetur maxime, non eaque maiores molestias, doloribus suscipit aliquid temporibus. Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero eligendi sint itaque tenetur in a cum illum repellendus? Expedita, voluptates. Cum nostrum eum illo cumque vitae iusto eos, nobis libero. consectetur adipisicing elit. Quas ullam deserunt non voluptas quos quisquam? Fugit eveniet mollitia possimus dolorem odio aliquam. Corrupti eveniet beatae nam quasi mollitia soluta excepturi.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center mb-3">
                        <form action="" id="formReview" class="w-100">
                            <h3 class="mb-3 text-center">Add your review</h3>
                            <div class="d-flex justify-content-center">
                                <input type="hidden" name="intRate" id="intRate" value="0">
                                <div class="review-rate mb-3">
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                    <button type="button" class="starBtn"><i class="far fa-star"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Your review"></textarea>
                            </div>
                            <button type="submit" class="btn btnc-primary">Post review</button>
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
                        $btnAdd ='<button type="button" class="btn btn-primary product-card-add">Add to cart</a>';
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
                            <button type="button" class="btn quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></button>
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
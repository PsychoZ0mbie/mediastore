<?php
    headerPage($data);
?>
    <div id="modalLogin"></div>
    <div id="modalItem"></div>
    <div id="modalPoup"></div>
    <main id="<?=$data['page_name']?>">
        <div class="popup">
            <div class="popup-close">X</div>
            <div class="popup-info">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdq0BfB70WI3UM5iFrRWAfPCcI_xfgJidpUbxk-iKTOYhOsfsmgYCRG9XGXgJfKp5e218&usqp=CAU" alt="">
                <div class="h-100">
                    <a href="product.html">Product 1</a>
                    <p>Has been added to your cart</p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center text-center mt-3">
                <a href="cart.html" class="btnc w-50 p-1 btnc-primary me-4">View Cart</a>
                <a href="checkout.html" class="btnc w-50 p-1 btnc-primary">Checkout</a>
            </div>
        </div>
        <section>
            <div id="carouselExampleControls" class="carousel slide main-carousel" data-bs-ride="carousel">
                <div class="carousel-inner"></div>
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
                <div class="row" id="categories1"></div>
            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="t-p"><strong>NEW PRODUCTS</strong></h3>
                <div class="row mt-5" id="newProducts"></div>
            </div>
        </section>
        <section>
            <div class="container mt-4 mb-4">
                <div class="row" id="categories2"></div>
            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="t-p"><strong>TOP RATED</strong></h3>
                <div class="row mt-5">
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdq0BfB70WI3UM5iFrRWAfPCcI_xfgJidpUbxk-iKTOYhOsfsmgYCRG9XGXgJfKp5e218&usqp=CAU" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Computers</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">ASUS X550CA</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$250.00</strong></p>
                                </a>
                            </div>
                            <div class="product-rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-btns">
                                <div class="addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></div>
                                <div class="quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtnmDRih1E3G4hNyQoAlabjqJANhHvFOxCqA&usqp=CAU" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Accesories</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">Sony MDR-ZX310APB</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$250.00</strong></p>
                                </a>
                            </div>
                            <div class="product-rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-btns">
                                <div class="addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></div>
                                <div class="quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTeevb2rnHRLlczlhrjO4JDq8aQQPlFdyejPQ&usqp=CAU" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Tablets</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">Galaxy Tab S8 Ultra</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$250.00</strong></p>
                                </a>
                            </div>
                            <div class="product-rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-btns">
                                <div class="addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></div>
                                <div class="quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="data:image/jpeg;base64,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" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Smartphones</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">Xiaomi redmi note 9</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$250.00</strong></p>
                                </a>
                            </div>
                            <div class="product-rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-btns">
                                <div class="addWishList pe-2 ps-2 "><i class="far fa-heart " data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></i></div>
                                <div class="quickView pe-2 ps-2"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    
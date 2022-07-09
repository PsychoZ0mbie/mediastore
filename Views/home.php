<?php
    headerPage($data);
?>
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
                <div class="row" id="categories1">
                    <div class="col-md-4">
                        <a href="shop.html" class="text-decoration-none">
                            <div class="category">
                                <img src="https://img.freepik.com/psd-gratis/diseno-maqueta-smartphone-pantalla-completa_53876-65968.jpg?w=2000">
                                <div class="category-info">
                                    <h3><strong>Smartphones</strong></h3>
                                </div>
                                <a href="shop.html" class="category-btn"><strong>Shop now</strong></a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="shop.html" class="text-decoration-none">
                            <div class="category">
                                <img src="https://images-na.ssl-images-amazon.com/images/I/819XYUimTuL._AC._SR360,460.jpg">
                                <div class="category-info">
                                    <h3><strong>Computers</strong></h3>
                                </div>
                                <a href="shop.html" class="category-btn"><strong>Shop now</strong></a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="shop.html" class="text-decoration-none">
                            <div class="category">
                                <img src="https://educacion30.b-cdn.net/wp-content/uploads/2021/07/glab-kstand.jpg">
                                <div class="category-info">
                                    <h3><strong>Accesories</strong></h3>
                                </div>
                                <a href="shop.html" class="category-btn"><strong>Shop now</strong></a>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="t-p"><strong>NEW PRODUCTS</strong></h3>
                <div class="row mt-5">
                    <div class="col-md-3">
                        <div class="product-card">
                            <p class="product-discount">-30%</p>
                            <div class="product-img">
                                <img src="data:image/jpeg;base64,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" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Smartphones</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">Huawei nova Y60</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$175.00</strong><span>$250.00</span></p>
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
                                    <h3 class="product-title fw-bold">Huawei P50 Pro</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$175.00</strong></p>
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
                            <p class="product-discount">-30%</p>
                            <div class="product-img">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_726196-MLA44156497086_112020-O.jpg" alt="">
                                <button type="button" class="btn btn-primary product-card-add">Add to cart</a>
                            </div>
                            <div class="product-info">
                                <a class="m-0 product-category fw-bold" href="shop.html">Smartphones</a>
                                <a href="product.html">
                                    <h3 class="product-title fw-bold">Samsung Galaxy A50</h3>
                                    <p class="m-0 fs-5 product-price"><strong>$175.00</strong><span>$250.00</span></p>
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
                                    <h3 class="product-title fw-bold">Samsung Galaxy S20</h3>
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
        <section>
            <div class="container mt-4 mb-4">
                <div class="row" id="categories2">
                    <div class="col-md-4 mb-3">
                        <div class="more-category">
                            <img src="https://panamericana.vteximg.com.br/arquivos/ids/370523-600-690/table-lenovo-smart-tab-m8-8-gris-1-194632687668.jpg?v=637415828691400000" alt="">
                            <div class="more-category-info">
                                <a href="shop.html"><h3><strong>Tablets</strong></h3></a>
                                <p>Browse all our categories</p>
                                <a href="shop.html" class="btn btn-primary">Shop by tablets</a>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="more-category">
                            <img src="https://e00-expansion.uecdn.es/assets/multimedia/imagenes/2020/06/09/15916972633911.jpg" alt="">
                            <div class="more-category-info">
                                <a href="shop.html"><h3><strong>SmartWatch</strong></h3></a>
                                <p>Browse all our categories</p>
                                <a href="shop.html" class="btn btn-primary">Shop by SmartWatch</a>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="more-category">
                            <img src="https://www.sony.com.co/image/53d7c185420c8f2a09c5b73efaf8fcd5?fmt=png-alpha&wid=720" alt="">
                            <div class="more-category-info">
                                <a href="shop.html"><h3><strong>TV</strong></h3></a>
                                <p>Browse all our categories</p>
                                <a href="shop.html" class="btn btn-primary">Shop by TV</a>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
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
    
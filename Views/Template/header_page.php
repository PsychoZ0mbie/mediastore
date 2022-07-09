<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['page_title']?></title>

    <!------------------------------------Frameworks--------------------------->
    <link rel="stylesheet" href="<?=media();?>/css/bootstrap/bootstrap.min.css">
    <!------------------------------------Font Awesome 5--------------------------->
    <link href="<?=media();?>/css/icons/font-awesome.min.css">
    <!------------------------------------Styles--------------------------->
    <link rel="stylesheet" href="<?=media();?>/template/Assets/css/style.css">

</head>
<body>
    <header>
        <nav class="nav-custom">
            <div class="nav-logo">
                <a href="index.html"><strong>MEDIASTORE</strong></a>
            </div>
            <div class="nav-search d-none d-flex">
                <button type="button" class="btn"><i class="fas fa-search"></i></button>
                <input type="search" id="txtSearch" placeholder="search something">
                <div id="btnCloseSearch">X</div>
            </div>
            <div class="nav-main">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="shop.html">Shop</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li class="active"><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="nav-icons">
                <ul>
                    <li title="Search" class="c-p" id="btnSearch"><i class="fas fa-search"></i></li>
                    <li title="Wishlist" ><a href="wishlist.html"><i class="fas fa-heart"></i></a></li>
                    <li class="nav-icons-qty" title="My cart" id="btnToggleCart">
                        <i class="fas fa-shopping-cart"></i>
                        <span>0</span>
                    </li>
                    <li title="My account"><a href="login.html"><i class="fas fa-user"></i></a></li>
                    <li id="btnToggleNav"><i class="fas fa-bars"></i></li>
                </ul>
            </div>
            <div class="nav-mobile">
                <div class="container nav-mobile-main">
                    <div class="nav-logo d-flex justify-content-between align-items m-0">
                        <strong>MEDIASTORE</strong>
                        <div id="btnCloseNav">X</div>
                    </div>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="cart-panel">
            <div class="container cart-panel-main">
                <div class="cart-panel-title d-flex justify-content-between align-items m-0">
                    <strong>YOUR CART</strong>
                    <div id="btnCloseCart">X</div>
                </div>
                <div class="cart-panel-items scroll-y">
                    <div class="cart-panel-item">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdq0BfB70WI3UM5iFrRWAfPCcI_xfgJidpUbxk-iKTOYhOsfsmgYCRG9XGXgJfKp5e218&usqp=CAU" alt="">
                        <div class="btn-del">X</div>
                        <h3><a href="product.html"><strong>Xiaomi redmi note 9</strong></a></h3>
                        <p>3 x $250.000 </p>
                    </div>
                </div>
                <p class="t-p "><strong>Total: $750.000</strong></p>
                <div>
                    <a href="cart.html" class="btn w-100 btnc-primary mb-2">View Cart</a>
                    <a href="checkout.html" class="btn w-100 btnc-primary">Checkout</a>
                </div>
            </div>
        </div>
    </header>
    <a class="text-decoration-none" href="#" id="scrollTop"><i class="fas fa-angle-up"></i></a>
    
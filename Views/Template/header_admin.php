<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title><?=$data['page_title']?></title>
        <script src="<?= media();?>/js/plugins/tinymce/tinymce.min.js"></script>
        <!-- Font Awesome 5-->
        <link href="<?=media()?>/css/icons/font-awesome.min.css">
        <!-- AdminKit CSS file -->
        <link href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/css/style.css" rel="stylesheet">
        <!-- My Styles -->
        <link rel="stylesheet" href="<?=media()?>/css/style.css">
    </head>
    <body>
        <?php require_once("nav_admin.php");?>
        <!--wrapper-->
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <header class="header header-sticky mb-4">
                <div class="container-fluid">
                    <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                        <svg class="icon icon-lg">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
                        </svg>
                    </button>
                    <a class="header-brand d-md-none" href="#">
                        <i class="" style="width: 118px;height: 46px;"></i>
                        <svg width="118" height="46" alt="MediaStore Logo">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/assets/brand/coreui.svg#full"></use>
                        </svg>
                    </a>
                    <ul class="header-nav ms-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img" src="<?=media()?>/images/uploads/<?=$_SESSION['userData']['image']?>" alt="<?=$_SESSION['userData']['email']?>">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <a class="dropdown-item" href="<?=base_url()?>/user/profile">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url()?>/logout">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                    </svg> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="header-divider"></div>
                <?php
                    if(isset($_SESSION['permitsModule']['w'])){

                    
                ?>
                <div class="container-fluid">
                    <button class="btn btn-primary d-none" type="button" id="btnNew">Add <?= $data['page_name']?> <i class="fas fa-plus"></i></button>
                </div>
                <?php
                    }
                ?>
            </header>

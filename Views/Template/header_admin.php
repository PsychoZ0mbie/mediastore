<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title><?=$data['page_title']?></title>
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
                    <ul class="header-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg class="icon icon-lg">
                                    <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg class="icon icon-lg">
                                    <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg class="icon icon-lg">
                                    <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <ul class="header-nav ms-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img" src="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/assets/img/avatars/8.jpg" alt="user@email.com">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="dropdown-header bg-light py-2">
                                    <div class="fw-semibold">Account</div>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                    </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                                    </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-task"></use>
                                    </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-square"></use>
                                    </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span>
                                </a>
                                <div class="dropdown-header bg-light py-2">
                                    <div class="fw-semibold">Settings</div>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                    </svg> Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-credit-card"></use>
                                    </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
                                    </svg> Projects<span class="badge badge-sm bg-primary ms-2">42</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                    </svg> Lock Account
                                </a>
                                <a class="dropdown-item" href="#">
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
                    if($_SESSION['permitsModule']['w']){

                    
                ?>
                <div class="container-fluid">
                    <button class="btn btn-primary" type="button" id="btnNew">Nuevo <i class="fas fa-plus"></i></button>
                </div>
                <?php
                    }
                ?>
            </header>

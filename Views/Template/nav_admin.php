<!--sidebar-->
  <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="<?=base_url()?>" class="fs-4 m-0 text-decoration-none text-white"><?=NOMBRE_EMPRESA?></a>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <?php
                                if($_SESSION['permit'][1]['r']){

                                
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/dashboard">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                                    </svg> 
                                    Dashboard<span class="badge badge-sm bg-info ms-auto"></span>
                                </a>
                            </li>
                            <?php
                                }
                            ?>
                            <?php  if($_SESSION['permit'][2]['r']){?>
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Users
                                </a>
                                <ul class="nav-group-items">
                                    <?php
                                        if($_SESSION['idUser'] == 1 && $_SESSION['permit'][2]['r']){
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/role"><span class="nav-icon"></span> Roles</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/user"><span class="nav-icon"></span> Users</a></li>
                                </ul>
                            </li>
                            <?php
                                }
                            ?>
                            <?php 
                                if($_SESSION['permit'][3]['r']){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/customer">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user-follow"></use>
                                    </svg> 
                                    Customers<span class="badge badge-sm bg-info ms-auto"></span>
                                </a>
                            </li>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($_SESSION['permit'][4]['r']){
                            ?>
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-inbox"></use>
                                    </svg> Inventory
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/category"><span class="nav-icon"></span> Categories</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/category/subcategory"><span class="nav-icon"></span> Subcategories</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/product"><span class="nav-icon"></span> Products</a></li>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($_SESSION['permit'][6]['r']){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/orders">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-money"></use>
                                    </svg> 
                                    Orders<span class="badge badge-sm bg-info ms-auto"></span>
                                </a>
                            </li>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($_SESSION['permit'][5]['r']){
                            ?>
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
                                    </svg> Store
                                </a>
                                <ul class="nav-group-items">
                                    <?php 
                                    $emails = "";
                                    if($notification>0){
                                        $emails = '<span class="badge badge-sm bg-danger ms-auto">'.$notification.'</span>';
                                    }else{
                                        $emails = "";
                                    }
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/coupon"><span class="nav-icon"></span> Coupons</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/mailbox"><span class="nav-icon"></span> Mailbox <?=$emails?></a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/suscribers"><span class="nav-icon"></span> Suscribers</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/polities"><span class="nav-icon"></span> polities</a></li>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                            <li class="nav-item mt-5">
                                <a class="nav-link" href="<?=base_url()?>/user/profile">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/logout">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                    </svg> Logout
                                </a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 843px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="height: 0px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
        </div>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<!--sidebar-->
  <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/assets/brand/coreui.svg#signet"></use>
        </svg>
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
                                if($_SESSION['permitsModule']['r']){

                                
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
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Usuarios
                                </a>
                                <ul class="nav-group-items">
                                    <?php
                                        if($_SESSION['idUser'] == 1 && $_SESSION['permitsModule']['r']){
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/role"><span class="nav-icon"></span> Roles</a></li>
                                    <?php
                                        }
                                        if($_SESSION['permitsModule']['r']){
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/user"><span class="nav-icon"></span> Usuarios</a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                            <?php 
                                if($_SESSION['permitsModule']['r']){
                            ?>
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-inbox"></use>
                                    </svg> Inventario
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/category"><span class="nav-icon"></span> Categorias</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/category/subcategory"><span class="nav-icon"></span> Subcategorias</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/product"><span class="nav-icon"></span> Productos</a></li>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                            <li class="nav-item mt-5">
                                <a class="nav-link" href="<?=base_url()?>/logout">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                    </svg> Salir
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
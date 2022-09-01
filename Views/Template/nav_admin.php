<!--sidebar-->
  <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="<?=base_url()?>" class="fs-4 m-0 text-decoration-none text-white d-flex align-items-center justify-content-between">
            <img src="<?=media()."/images/uploads/".$companyData['logo']?>" alt="MediaStore Logo" width="50" height="46">
            <?=$companyData['name']?>
        </a>
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
                                    </svg> Usuarios
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
                                    Clientes<span class="badge badge-sm bg-info ms-auto"></span>
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
                            <?php 
                                if($_SESSION['permit'][6]['r']){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/orders">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-money"></use>
                                    </svg> 
                                    Pedidos<span class="badge badge-sm bg-info ms-auto"></span>
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
                                    </svg> Tienda
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
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/coupon"><span class="nav-icon"></span> Cupones</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/mailbox"><span class="nav-icon"></span> Correo <?=$emails?></a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/subscribers"><span class="nav-icon"></span> Suscriptores</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/shipping"><span class="nav-icon"></span> Envio</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/about"><span class="nav-icon"></span> Nosotros</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/store/policies"><span class="nav-icon"></span> Politicas</a></li>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($_SESSION['permit'][7]['r']){
                            ?>
                            <li class="nav-group">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                                    </svg> Blog
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/post/category"><span class="nav-icon"></span> Categorias</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/post/subcategory"><span class="nav-icon"></span> Subcategorias</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?=base_url()?>/post/articles"><span class="nav-icon"></span> Articulos</a></li>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($_SESSION['idUser']==1){
                            ?>
                            <li class="nav-item mt-5">
                                <a class="nav-link" href="<?=base_url()?>/company">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-storage"></use>
                                    </svg> Empresa
                                </a>
                            </li>
                            <?php 
                                }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/user/profile">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg> Perfil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>/logout">
                                    <svg class="nav-icon">
                                        <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                    </svg> Cerrar sesión
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
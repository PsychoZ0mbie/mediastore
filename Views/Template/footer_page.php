<footer>
        <div class="container p-5 ">
            <div class="row mb-4">
                <p class="fs-3">FOLLOW US</p>
                <div class="footer-social">
                    <a href="<?=FACEBOOK?>"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?=INSTAGRAM?>"><i class="fab fa-instagram"></i></a>
                    <a href="<?=TWITTER?>"><i class="fab fa-twitter"></i></i></a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <h4 class="fs-5">PAYMENT METHOD</h4>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab tempora corporis dolorum debitis animi harum dolorem illum doloremque quaerat? Similique non facere quaerat cum ad nulla sapiente consectetur corrupti sint.</p>
                    <div>
                        <i class="fs-3 p-2 fab fa-cc-mastercard"></i>
                        <i class="fs-3 p-2 fab fa-cc-discover"></i>
                        <i class="fs-3 p-2 fab fa-cc-paypal"></i>
                        <i class="fs-3 p-2 fab fa-cc-visa"></i>
                        <i class="fs-3 p-2 fab fa-cc-amex"></i>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="fs-5">CONTACT INFO</h4>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Address</strong></p>
                        <p><?=DIRECCION?></p>
                    </div>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Phone</strong></p>
                        <p><?=TELEFONO?></p>
                    </div>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Email</strong></p>
                        <p>EMAIL_REMITENTE</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="fs-5">COMPANY</h4>
                    <a href="<?=base_url()?>/about" class="text-decoration-none text-dark m-0 d-block">About us</a>
                    <a href="<?=base_url()?>/contact" class="text-decoration-none text-dark m-0 d-block">Contact us</a>
                    <a href="<?=base_url()?>/policies" class="text-decoration-none text-dark m-0 d-block">Policies</a>
                </div>
            </div>
            <div class="row text-center">
                <p class="mb-0">Copyright © 2022 Código Energizado</p>
            </div>
        </div>
    </footer>
    <script>
        const base_url = "<?= base_url(); ?>";
        const MS = "<?=MS;?>";
        const MD = "<?=MD?>";
        const COMPANY = "<?=NOMBRE_EMPRESA?>";
        const SHAREDHASH ="<?=SHAREDHASH?>";
    </script>
    <!------------------------------------Plugins--------------------------->
    <script src="<?=media();?>/js/plugins/sweetalert.js"></script>
    <!------------------------------------Framework--------------------------->
    <script src="<?=media();?>/js/bootstrap/popper.min.js"></script>
    <script src="<?=media();?>/js/bootstrap/bootstrap.min.js"></script>
    <!------------------------------------Font Awesome 5--------------------------->
    <script src="<?=media();?>/js/icons/fontawesome.js"></script>
    <!------------------------------------Functions--------------------------->
    <script src="<?=media();?>/js/functions.js"></script>
    <script src="<?=media();?>/template/Assets/js/app.js"></script>
</body>
</html>
<footer>
        <div class="container p-5 ">
            <div class="row mb-4">
                <p class="fs-3">FOLLOW US</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></i></a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
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
                <div class="col-md-3 mb-3">
                    <h4 class="fs-5">CONTACT INFO</h4>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Address</strong></p>
                        <p>1234 Street Name, City, US</p>
                    </div>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Phone</strong></p>
                        <p>(123) 456-7890</p>
                    </div>
                    <div class="d-flex justify-content-between pe-2">
                        <p class="m-0"><strong>Email</strong></p>
                        <p>mail@example.com</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <h4 class="fs-5">COMPANY</h4>
                    <a href="about.html" class="text-decoration-none text-dark m-0 d-block">About us</a>
                    <a href="contact.html" class="text-decoration-none text-dark m-0 d-block">Contact us</a>
                    <a href="policies.html" class="text-decoration-none text-dark m-0 d-block">Policies</a>
                </div>
                <div class="col-md-3 text-decoration-none">
                    <h4 class="fs-5">CATEGORIES</h4>
                    <a href="shop.html" class="text-decoration-none text-dark m-0 d-block">Smartphones</a>
                    <a href="shop.html" class="text-decoration-none text-dark m-0 d-block">Computers</a>
                    <a href="shop.html" class="text-decoration-none text-dark m-0 d-block">Accesories</a>
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
<?php 
$discount = statusCoupon();
$company = getCompanyInfo();
$social = getSocialMedia();

$links ="";
for ($i=0; $i < count($social) ; $i++) { 
    if($social[$i]['link']!=""){
        if($social[$i]['name']=="whatsapp"){
            $links.='<a href="https://wa.me/'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a>';
        }else{
            $links.='<a href="'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a>';
        }
    }
}

?>
<footer>
        <div class="container p-5 ">
            <div class="row mb-4">
                <p class="fs-3">FOLLOW US</p>
                <div class="footer-social">
                    <?=$links?>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <h4 class="fs-5">PAYMENT METHOD</h4>
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
                    <p class="m-0"><strong>Address</strong>: <?=$company['addressfull']?></p>
                    <p class="m-0"><strong>Phone</strong>: +<?=$company['phonecode']." ".$company['phone']?></p>
                    <p class="m-0"><strong>Email</strong>: <?=$company['email']?></p>
                </div>
                <div class="col-md-3 mb-3">
                    <h4 class="fs-5">COMPANY</h4>
                    <a href="<?=base_url()?>/about" class="text-decoration-none text-dark m-0 d-block">About us</a>
                    <a href="<?=base_url()?>/contact" class="text-decoration-none text-dark m-0 d-block">Contact us</a>
                    <a href="<?=base_url()?>/policies" class="text-decoration-none text-dark m-0 d-block">Policies</a>
                </div>
                <?php if(!empty($discount)){ ?>
                <div class="col-md-3 mb-3">
                    <h4 class="fs-5">NEWSLETTER</h4>
                    <p>Subscribe to our newsletter and get a <?=$discount['discount']?>% discount coupon. <br><br>Receive updates on new arrivals, special offers and our promotions</p>
                    <form id="formSuscriber">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">Email:</label>
                            <input type="email" class="form-control" id="txtEmailSuscribe" name="txtEmailSuscribe" placeholder="Your email" required="">
                        </div>
                        <div class="alert alert-danger d-none" id="alertSuscribe" role="alert"></div>
                        <button type="submit" class="btn btnc-primary" id="btnSuscribe">Subscribe</button>
                    </form>
                </div>
                <?php }?>
            </div>
            <div class="row text-center">
                <p class="mb-0">Copyright © 2022 <?=$company['name']?></p>
            </div>
        </div>
    </footer>
    
    <!------------------------------Frameworks--------------------------------->
    <script src="<?= media(); ?>/frameworks/bootstrap/popper.min.js?n=1"></script>
    <script src="<?= media(); ?>/frameworks/bootstrap/bootstrap.min.js?n=1"></script>
    <!------------------------------Plugins--------------------------------->
    <script src="<?= media();?>/plugins/fontawesome/fontawesome.js"></script>
    <script src="<?= media();?>/plugins/sweetalert/sweetalert.js"></script>
    <!------------------------------My functions--------------------------------->
    <script>
        const base_url = "<?= base_url(); ?>";
        const MS = "<?=$company['currency']['symbol'];?>";
        const MD = "<?=$company['currency']['code']?>";
        const COMPANY = "<?=$company['name']?>";
        const SHAREDHASH ="<?=strtolower(str_replace(" ","",$company['name']))?>";
    </script>
    
    <script src="<?=media();?>/js/functions.js"></script>
    <script src="<?=media();?>/template/Assets/js/general.js"></script>
    <?php if(isset($data['app'])){?>
    <script src="<?=media();?>/template/Assets/js/<?=$data['app']?>"></script>
    <?php }?>
    
    
</body>
</html>
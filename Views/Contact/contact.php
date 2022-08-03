<?php
    headerPage($data);
?>
    <main id="<?=$data['page_name']?>">
        <div class="cover">
            <h1>CONTACT US</h1>
        </div>
        <div class="container mt-4 mb-4">
            <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
            <div class="row contact">
                <div class="col-md-6">
                    <div class="row h-100">
                        <div class="col-md-6 contact-info">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt fs-1 mb-3 t-p"></i>
                                <p class="fs-6 fw-bold m-0">Our location</p>
                                <p class="fs-6"><?=DIRECCION?></p>
                            </div>
                        </div>
                        <div class="col-md-6 contact-info">
                            <div class="contact-item">
                                <i class="fas fa-phone fs-1 mb-3 t-p"></i>
                                <p class="fs-6 fw-bold m-0">Our phone</p>
                                <p class="fs-6"><?=TELEFONO?></p>
                            </div>
                        </div>
                        <div class="col-md-6 contact-info">
                            <div class="contact-item">
                                <i class="fas fa-envelope fs-1 mb-3 t-p"></i>
                                <p class="fs-6 fw-bold m-0">Our email</p>
                                <p class="fs-6"><?=EMAIL_REMITENTE?></p>
                            </div>
                        </div>
                        <div class="col-md-6 contact-info">
                            <div class="contact-item p-0">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d201877.7344402928!2d-122.3753904!3d37.7586346!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20EE.%20UU.!5e0!3m2!1ses!2sco!4v1656619489035!5m2!1ses!2sco" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 contact-form">
                    <form id="formContact">
                        <div class="mb-3">
                            <label for="txtContactName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="txtContactName" name="txtContactName" placeholder="Your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtContactEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="txtContactEmail" name="txtContactEmail" placeholder="Your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtMessageEmail" class="form-label">Message</label>
                            <textarea class="form-control" id="txtContactMessage" name="txtContactMessage" placeholder="Your message" rows="5" required></textarea>
                        </div>
                        <div class="alert alert-danger d-none" id="alertContact" role="alert"></div>
                        <div>
                            <button type="submit" id="btnMessage" class="btn btnc-primary w-100 mb-2">Submit</button>
                            <div class="d-flex justify-content-center">
                                <a href="<?=FACEBOOK?>" target="_blank" class="me-3 ms-3 text-dark fs-5"><i class="fab fa-facebook-f"></i></a>
                                <a href="<?=INSTAGRAM?>" target="_blank" class="me-3 ms-3 text-dark fs-5"><i class="fab fa-instagram"></i></a>
                                <a href="<?=TWITTER?>" target="_blank" class="me-3 ms-3 text-dark fs-5"><i class="fab fa-twitter"></i></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>
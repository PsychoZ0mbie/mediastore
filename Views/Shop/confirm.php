<?php
    headerPage($data);
?>
    <main>
        <div class="container mt-4 mb-4 text-center">
            <h2 class="fs-1 text-secondary">Thank you for your purchase!</h2>
            <p class="m-0">Your order has been placed</p>
            <p class="m-0">Order number: <?=openssl_decrypt($data['orderData']['order'],METHOD,KEY)?></p>
            <p class="m-0">Transaction: <?=openssl_decrypt($data['orderData']['transaction'],METHOD,KEY)?></p>
            <hr>
            <div class="mt-3">
                <p class="m-0">We will contact you soon to organize the delivery</p>
                <p class="m-0 mb-3">You can view your order in your profile</p>
                <a href="<?=base_url()?>" class="btn btnc-primary">Continue</a>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>
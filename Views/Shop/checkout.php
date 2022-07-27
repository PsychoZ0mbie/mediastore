<?php
    headerPage($data);
    $total = 0;
    $subtotal = 0;
    $arrProducts = array();
    $dataCoupon = $data['coupon'];
    
    if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
        $arrProducts = $_SESSION['arrCart'];
        foreach ($arrProducts as $product) {
            if($product['discount']>0){
                $total += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
                $subtotal += $product['qty']*($product['price']-($product['price']*($product['discount']*0.01)));
            }else{
                $total+=$product['qty']*$product['price'];
                $subtotal+=$product['qty']*$product['price'];
            }
        }
    }
    if(!empty($dataCoupon)){
        $total = $total-(($dataCoupon['discount']/100)*$total);
    }
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=CLIENT_ID?>&currency=<?=CURRENCY?>"></script>
    <!-- Set up a container element for the button -->
    
    <script>
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?=$total?>' // Can also reference a variable or function
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            let formData = new FormData();
            formData.append("data",JSON.stringify(orderData, null, 2));
            request(base_url+"/shop/setOrder",formData,"post").then(function(objData){
                if(objData.status){
                    
                }
            });
            //console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            //const transaction = orderData.purchase_units[0].payments.captures[0];
            //alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script>

<main id="<?=$data['page_name']?>">
    <div class="container">
        <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row">
           <div class="col-lg-7 order-lg-1 order-md-5 order-sm-5">
                <form id="formOrder" name="formOrder" class="p-4">
                    <h2>Billing details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtNameOrder" class="form-label">First name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtNameOrder" name="txtNameOrder" value="<?=$_SESSION['userData']['firstname']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtLastNameOrder" class="form-label">Last name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtLastNameOrder" name="txtLastNameOrder" value="<?=$_SESSION['userData']['lastname']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtEmailOrder" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="txtEmailOrder" name="txtEmailOrder" value="<?=$_SESSION['userData']['email']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtPhoneOrder" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="txtPhoneOrder" name="txtPhoneOrder" required="">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="txtAddressOrder" class="form-label"> Address<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txtAddressOrder" name="txtAddressOrder" required="">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listCountry" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select" id="listCountry" name="listCountry" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listState" class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-select" id="listState" name="listState" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listCity" class="form-label">City <span class="text-danger">*</span></label>
                                <select class="form-select" id="listCity" name="listCity" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtPostCodeOrder" class="form-label"> Postcode</label>
                                <input type="text" class="form-control" id="txtPostCodeOrder" name="txtPostCodeOrder">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="txtNote" class="form-label">Order notes</label>
                        <textarea class="form-control" id="txtNote" name="txtNote" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 order-lg-5 order-md-5 order-sm-1 mb-4">
                <div class="p-4 mb-4">
                    <h2>Resume</h2>
                    <?php 
                        for ($i=0; $i < count($arrProducts) ; $i++) { 
                            $price=0;
                            if($arrProducts[$i]['discount']>0){
                                $price = $arrProducts[$i]['qty']*($arrProducts[$i]['price']-($arrProducts[$i]['price']*($arrProducts[$i]['discount']*0.01)));
                            }else{
                                $price=$arrProducts[$i]['qty']*$arrProducts[$i]['price'];
                            }
                        
                    ?>
                    <div class="d-flex justify-content-between">
                        <p><?=$arrProducts[$i]['name']." x ".$arrProducts[$i]['qty']?></p>
                        <p><?=formatNum($price)?></p>
                    </div>
                    <?php }?>
                    <div class="d-flex justify-content-between mb-3 position-relative af-b-line">
                        <p class="m-0 fw-bold">Subtotal</p>
                        <p class="m-0"><?=formatNum($subtotal)?></p>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <?php if(!empty($dataCoupon)){ ?>
                            <p><?=$dataCoupon['code']?></p>
                            <p>-<?=$dataCoupon['discount']?>%</p>
                        <?php }else{?>
                        <form id="formCoupon" class="w-100">
                            <div class="input-group">
                                <input type="text" id="txtCoupon" name="txtCoupon" class="form-control" placeholder="Your coupon code" aria-label="Coupon code" aria-describedby="button-addon2">
                                <button class="btn btnc-primary" type="button" id="btnCoupon">+</button>
                            </div>
                            <div class="alert alert-danger mt-3 d-none" id="alertCoupon" role="alert"></div>
                        </form>
                        <?php }?>
                    </div>
                    <div class="d-flex justify-content-between mb-3 position-relative af-b-line">
                        <p class="m-0 fw-bold fs-5">Total</p>
                        <p class="m-0 fw-bold fs-5" id="totalResume"><?=formatNum($total)?></p>
                    </div>
                    <div id="alertCheckData" class="alert alert-danger d-none" role="alert"></div>
                    <div id="paypal-button-container" class="d-none"></div>
                    <button type="button" class="mb-3 w-100 btn btnc-primary" id="checkData">Pay now</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    footerPage($data);
?>
<?php 
headerAdmin($data);
$order = $data['orderdata'];
$detail = $data['orderdetail'];
$coupon = $data['coupon'];
$total=0;
?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem"></div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div id="orderInfo">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fs-5"><?=NOMBRE_EMPRESA?></div>
                        <div class="fs-5 fw-bold"><?=$order['date']?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2 fw-bold">From</p>
                            <p class="m-0"><?=DIRECCION?></p>
                            <p class="m-0"><?=TELEFONO?></p>
                            <p class="m-0"><?=EMAIL_REMITENTE?></p>
                            <p class="m-0"><?=WEB_EMPRESA?></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2 fw-bold">To</p>
                            <p class="m-0">Name: <?=$order['firstname']." ".$order['lastname']?></p>
                            <p class="m-0">Phone: <?=$order['phone']?></p>
                            <p class="m-0">Email: <?=$order['email']?></p>
                            <p class="m-0">Country: <?=$order['country']?></p>
                            <p class="m-0">State: <?=$order['state']?></p>
                            <p class="m-0">City: <?=$order['city']?></p>
                            <p class="m-0">Shipping address: <?=$order['address']?></p>
                            <p class="m-0">Postal code: <?=$order['postalcode']?></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2 fw-bold">Order: <?=$order['idorder']?></p>
                            <p class="m-0">Transaction: <?=$order['idtransaction']?></p>
                            <p class="m-0">Status: <?=$order['status']?></p>
                            <p class="m-0">Amount: <?=formatNum($order['amount'])?></p>
                        </div>
                    </div>
                    <table class="table items align-middle">
                        <thead class="text-center">
                            <tr>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach($detail as $product){
                                $total += $product['quantity']*$product['price'];
                            ?>
                                
                            <tr>
                                <td><?=$product['name']?></td>
                                <td><?=formatNum($product['price'])?></td>
                                <td><?=$product['quantity']?></td>
                                <td><?=formatNum($product['quantity']*$product['price'])?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <tfoot >
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-center"><?= formatNum($total)?></td>
                            </tr>
                            <?php if(!empty($coupon)){?>
                            <tr>
                                <th colspan="3" class="text-end">Coupon discount:</th>
                                <td class="text-center"><?=$coupon['discount']?>%</td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <td class="text-center"><?= formatNum($order['amount'])?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-6 text-start">
                        <a href="<?=base_url()?>/Orders" class="btn btn-secondary text-white"><i class="fas fa-arrow-circle-left"></i> Back</a>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" id="btnPrint" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
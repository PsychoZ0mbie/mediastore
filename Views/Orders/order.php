<?php 
headerAdmin($data);
$order = $data['orderdata'];
$detail = $data['orderdetail'];
$amountData = json_decode($order['amountdata'],true);
$totalInfo = $amountData['totalInfo'];
$subtotal =$totalInfo['total']['subtotalCoupon'] >0 ? $totalInfo['total']['subtotalCoupon'] : $totalInfo['total']['subtotal'];
$subtotalCoupon = $totalInfo['total']['subtotal'];
$total=0;
?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem"></div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div id="orderInfo">
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="mb-3">
                            <p class="fs-5 fw-bold"><?=NOMBRE_EMPRESA?></p>
                            <p class="m-0"><?=DIRECCION?></p>
                            <p class="m-0"><?=TELEFONO?></p>
                            <p class="m-0"><?=EMAIL_REMITENTE?></p>
                            <p class="m-0"><?=WEB_EMPRESA?></p>
                        </div>
                        <div class="text-start">
                            <p class="m-0"><span class="fw-bold">Date: </span><?=$order['date']?></p>
                            <p class="m-0"><span class="fw-bold">Order: </span>#<?=$order['idorder']?></p>
                            <p class="m-0"><span class="fw-bold">Transaction: </span><?=$order['idtransaction']?></p>
                            <p class="m-0"><span class="fw-bold">Status: </span><?=$order['status']?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <p class="m-0 mb-2 fw-bold">Customer</p>
                            <p class="m-0">Name: <?=$order['firstname']." ".$order['lastname']?></p>
                            <p class="m-0">Phone: <?=$order['phone']?></p>
                            <p class="m-0">Email: <?=$order['email']?></p>
                            <p class="m-0">Address: <?=$order['country'].", ".$order['state'].", ".$order['city']." ".$order['address']." ".$order['postalcode']?></p>
                            <p class="m-0 fw-bold mt-3">Order note:</p>
                            <p class="m-0"><?=$order['note']?></p> 
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
                        <?php if($totalInfo['total']['subtotalCoupon'] >0) {?>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-right"><?= formatNum($subtotal)?></td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Coupon discount:</th>
                                <td class="text-right"><?=$amountData['couponInfo']['code']." - ".$amountData['couponInfo']['discount']?>%</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-right"><?= formatNum($subtotalCoupon)?></td>
                            </tr>
                            <?php }else{?>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-right"><?= formatNum($subtotal)?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th colspan="3" class="text-end">Shipping:</th>
                                <?php if($totalInfo['shipping']['id'] == 3){?>
                                <td class="text-right"><?=formatNum($totalInfo['shipping']['city']['value'])?></td>
                                <?php }else{ ?>
                                    <td class="text-right"><?= formatNum($totalInfo['shipping']['value'])?></td>
                                <?php }?>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <td class="text-right"><?= formatNum($order['amount'])?></td>
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
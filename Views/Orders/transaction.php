<?php 
headerAdmin($data);
$transaction = $data['transaction'];
$idTransaction = $transaction->purchase_units[0]->payments->captures[0]->id;
$date = $transaction->purchase_units[0]->payments->captures[0]->create_time;
$status = $transaction->purchase_units[0]->payments->captures[0]->status;
$amount = $transaction->purchase_units[0]->payments->captures[0]->amount->value;
$currency = $transaction->purchase_units[0]->payments->captures[0]->amount->currency_code;
$name = $transaction->purchase_units[0]->shipping->name->full_name;
$address=$transaction->purchase_units[0]->shipping->address->address_line_1;
$address.=", ".$transaction->purchase_units[0]->shipping->address->admin_area_2;
$address.=" ".$transaction->purchase_units[0]->shipping->address->postal_code;
$address.=", ".$transaction->purchase_units[0]->shipping->address->country_code;
$email = $transaction->payer->email_address;
$payee = $transaction->purchase_units[0]->payee->email_address;
$grossAmount = $transaction->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
$feeAmount = $transaction->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
$netAmount = $transaction->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->net_amount->value;

$refund = false;
if(isset($transaction->purchase_units[0]->payments->refunds)){
    $refund = true;
    $grossAmount = $transaction->purchase_units[0]->payments->refunds[0]->seller_payable_breakdown->gross_amount->value;
    $feeAmount = $transaction->purchase_units[0]->payments->refunds[0]->seller_payable_breakdown->paypal_fee->value;
    $netAmount = $transaction->purchase_units[0]->payments->refunds[0]->seller_payable_breakdown->net_amount->value;
    $dateUpdate = $transaction->purchase_units[0]->payments->captures[0]->update_time;
}
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem"></div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div id="orderInfo">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <img src="<?=media()?>/images/uploads/paypal.png" style="width=100px;height:100px;" alt="">
                        <?php if(!$refund){ 
                            if($_SESSION['permitsModule']['r'] && $_SESSION['userData']['roleid'] != 2){
                        ?>
                            <button type="button" class="btn btn-success text-white" id="btnRefund" data-id="<?=$idTransaction?>"><i class="fas fa-undo"></i> Refund</a>
                        <?php } }?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2"><span class="fw-bold">Transaction:</span> <?=$idTransaction?></p>
                            <p class="m-0"><span class="fw-bold">Date:</span> <?=$date?></p>
                            <p class="m-0"><span class="fw-bold">Status:</span> <?=$status?></p>
                            <p class="m-0"><span class="fw-bold">Amount:</span> <?=$amount?></p>
                            <p class="m-0"><span class="fw-bold">Currency:</span> <?=$currency?></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2 fw-bold">Payer</p>
                            <p class="m-0"><span class="fw-bold">Name:</span> <?=$name?></p>
                            <p class="m-0"><span class="fw-bold">Email:</span> <?=$email?></p>
                            <p class="m-0"><span class="fw-bold">Address:</span> <?=$address?></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="m-0 mb-2 fw-bold">Payee</p>
                            <p class="m-0"><span class="fw-bold">Email:</span> <?=$payee?></p>
                        </div>
                    </div>
                    <?php if($refund){?>
                    <table class="table items align-middle">
                        <thead class="text-center">
                            <tr>
                                <th>Movement</th>
                                <th>Gross amount</th>
                                <th>Papyal fee</th>
                                <th>Net amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if($_SESSION['userData']['roleid'] == 2){?>
                            <tr>
                                <td><?=$dateUpdate.' Refund for '.$name?></td>
                                <td class="text-right"> <?=formatNum($grossAmount)?></td>
                                <td class="text-right"><?=formatNum(0)?></td>
                                <td class="text-right"> <?=formatNum($grossAmount)?></td>
                            </tr>
                            <?php }else{?>
                            <tr>
                                <td><?=$dateUpdate.' Refund for '.$name?></td>
                                <td class="text-right">- <?=formatNum($grossAmount)?></td>
                                <td class="text-right">- <?=formatNum($feeAmount)?></td>
                                <td class="text-right">- <?=formatNum($netAmount)?></td>
                            </tr>
                            <tr>
                                <td><?=$dateUpdate.' Paypal fee canceled for '.$name?></td>
                                <td class="text-right"> <?=formatNum($feeAmount)?></td>
                                <td class="text-right"><?=formatNum(0)?></td>
                                <td class="text-right"> <?=formatNum($feeAmount)?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php }?>
                    <?php if($_SESSION['permitsModule']['r'] && $_SESSION['userData']['roleid'] != 2){?>
                    <div class="row text-start mb-3">
                        <p class="m-0 mb-2 fw-bold">Payment details</p>
                        <p class="m-0"><span class="fw-bold">Gross amount:</span> <?=formatNum($grossAmount)?></p>
                        <p class="m-0"><span class="fw-bold">Paypal fee:</span> -<?=formatNum($feeAmount)?></p>
                        <p class="m-0"><span class="fw-bold">Net amount:</span> <?=formatNum($netAmount)?></p>
                    </div>
                    <?php }?>
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
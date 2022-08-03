<?php 
    //dep($data['message']);exit;
    headerAdmin($data);
    $replies = $data['replies'];
    
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body"> 
                <h2 class="fs-5">You have sent a new message</h2>
                <div class="d-flex justify-content-between flex-wrap">
                    <p class="m-0"><?=$data['message']['name']." (".$data['message']['email'].")"?></p>
                    <p class="m-0"><?=$data['message']['date']?></p>
                </div>
                <hr>
                <label for="" class="fw-bold">Message:</label>
                <p><?=$data['message']['message']?></p>
                <hr>
                <?php
                    if(!empty($replies)){
                        
                ?>
                <label for="" class="fw-bold">Replies:</label>
                <?php for ($i=0; $i < count($replies) ; $i++) {?>
                <div class="mb-3">
                    <p class="m-0 mt-2"><?=$replies[$i]['date']?></p>
                    <p><?=$replies[$i]['reply']?></p>
                </div>
                <?php }?>
                <hr>
                <?php }?>
                <form id="formReply">
                    <input type="hidden" id="idMessage" name="idMessage" value="<?=$data['message']['id']?>">
                    <input type="hidden" id="txtEmail" name="txtEmail" value="<?=$data['message']['email']?>">
                    <input type="hidden" id="txtName" name="txtName" value="<?=$data['message']['name']?>">
                    <div class="mb-3">
                        <textarea class="form-control" id="txtMessage" name="txtMessage" rows="5" placeholder="Click here to reply"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 text-start">
                            <a href="<?=base_url()?>/store/mailbox" class="btn btn-secondary text-white mb-4"><i class="fas fa-arrow-circle-left"></i> back</a>   
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" id="btnSubmit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Reply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
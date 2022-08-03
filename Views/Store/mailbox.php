<?php 
    headerAdmin($data);
    $inbox = $data['inbox'];
    $total ='('.$inbox['total'].')';
    if($inbox['total'] != 0){
        $total = '<span class="badge bg-danger">'.$inbox['total'].'</span>';
    }
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true">New email</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button" role="tab" aria-controls="inbox" aria-selected="true">Inbox <?=$total?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="false">Sent</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash" type="button" role="tab" aria-controls="trash" aria-selected="false">Trash</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                        <form id="formEmail" name="formEmail" class="mb-4 mt-4">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">To:</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="" placeholder="Type an email" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtEmailCC" class="form-label">CC:</label>
                                <input type="email" class="form-control" id="txtEmailCC" name="txtEmailCC" placeholder="Type an email" value="">
                            </div>
                            <div class="mb-3">
                                <label for="txtSubject" class="form-label">Subject:</label>
                                <input type="text" class="form-control" id="txtSubject" name="txtSubject" placeholder="Type a subject" value="" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="txtMessage" name="txtMessage" rows="5" placeholder="Click here to reply"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fas fa-paper-plane"></i> Send</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                        <div class="scroll-y">
                            <?php if($inbox['status']){?>
                                <?=$inbox['data']?>
                            <?php }else{?>
                                <div class="mail-item d-flex justify-content-center align-items-center">
                                    <p class="m-0"><?=$inbox['msg']?></p>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                        
                    </div>
                    <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
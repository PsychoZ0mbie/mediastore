<?php 
headerAdmin($data);
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center"><?=$data['page_title']?></h2>
                <form id="formPage" name="formPage" class="mb-4 mt-4">
                    <input type="hidden" name="idPage" value=<?=$data['page']['id']?>>
                    <div class="mb-3">
                        <label for="txtName" class="form-label">Title</label>
                        <input type="text" class="form-control" id="txtName" name="txtName" value="<?=$data['page']['name']?>">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5"><?=$data['page']['description']?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="far fa-edit"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
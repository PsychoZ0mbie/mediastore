<?php headerAdmin($data)?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="scroll-y">
                    <table class="table text-center items align-middle">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Date created</th>
                                <th>Date updated</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="listItem">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
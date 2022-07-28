<?php headerAdmin($data)?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem"></div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search" name="search">
                    </div>
                </div>
                <div class="scroll-y">
                    <table class="table text-center items align-middle">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Transaction</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
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
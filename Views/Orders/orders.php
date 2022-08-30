<?php 
    headerAdmin($data);
?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="modal fade" tabindex="-1" id="modalPos">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Point of sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="" id="idCustomer" value ="0">
                    <div>
                        <label for="" class="form-label">Customer</label>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchCustomers" name="searchCustomers">
                    </div>
                    <div class="position-relative" id="selectCustomers">
                        <div id="customers" class="bg-white position-absolute w-100" style="overflow-y:scroll; max-height:30vh;"></div>
                    </div>
                    <div id="selectedCustomer"></div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Money received:</label>
                        <input type="number" name="" id="moneyReceived" class="form-control">
                    </div>
                    <p id="saleValue"></p>
                    <p id="moneyBack"></p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btnAddPos">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <button class="nav-link active" id="navOrders-tab" data-bs-toggle="tab" data-bs-target="#navOrders" type="button" role="tab" aria-controls="navOrders" aria-selected="true">Orders</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="quickSale-tab" data-bs-toggle="tab" data-bs-target="#quickSale" type="button" role="tab" aria-controls="quickSale" aria-selected="true">Quick sale</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navOrders">
                        <h2 class="text-center"><?=$data['page_title']?></h2>
                        <button type="button" class="btn btn-success text-white" id="exportExcel" data-name="table<?=$data['page_title']?>" title="Export to excel" ><i class="fas fa-file-excel"></i></button>
                        <div class="row mb-3">
                            <div class="col-md-6 mt-3">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search" name="search">
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center text-end">
                                        <span>Order by: </span>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" aria-label="Default select example" id="sortBy" name="sortBy" required>
                                            <option value="1">Latest</option>
                                            <option value="2">Oldest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="scroll-y">
                            <table class="table text-center items align-middle" id="table<?=$data['page_title']?>">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Transaction</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody id="listItem">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="quickSale">
                        <div class="row mt-3">
                            <div class="col-md-8 mb-3">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchProducts" name="searchProducts">
                                <div class="scroll-y">
                                    <table class="table text-center items align-middle">
                                        <thead>
                                            <tr>
                                                <th>Cover</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="listProducts">
                                            <?=$data['products']['data']?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-3"><i class="fs-4 text-primary fas fa-store"></i> <div class="fs-4 d-inline">Point Of Sale</div>
                                <div class="scroll-y container mb-3 mt-3" id="posProducts"></div>
                                <p class="fw-bold text-start fs-5">Total: <span id="total"><?=formatNum(0)?></span></p>
                                <button type="button" class="btn btn-primary d-none" id="btnPos" disabled onclick="openModalOrder()">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        
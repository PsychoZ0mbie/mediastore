'use strict';

document.querySelector("#btnNew").classList.remove("d-none");

let element = document.querySelector("#listItem");
if(document.querySelector("#btnNew")){
    let btnNew = document.querySelector("#btnNew");
    btnNew.addEventListener("click",function(){
        addItem();
    });
}

window.addEventListener("DOMContentLoaded",function() {
    showItems(element);
})

element.addEventListener("click",function(e) {
    let element = e.target;
    let id = element.getAttribute("data-id");
    if(element.name == "btnDelete"){
        deleteItem(id);
    }else if(element.name == "btnEdit"){
        editItem(id);
    }else if(element.name == "btnView"){
        viewItem(id);
    }
});

function showItems(element){
    let url = base_url+"/Store/getCoupons";
    request(url,"","get").then(function(objData){
        if(objData.status){
            element.innerHTML = objData.data;
        }else{
            element.innerHTML = objData.msg;
        }
    })
}
function addItem(){
    let modalItem = document.querySelector("#modalItem");
    let modal= `
    <div class="modal fade" id="modalElement">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formItem" name="formItem" class="mb-4">
                        <input type="hidden" id="idCoupon" name="idCoupon">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtName" name="txtName" required>
                        </div>
                        <div class="mb-3">
                            <label for="intDiscount" class="form-label">Discount (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="intDiscount" name="intDiscount" required>
                        </div>
                        <div class="mb-3">
                            <label for="typeList" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Add</button>
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    `;

    modalItem.innerHTML = modal;
    let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
    modalView.show();

    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strCode = document.querySelector("#txtName").value;
        let intDiscount = document.querySelector("#intDiscount").value;
        let intStatus = document.querySelector("#statusList").value;
        let idCoupon = document.querySelector("#idCoupon").value;

        if(strCode == "" || intStatus == "" || intDiscount==""){
            Swal.fire("Error","All fields marked with (*) are required","error");
            return false;
        }
        if(intDiscount <=0){
            Swal.fire("Error","Discount field can't be less or equal to 0%","error");
            return false;
        }else if(intDiscount >100){
            Swal.fire("Error","Discount field can't be more than 100%","error");
            return false;
        }
        let url = base_url+"/Store/setCoupon";
        let formData = new FormData(form);
        let btnAdd = document.querySelector("#btnAdd");

        btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
        btnAdd.setAttribute("disabled","");

        request(url,formData,"post").then(function(objData){
            btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Add`;
            btnAdd.removeAttribute("disabled");
            if(objData.status){
                Swal.fire("Added",objData.msg,"success");
                modalView.hide();
                showItems(element);
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    })
}
function editItem(id){
    let url = base_url+"/Store/getCoupon";
    let formData = new FormData();
    formData.append("idCoupon",id);
    request(url,formData,"post").then(function(objData){
        let modalItem = document.querySelector("#modalItem");
        let modal= `
        <div class="modal fade" id="modalElement">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New coupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formItem" name="formItem" class="mb-4">
                            <input type="hidden" id="idCoupon" name="idCoupon" value="${objData.data.id}">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.code}" required>
                            </div>
                            <div class="mb-3">
                                <label for="intDiscount" class="form-label">Discount (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="intDiscount" name="intDiscount" value="${objData.data.discount}" required>
                            </div>
                            <div class="mb-3">
                                <label for="typeList" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Add</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `;

        modalItem.innerHTML = modal;
        let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
        let status = document.querySelectorAll("#statusList option");
        for (let i = 0; i < status.length; i++) {
            if(status[i].value == objData.data.status){
                status[i].setAttribute("selected",true);
            }
        }
        modalView.show();

        let form = document.querySelector("#formItem");
        form.addEventListener("submit",function(e){
            e.preventDefault();

            let strCode = document.querySelector("#txtName").value;
            let intDiscount = document.querySelector("#intDiscount").value;
            let intStatus = document.querySelector("#statusList").value;
            let idCoupon = document.querySelector("#idCoupon").value;

            if(strCode == "" || intStatus == "" || intDiscount==""){
                Swal.fire("Error","All fields marked with (*) are required","error");
                return false;
            }
            if(intDiscount <=0){
                Swal.fire("Error","Discount field can't be less or equal to 0%","error");
                return false;
            }else if(intDiscount >100){
                Swal.fire("Error","Discount field can't be more than 100%","error");
                return false;
            }
            
            let url = base_url+"/Store/setCoupon";
            let formData = new FormData(form);
            let btnAdd = document.querySelector("#btnAdd");

            btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
            btnAdd.setAttribute("disabled","");

            request(url,formData,"post").then(function(objData){
                btnAdd.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire("Updated",objData.msg,"success");
                    modalView.hide();
                    showItems(element);
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        })
    });
}
function deleteItem(id){
    Swal.fire({
        title:"Are you sure to delete it?",
        text:"It will delete for ever...",
        icon: 'warning',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:"Yes, delete",
        cancelButtonText:"No, cancel"
    }).then(function(result){
        if(result.isConfirmed){
            let url = base_url+"/Store/delCoupon"
            let formData = new FormData();
            formData.append("idCoupon",id);
            request(url,formData,"post").then(function(objData){
                if(objData.status){
                    Swal.fire("Deleted",objData.msg,"success");
                    showItems(element);
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        }
    });
}
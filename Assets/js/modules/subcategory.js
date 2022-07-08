export default class SubCategory{
    showItems(element){
        let url = base_url+"/Category/getSubCategories";
        request(url,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        })
    }
    addItem(){
        let modalItem = document.querySelector("#modalItem");
        let modal= `
        <div class="modal fade" id="modalElement">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New subcategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formItem" name="formItem" class="mb-4">
                            <input type="hidden" id="idSubCategory" name="idSubCategory">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
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
        let url = base_url+"/Category/getSelectCategories"
        request(url,"","get").then(function(objData){
            document.querySelector("#categoryList").innerHTML = objData.data;
        });
        modalView.show();

        let form = document.querySelector("#formItem");
        form.addEventListener("submit",function(e){
            e.preventDefault();

            let strName = document.querySelector("#txtName").value;
            let intStatus = document.querySelector("#statusList").value;
            let idSubCategory = document.querySelector("#idSubCategory").value;
            let idCategory = document.querySelector("#categoryList").value;

            if(strName == "" || intStatus == "" || idCategory == ""){
                Swal.fire("Error","All fields marked with (*) are required","error");
                return false;
            }
            
            url = base_url+"/Category/setSubCategory";
            let formData = new FormData(form);
            let btnAdd = document.querySelector("#btnAdd");
            let element = document.querySelector("#listItem");
            btnAdd.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Wait...
            `;
            btnAdd.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Add`;
                btnAdd.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire("Added",objData.msg,"success");
                    //modalView.hide();
                    url = base_url+"/Category/getSubCategories";
                    request(url,"","get").then(function(objData){
                        if(objData.status){
                            element.innerHTML = objData.data;
                        }else{
                            element.innerHTML = objData.msg;
                        }
                    })
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        })
    }
    editItem(id){
        let url = base_url+"/Category/getSubCategory";
        let formData = new FormData();
        formData.append("idSubCategory",id);
        request(url,formData,"post").then(function(objData){
            let modalItem = document.querySelector("#modalItem");
            let modal= `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update subcategory</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formItem" name="formItem" class="mb-4">
                                <input type="hidden" id="idSubCategory" name="idSubCategory" value="${objData.data.idsubcategory}">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnAdd">Add</button>
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
            url = base_url+"/Category/getSelectCategories";
            request(url,"","get").then(function(html){
                document.querySelector("#categoryList").innerHTML = html.data;
                let categories = document.querySelectorAll("#categoryList option");
                for (let i = 0; i < categories.length; i++) {
                    if(categories[i].value == objData.data.categoryid){
                        categories[i].setAttribute("selected",true);
                    }
                }
            });
            modalView.show();

            let form = document.querySelector("#formItem");
            form.addEventListener("submit",function(e){
                e.preventDefault();

                let strName = document.querySelector("#txtName").value;
                let intStatus = document.querySelector("#statusList").value;
                let idSubCategory = document.querySelector("#idSubCategory").value;
                let idCategory = document.querySelector("#categoryList").value;

                if(strName == "" || intStatus == "" || idCategory == ""){
                    Swal.fire("Error","All fields marked with (*) are required","error");
                    return false;
                }
                
                url = base_url+"/Category/setSubCategory";
                let formData = new FormData(form);
                let btnAdd = document.querySelector("#btnAdd");
                let element = document.querySelector("#listItem");
                btnAdd.innerHTML=`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Wait...
                `;
                btnAdd.setAttribute("disabled","");
                request(url,formData,"post").then(function(objData){
                    btnAdd.innerHTML=`Update`;
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        Swal.fire("Updated",objData.msg,"success");
                        modalView.hide();
                        url = base_url+"/Category/getSubCategories";
                        request(url,"","get").then(function(objData){
                            if(objData.status){
                                element.innerHTML = objData.data;
                            }else{
                                element.innerHTML = objData.msg;
                            }
                        })
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            })
        });
    }
    deleteItem(id){
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
                let url = base_url+"/Category/delSubCategory"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idSubCategory",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Deleted",objData.msg,"success");
                        url = base_url+"/Category/getSubCategories";
                        request(url,"","get").then(function(objData){
                            if(objData.status){
                                element.innerHTML = objData.data;
                            }else{
                                element.innerHTML = objData.msg;
                            }
                        })
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            }
        });
    }
}
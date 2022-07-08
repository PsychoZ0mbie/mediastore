export default class Category{
    showItems(element){
        let url = base_url+"/Category/getCategories";
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
                        <h5 class="modal-title" id="staticBackdropLabel">New category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formItem" name="formItem" class="mb-4">
                            <input type="hidden" id="idCategory" name="idCategory">
                            <div class="mb-3 uploadImg">
                                <img src="${base_url}/Assets/images/uploads/category.jpg">
                                <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                                <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                            </div>
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtName" name="txtName" required>
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

        let img = document.querySelector("#txtImg");
        let imgLocation = ".uploadImg img";
        img.addEventListener("change",function(){
            uploadImg(img,imgLocation);
        });

        let form = document.querySelector("#formItem");
        form.addEventListener("submit",function(e){
            e.preventDefault();

            let strName = document.querySelector("#txtName").value;
            let intStatus = document.querySelector("#statusList").value;
            let idCategory = document.querySelector("#idCategory").value;

            if(strName == "" || intStatus == ""){
                Swal.fire("Error","All fields marked with (*) are required","error");
                return false;
            }
            
            let url = base_url+"/Category/setCategory";
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
                    url = base_url+"/Category/getCategories";
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
        let url = base_url+"/Category/getCategory";
        let formData = new FormData();
        formData.append("idCategory",id);
        request(url,formData,"post").then(function(objData){
            let modalItem = document.querySelector("#modalItem");
            let modal= `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formItem" name="formItem" class="mb-4">
                                <input type="hidden" id="idCategory" name="idCategory" value="${objData.data.idcategory}">
                                <div class="mb-3 uploadImg">
                                    <img src="${objData.data.picture}">
                                    <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                                    <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                                </div>
                                <div class="mb-3">
                                    <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="typeList" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnAdd">Update</button>
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

            let img = document.querySelector("#txtImg");
            let imgLocation = ".uploadImg img";
            img.addEventListener("change",function(){
                uploadImg(img,imgLocation);
            });

            let form = document.querySelector("#formItem");
            form.addEventListener("submit",function(e){
                e.preventDefault();
    
                let strName = document.querySelector("#txtName").value;
                let intStatus = document.querySelector("#statusList").value;
                let idCategory = document.querySelector("#idCategory").value;
    
                if(strName == "" || intStatus == ""){
                    Swal.fire("Error","All fields marked with (*) are required","error");
                    return false;
                }
                
                let url = base_url+"/Category/setCategory";
                let formData = new FormData(form);
                let btnAdd = document.querySelector("#btnAdd");
                let element = document.querySelector("#listItem");
                btnAdd.innerHTML=`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Wait...
                `;
                btnAdd.setAttribute("disabled","");
                request(url,formData,"post").then(function(objData){
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        Swal.fire("Updated",objData.msg,"success");
                        modalView.hide();
                        url = base_url+"/Category/getCategories";
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
                let url = base_url+"/Category/delCategory"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idCategory",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Deleted",objData.msg,"success");
                        url = base_url+"/Category/getCategories";
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
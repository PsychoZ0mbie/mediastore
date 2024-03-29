
let search = document.querySelector("#search");
let sort = document.querySelector("#sortBy");
let element = document.querySelector("#listItem");

search.addEventListener('input',function() {
    request(base_url+"/post/search/"+search.value,"","get").then(function(objData){
        if(objData.status){
            element.innerHTML = objData.data;
        }else{
            element.innerHTML = objData.msg;
        }
    });
})
sort.addEventListener("change",function(){
    request(base_url+"/post/sort/"+sort.value,"","get").then(function(objData){
        if(objData.status){
            element.innerHTML = objData.data;
        }else{
            element.innerHTML = objData.msg;
        }
    });
});

if(document.querySelector("#btnNew")){
    document.querySelector("#btnNew").classList.remove("d-none");
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
    }else if(element.name == "btnView"){
        viewItem(id);
    }else if(element.name == "btnEdit"){
        editItem(id);
    }
});

function showItems(element){
    let url = base_url+"/post/getArticles";
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
    let modal = `
    <div class="modal fade" id="modalElement">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formItem" name="formItem" class="mb-4">  
                        <input type="hidden" id="idArticle" name="idArticle" value="">
                        <div class="mb-3 uploadImg">
                            <img src="${base_url}/Assets/images/uploads/category.jpg">
                            <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                            <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                        </div>
                        <div class="mb-3">
                            <label for="txtName" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtName" name="txtName" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoryList" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subcategoryList" class="form-label">Subcategory <span class="text-danger">*</span></label>
                                    <select class="form-control" aria-label="Default select example" id="subcategoryList" name="subcategoryList" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="statusList" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txtDescription" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5"></textarea>
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
    let categoryList = document.querySelector("#categoryList");
    let subcategoryList = document.querySelector("#subcategoryList");
    let btnAdd = document.querySelector("#btnAdd");

    request(base_url+"/post/getSelectCategories","","get").then(function(objData){
        categoryList.innerHTML = objData.data;
    });

    categoryList.addEventListener("change",function(){
        let formData = new FormData();
        formData.append("idCategory",categoryList.value);

        request(base_url+"/post/getSelectSubcategories",formData,"post").then(function(objData){
            document.querySelector("#subcategoryList").innerHTML = objData.data;
        });
    });

    setTinymce("#txtDescription");

    form.addEventListener("submit",function(e){
        e.preventDefault();
        tinymce.triggerSave();
        let strName = document.querySelector("#txtName").value;
        let strDescription = document.querySelector("#txtDescription").value;
        let intStatus = document.querySelector("#statusList");
        let intSubCategory = subcategoryList.value;
        let intCategory = categoryList.value;

        if(strName == "" || intStatus == "" || intCategory == 0 || intSubCategory==0 || strDescription==""){
            Swal.fire("Error","All fields marked with (*) are required","error");
            return false;
        }

        let data = new FormData(form);
        
        btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
        btnAdd.setAttribute("disabled","");

        request(base_url+"/post/setArticle",data,"post").then(function(objData){
            btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Add`;
            btnAdd.removeAttribute("disabled");
            if(objData.status){
                Swal.fire("Added",objData.msg,"success");
                modalView.hide();
                modalItem.innerHTML="";
                showItems(element);
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    });
}
function viewItem(id){
    let url = base_url+"/post/getArticle";
    let formData = new FormData();
    
    formData.append("idArticle",id);
    request(url,formData,"post").then(function(objData){
        if(objData.status){
            let status = objData.data.status;
            let img="";
            if(status==1){
                status='<span class="badge me-1 bg-success">Active</span>';
            }else{
                status='<span class="badge me-1 bg-danger">Inactive</span>';
            }
            if(objData.data.picture!=""){
                img= `<tr>
                        <td><img src="${objData.data.picture}" class="rounded-circle" style="height:100px;width:100px;"></td>
                    </tr>`;
            }
            let modalItem = document.querySelector("#modalItem");
            let modal= `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Article data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table align-middle text-break">
                                <tbody id="listItem">
                                    ${img}
                                    <tr>
                                        <td><strong>Title: </strong></td>
                                        <td>${objData.data.name}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Category: </strong></td>
                                        <td>${objData.data.category}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Subcategory: </strong></td>
                                        <td>${objData.data.subcategory}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date created: </strong></td>
                                        <td>${objData.data.date}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date updated: </strong></td>
                                        <td>${objData.data.dateupdated}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status: </strong></td>
                                        <td>${status}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            `;
            modalItem.innerHTML = modal;
            let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
            modalView.show();
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
    });
}
function editItem(id){ 
    let url = base_url+"/post/getArticle";
    let formData = new FormData();
    formData.append("idArticle",id);
    request(url,formData,"post").then(function(objData){
        let picture = base_url+"/Assets/images/uploads/category.jpg";
        if(objData.data.picture !=""){
            picture = objData.data.picture;
        }
        let modalItem = document.querySelector("#modalItem");
        let modal = `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">New article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formItem" name="formItem" class="mb-4">  
                                <input type="hidden" id="idArticle" name="idArticle" value="${objData.data.idarticle}">
                                <div class="mb-3 uploadImg">
                                    <img src="${picture}">
                                    <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                                    <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                                </div>
                                <div class="mb-3">
                                    <label for="txtName" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="categoryList" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subcategoryList" class="form-label">Subcategory <span class="text-danger">*</span></label>
                                            <select class="form-control" aria-label="Default select example" id="subcategoryList" name="subcategoryList" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="statusList" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="txtDescription" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5" value=""></textarea>
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
        document.querySelector("#txtDescription").value = objData.data.description;
        request(base_url+"/post/getSelectCategories","","get").then(function(html){
            document.querySelector("#categoryList").innerHTML = html.data;
            let categories = document.querySelectorAll("#categoryList option");
            for (let i = 0; i < categories.length; i++) {
                if(categories[i].value == objData.data.categoryid){
                    categories[i].setAttribute("selected",true);
                    let formData = new FormData();

                    formData.append("idCategory",objData.data.categoryid);
                    request(base_url+"/post/getSelectSubcategories",formData,"post").then(function(htmls){
                        document.querySelector("#subcategoryList").innerHTML = htmls.data;
                        let subcategories = document.querySelectorAll("#subcategoryList option");
                        for (let i = 0; i < subcategories.length; i++) {
                            if(subcategories[i].value == objData.data.subcategoryid){
                                subcategories[i].setAttribute("selected",true);
                                break;
                            }
                        }
                    });
                    break;
                }
            }
        });

        modalView.show();
        
        let img = document.querySelector("#txtImg");
        let imgLocation = ".uploadImg img";
        img.addEventListener("change",function(){
            uploadImg(img,imgLocation);
        });
        setTinymce("#txtDescription");
        let form = document.querySelector("#formItem");
        form.addEventListener("submit",function(e){
            e.preventDefault();
            tinymce.triggerSave();
            let strName = document.querySelector("#txtName").value;
            let strDescription = document.querySelector("#txtDescription").value;
            let intStatus = document.querySelector("#statusList");
            let intSubCategory = subcategoryList.value;
            let intCategory = categoryList.value;

            if(strName == "" || intStatus == "" || intCategory == 0 || intSubCategory==0 || strDescription==""){
                Swal.fire("Error","All fields marked with (*) are required","error");
                return false;
            }

            let data = new FormData(form);
            
            btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
            btnAdd.setAttribute("disabled","");

            request(base_url+"/post/setArticle",data,"post").then(function(objData){
                btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Add`;
                btnAdd.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire("Added",objData.msg,"success");
                    modalView.hide();
                    modalItem.innerHTML="";
                    showItems(element);
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        });
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
            let formData = new FormData();
            formData.append("idArticle",id);
            request(base_url+"/post/delArticle",formData,"post").then(function(objData){
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


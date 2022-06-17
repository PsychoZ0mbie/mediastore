export default class Product{
    showItems(element){
        let url = base_url+"/Product/getProducts";
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
        let modal = `
        <div class="modal fade" id="modalElement">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formFile" name="formFile">
                            <div class="row scrolly" id="upload-multiple">
                                <div class="col-md-3">
                                    <div class="mb-3 upload-images">
                                        <label for="txtImg" class="text-primary text-center d-flex justify-content-center align-items-center">
                                            <div>
                                                <i class="far fa-images fs-1"></i>
                                                <p class="m-0">Subir imágen</p>
                                            </div>
                                        </label>
                                        <input class="d-none" type="file" id="txtImg" name="txtImg[]" multiple accept="image/*"> 
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="formItem" name="formItem" class="mb-4">  
                            <input type="hidden" id="idProduct" name="idProduct" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtReference" class="form-label">Referencia</label>
                                        <input type="text" class="form-control" id="txtReference" name="txtReference" placeholder="SKU">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subcategoryList" class="form-label">SubCategoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="subcategoryList" name="subcategoryList" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtDiscount" class="form-label">Descuento</label>
                                        <input type="number" class="form-control"  max="99" id="txtDiscount" name="txtDiscount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPrice" class="form-label">Precio <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" min ="1" id="txtPrice" name="txtPrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtStock" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" value="1" min="0" class="form-control" id="txtStock" name="txtStock">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="txtDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Agregar</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
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
        let formFile = document.querySelector("#formFile");
        let parent = document.querySelector("#upload-multiple");
        let img = document.querySelector("#txtImg");
        let categoryList = document.querySelector("#categoryList");
        let subcategoryList = document.querySelector("#subcategoryList");
        let btnAdd = document.querySelector("#btnAdd");
        form.reset();
        formFile.reset();
        if(document.querySelectorAll(".upload-image")){
            let divImg = document.querySelectorAll(".upload-image");
            for (let i = 0; i < divImg.length; i++) {
                divImg[i].remove();
            }
        }
        request(base_url+"/Product/getSelectCategories","","get").then(function(objData){
            categoryList.innerHTML = `<option value="0" selected>Seleccione categoría</option>`+objData.data;
            subcategoryList.innerHTML = `<option value="0" selected>Seleccione subcategoría</option>`;
        });
        img.addEventListener("change",function(e){
            if(img.value!=""){
                let formImg = new FormData(formFile);
                let url = base_url+"/Product/setImg";
                
                uploadMultipleImg(img,parent);
                formImg.append("id","");
                request(url,formImg,"post").then(function(objData){});
            }
        });
        parent.addEventListener("click",function(e){
            if(e.target.className =="deleteImg"){
                let divImg = document.querySelectorAll(".upload-image");
                let deleteItem = e.target.parentElement;
                let nameItem = deleteItem.getAttribute("data-name");
                let arrDel = [];
                let imgDel;
                for (let i = 0; i < divImg.length; i++) {
                    if(divImg[i].getAttribute("data-name")==nameItem){
                        deleteItem.remove();
                        imgDel = document.querySelectorAll(".upload-image");
                    }
                }
                for (let i = 0; i < imgDel.length; i++) {
                    arrDel.push(imgDel[i].getAttribute("data-name"));
                }
                let url = base_url+"/Product/delImg";
                let formDel = new FormData();

                formDel.append("id","");
                formDel.append("files",JSON.stringify(arrDel));
                request(url,formDel,"post").then(function(objData){});
            }
        });
        categoryList.addEventListener("change",function(){
            let formData = new FormData();
            formData.append("idCategory",categoryList.value);

            request(base_url+"/Product/getSelectSubcategories",formData,"post").then(function(objData){
                document.querySelector("#subcategoryList").innerHTML = objData.data;
            });
        });
        let flag = true;
        form.addEventListener("submit",function(e){
            e.preventDefault();
            e.stopPropagation();
            let strName = document.querySelector("#txtName").value;
            let intDiscount = document.querySelector("#txtDiscount").value;
            let intPrice = document.querySelector("#txtPrice").value;
            let intStatus = document.querySelector("#statusList").value;
            let intStock = document.querySelector("#txtStock").value;
            let intSubCategory = subcategoryList.value;
            let intCategory = categoryList.value;
            let images = document.querySelectorAll(".upload-image");

            if(strName == "" || intStatus == "" || intCategory == 0 || intSubCategory==0 || intPrice=="" || intStock==""){
                Swal.fire("Error","Todos los campos con (*) son obligatorios","error");
                return false;
            }
            if(images.length < 1){
                Swal.fire("Error","Debes subir al menos una imágen","error");
                return false;
            }
            if(intPrice <= 0){
                Swal.fire("Error","El precio no puede ser menor o igual a 0","error");
                return false;
            }
            if(intDiscount !=""){
                if(intDiscount < 0){
                    Swal.fire("Error","El descuento no puede ser menor a 0%","error");
                    document.querySelector("#txtDiscount").value="";
                    return false;
                }else if(intDiscount > 100){
                    Swal.fire("Error","El descuento no puede ser mayor a 100%","error");
                    document.querySelector("#txtDiscount").value="";
                    return false;
                }
            }
            
            
            let data = new FormData(form);
            let element = document.querySelector("#listItem");
            
            if(flag ===true){
                btnAdd.innerHTML=`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Espera...
                `;
                btnAdd.setAttribute("disabled","");
                request(base_url+"/Product/setProduct",data,"post").then(function(objData){
                    modalView.hide();
                    form.reset();
                    formFile.reset();
                    if(objData.status){
                        Swal.fire("Agregado",objData.msg,"success");
                        //modalView.hide();
                        let divImg = document.querySelectorAll(".upload-image");
                        for (let i = 0; i < divImg.length; i++) {
                            divImg[i].remove();
                        }
                        /*request(base_url+"/Product/getSelectCategories","","get").then(function(objData){
                            categoryList.innerHTML = `<option value="0" selected>Seleccione categoría</option>`+objData.data;
                            subcategoryList.innerHTML = `<option value="0" selected>Seleccione subcategoría</option>`;
                        });*/
                        request(base_url+"/Product/getProducts","","get").then(function(objData){
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
                modalItem.innerHTML="";
                btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Agregar`;
                btnAdd.removeAttribute("disabled");
                flag = false;
            }
        },false);
    }
    viewItem(id){
        let url = base_url+"/Product/getProduct";
        let formData = new FormData();
        formData.append("idProduct",id);
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let images = objData.data.image;
                let html = "";
                let discount =objData.data.discount;
                let status = objData.data.status;
                if(images[0]!=""){
                    for (let i = 0; i < images.length; i++) {
                        html+=`
                            <div class="col-md-3 upload-image mb-3">
                                <img src="${images[i]['url']}">
                            </div>
                        `;
                        
                    }
                }
                if(discount>0){
                    discount = `<span class="text-success">${discount}% OFF</span>`
                }else{
                    discount = `<span class="text-danger">Sin descuento</span>`
                }
                if(status==1){
                    status='<span class="badge me-1 bg-success">Activo</span>';
                }else{
                    status='<span class="badge me-1 bg-danger">Inactivo</span>';
                }
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Datos de producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table align-middle text-break text-center">
                                    <tbody id="listItem">
                                        <tr>
                                            <td class="row scrolly">${html}</td>
                                        </tr>
                                        <tr><td><strong>Referencia: </strong>${objData.data.reference}</td></tr>
                                        <tr><td><strong>Nombre: </strong>${objData.data.name}</td></tr>
                                        <tr><td><strong>Categoría: </strong>${objData.data.category}</td></tr>
                                        <tr><td><strong>Subcategoría: </strong>${objData.data.subcategory}</td></tr>
                                        <tr><td><strong>Precio: </strong>${objData.data.priceFormat}</td></tr>
                                        <tr><td><strong>Descuento: </strong>${discount}</td></tr>
                                        <tr><td><strong>Cantidad: </strong>${objData.data.stock}</td></tr>
                                        <tr><td><strong>Fecha de registro: </strong>${objData.data.date}</td></tr>
                                        <tr><td><strong>Estado: </strong>${status}</td></tr>
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
    editItem(id){ 

        let modalItem = document.querySelector("#modalItem");
        
        let modal = `
        <div class="modal fade" id="modalElement">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Actualizar producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formFile" name="formFile">
                            <div class="row scrolly" id="upload-multiple">
                                <div class="col-md-3">
                                    <div class="mb-3 upload-images">
                                        <label for="txtImg" class="text-primary text-center d-flex justify-content-center align-items-center">
                                            <div>
                                                <i class="far fa-images fs-1"></i>
                                                <p class="m-0">Subir imágen</p>
                                            </div>
                                        </label>
                                        <input class="d-none" type="file" id="txtImg" name="txtImg[]" multiple accept="image/*"> 
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="formItem" name="formItem" class="mb-4">  
                            <input type="hidden" id="idProduct" name="idProduct" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtReference" class="form-label">Referencia</label>
                                        <input type="text" class="form-control" id="txtReference" name="txtReference" placeholder="SKU">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subcategoryList" class="form-label">SubCategoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="subcategoryList" name="subcategoryList" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtDiscount" class="form-label">Descuento</label>
                                        <input type="number" class="form-control"  max="99" id="txtDiscount" name="txtDiscount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPrice" class="form-label">Precio <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" min ="1" id="txtPrice" name="txtPrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtStock" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" value="1" min="0" class="form-control" id="txtStock" name="txtStock">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="txtDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnAdd">Actualizar</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
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
        let formFile = document.querySelector("#formFile");
        let parent = document.querySelector("#upload-multiple");
        let img = document.querySelector("#txtImg");
        let categoryList = document.querySelector("#categoryList");
        let subcategoryList = document.querySelector("#subcategoryList");
        let btnAdd = document.querySelector("#btnAdd");
        form.reset();
        formFile.reset();
        let formData = new FormData();
        formData.append("idProduct",id);
        request(base_url+"/Product/getProduct",formData,"post").then(function(objData){
            let status = document.querySelectorAll("#statusList option");
            let images = objData.data.image;
            document.querySelector("#idProduct").value = objData.data.idproduct;
            document.querySelector("#txtReference").value = objData.data.reference;
            document.querySelector("#txtName").value = objData.data.name;
            document.querySelector("#txtDiscount").value = objData.data.discount;
            document.querySelector("#txtPrice").value = objData.data.price;
            document.querySelector("#txtStock").value = objData.data.stock;
            document.querySelector("#txtDescription").value=objData.data.description; 
            //modal.classList.remove("d-none");

            for (let i = 0; i < status.length; i++) {
                if(status[i].value == objData.data.status){
                    status[i].setAttribute("selected",true);
                    break;
                }
            }
            if(images[0]!=""){
                for (let i = 0; i < images.length; i++) {
                    let div = document.createElement("div");
                    div.classList.add("col-md-3","upload-image","mb-3");
                    div.setAttribute("data-name",images[i]['name']);
                    div.innerHTML = `
                            <img>
                            <div class="deleteImg" name="delete">x</div>
                    `
                    div.children[0].setAttribute("src",images[i]['url']);
                    parent.appendChild(div);
                }
            }
            request(base_url+"/Product/getSelectCategories","","get").then(function(html){
                document.querySelector("#categoryList").innerHTML = `<option value="0">Seleccione categoría</option>`+html.data;
                let categories = document.querySelectorAll("#categoryList option");
                for (let i = 0; i < categories.length; i++) {
                    if(categories[i].value == objData.data.categoryid){
                        categories[i].setAttribute("selected",true);
                        let formData = new FormData();

                        formData.append("idCategory",objData.data.categoryid);
                        request(base_url+"/Product/getSelectSubcategories",formData,"post").then(function(htmls){
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
        });
        modalView.show();
        img.addEventListener("change",function(e){
            e.stopPropagation();
            if(img.value!=""){
                let formImg = new FormData(formFile);
                let id = document.querySelector("#idProduct").value;
                uploadMultipleImg(img,parent);
                formImg.append("id",id);
                request(base_url+"/Product/setImg",formImg,"post").then(function(objData){});
            }
        },false);
        parent.addEventListener("click",function(e){
            let flagImg = true;
            e.stopPropagation();
            if(e.target.className =="deleteImg"){
                let deleteItem = e.target.parentElement;
                let nameItem = deleteItem.getAttribute("data-name");
                let arrDel = [];
                let imgDel = [];
                let divImg = document.querySelectorAll(".upload-image");
                for (let i = 0; i < divImg.length; i++) {
                    if(divImg[i].getAttribute("data-name") == nameItem){
                        deleteItem.remove();
                        imgDel = document.querySelectorAll(".upload-image");
                        break;
                    }
                }
                for (let i = 0; i < imgDel.length; i++) {
                    arrDel.push(imgDel[i].getAttribute("data-name"));
                }
                let formDel = new FormData();
                formDel.append("id",document.querySelector("#idProduct").value);
                formDel.append("files",JSON.stringify(arrDel));
                if(flagImg === true){
                    request(base_url+"/Product/delImg",formDel,"post").then(function(objData){formFile.reset();});
                    flagImg = false;
                }
            }
        },false);
        categoryList.addEventListener("change",function(){
            let formData = new FormData();
            formData.append("idCategory",categoryList.value);

            request(base_url+"/Product/getSelectSubcategories",formData,"post").then(function(objData){
                document.querySelector("#subcategoryList").innerHTML = objData.data;
            });
        },false);

        let flag = true;
        form.addEventListener("submit",function(e){
            e.preventDefault();
            e.stopPropagation();
            
            
            let strName = document.querySelector("#txtName").value;
            let intDiscount = document.querySelector("#txtDiscount").value;
            let intPrice = document.querySelector("#txtPrice").value;
            let intStatus = document.querySelector("#statusList").value;
            let intSubCategory = subcategoryList.value;
            let intCategory = categoryList.value;
            let images = document.querySelectorAll(".upload-image");

            
            if(strName == "" || intStatus == "" || intCategory == 0 || intSubCategory==0 || intPrice==""){
                Swal.fire("Error","Todos los campos con (*) son obligatorios","error");
                return false;
            }
            if(images.length < 1){
                Swal.fire("Error","Debes subir al menos una imágen","error");
                return false;
            }
            if(intPrice <= 0){
                Swal.fire("Error","El precio no puede ser menor o igual a 0","error");
                return false;
            }
            if(intDiscount !=""){
                if(intDiscount < 0){
                    Swal.fire("Error","El descuento no puede ser menor a 0%","error");
                    document.querySelector("#txtDiscount").value="";
                    return false;
                }else if(intDiscount > 100){
                    Swal.fire("Error","El descuento no puede ser mayor a 100%","error");
                    document.querySelector("#txtDiscount").value="";
                    return false;
                }
            }
            
            let data = new FormData(form);
            let element = document.querySelector("#listItem");
            btnAdd.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Espera...
                `;
            btnAdd.setAttribute("disabled","");
            if(flag === true){
                request(base_url+"/Product/setProduct",data,"post").then(function(objData){
                    form.reset();
                    formFile.reset();
                    if(objData.status){
                        Swal.fire("Actualizado",objData.msg,"success");
                        modalView.hide();
                        let divImg = document.querySelectorAll(".upload-image");
                        for (let i = 0; i < divImg.length; i++) {
                            divImg[i].remove();
                        }
                        request(base_url+"/Product/getProducts","","get").then(function(objData){
                            if(objData.status){
                                element.innerHTML = objData.data;
                            }else{
                                element.innerHTML = objData.msg;
                            }
                        });
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
                btnAdd.innerHTML=`Actualizar`;
                btnAdd.removeAttribute("disabled");
                modalItem.innerHTML="";
                flag = false;
            }
            
        },false);
        
    }
    deleteItem(id){
        Swal.fire({
            title:"¿Está segur@ de eliminar?",
            text:"Se eliminará para siempre",
            icon: 'warning',
            showCancelButton:true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText:"Sí, eliminar",
            cancelButtonText:"No, cancelar"
        }).then(function(result){
            if(result.isConfirmed){
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idProduct",id);
                request(base_url+"/Product/delProduct",formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Eliminado",objData.msg,"success");
                        request(base_url+"/Product/getProducts","","get").then(function(objData){
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
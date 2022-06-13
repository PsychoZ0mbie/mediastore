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
        let modal = document.querySelector("#modalElement");
        let form = document.querySelector("#formItem");
        let formFile = document.querySelector("#formFile");
        let modalView = new bootstrap.Modal(modal);
        let url = base_url+"/Product/getSelectCategories";
        let parent = document.querySelector("#upload-multiple");
        let img = document.querySelector("#txtImg");
        let categoryList = document.querySelector("#categoryList");
        let subcategoryList = document.querySelector("#subcategoryList");
        modal.classList.remove("d-none");

        request(url,"","get").then(function(objData){
            categoryList.innerHTML = `<option value="0" selected>Seleccione categoría</option>`+objData.data;
            subcategoryList.innerHTML = `<option value="0" selected>Seleccione subcategoría</option>`;
        });

        modalView.show();

        img.addEventListener("change",function(e){
            if(img.value!=""){
                let formImg = new FormData(formFile);
                url = base_url+"/Product/setImg";
                uploadMultipleImg(img,parent);
                request(url,formImg,"post").request(function(objData){});
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
                url = base_url+"/Product/delImg";
                let formDel = new FormData();
                formDel.append("files",JSON.stringify(arrDel));
                request(url,formDel,"post").request(function(objData){});
            }
        });
        categoryList.addEventListener("change",function(){
            url = base_url+"/Product/getSelectSubcategories"
            let formData = new FormData();
            formData.append("idCategory",categoryList.value);

            request(url,formData,"post").then(function(objData){
                document.querySelector("#subcategoryList").innerHTML = objData.data;
            });
        });

        form.addEventListener("submit",function(e){
            e.preventDefault();
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
            
            url = base_url+"/Product/setProduct";
            let formData = new FormData(form);
            let btnAdd = document.querySelector("#btnAdd");
            let element = document.querySelector("#listItem");
            btnAdd.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Espera...
            `;
            btnAdd.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnAdd.innerHTML=`<i class="fas fa-plus-circle"></i> Agregar`;
                btnAdd.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire("Agregado",objData.msg,"success");
                    //modalView.hide();
                    form.reset();
                    /*url = base_url+"/Product/getProducts";
                    request(url,"","get").then(function(objData){
                        if(objData.status){
                            element.innerHTML = objData.data;
                        }else{
                            element.innerHTML = objData.msg;
                        }
                    })*/
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
                            <h5 class="modal-title" id="staticBackdropLabel">Actualizar categoría</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formItem" name="formItem" class="mb-4">
                                <input type="hidden" id="idSubCategory" name="idSubCategory" value="${objData.data.idsubcategory}">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
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
                    Swal.fire("Error","Todos los campos con (*) son obligatorios","error");
                    return false;
                }
                
                url = base_url+"/Category/setSubCategory";
                let formData = new FormData(form);
                let btnAdd = document.querySelector("#btnAdd");
                let element = document.querySelector("#listItem");
                btnAdd.innerHTML=`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Espera...
                `;
                btnAdd.setAttribute("disabled","");
                request(url,formData,"post").then(function(objData){
                    btnAdd.innerHTML=`Actualizar`;
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        Swal.fire("Actualizado",objData.msg,"success");
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
                let url = base_url+"/Category/delSubCategory"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idSubCategory",id);
                request(url,formData,"post").then(function(objData){
                    Swal.fire("Eliminado",objData.msg,"success");
                    url = base_url+"/Category/getSubCategories";
                    request(url,"","get").then(function(objData){
                        if(objData.status){
                            element.innerHTML = objData.data;
                        }else{
                            element.innerHTML = objData.msg;
                        }
                    })
                });
            }
        });
    }
}
export default class User{
    showItems(element){
        let url = base_url+"/User/getUsers";
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
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formItem" name="formItem" class="mb-4">
                            <input type="hidden" id="idUser" name="idUser">
                            <div class="mb-3 uploadImg">
                                <img src="${base_url}/Assets/images/uploads/user.jpg">
                                <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                                <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtFirstName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtLastName" class="form-label">Apellido <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtLastName" name="txtLastName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtEmail" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPhone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtPhone" name="txtPhone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPassword" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="typeList" class="form-label">Rol de usuario <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="typeList" name="typeList" required></select>
                                    </div>
                                </div>
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
        let url = base_url+"/User/getRoles";
        request(url,"","get").then(function(objData){
            document.querySelector("#typeList").innerHTML = objData.data;
        });
        modalView.show();

        let img = document.querySelector("#txtImg");
        let imgLocation = ".uploadImg img";
        img.addEventListener("change",function(){
            uploadImg(img,imgLocation);
        });

        let form = document.querySelector("#formItem");
        form.addEventListener("submit",function(e){
            e.preventDefault();
            let strFirstName = document.querySelector("#txtFirstName").value;
            let strLastName = document.querySelector("#txtLastName").value;
            let strEmail = document.querySelector("#txtEmail").value;
            let strPhone = document.querySelector("#txtPhone").value;
            let typeValue = document.querySelector("#typeList").value;
            let strPassword = document.querySelector("#txtPassword").value;
            let idUser = document.querySelector("#idUser").value;

            if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == ""){
                Swal.fire("Error","Todos los campos con (*) son obligatorios","error");
                return false;
            }
            if(strPassword.length < 8 && strPassword!=""){
                Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres","error");
                return false;
            }
            if(!fntEmailValidate(strEmail)){
                let html = `
                <br>
                <br>
                <p>micorreo@hotmail.com</p>
                <p>micorreo@outlook.com</p>
                <p>micorreo@yahoo.com</p>
                <p>micorreo@live.com</p>
                <p>micorreo@gmail.com</p>
                `;
                Swal.fire("Error","El correo es inválido, solo permite los siguientes correos: "+html,"error");
                return false;
            }
            if(strPhone.length < 10){
                Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
                return false;
            }
            
            url = base_url+"/User/setUser";
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
                    modalView.hide();
                    url = base_url+"/User/getUsers";
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
    permitItem(id){
        let url = base_url+"/Role/getPermits";
        let formData = new FormData();
        formData.append("idRol",id);
        request(url,formData,"post").then(function(objData){
            let module = objData.module;
            let permit = objData.permit;
            let htmlModule = "";
            for (let i = 0; i < module.length; i++) {
                htmlModule+=`
                <tr>
                    <td class="text-start" >
                        <div>
                            <input type="hidden" value ="${module[i]['idmodule']}">
                            ${module[i]['name']}
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center" style="width:100px;">
                            <input class="form-check-input" type="checkbox" role="switch" id="r${module[i]['idmodule']}">
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center" style="width:100px;">
                            <input class="form-check-input" type="checkbox" role="switch" id="w${module[i]['idmodule']}">
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center" style="width:100px;">
                            <input class="form-check-input" type="checkbox" role="switch" id="u${module[i]['idmodule']}">
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center" style="width:100px;">
                            <input class="form-check-input" type="checkbox" role="switch" id="d${module[i]['idmodule']}">
                        </div>
                    </td>
                </tr>
                `;
            }
            let modalItem = document.querySelector("#modalItem");
            let modal= `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Permisos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Módulo</th>
                                            <th>Leer</th>
                                            <th>Crear</th>
                                            <th>Actualizar</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modules">
                                        ${htmlModule}
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btnAdd">Guardar</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            `;
            modalItem.innerHTML = modal;
            let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
            for (let i = 0; i < module.length; i++) {
                if(permit.length > 0){
                    for (let j = 0; j < permit.length; j++) {
                        if(module[i]['idmodule'] == permit[j]['moduleid']){
                            document.querySelector("#r"+(i+1)).checked=permit[j]['r'];
                            document.querySelector("#w"+(i+1)).checked=permit[j]['w'];
                            document.querySelector("#u"+(i+1)).checked=permit[j]['u'];
                            document.querySelector("#d"+(i+1)).checked=permit[j]['d'];
                        }
                    }
                }
            }

            modalView.show();
            let btnAdd = document.querySelector("#btnAdd");
            btnAdd.addEventListener("click",function(){
                let row = document.querySelectorAll("#modules tr");
                let data = new Array();
                for (let i = 0; i < row.length; i++) {
                    let col = row[i].children;
                    data[i] = new Array();
                    for (let j = 0; j < col.length; j++) {
                        if(j == 0){
                            data[i][j] = (col[j].children[0].children[0].value);
                        }else{
                            data[i][j] = col[j].children[0].children[0].checked;
                        }
                    }
                }
                btnAdd.innerHTML=`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Espera...
                    `;
                btnAdd.setAttribute("disabled","");
                url = base_url+"/Role/setPermits";
                let permits = new FormData();
                permits.append("permits",JSON.stringify(data));
                permits.append("idRol",id);
                request(url,permits,"post").then(function(objData){
                    btnAdd.innerHTML=`Guardar`;
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        Swal.fire("Permisos",objData.msg,"success");
                    }else{
                        Swal.fire("Permisos",objData.msg,"error");
                    }
                });
            })

        });
    }
    editItem(id){
        let url = base_url+"/Role/getrole";
        let formData = new FormData();
        
        formData.append("idRol",id);
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Actualizar rol</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formItem" name="formItem" class="mb-4">
                                    <input type="hidden" id="idRol" name="idRol" value="${objData.data.idrole}">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info text-white" id="btnAdd">Actualizar</button>
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
                form.addEventListener("submit",function(e){
                    e.preventDefault();
                    let strName = document.querySelector("#txtName").value;

                    if(strName ==""){
                        Swal.fire("Error","Los campos no pueden estar vacíos","error");
                        return false;
                    }

                    let url = base_url+"/Role/setRole";
                    let formData = new FormData(form);
                    let element = document.querySelector("#listItem");
                    let btnAdd = document.querySelector("#btnAdd");
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
                            modalView.hide();
                            url = base_url+"/Role/getRoles";
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
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
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
                let url = base_url+"/Role/delRole"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idRol",id);
                request(url,formData,"post").then(function(objData){
                    Swal.fire("Eliminado",objData.msg,"success");
                    url = base_url+"/Role/getRoles";
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
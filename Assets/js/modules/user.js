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
    viewItem(id){
        let url = base_url+"/User/getUser";
        let formData = new FormData();
        
        formData.append("idUser",id);
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Datos de usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table align-middle text-break text-center">
                                    <tbody id="listItem">
                                        <tr>
                                            <td><img src="${objData.data.image}" class="rounded-circle" style="height:100px;width:100px;"></td>
                                        </tr>
                                        <tr><td><strong>Nombre: </strong>${objData.data.firstname}</td></tr>
                                        <tr><td><strong>Apellido: </strong>${objData.data.lastname}</td></tr>
                                        <tr><td><strong>Correo: </strong>${objData.data.email}</td></tr>
                                        <tr><td><strong>Teléfono: </strong>${objData.data.phone}</td></tr>
                                        <tr><td><strong>País: </strong>${objData.data.country}</td></tr>
                                        <tr><td><strong>Estado: </strong>${objData.data.state}</td></tr>
                                        <tr><td><strong>Ciudad: </strong>${objData.data.city}</td></tr>
                                        <tr><td><strong>Fecha de registro: </strong>${objData.data.date}</td></tr>
                                        <tr><td><strong>Rol: </strong>${objData.data.role}</td></tr>
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
        let url = base_url+"/User/getUser";
        let formData = new FormData();
        formData.append("idUser",id);
        request(url,formData,"post").then(function(objData){
            let modalItem = document.querySelector("#modalItem");
            let modal= `
            <div class="modal fade" id="modalElement">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Actualizar usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formItem" name="formItem" class="mb-4">
                                <input type="hidden" id="idUser" name="idUser" value="${objData.data.idperson}">
                                <div class="mb-3 uploadImg">
                                    <img src="${objData.data.image}">
                                    <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                                    <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtFirstName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" value="${objData.data.firstname}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtLastName" class="form-label">Apellido <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="txtLastName" name="txtLastName" value="${objData.data.lastname}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="${objData.data.email}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtPhone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="txtPhone" name="txtPhone" value="${objData.data.phone}" required>
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
            url = base_url+"/User/getRoles";
            request(url,"","get").then(function(html){
                document.querySelector("#typeList").innerHTML = html.data;
                let roles = document.querySelectorAll("#typeList option");
                for (let i = 0; i < roles.length; i++) {
                    if(roles[i].value == objData.data.roleid){
                        roles[i].setAttribute("selected",true);
                    }
                }
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
                    btnAdd.innerHTML=`Actualizar`;
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        Swal.fire("Actualizado",objData.msg,"success");
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
                let url = base_url+"/User/delUser"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idUser",id);
                request(url,formData,"post").then(function(objData){
                    Swal.fire("Eliminado",objData.msg,"success");
                    url = base_url+"/User/getUsers";
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
'use strict';
import Interface from "./interfaceClass.js";
let loading = document.querySelector("#divLoading");
export default class Usuario extends Interface{
    constructor(){
        super();
    }
    interface(){
        let fragment = document.createDocumentFragment();
        let form = document.createElement('div');
        form.innerHTML = `
        <form id="formItem" name="formItem" class="mb-4">
            <input type="hidden" id="idUser" name="idUser">
            <div class="mb-3 uploadImg">
                <img src="${base_url}/Assets/images/uploads/avatar.png">
                <label for="txtImg"><a class="btn btn-info text-white">Subir foto</a></label>
                <input class="d-none" type="file" id="txtImg" name="txtImg"> 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="txtFirstName" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="txtFirstName" name="txtFirstName">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="txtLastName" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="txtLastName" name="txtLastName">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="txtPhone" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="txtPhone" name="txtPhone">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="typeList" class="form-label">Rol de usuario</label>
                <select class="form-control" aria-label="Default select example" id="typeList" name="typeList">
                    <option value="1">Administrador</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="txtPassword" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="txtPassword" name="txtPassword">
            </div>
            <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Agregar</button>
            <button type="button" class="btn btn-danger" onclick="location.reload()">Cancelar</button>
        </form>
        `;
        fragment.appendChild(form);
        document.querySelector("#interface").appendChild(fragment);
    }
    orderItem(value){
        let url = base_url+"/Usuarios/getUsuarios"
        let formData = new FormData();
        formData.append("orderBy",value);
        request(url,formData,"post").then(function(objData){
            let div = document.querySelector("div.scroll_list");
            let html="";
            let typeList = document.querySelectorAll("#typeList option");
            let rolname ="";
            for (let i = 0; i < objData.data.length; i++) {
                for (let j = 0; j < typeList.length; j++) {
                    if(typeList[j].value == objData.data[i].roleid){
                        rolname = typeList[j].textContent;
                        break;
                    }
                }
                if(objData.admin){
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${objData.data[i]['firstname']}" data-lastname="${objData.data[i]['lastname']}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${objData.data[i]['picture']}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Rol: </strong>${rolname}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['idperson']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['idperson']}">Editar</a>
                            <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData.data[i]['idperson']}">Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }else{
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${objData.data[i]['firstname']}" data-lastname="${objData.data[i]['lastname']}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${objData.data[i]['picture']}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Rol: </strong>${rolname}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['idperson']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['idperson']}">Editar</a>
                            <button class="btn btn-secondary w-100 text-white" title="Eliminar" name="btnDelete" disabled>Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `; 
                }
            }
            div.innerHTML = html;
        });
    }
    showItems(element){
        let url = base_url+"/Usuarios/getUsuarios";
        request(url,"","get").then(function(objData){
            let div = document.createElement("div");
            let fragment = document.createDocumentFragment();
            let html="";
            let typeList = document.querySelectorAll("#typeList option");
            let rolname ="";
            let admin=false;
            for (let i = 0; i < objData.data.length; i++) {
                for (let j = 0; j < typeList.length; j++) {
                    if(typeList[j].value == objData.data[i].roleid){
                        rolname = typeList[j].textContent;
                        break;
                    }
                }
                if(objData.admin){
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${objData.data[i]['firstname']}" data-lastname="${objData.data[i]['lastname']}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${objData.data[i]['picture']}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Rol: </strong>${rolname}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['idperson']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['idperson']}">Editar</a>
                            <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData.data[i]['idperson']}">Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }else{
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${objData.data[i]['firstname']}" data-lastname="${objData.data[i]['lastname']}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${objData.data[i]['picture']}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Rol: </strong>${rolname}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['idperson']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['idperson']}">Editar</a>
                            <button class="btn btn-secondary w-100 text-white" title="Eliminar" name="btnDelete" disabled>Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `; 
                }
            }
            div.innerHTML = html;
            div.classList.add("scroll_list");
            fragment.appendChild(div);
            element.appendChild(fragment);
        })

    }
    viewItem(id){
        let url = base_url+"/Usuarios/getUsuario";
        let formData = new FormData();
        formData.append("idUser",id);

        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let typeList = document.querySelectorAll("#typeList option");
                let rolname ="";
                for (let i = 0; i < typeList.length; i++) {
                    if(typeList[i].value == objData.data.roleid){
                        rolname = typeList[i].textContent;
                        break;
                    }
                }

                let modalItem = document.querySelector("#modalItem");
                //let fragment = document.createDocumentFragment();
                //let div = document.createElement("div");
                let modal=`
                <div class="modal fade" tabindex="-1" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><strong>Datos de usuario</strong></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table w-100">
                                            <tbody>
                                                <tr scope="row">
                                                    <td>Imágen: </td>
                                                    <td>
                                                        <div class="modal_img">
                                                            <img src="${objData.data.url}" alt="">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Dirección: </td>
                                                    <td>${objData.data.date}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Nombre: </td>
                                                    <td> ${objData.data.firstname} ${objData.data.lastname}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Cc: </td>
                                                    <td> ${objData.data.identification}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Correo: </td>
                                                    <td> ${objData.data.email}</td>
                                                </tr>
                                                <tr scope="row"">
                                                    <td>Teléfono: </td>
                                                    <td>${objData.data.phone}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Rol de usuario: </td>
                                                    <td> ${rolname}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Dirección: </td>
                                                    <td>${objData.data.address}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Departamento/ciudad: </td>
                                                    <td>${objData.data.departamento}/${objData.data.ciudad}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
    
                modalItem.innerHTML = modal;
                //fragment.appendChild(div);
                //modalItem.appendChild(fragment);
                let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                modalView.show();
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        })
    }
    editItem(id){

        let url = base_url+"/Usuarios/getUsuario";
        let formData = new FormData();
        formData.append("idUser",id);
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let typeList = document.querySelectorAll("#typeList option");
                for (let i = 0; i < typeList.length; i++) {
                    if(typeList[i].value == objData.data.roleid){
                        typeList[i].setAttribute("selected","selected");
                        break;
                    }
                }
                document.querySelector("#txtFirstName").value = objData.data.firstname;
                document.querySelector("#txtLastName").value = objData.data.lastname;
                document.querySelector("#txtEmail").value = objData.data.email;
                document.querySelector("#txtPhone").value = objData.data.phone;
                document.querySelector(".uploadImg img").setAttribute("src",objData.data.url);
                document.querySelector("#idUser").value = objData.data.idperson;


            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
        document.querySelector("#btnAdd").textContent = "Actualizar";

    }
    deleteItem(element,id){
        if(element.name == "btnDelete"){
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
                    let url = base_url+"/Usuarios/delUsuario"
                    let formData = new FormData();
                    formData.append("idUser",id);
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        loading.style.display = "none";
                        Swal.fire("Usuarios",objData.msg,"success");
                        element.parentElement.parentElement.remove();
                    });
                }
            });
        }
    }
}
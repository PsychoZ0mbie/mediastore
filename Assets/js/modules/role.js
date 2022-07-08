'use strict';

export default class Role{
    showItems(element){
        let url = base_url+"/Role/getRoles";
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
                        <h5 class="modal-title" id="staticBackdropLabel">New role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formItem" name="formItem" class="mb-4">
                            <input type="hidden" id="idRol" name="idRol" value="">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="txtName" name="txtName">
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
            let strName = document.querySelector("#txtName").value;

            if(strName ==""){
                Swal.fire("Error","The fields can't be empty","error");
                return false;
            }
            
            let url = base_url+"/Role/setRole";
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
                    Swal.fire("Add",objData.msg,"success");
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
                            <h5 class="modal-title" id="staticBackdropLabel">Permits</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Module</th>
                                            <th>Read</th>
                                            <th>Create</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modules">
                                        ${htmlModule}
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btnAdd">Save</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
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
                        Wait...
                    `;
                btnAdd.setAttribute("disabled","");
                url = base_url+"/Role/setPermits";
                let permits = new FormData();
                permits.append("permits",JSON.stringify(data));
                permits.append("idRol",id);
                request(url,permits,"post").then(function(objData){
                    btnAdd.innerHTML=`Save`;
                    btnAdd.removeAttribute("disabled");
                    if(objData.status){
                        modalView.hide();
                        Swal.fire("Permits",objData.msg,"success");
                    }else{
                        Swal.fire("Permits",objData.msg,"error");
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
                                <h5 class="modal-title" id="staticBackdropLabel">Update role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formItem" name="formItem" class="mb-4">
                                    <input type="hidden" id="idRol" name="idRol" value="${objData.data.idrole}">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" value="${objData.data.name}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info text-white" id="btnAdd">Update</button>
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
                    let strName = document.querySelector("#txtName").value;

                    if(strName ==""){
                        Swal.fire("Error","The fields can't be empty","error");
                        return false;
                    }

                    let url = base_url+"/Role/setRole";
                    let formData = new FormData(form);
                    let element = document.querySelector("#listItem");
                    let btnAdd = document.querySelector("#btnAdd");
                    btnAdd.innerHTML=`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Wait...
                    `;
                    btnAdd.setAttribute("disabled","");
                    request(url,formData,"post").then(function(objData){
                        btnAdd.innerHTML=`Update`;
                        btnAdd.removeAttribute("disabled");
                        if(objData.status){
                            Swal.fire("Update",objData.msg,"success");
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
            title:"Are you sure to delete it?",
            text:"It will delete for ever",
            icon: 'warning',
            showCancelButton:true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText:"Yes, delete",
            cancelButtonText:"No, cancel"
        }).then(function(result){
            if(result.isConfirmed){
                let url = base_url+"/Role/delRole"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idRol",id);
                request(url,formData,"post").then(function(objData){
                    Swal.fire("Deleted",objData.msg,"success");
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
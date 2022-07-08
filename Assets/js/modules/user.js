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
                        <h5 class="modal-title" id="staticBackdropLabel">New user</h5>
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
                                        <label for="txtFirstName" class="form-label">First name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtLastName" class="form-label">Last name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtLastName" name="txtLastName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtPhone" name="txtPhone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="typeList" class="form-label">Role <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="typeList" name="typeList" required></select>
                                    </div>
                                </div>
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
            let statusList = document.querySelector("#statusList").value;
            let idUser = document.querySelector("#idUser").value;

            if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == "" || statusList == ""){
                Swal.fire("Error","All fields marked with (*) are required","error");
                return false;
            }
            if(strPassword.length < 8 && strPassword!=""){
                Swal.fire("Error","The password must have at least 8 characters","error");
                return false;
            }
            if(!fntEmailValidate(strEmail)){
                let html = `
                <br>
                <br>
                <p>youremail@hotmail.com</p>
                <p>youremail@outlook.com</p>
                <p>youremail@yahoo.com</p>
                <p>youremail@live.com</p>
                <p>youremail@gmail.com</p>
                `;
                Swal.fire("Error","Email is invalid , valid emails are: "+html,"error");
                return false;
            }
            if(strPhone.length < 9){
                Swal.fire("Error","Phone number must have at least 9 digits","error");
                return false;
            }
            
            url = base_url+"/User/setUser";
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
                    form.reset();
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
                let status = objData.data.status;
                if(status==1){
                    status='<span class="badge me-1 bg-success">Active</span>';
                }else{
                    status='<span class="badge me-1 bg-danger">Inactive</span>';
                }
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">User data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table align-middle text-break text-center">
                                    <tbody id="listItem">
                                        <tr>
                                            <td><img src="${objData.data.image}" class="rounded-circle" style="height:100px;width:100px;"></td>
                                        </tr>
                                        <tr><td><strong>First name: </strong>${objData.data.firstname}</td></tr>
                                        <tr><td><strong>Last name: </strong>${objData.data.lastname}</td></tr>
                                        <tr><td><strong>Email: </strong>${objData.data.email}</td></tr>
                                        <tr><td><strong>Phone: </strong>${objData.data.phone}</td></tr>
                                        <tr><td><strong>Country: </strong>${objData.data.country}</td></tr>
                                        <tr><td><strong>State: </strong>${objData.data.state}</td></tr>
                                        <tr><td><strong>City: </strong>${objData.data.city}</td></tr>
                                        <tr><td><strong>Date: </strong>${objData.data.date}</td></tr>
                                        <tr><td><strong>Role: </strong>${objData.data.role}</td></tr>
                                        <tr><td><strong>Status: </strong>${status}</td></tr>
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
                            <h5 class="modal-title" id="staticBackdropLabel">Update user</h5>
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
                                            <label for="txtFirstName" class="form-label">First name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" value="${objData.data.firstname}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtLastName" class="form-label">Last name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="txtLastName" name="txtLastName" value="${objData.data.lastname}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="${objData.data.email}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="txtPhone" name="txtPhone" value="${objData.data.phone}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="typeList" class="form-label">Role <span class="text-danger">*</span></label>
                                            <select class="form-control" aria-label="Default select example" id="typeList" name="typeList" required></select>
                                        </div>
                                    </div>
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
                let strFirstName = document.querySelector("#txtFirstName").value;
                let strLastName = document.querySelector("#txtLastName").value;
                let strEmail = document.querySelector("#txtEmail").value;
                let strPhone = document.querySelector("#txtPhone").value;
                let typeValue = document.querySelector("#typeList").value;
                let strPassword = document.querySelector("#txtPassword").value;
                let idUser = document.querySelector("#idUser").value;

                if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == ""){
                    Swal.fire("Error","All fields marked with (*) are required","error");
                    return false;
                }
                if(strPassword.length < 8 && strPassword!=""){
                    Swal.fire("Error","The password must have at least 8 characters","error");
                    return false;
                }
                if(!fntEmailValidate(strEmail)){
                    let html = `
                    <br>
                    <br>
                    <p>youremail@hotmail.com</p>
                    <p>youremail@outlook.com</p>
                    <p>youremail@yahoo.com</p>
                    <p>youremail@live.com</p>
                    <p>youremail@gmail.com</p>
                    `;
                    Swal.fire("Error","Email is invalid , valid emails are: "+html,"error");
                    return false;
                }
                if(strPhone.length < 9){
                    Swal.fire("Error","Phone number must have at least 9 digits","error");
                    return false;
                }
                
                url = base_url+"/User/setUser";
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
                let url = base_url+"/User/delUser"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idUser",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Deleted",objData.msg,"success");
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
            }
        });
    }
}
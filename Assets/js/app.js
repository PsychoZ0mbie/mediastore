'use strict';
import Role from "./modules/role.js";
import User from "./modules/user.js";
import Category from "./modules/category.js";
import SubCategory from "./modules/subcategory.js";
import Product from "./modules/product.js";

document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
    }
});
/*************************Dashboard Page*******************************/
if(document.querySelector("#dashboard")){
    if(document.querySelector("#btnNew")){
        document.querySelector("#btnNew").classList.add("d-none");
    }
}
/*************************Roles Page*******************************/
if(document.querySelector("#role")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            if(!strName.includes(value) ){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Role();
    let element = document.querySelector("#listItem");
    if(document.querySelector("#btnNew")){
        let btnNew = document.querySelector("#btnNew");
        btnNew.addEventListener("click",function(){
            item.addItem();
        });
    }

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }else if(element.name == "btnPermit"){
            item.permitItem(id);
        }else if(element.name == "btnEdit"){
            item.editItem(id);
        }
    });
    
}
/*************************User Page*******************************/
if(document.querySelector("#user")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            if(!strName.includes(value) ){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new User();
    let element = document.querySelector("#listItem");

    if(document.querySelector("#btnNew")){
        let btnNew = document.querySelector("#btnNew");
        btnNew.addEventListener("click",function(){
            item.addItem();
        });
    }

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }else if(element.name == "btnView"){
            item.viewItem(id);
        }else if(element.name == "btnEdit"){
            item.editItem(id);
        }
    });
    
}
/*************************Category Page*******************************/
if(document.querySelector("#category")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {

            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();

            if(!strName.includes(value) ){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Category();
    let element = document.querySelector("#listItem");
    if(document.querySelector("#btnNew")){
        let btnNew = document.querySelector("#btnNew");
        btnNew.addEventListener("click",function(){
            item.addItem();
        });
    }

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }else if(element.name == "btnEdit"){
            item.editItem(id);
        }
    });
    
}
/*************************SubCategory Page*******************************/
if(document.querySelector("#subcategory")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            if(!strName.includes(value) ){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new SubCategory();
    let element = document.querySelector("#listItem");
    if(document.querySelector("#btnNew")){
        let btnNew = document.querySelector("#btnNew");
        btnNew.addEventListener("click",function(){
            item.addItem();
        });
    }

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }else if(element.name == "btnEdit"){
            item.editItem(id);
        }
    });
    
}
/*************************Product Page*******************************/
if(document.querySelector("#product")){
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            if(!strName.includes(value) ){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Product();
    let element = document.querySelector("#listItem");
    if(document.querySelector("#btnNew")){
        let btnNew = document.querySelector("#btnNew");
        btnNew.addEventListener("click",function(){
            item.addItem();
        });
        /*tinymce.triggerSave();
        tinymce.init({
            relative_urls: 0,
            remove_script_host: 0,
            selector: '#txtDescription',
            height: 300,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'   
        });*/
    }

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }else if(element.name == "btnEdit"){
            item.editItem(id);
        }else if(element.name == "btnView"){
            item.viewItem(id);
        }
    });
    
}
/*************************Profile Page*******************************/
if(document.querySelector("#perfil")){
    let url = base_url+"/usuarios/getSelectDepartamentos";
    let listDepartamento = document.querySelector("#listDepartamento");
    let formPerfil = document.querySelector("#formPerfil");
    request(url,"","get").then(function(objData){
        listDepartamento.innerHTML = objData.department;
        document.querySelector("#listCiudad").innerHTML = objData.city;
    });
    listDepartamento.addEventListener("change",function(){
        let url = base_url+"/usuarios/getSelectCity/"+listDepartamento.value;
        request(url,"","get").then(function(objData){
            document.querySelector("#listCiudad").innerHTML = objData.html;
        });
    });

    formPerfil.addEventListener("submit",function(e){
        e.preventDefault();
        let url = base_url+"/usuarios/putPerfil";
        let strNombre = document.querySelector("#txtNombre").value;
        let strApellido = document.querySelector("#txtApellido").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let intTelefono = document.querySelector("#txtTelefono").value;
        let intDepartamento = document.querySelector("#listDepartamento").value;
        let intCiudad = document.querySelector("#listCiudad").value;
        let intCedula = document.querySelector("#txtId").value;
        let strPassword = document.querySelector("#txtPassword").value;
        let strConfirmarPassword = document.querySelector("#txtPasswordConfirm").value;

        if(strNombre =="" || strApellido =="" || strEmail =="" || intTelefono=="" || intDepartamento ==""
        || intCiudad =="" || intCedula ==""){
            Swal.fire("Error","todos los campos con (*) son obligatorios","error");
            return false;
        }
        if(intTelefono.length < 10){
            Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
            return false;
        }
        if(intCedula.length < 8 || intCedula.length > 10){
            Swal.fire("Error","La cédula debe tener de 8 a 10 dígitos","error");
            return false;
        }
        if(strPassword !=""){
            if(strPassword.length < 8){
                Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres","error");
                return false;
            } 
            if(strApellido != strConfirmarPassword){
                Swal.fire("Error","Las contraseñas no coinciden","error");
                return false;
            }
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
            Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
            return false;
        }

        

        let formData = new FormData(formPerfil);
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                Swal.fire("Perfil",objData.msg,"success");
            }else{
                Swal.fire("Perfil",objData.msg,"error");
            }
        })
    })
}
/*************************Login Page*******************************/
if(document.querySelector("#login")){

    let formLogin = document.querySelector("#formLogin");
    let formReset = document.querySelector("#formReset");
    let btnResetPass = document.querySelector("#btnResetPass");
    let btnSession = document.querySelector("#btnSession");

    btnResetPass.addEventListener("click",function(){
        document.querySelector("#cardLogin").classList.add("d-none");
        document.querySelector("#cardReset").classList.remove("d-none");
    });
    btnSession.addEventListener("click",function(){
        document.querySelector("#cardLogin").classList.remove("d-none");
        document.querySelector("#cardReset").classList.add("d-none");
    });

    formLogin.addEventListener("submit",function(e){
        e.preventDefault();
        let strEmail = document.querySelector('#txtEmail').value;
        let strPassword = document.querySelector('#txtPassword').value;

        if(strEmail == "" || strPassword ==""){
            Swal.fire("Error", "Please, fill the fields", "error");
            return false;
        }else{
            let url = base_url+'/Login/loginUser'; 
            let formData = new FormData(formLogin);
            let btnLogin = document.querySelector("#btnLogin");
            btnLogin.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Wait...
            `;
            btnLogin.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnLogin.innerHTML=`Login`;
                btnLogin.removeAttribute("disabled");
                if(objData.status){
                    window.location = base_url+'/dashboard';
                    //window.location.reload(false);
                }else{
                    Swal.fire("Error", objData.msg, "error");
                    document.querySelector('#txtPassword').value = "";
                }
            });
        }
    });
        
    formReset.addEventListener("submit",function(e){
        e.preventDefault();
        let btnReset = document.querySelector("#btnReset");
        let strEmail = document.querySelector("#txtEmailReset").value;
        let url = base_url+'/Login/resetPass'; 
        let formData = new FormData(formReset);
        if(strEmail == ""){
            Swal.fire("Error", "Please, fill the field", "error");
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
        btnReset.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Wait...
        `;
        btnReset.setAttribute("disabled","");
        request(url,formData,"post").then(function(objData){
            btnReset.innerHTML=`Reset my password`;
            btnReset.removeAttribute("disabled");
            if(objData.status){
                Swal.fire({
                    title: "Reset my password",
                    text: objData.msg,
                    icon: "success",
                    confirmButtonText: 'Ok',
                    showCancelButton: true,
                }).then(function(result){
                    if(result.isConfirmed){
                        window.location = base_url+"/login";
                    }
                });
            }else{
                swal("Error",objData.msg,"error");
            }
        });
    });
}
/*************************Recovery Page*******************************/
if(document.querySelector("#recovery")){
    let btnReset = document.querySelector("#btnReset");
    let formCambiarPass = document.querySelector("#formRecovery");
    formCambiarPass.addEventListener("submit",function(e){
        e.preventDefault();
        
        let strPassword = document.querySelector("#txtPassword").value;
        let strPasswordConfirm = document.querySelector("#txtPasswordConfirm").value;
        let idUser = document.querySelector("#idUser").value;
        let url = base_url+'/Login/setPassword'; 
        let formData = new FormData(formCambiarPass);

        if(strPassword == "" || strPasswordConfirm==""){
            swal("Error", "Put your new password.", "error");
            return false;
        }else{
            if(strPassword.length < 8){
                Swal.fire("Error","The password must have at least 8 characters","error");
                return false;
            }if(strPassword != strPasswordConfirm){
                swal("Error", "Passwords do not match.", "error");
                return false;
            }
            btnReset.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Wait...
            `;
            btnReset.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnReset.innerHTML=`Reset my password`;
                btnReset.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire({
                        title: "Please, login",
                        text: objData.msg,
                        icon: "success",
                        confirmButtonText: 'Ok',
                        showCancelButton: true,
                    }).then(function(result){
                        if(result.isConfirmed){
                            window.location = base_url+"/login";
                        }
                    });
                }else{
                    swal("Error",objData.msg,"error");
                }
            });
        }
    });
}
/*************************Order Page*******************************/
if(document.querySelector("#pedidos")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            let strEmail = element.getAttribute("data-email").toLowerCase();
            let strPhone = element.getAttribute("data-phone").toLowerCase();
            let strStatus = element.getAttribute("data-status").toLocaleLowerCase();
            if(!strName.includes(value) && !strEmail.includes(value) && !strPhone.includes(value) && !strStatus.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Pedidos();
    let element = document.querySelector("#listItem");
    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    //buttons
    if(document.querySelector("#listItem")){
        let listProduct = document.querySelector("#listItem");
        listProduct.addEventListener("click",function(e) {
                let element = e.target;
                let id = element.getAttribute("data-id");
                let idorder = element.getAttribute("data-order");
                if(element.name == "btnDelete"){
                    item.deleteItem(element,id,idorder);
                }else if(element.name == "btnView"){
                    item.viewItem(id,idorder);
                }else if(element.name == "btnEdit"){
                    item.editItem(id,idorder);
                }
        });
    }
        /*
        
        formOrder.addEventListener("submit",function(){
            e.preventDefault();
            let idorder = document.querySelector("#idpedido").value;
            let idperson = document.querySelector("#idpersona").value;
            let status = document.querySelector("#status").innerHTML;
            let url = base_url+"/pedidos/updatePedido";
            let formData = new FormData(formOrder);
            request(url,formData,"post").then(function(objData){
                console.log(objData);
            });
            console.log("existe");
        })*/

    let btnBack = document.querySelector("#btnBack");
    btnBack.addEventListener("click",function(){
        document.querySelector("#listItem").classList.remove("d-none");
        document.querySelector("#detailItem").classList.add("d-none");
    });


}
/*************************Message Page*******************************/
if(document.querySelector("#mensaje")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
        let elements = document.querySelectorAll(".item");
        let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            let strEmail = element.getAttribute("data-email").toLowerCase();
            let strPhone = element.getAttribute("data-phone").toLowerCase();
            if(!strName.includes(value) && !strEmail.includes(value) && !strPhone.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Mensaje();
    let element = document.querySelector("#listItem");
    let orderBy = document.querySelector("#orderBy");

    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    //buttons
    if(document.querySelector("#listItem")){
        let listProduct = document.querySelector("#listItem");
        listProduct.addEventListener("click",function(e) {
            let element = e.target;
            let id = element.getAttribute("data-id");
            if(element.name == "btnDelete"){
                item.deleteItem(element,id);
            }else if(element.name == "btnView"){
                item.viewItem(id);
            }
        });
    }
}


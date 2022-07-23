'use strict';
import Role from "./modules/role.js";
import User from "./modules/user.js";
import Category from "./modules/category.js";
import SubCategory from "./modules/subcategory.js";
import Product from "./modules/product.js";
import Coupon from "./modules/coupon.js";

document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
    }
});
/*************************Dashboard Page*******************************/
if(document.querySelector("#dashboard")){
}
/*************************Roles Page*******************************/
if(document.querySelector("#role")){
    document.querySelector("#btnNew").classList.remove("d-none");
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
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            let strLastName = element.getAttribute("data-lastname").toLowerCase();
            let strEmail = element.getAttribute("data-email").toLowerCase();
            let intPhone = element.getAttribute("data-phone").toLowerCase();
            if(!strName.includes(value) && !strLastName.includes(value) && !strEmail.includes(value) && !intPhone.includes(value)){
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
    document.querySelector("#btnNew").classList.remove("d-none");
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
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            let strCategory = element.getAttribute("data-category").toLowerCase();
            if(!strName.includes(value) && !strCategory.includes(value) ){
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
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            let strCategory = element.getAttribute("data-category").toLowerCase();
            let strSubcategory = element.getAttribute("data-subcategory").toLowerCase();
            if(!strName.includes(value) && !strCategory.includes(value) && !strSubcategory.includes(value)){
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
/*************************Store Pages*******************************/
if(document.querySelector("#coupon")){
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase();
            if(!strName.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let item = new Coupon();
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
        }else if(element.name == "btnView"){
            item.viewItem(id);
        }
    });
}
/*************************Profile Page*******************************/
if(document.querySelector("#profile")){

    let img = document.querySelector("#txtImg");
    let imgLocation = ".uploadImg img";
    img.addEventListener("change",function(){
        uploadImg(img,imgLocation);
    });

    let intCountry = document.querySelector("#countryList");
    let intState = document.querySelector("#stateList");
    let intCity = document.querySelector("#cityList");
    let formProfile = document.querySelector("#formProfile");

    request(base_url+"/user/getSelectLocationInfo","","get").then(function(objData){
        intCountry.innerHTML = objData.countries;
        intState.innerHTML = objData.states;
        intCity.innerHTML = objData.cities;
    });

    intCountry.addEventListener("change",function(){
        let url = base_url+"/user/getSelectCountry/"+intCountry.value;
        request(url,"","get").then(function(objData){
            intState.innerHTML = objData;
        });
    });
    intState.addEventListener("change",function(){
        let url = base_url+"/user/getSelectState/"+intState.value;
        request(url,"","get").then(function(objData){
            intCity.innerHTML = objData;
        });
    });

    formProfile.addEventListener("submit",function(e){
        e.preventDefault();

        let url = base_url+"/user/updateProfile";
        let strFirstName = document.querySelector("#txtFirstName").value;
        let strLastName = document.querySelector("#txtLastName").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let strPhone = document.querySelector("#txtPhone").value;
        let intCountry = document.querySelector("#countryList").value;
        let intState = document.querySelector("#stateList").value;
        let intCity = document.querySelector("#cityList").value;
        let strAddress = document.querySelector("#txtAddress");
        let strPassword = document.querySelector("#txtPassword").value;
        let strConfirmPassword = document.querySelector("#txtConfirmPassword").value;
        let idUser = document.querySelector("#idUser").value;

        if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || intCountry == "" || intState == ""
        || intCity == "" || strAddress ==""){
            Swal.fire("Error","All fields marked with (*) are required","error");
            return false;
        }
       if(strPassword!=""){
            if(strPassword.length < 8){
                Swal.fire("Error","The password must have at least 8 characters","error");
                return false;
            }
            if(strPassword != strConfirmPassword){
                Swal.fire("Error","The passwords do not match","error");
                return false;
            }
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

        let formData = new FormData(formProfile);
        let btnAdd = document.querySelector("#btnAdd");
        btnAdd.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Wait...
        `;
        btnAdd.setAttribute("disabled","");
        request(url,formData,"post").then(function(objData){
            if(objData.status){
                Swal.fire("Profile",objData.msg,"success");
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
            btnAdd.innerHTML="Update";
            btnAdd.removeAttribute("disabled");
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


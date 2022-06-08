'use strict';
import Role from "./modules/role.js";
import User from "./modules/user.js";

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
            Swal.fire("Por favor", "Escribe usuario y contraseña.", "error");
            return false;
        }else{
            let url = base_url+'/Login/loginUser'; 
            let formData = new FormData(formLogin);
            let btnLogin = document.querySelector("#btnLogin");
            btnLogin.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Espera...
            `;
            btnLogin.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnLogin.innerHTML=`Iniciar sesión`;
                btnLogin.removeAttribute("disabled");
                if(objData.status){
                    window.location = base_url+'/dashboard';
                    //window.location.reload(false);
                }else{
                    Swal.fire("Atención", objData.msg, "error");
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
            swal("Por favor", "Escribe tu correo electrónico.","error");
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
            Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
            return false;
        }
        btnReset.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Espera...
        `;
        btnReset.setAttribute("disabled","");
        request(url,formData,"post").then(function(objData){
            btnReset.innerHTML=`Recuperar`;
            btnReset.removeAttribute("disabled");
            if(objData.status){
                Swal.fire({
                    title: "Recuperar cuenta",
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
                swal("Atención",objData.msg,"error");
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
            swal("Por favor", "Escribe la nueva contraseña.", "error");
            return false;
        }else{
            if(strPassword.length < 8){
                swal("Atención", "La contraseña debe tener un mínimo de 8 carácteres.","info");
                return false;
            }if(strPassword != strPasswordConfirm){
                swal("Atención", "Las contraseñas no coinciden.", "error");
                return false;
            }
            btnReset.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Espera...
            `;
            btnReset.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnReset.innerHTML=`Recuperar`;
                btnReset.removeAttribute("disabled");
                if(objData.status){
                    Swal.fire({
                        title: "Por favor, inicia sesión",
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
                    swal("Atención",objData.msg,"error");
                }
            });
        }
    });
}

/*************************Gallery Page*******************************/

if(document.querySelector("#galeria")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            let strTopic = element.getAttribute("data-topic").toLowerCase();
            let strTechnique = element.getAttribute("data-technique").toLowerCase();
            let strAuthor = element.getAttribute("data-author").toLowerCase();
            if(!strTitle.includes(value) && !strTopic.includes(value) && !strTechnique.includes(value) && !strAuthor.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    

    let item = new Galeria();
    item.interface();
    let element = document.querySelector("#listItem");
    let img = [document.querySelector("#txtImg"),document.querySelector("#txtImg2")];
    let imgLocation = ["#img","#img2"];
    for (let i = 0; i < 2; i++) {
        let image = img[i];
        let imageLocation = imgLocation[i];
        image.addEventListener("change",function(){
            uploadImg(image,imageLocation);
        })
    }

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector("#txtName").value;
        let intWidth = document.querySelector("#intWidth").value;
        let intHeight = document.querySelector("#intHeight").value;
        let topicList = document.querySelector("#topicList");
        let subtopicList = document.querySelector("#subtopicList");
        let frameList = document.querySelector("#frameList").value;
        let statusList = document.querySelector("#statusList").value;
        let intPrice = document.querySelector("#intPrice").value;
        let idProduct = document.querySelector("#idProduct").value;

        if(strName == "" || intWidth == "" || intHeight == "" || topicList.value == "" || subtopicList.value == ""
            || intPrice == "" || frameList == "" || statusList==""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }


        //Request
        let formData = new FormData(form);
        let url = base_url+"/Galeria/setProducto";
        loading.style.display="flex";
        request(url,formData,"post").then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Galeria",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    });
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
                }else if(element.name == "btnEdit"){
                    item.editItem(id);
                }
        });
    }
}


/*************************Framing Page*******************************/

if(document.querySelector("#marqueteria")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            let strTopic = element.getAttribute("data-topic").toLowerCase();
            if(!strTitle.includes(value) && !strTopic.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    

    let item = new Marqueteria();
    item.interface();
    let element = document.querySelector("#listItem");
    let img = [document.querySelector("#txtImg"),document.querySelector("#txtImg2")];
    let imgLocation = ["#img","#img2"];
    for (let i = 0; i < 2; i++) {
        let image = img[i];
        let imageLocation = imgLocation[i];
        image.addEventListener("change",function(){
            uploadImg(image,imageLocation);
        })
    }

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector("#txtName").value;
        let topicList = document.querySelector("#topicList").value;
        let statusList = document.querySelector("#statusList").value;
        let intWaste = document.querySelector("#intWaste").value;
        let intPrice = document.querySelector("#intPrice").value;
        let idProduct = document.querySelector("#idProduct").value;

        if(strName == "" ||  topicList == "" || intPrice == "" || statusList=="" || intWaste == ""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }


        //Request
        let formData = new FormData(form);
        let url = base_url+"/Marqueteria/setProducto";
        loading.style.display="flex";
        request(url,formData,"post").then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Marqueteria",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    });
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
                }else if(element.name == "btnEdit"){
                    item.editItem(id);
                }
        });
    }
}
if(document.querySelector("#colores")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            if(!strTitle.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    

    let item = new MarqueteriaColores();
    item.interface();

    let element = document.querySelector("#listItem");
    let orderBy = document.querySelector("#orderBy");

    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector("#txtName").value;
        let statusList = document.querySelector("#statusList").value;
        let strHex = document.querySelector("#txtHexa").value;
        let idColor = document.querySelector("#idColor").value;

        if(strName == "" ||  statusList == "" || strHex == ""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }


        //Request
        let formData = new FormData(form);
        let url = base_url+"/Marqueteria/setColor";
        loading.style.display="flex";
        request(url,formData,"post").then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Marqueteria",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    });
    //buttons
    if(document.querySelector("#listItem")){
        let listProduct = document.querySelector("#listItem");
        listProduct.addEventListener("click",function(e) {
                let element = e.target;
                let id = element.getAttribute("data-id");
                if(element.name == "btnDelete"){
                    item.deleteItem(element,id);
                }else if(element.name == "btnEdit"){
                    item.editItem(id);
                }
        });
    }
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


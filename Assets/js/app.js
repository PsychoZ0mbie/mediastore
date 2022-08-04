'use strict';
import Role from "./modules/role.js";
import User from "./modules/user.js";
import Customer from "./modules/customer.js";
import Category from "./modules/category.js";
import SubCategory from "./modules/subcategory.js";
import Product from "./modules/product.js";
import Coupon from "./modules/coupon.js";
import Orders from "./modules/orders.js";


/*************************Dashboard Page*******************************/
if(document.querySelector("#dashboard")){
    $('.date-picker').datepicker( {
        closeText: 'Close',
        prevText: 'back',
        nextText: 'next',
        currentText: 'Today',
        monthNames: ['1 -', '2 -', '3 -', '4 -', '5 -', '6 -', '7 -', '8 -', '9 -', '10 -', '11 -', '12 -'],
        monthNamesShort: ['January','February','March','April', 'May','June','July','August','September', 'October','November','Dicember'],
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        showDays: false,
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });

    
    let btnSalesMonth = document.querySelector("#btnSalesMonth");
    let btnSalesYear = document.querySelector("#btnSalesYear");
    btnSalesMonth.addEventListener("click",function(){
        let salesMonth = document.querySelector(".salesMonth").value;
        if(salesMonth==""){
            Swal.fire("Error", "Please choose a date", "error");
            return false;
        }
        btnSalesMonth.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        btnSalesMonth.setAttribute("disabled","");
        let formData = new FormData();
        formData.append("date",salesMonth);
        request(base_url+"/dashboard/getSalesMonth",formData,"post").then(function(objData){
            btnSalesMonth.innerHTML=`<i class="fas fa-search"></i>`;
            btnSalesMonth.removeAttribute("disabled");
            $("#salesMonth").html(objData);
        });
    });
    btnSalesYear.addEventListener("click",function(){
        
        let salesYear = document.querySelector("#sYear").value;
        let strYear = salesYear.toString();

        if(salesYear==""){
            Swal.fire("Error", "Please put a year", "error");
            document.querySelector("#sYear").value ="";
            return false;
        }
        if(strYear.length>4){
            Swal.fire("Error", "Date is wrong.", "error");
            document.querySelector("#sYear").value ="";
            return false;
        }
        btnSalesYear.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        btnSalesYear.setAttribute("disabled","");

        let formData = new FormData();
        formData.append("date",salesYear);
        request(base_url+"/dashboard/getSalesYear",formData,"post").then(function(objData){
            btnSalesYear.innerHTML=`<i class="fas fa-search"></i>`;
            btnSalesYear.removeAttribute("disabled");
            console.log(objData);
            if(objData.status){
                $("#salesYear").html(objData.script);
            }else{
                Swal.fire("Error", objData.msg, "error");
                document.querySelector("#sYear").value ="";
            }
        });
    });

    
}
/*************************Roles Page*******************************/
if(document.querySelector("#role")){
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new Role();
    search.addEventListener('input',function() {
        request(base_url+"/role/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    })
    sort.addEventListener("change",function(){
        request(base_url+"/role/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

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
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new User();
    search.addEventListener('input',function() {
        request(base_url+"/user/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    })
    sort.addEventListener("change",function(){
        request(base_url+"/user/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

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
/*************************Customer Page*******************************/
if(document.querySelector("#customer")){
    document.querySelector("#btnNew").classList.remove("d-none");
    let search = document.querySelector("#search");
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new Customer();
    search.addEventListener('input',function() {
        request(base_url+"/customer/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    })
    sort.addEventListener("change",function(){
        request(base_url+"/customer/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

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
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new Category();

    search.addEventListener('input',function() {
        request(base_url+"/category/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

    sort.addEventListener("change",function(){
        request(base_url+"/category/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

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
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new SubCategory();
    
    search.addEventListener('input',function() {
        request(base_url+"/category/searchs/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

    sort.addEventListener("change",function(){
        request(base_url+"/category/sorts/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });
    
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
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    let item = new Product();
    
    search.addEventListener('input',function() {
        request(base_url+"/product/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

    sort.addEventListener("change",function(){
        request(base_url+"/product/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

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
/*************************Order Page*******************************/
if(document.querySelector("#orders")){
    let item = new Orders();
    let search = document.querySelector("#search");
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");

    search.addEventListener('input',function() {
        request(base_url+"/orders/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

    sort.addEventListener("change",function(){
        request(base_url+"/orders/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })

    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            item.deleteItem(id);
        }
    });
}
/*************************Store Pages*******************************/
//Coupon page
if(document.querySelector("#coupon")){
    document.querySelector("#btnNew").classList.remove("d-none");

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
//Mailbox page
if(document.querySelector("#mailbox")){
    setTinymce("#txtMessage");
    tinymce.triggerSave();
    let formEmail = document.querySelector("#formEmail");
    formEmail.addEventListener("submit",function(e){
        e.preventDefault();
        let strEmail = document.querySelector("#txtEmail");
        let strMessage = document.querySelector("#txtMessage");
        let btn = document.querySelector("#btnSubmit");
        if(strEmail == "" || strMessage ==""){
            Swal.fire("Error", "Please fill the fields with (*)", "error");
            return false;
        }
        let formData = new FormData(formEmail);
        btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Wait...`;
        btn.setAttribute("disabled","");
        request(base_url+"/store/sendEmail",formData,"post").then(function(objData){
            btn.innerHTML=`<i class="fas fa-paper-plane"></i> Reply`;
            btn.removeAttribute("disabled");
            if(objData.status){
                window.location.reload();
            }else{
                Swal.fire("Message", objData.msg, "success");
            }
        });
    });
}
if(document.querySelector("#message")){
    setTinymce("#txtMessage");
    tinymce.triggerSave();

    let formReply = document.querySelector("#formReply");
    formReply.addEventListener("submit",function(e){
        e.preventDefault();
        let btn = document.querySelector("#btnSubmit");
        let strMessage = document.querySelector("#txtMessage");
        if(strMessage ==""){
            Swal.fire("Error", "Please fill the field", "error");
            return false;
        }
        let formData = new FormData(formReply);
        btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Wait...`;
        btn.setAttribute("disabled","");
        request(base_url+"/store/setReply",formData,"post").then(function(objData){
            btn.innerHTML=`<i class="fas fa-paper-plane"></i> Reply`;
            btn.removeAttribute("disabled");
            if(objData.status){
                window.location.reload();
            }else{
                Swal.fire("Message", objData.msg, "success");
            }
        });
    });

}
//Subscribers page
if(document.querySelector("#subscribers")){
    
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
        intCity.innerHTML = "";
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
if(document.querySelector("#btnRefund")){
    let item = new Orders();
    let btn = document.querySelector("#btnRefund");
    btn.addEventListener("click",function(){
        item.refund(btn.getAttribute("data-id"));
    });
}
if(document.querySelector("#btnPrint")){
    let btn = document.querySelector("#btnPrint");
    btn.addEventListener("click",function(){
        if(document.querySelector("#btnRefund"))document.querySelector("#btnRefund").classList.add("d-none");
        printDiv(document.querySelector("#orderInfo"));
    });
}
if(document.querySelector("#exportExcel")){
    document.querySelector("#exportExcel").addEventListener("click",function(){
        let id = document.querySelector("#exportExcel").getAttribute('data-name');
        exportToExcel(id);
    })
}

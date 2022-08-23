
let img = document.querySelector("#txtImg");
let imgLocation = ".uploadImg img";
let intCountry = document.querySelector("#countryList");
let intState = document.querySelector("#stateList");
let intCity = document.querySelector("#cityList");
let formCompany = document.querySelector("#formCompany");
let formSocial = document.querySelector("#formSocial");
let formPayment = document.querySelector("#formPayment");

img.addEventListener("change",function(){
    uploadImg(img,imgLocation);
});

/*
request(base_url+"/company/getSelectLocationInfo","","get").then(function(objData){
    intCountry.innerHTML = objData.countries;
    intState.innerHTML = objData.states;
    intCity.innerHTML = objData.cities;
});*/

intCountry.addEventListener("change",function(){
    let url = base_url+"/company/getSelectCountry/"+intCountry.value;
    request(url,"","get").then(function(objData){
        intState.innerHTML = objData;
    });
    intCity.innerHTML = "";
});
intState.addEventListener("change",function(){
    let url = base_url+"/company/getSelectState/"+intState.value;
    request(url,"","get").then(function(objData){
        intCity.innerHTML = objData;
    });
});


formCompany.addEventListener("submit",function(e){
    e.preventDefault();

    let strName = document.querySelector("#txtName").value;
    let intCurrency = document.querySelector("#currencyList").value;
    let strCompanyEmail = document.querySelector("#txtCompanyEmail").value;
    let strEmail = document.querySelector("#txtEmail").value;
    let strPhone = document.querySelector("#txtPhone").value;
    let strAddress = document.querySelector("#txtAddress").value;
    let intCountry = document.querySelector("#countryList").value;
    let intState = document.querySelector("#stateList").value;
    let intCity = document.querySelector("#cityList").value;
    let strPassword = document.querySelector("#txtPassword").value;

    if(strName == "" || intCurrency == "" || strCompanyEmail=="" || strEmail == "" || strPhone == "" || strAddress ==""
    || intCountry == "" || intState == ""
    || intCity == "" || strPassword==""){
        Swal.fire("Error","All fields marked with (*) are required","error");
        return false;
    }

    if(strPhone.length < 9){
        Swal.fire("Error","Phone number must have at least 9 digits","error");
        return false;
    }

    let formData = new FormData(formCompany);
    let btnAdd = document.querySelector("#btnCompany");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/company/setCompany",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
})
formSocial.addEventListener("submit",function(e){
    e.preventDefault();
    let formData = new FormData(formSocial);
    let btnAdd = document.querySelector("#btnSocial");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/company/setSocial",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
});
formPayment.addEventListener("submit",function(e){
    e.preventDefault();
    let client = document.querySelector("#txtClient");
    let secret = document.querySelector("#txtSecret");

    if(client =="" || secret==""){
        Swal.fire("Error","The fields cannot be empty.","error");
        return false;
    }

    let formData = new FormData(formPayment);
    let btnAdd = document.querySelector("#btnPayment");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Wait...`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/company/setCredentials",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
});

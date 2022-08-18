
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

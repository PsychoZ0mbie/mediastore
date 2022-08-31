let formContact = document.querySelector("#formContact");
formContact.addEventListener("submit",function(e){
    e.preventDefault();
    
    let strName = document.querySelector("#txtContactName").value;
    let strEmail = document.querySelector("#txtContactEmail").value;
    let strMessage = document.querySelector("#txtContactMessage").value;
    let alert = document.querySelector("#alertContact");
    let btn = document.querySelector("#btnMessage");

    if( strName =="" || strEmail =="" || strMessage == ""){
        alert.classList.remove("d-none");
        alert.innerHTML="Please fill the fields.";
        return false;
    }
    if(!fntEmailValidate(strEmail)){
        let html = ` Your email is incorrect, it is only allowed:
        <ul class="m-0 mt-1">
            <li>@hotmail.com</li>
            <li>@outlook.com</li>
            <li>@yahoo.com</li>
            <li>@live.com</li>
            <li>@gmail.com</li>
        </ul>
        `;
        alert.classList.remove("d-none");
        alert.innerHTML = html;
        return false;
    }

    btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Wait...`;    
    btn.setAttribute("disabled","");
    let formData = new FormData(formContact);
    request(base_url+"/contact/setContact",formData,"post").then(function(objData){
        btn.innerHTML="Submit";    
        btn.removeAttribute("disabled");
        if(objData.status){
            alert.classList.remove("d-none");
            alert.classList.replace("alert-danger","alert-success");
            alert.innerHTML =objData.msg;
            formContact.reset();
        }else{
            alert.classList.remove("d-none");
            alert.classList.replace("alert-success","alert-danger");
            alert.innerHTML =objData.msg;
        }
    });

});
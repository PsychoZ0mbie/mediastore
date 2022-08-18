'use strict';

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
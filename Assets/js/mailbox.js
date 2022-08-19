'use strict';

if(document.querySelector("#mailbox")){
    setTinymce("#txtMessage");
    
    let formEmail = document.querySelector("#formEmail");
    formEmail.addEventListener("submit",function(e){
        e.preventDefault();
        tinymce.triggerSave();
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
                Swal.fire("Error", objData.msg, "error");
            }
        });
    });
}

if(document.querySelector("#message") && document.querySelector("#formReply")){
    setTinymce("#txtMessage");
    let formReply = document.querySelector("#formReply");
    formReply.addEventListener("submit",function(e){
        e.preventDefault();
        tinymce.triggerSave();
        let btn = document.querySelector("#btnSubmit");
        let strMessage = document.querySelector("#txtMessage").value;
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
                Swal.fire("Error", objData.msg, "error");
            }
        });
    });

}
function delMail(id,option){
    Swal.fire({
        title:"Are you sure to delete it?",
        text:"It will delete for ever...",
        icon: 'warning',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:"Yes, delete",
        cancelButtonText:"No, cancel"
    }).then(function(result){
        if(result.isConfirmed){
            let formData = new FormData();
            formData.append("id",id);
            formData.append("option",option);
            request(base_url+"/Store/delMail",formData,"post").then(function(objData){
                if(objData.status){
                    window.location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        }
    });
}
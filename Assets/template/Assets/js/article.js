window.addEventListener("load",function(){
    let featured = document.querySelector(".featured-container-items");
    let left = document.querySelector(".featured-btn-left");
    let right = document.querySelector(".featured-btn-right");
    let filter = document.querySelector("#filter");
    let filterOptions = document.querySelector(".filter-options");
    let filterOverlay = document.querySelector(".filter-options-overlay");

    left.addEventListener("click",function(){
        featured.scrollBy(-featured.offsetWidth,0);
    });
    right.addEventListener("click",function(){
        featured.scrollBy(featured.offsetWidth,0);
    });
    filterOverlay.addEventListener("click",function(){
        filterOverlay.style.display="none";
        filterOptions.classList.remove("active");
    });
    filter.addEventListener("click",function(){
        filterOptions.classList.add("active");
        document.querySelector(".filter-options-overlay").style.display="block";
    });
    
    if(document.querySelector("#formComment")){
        let formComment = document.querySelector("#formComment");
        formComment.addEventListener("submit",function(e){
            e.preventDefault();
            let formData = new FormData(formComment);
            let strComment = document.querySelector("#txtDescription").value;
            let alert = document.querySelector("#alertComment");
            let addComment = document.querySelector("#addComment");
            if(strComment ==""){
                alert.classList.remove("d-none");
                alert.classList.replace("alert-warning","alert-danger");
                alert.innerHTML = "Please write your comment.";
                return false;
            }
            addComment.setAttribute("disabled","disabled");
            addComment.innerHTML = `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
            request(base_url+"/blog/setComment",formData,"post").then(function(objData){
                addComment.removeAttribute("disabled");
                addComment.innerHTML="Post comment";
                if(objData.status){
                    alert.classList.add("d-none");
                    document.querySelector("#txtDescription").value="";
                    document.querySelector(".comment-list").innerHTML= objData.html;
                    document.querySelector("#totalComments").innerHTML =`Comments (${objData.total})`;
                    //showMore(document.querySelectorAll(".comment-block"),4,document.querySelector("#showMore"));
                }else if(objData.login == false){
                    alert.classList.remove("d-none");
                    alert.classList.replace("alert-warning","alert-danger");
                    alert.innerHTML = objData.msg;
                    openLoginModal();
                }else{
                    alert.classList.remove("d-none");
                    alert.classList.replace("alert-warning","alert-danger");
                    alert.innerHTML = objData.msg;
                }
            });
        });
    }
    showMore(document.querySelectorAll(".comment-block"),4,document.querySelector("#showMore"));
})
'use strict'
/***************************Nav Events****************************** */
let btnBar = document.querySelector("#btnToggleNav");
let btnCart = document.querySelector("#btnToggleCart");
let btnClose = document.querySelector("#btnCloseNav");
let btnCloseCart = document.querySelector("#btnCloseCart");
let btnSearch = document.querySelector("#btnSearch");
let btnCloseSearch = document.querySelector("#btnCloseSearch");

btnCloseSearch.addEventListener("click",function(){
    document.querySelector(".nav-search").classList.remove("nav-search-open");
    document.querySelector(".nav-search").classList.add("nav-search-close");
    document.querySelector(".nav-logo").classList.remove("active");
    document.querySelector(".nav-main").classList.remove("active");
    document.querySelector(".nav-icons").classList.remove("active");
    setTimeout(function(){
        document.querySelector(".nav-search").classList.add("d-none");
        document.querySelector("#txtSearch").value="";
    },800)
});
btnSearch.addEventListener("click",function(){
    document.querySelector(".nav-logo").classList.add("active");
    document.querySelector(".nav-main").classList.add("active");
    document.querySelector(".nav-icons").classList.add("active");
    document.querySelector(".nav-search").classList.remove("nav-search-close");
    document.querySelector(".nav-search").classList.remove("d-none");
    document.querySelector(".nav-search").classList.add("nav-search-open");
});
btnBar.addEventListener("click",function(){
    document.querySelector(".nav-mobile-main").classList.toggle("active");
    document.querySelector(".nav-mobile").classList.toggle("active");
});
btnCart.addEventListener("click",function(){
    document.querySelector(".cart-panel-main").classList.toggle("active");
    document.querySelector(".cart-panel").classList.toggle("active");
    request(base_url+"/shop/currentCart","","get").then(function(objData){
        document.querySelector(".cart-panel-items").innerHTML=objData.items;
        document.querySelector("#total").innerHTML = `<strong>Total: ${objData.total}</strong>`;
        if(document.querySelectorAll(".btn-del")){
            let btns = document.querySelectorAll(".btn-del");
            for (let i = 0; i < btns.length; i++) {
                let btn = btns[i];
                btn.addEventListener("click",function(){
                    let idProduct = btn.parentElement.getAttribute("data-id");
                    let formData = new FormData();
                    formData.append("idProduct",idProduct);
                    request(base_url+"/shop/delCart",formData,"post").then(function(objData){
                        if(objData.status){
                            btn.parentElement.remove();
                            document.querySelector("#total").innerHTML = `<strong>Total: ${objData.total}</strong>`;
                            document.querySelector("#qtyCart").innerHTML=objData.qty;
                        }
                    });
                });
            }
        }
    });
});
btnClose.addEventListener("click",function(){
    document.querySelector(".nav-mobile-main").classList.remove("active");
    document.querySelector(".nav-mobile").classList.remove("active"); 
});
btnCloseCart.addEventListener("click",function(){
    document.querySelector(".cart-panel-main").classList.remove("active");
    document.querySelector(".cart-panel").classList.remove("active"); 
})
document.querySelector(".nav-mobile").addEventListener("click",function(e){
    let element = e.target;
    if(element.className == "nav-mobile active"){
        document.querySelector(".nav-mobile-main").classList.remove("active");
        document.querySelector(".nav-mobile").classList.remove("active"); 
    }
});
document.querySelector(".cart-panel").addEventListener("click",function(e){
    let element = e.target;
    if(element.className == "cart-panel active"){
        document.querySelector(".cart-panel-main").classList.remove("active");
        document.querySelector(".cart-panel").classList.remove("active"); 
    }
});

if(document.querySelector("#logout")){
    let logout = document.querySelector("#logout");
    logout.addEventListener("click",function(e){
        let url = base_url+"/logout";
        request(url,"","get").then(function(objData){
            window.location.reload(false);
        });
    });
}
if(document.querySelector("#myAccount")){
    let myAccount = document.querySelector("#myAccount");
    myAccount.addEventListener("click",function(e){
        openLoginModal();
    });
}

/***************************General Shop Events****************************** */
//Scroll top
window.addEventListener("scroll",function(){
    if(window.scrollY > 100){
        document.querySelector("#scrollTop").style.display="flex";
    }else{
        document.querySelector("#scrollTop").style.display="none";
    }
});


//filter select
if(document.querySelector("#selectSort")){
    let selectSort = document.querySelector("#selectSort");
    selectSort.addEventListener("change",function(){
        let value = selectSort.value;
        let url = window.location.href;
        url = url.split("/");
        let urlOption ="";
        
        if(url.length == 8){
            urlOption = base_url+"/shop/getProductSort/"+url[6]+"/"+url[7]+"/"+value;
        }else if(url.length == 7){
            urlOption = base_url+"/shop/getProductSort/"+url[6]+"/"+value;
        }else{
            urlOption = base_url+"/shop/getProductSort/"+value;
        }
        request(urlOption,"","get").then(function(html){
            document.querySelector("#productItems").innerHTML=html;
            addProductCard();
            quickModal();
            addWishList();
            filterPrice();
        });
    });
}
window.addEventListener("load",function(){
    addProductCard();
    quickModal();
    addWishList();
    filterPrice();
    /***************************Popup suscribe********************************/
    if(document.querySelector("#modalPoup")){
        setTimeout(function(){
            let modal="";
            let modalPopup = document.querySelector("#modalPoup");
            let timer;
            modal= `
                    <div class="modal fade" id="modalSuscribe">
                        <div class="modal-dialog modal-lg modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="container mb-3 p-4 pe-5 ps-5">
                                    <form id="formModalSuscribe" class="mb-3">
                                        <h2 class="t-p">MEDIASTORE</h2>
                                        <h2 class="fs-5">Suscribe to our newsletter and get a 15% discount coupon</h2>
                                        <p>Receive updates on new arrivals, special offers and our promotions</p>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Your email" required>
                                        </div>
                                        <button type="submit" class="btn btnc-primary">Suscribe</button>
                                    </form>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="delPopup">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Don't show this popup again
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
            modalPopup.innerHTML = modal;
            let modalView = new bootstrap.Modal(document.querySelector("#modalSuscribe"));
            modalView.show();
            document.querySelector("#modalSuscribe").addEventListener("hidden.bs.modal",function(){
                if(document.querySelector("#delPopup").checked){
                    window.clearTimeout(timer);
                    modalView.hide();
                    modalPopup.innerHTML = "";
                }else{
                    window.clearTimeout(timer);
                    const runTime = function(){
                        timer=setInterval(function(){
                            modalView.show();
                        },60000);
                    }
                    runTime();
                }
            });
        },30000);
    }
});

/***************************Filter****************************** */
if(document.querySelector(".addFilter")){
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
}
/***************************Comment****************************** */
if(document.querySelector(".comment-list")){
    let btnAnswer = document.querySelectorAll(".btnAnswer");
    let answer = document.querySelectorAll(".comment-answer");
    let stars = document.querySelectorAll(".review-rate button");
    for (let i = 0; i < btnAnswer.length; i++) {
        let btn = btnAnswer[i];
        btn.addEventListener("click",function(){

            answer[i].classList.toggle("active");
            btn.classList.toggle("active");
    
            if(btn.classList.contains("active")){
                answer[i].style.height=`auto`;
                let height = `${answer[i].clientHeight}px`;
                answer[i].style.height=`0px`;
                setTimeout(function(){
                    answer[i].style.height = height;
                },0);
                btn.innerHTML =`Hide answer <i class="fas fa-angle-up"></i>`;
            }else{
                answer[i].style.height=`0px`;
                btn.innerHTML =`Show answer <i class="fas fa-angle-down"></i>`;
            }
            
        });
    }
}

/***************************Product Page****************************** */
if(document.querySelector("#product")){
    let decrement = document.querySelector(".decrement");
    let increment = document.querySelector(".increment");
    let cant = document.querySelector(".cant");
    let addProduct = document.querySelector("#addProduct");
    let productImages = document.querySelectorAll(".product-image-item");
    let btnPrev = document.querySelector(".slider-btn-left");
    let btnNext = document.querySelector(".slider-btn-right");
    let inner = document.querySelector(".product-image-inner");
    let btn = document.querySelector(".product-addwishlist");
    let formReview = document.querySelector("#formReview");
    let search = document.querySelector("#searchReview");
    let sortReview = document.querySelector("#sortReviews");
    
    /***************************Product Page Events****************************** */
    
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".comment-block");
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
    });

    sortReview.addEventListener("change",function(){
        let idProduct = document.querySelector("#idProduct").value;
        let intSort = sortReview.value;
        let formData = new FormData();

        formData.append("idProduct",idProduct);
        formData.append("intSort",intSort);
        request(base_url+"/shop/sortReviews",formData,"post").then(function(objData){
            let rate = objData.rate;
            let rateStars ="";

            for (let i = 0; i < 5; i++) {
                if(i >= parseInt(rate.rate)){
                    rateStars+='<i class="far fa-star"></i>';
                }else{
                    rateStars+='<i class="fas fa-star"></i>';
                }
            }

            document.querySelector(".comment-list").innerHTML= objData.html;
            document.querySelectorAll(".product-rate")[0].innerHTML= rateStars+` (${rate.total} reviews)`;
            document.querySelectorAll(".product-rate")[1].innerHTML= rateStars;
            document.querySelector("#pills-reviews-tab").innerHTML=`Reviews (${rate.total})`;

            document.querySelector("#avgRate").innerHTML = `${parseFloat(rate.rate).toFixed(1)}<span class="fs-6">/ 5</span>`;
            document.querySelectorAll(".progress-bar")[0].style.width=`${(rate.five/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[0].ariaValueNow = (rate.five/rate.total)*100;
            document.querySelectorAll(".progress-bar")[1].style.width=`${(rate.four/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[1].ariaValueNow = (rate.four/rate.total)*100;
            document.querySelectorAll(".progress-bar")[2].style.width=`${(rate.three/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[2].ariaValueNow = (rate.three/rate.total)*100;
            document.querySelectorAll(".progress-bar")[3].style.width=`${(rate.two/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[3].ariaValueNow = (rate.two/rate.total)*100;
            document.querySelectorAll(".progress-bar")[4].style.width=`${(rate.one/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[4].ariaValueNow = (rate.one/rate.total)*100;
            document.querySelectorAll(".review-stars span")[0].innerHTML =`(${rate.five})`;
            document.querySelectorAll(".review-stars span")[1].innerHTML =`(${rate.four})`;
            document.querySelectorAll(".review-stars span")[2].innerHTML =`(${rate.three})`;
            document.querySelectorAll(".review-stars span")[3].innerHTML =`(${rate.two})`;
            document.querySelectorAll(".review-stars span")[4].innerHTML =`(${rate.one})`;
        });
    });


    rateProduct();
    //Select image
    for (let i = 0; i < productImages.length; i++) {
        let productImage = productImages[i];
        productImage.addEventListener("click",function(e){
            for (let j = 0; j < productImages.length; j++) {
                productImages[j].classList.remove("active");
                
            }
            productImage.classList.add("active");
            let image = productImage.children[0].src;
            document.querySelector(".product-image img").src = image;
        })
    }

    //Scroll image buttons 
    btnPrev.addEventListener("click",function(){
        inner.scrollBy(-100,0);
    });
    btnNext.addEventListener("click",function(){
        inner.scrollBy(100,0);
    });

    //Add to cart
    addProduct.addEventListener("click",function(){
        let formData = new FormData();
        let idProduct = addProduct.getAttribute("data-id");
        formData.append("idProduct",idProduct);
        formData.append("txtQty",cant.value);
        addProduct.setAttribute("disabled",true);
        addProduct.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        `;
        request(base_url+"/shop/addCart",formData,"post").then(function(objData){
            
            if(objData.status){
                addProduct.innerHTML = `<i class="fas fa-check"></i> Added`;
                setTimeout(function(){
                    addProduct.removeAttribute("disabled");
                    addProduct.innerHTML = `<i class="fas fa-shopping-cart me-2"></i> Add`;
                },1000);
                document.querySelector("#alert").classList.add("d-none");
                document.querySelector("#qtyCart").innerHTML=objData.qty;
            }else{
                addProduct.removeAttribute("disabled");
                addProduct.innerHTML = `<i class="fas fa-shopping-cart me-2"></i> Add`;
                document.querySelector("#alert").classList.remove("d-none");
            }
        });
        
    });

    //Quantity events
    cant.addEventListener("change",function(){
        if(cant.value <= 1){
            cant.value = 1;
        }else if(cant.value >= cant.getAttribute("max")){
            cant.value = product['stock'];
        }
    })
    decrement.addEventListener("click",function(){
        if(cant.value<=1){
            return cant.value=1;
        }
        cant.value--;
    });
    increment.addEventListener("click",function(){
        if(cant.value>=cant.getAttribute("max")){
            return cant.value=cant.getAttribute("max");
        }
        cant.value++;
    });

    //Add to wishlist
    btn.addEventListener("click",function(){
        let idProduct = addProduct.getAttribute("data-id");
        let formData = new FormData();
        formData.append("idProduct",idProduct);
        btn.classList.toggle("active");
        if(btn.classList.contains("active")){
            btn.parentElement.children[1].innerHTML= `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
            btn.setAttribute("disabled","disabled");
            request(base_url+"/shop/addWishList",formData,"post").then(function(objData){
                btn.removeAttribute("disabled");
                if(objData.status){
                    btn.classList.replace("far","fas");
                    btn.classList.add("text-danger");
                    btn.parentElement.children[1].classList.replace("c-d","c-p");
                    btn.parentElement.children[1].setAttribute("href",base_url+"/shop/wishlist");
                    btn.parentElement.children[1].innerHTML="Check wishlist";
                }else{
                    openLoginModal();
                    btn.parentElement.children[1].innerHTML="Add to wishlist";
                    btn.classList.replace("fas","far");
                    btn.classList.remove("text-danger");
                    btn.parentElement.children[1].classList.replace("c-p","c-d");
                    btn.parentElement.children[1].removeAttribute("href");
                }
            });
            
        }else{
            btn.parentElement.children[1].innerHTML= `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
            btn.setAttribute("disabled","disabled");
            request(base_url+"/shop/delWishList",formData,"post").then(function(objData){
                btn.removeAttribute("disabled");
                if(objData.status){
                    btn.classList.replace("fas","far");
                    btn.classList.remove("text-danger");
                    btn.parentElement.children[1].classList.replace("c-p","c-d");
                    btn.parentElement.children[1].removeAttribute("href");
                    btn.parentElement.children[1].innerHTML="Add to wishlist";
                }else{
                    openLoginModal();
                    btn.parentElement.children[1].innerHTML="Add to wishlist";
                    btn.classList.replace("fas","far");
                    btn.classList.remove("text-danger");
                    btn.parentElement.children[1].classList.replace("c-p","c-d");
                    btn.parentElement.children[1].removeAttribute("href");
                }
            });
        }
    });
    
    /***************************Review Events****************************** */
    //Add review
    formReview.addEventListener("submit",function(e){
        e.preventDefault();
        let formData = new FormData(formReview);
        let alert = document.querySelector("#alertReview");
        let intRate = document.querySelector("#intRate").value;
        let strReview = document.querySelector("#txtReview").value;
        let addReview = document.querySelector("#addReview");
        if(intRate ==0 || strReview ==""){
            alert.classList.remove("d-none");
            alert.classList.replace("alert-warning","alert-danger");
            alert.innerHTML = "Please rate it and write your review.";
            return false;
        }
        addReview.setAttribute("disabled","disabled");
        addReview.innerHTML = `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
        request(base_url+"/shop/setReview",formData,"post").then(function(objData){
            addReview.removeAttribute("disabled");
            addReview.innerHTML="Post review";
            if(objData.status){
                let stars = document.querySelectorAll(".starBtn");
                let rate = objData.rate;
                let rateStars ="";
                for (let i = 0; i < stars.length; i++) {
                    stars[i].innerHTML =`<i class="far fa-star"></i>`;
                }
                for (let i = 0; i < 5; i++) {
                    if(i >= parseInt(rate.rate)){
                        rateStars+='<i class="far fa-star"></i>';
                    }else{
                        rateStars+='<i class="fas fa-star"></i>';
                    }
                }
                alert.classList.add("d-none");
                document.querySelector("#intRate").value="";
                document.querySelector("#txtReview").value="";
                document.querySelector("#idReview").value="";
                document.querySelector(".comment-list").innerHTML= objData.html;
                document.querySelectorAll(".product-rate")[0].innerHTML= rateStars+` (${rate.total} reviews)`;
                document.querySelectorAll(".product-rate")[1].innerHTML= rateStars;
                document.querySelector("#pills-reviews-tab").innerHTML=`Reviews (${rate.total})`;

                document.querySelector("#avgRate").innerHTML = `${parseFloat(rate.rate).toFixed(1)}<span class="fs-6">/ 5</span>`;
                document.querySelectorAll(".progress-bar")[0].style.width=`${(rate.five/rate.total)*100}%`;
                document.querySelectorAll(".progress-bar")[0].ariaValueNow = (rate.five/rate.total)*100;
                document.querySelectorAll(".progress-bar")[1].style.width=`${(rate.four/rate.total)*100}%`;
                document.querySelectorAll(".progress-bar")[1].ariaValueNow = (rate.four/rate.total)*100;
                document.querySelectorAll(".progress-bar")[2].style.width=`${(rate.three/rate.total)*100}%`;
                document.querySelectorAll(".progress-bar")[2].ariaValueNow = (rate.three/rate.total)*100;
                document.querySelectorAll(".progress-bar")[3].style.width=`${(rate.two/rate.total)*100}%`;
                document.querySelectorAll(".progress-bar")[3].ariaValueNow = (rate.two/rate.total)*100;
                document.querySelectorAll(".progress-bar")[4].style.width=`${(rate.one/rate.total)*100}%`;
                document.querySelectorAll(".progress-bar")[4].ariaValueNow = (rate.one/rate.total)*100;
                document.querySelectorAll(".review-stars span")[0].innerHTML =`(${rate.five})`;
                document.querySelectorAll(".review-stars span")[1].innerHTML =`(${rate.four})`;
                document.querySelectorAll(".review-stars span")[2].innerHTML =`(${rate.three})`;
                document.querySelectorAll(".review-stars span")[3].innerHTML =`(${rate.two})`;
                document.querySelectorAll(".review-stars span")[4].innerHTML =`(${rate.one})`;

            }else if(objData.login == false){
                alert.classList.remove("d-none");
                alert.classList.replace("alert-warning","alert-danger");
                alert.innerHTML = objData.msg;
                openLoginModal();
            }else{
                if(typeof objData.id !== 'undefined'){
                    alert.classList.remove("d-none");
                    alert.classList.replace("alert-danger","alert-warning");
                    alert.innerHTML = objData.msg;
                    editReview(objData.id);
                }else{
                    alert.classList.remove("d-none");
                    alert.classList.replace("alert-warning","alert-danger");
                    alert.innerHTML = objData.msg;
                }
            }
        });
    });
}
/***************************Cart Page****************************** */
if(document.querySelector("#cart")){

    let decrement = document.querySelectorAll(".decrement");
    let increment = document.querySelectorAll(".increment");
    let inputs = document.querySelectorAll(".cant");

    for (let i = 0; i < inputs.length; i++) {
        let input = inputs[i];
        let minus = decrement[i];
        let plus = increment[i];
        input.addEventListener("change",function(){
            if(input.value <= 1){
                input.value = 1;
            }else if(input.value >= 99){
                input.value = 99;
            }
        })
        minus.addEventListener("click",function(){
            if(input.value<=1){
                return input.value=1;
            }
            input.value--;
        });
        plus.addEventListener("click",function(){
            if(input.value>=99){
                return input.value=99;
            }
            input.value++;
        })
        
    }
    
}
/***************************Recovery Page****************************** */
if(document.querySelector("#recovery")){
    
    let formReset = document.querySelector("#formRecovery");
    let btnReset = document.querySelector("#recoverySubmit");

    formReset.addEventListener("submit",function(e){
        e.preventDefault();

        let strPassword = document.querySelector("#txtPasswordRecovery").value;
        let strConfirmPassword = document.querySelector("#txtPasswordConfirmRecovery").value;
        let url = base_url+'/Login/setPassword'; 
        let formData = new FormData(formReset);

        if(strPassword.length < 8){
            Swal.fire("Error","The password must have at least 8 characters","error");
            return false;
        }
        if(strPassword != strConfirmPassword){
            Swal.fire("Error","The passwords do not match","error");
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
                window.location.href = base_url;
            }else{
                swal("Error",objData.msg,"error");
            }
        });
    });
}


/***************************Essentials Functions****************************** */
//login modal
function openLoginModal(){
    let modalItem = document.querySelector("#modalLogin");
    let modal="";
    modal= `
    <div class="modal fade" id="modalElementLogin">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="login">
                    <div class="container">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="login">
                                <form id="formLogin" name="formLogin">
                                    <h2 class="mb-4">Login</h2>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-envelope"></i></div>
                                        <input type="email" class="form-control" id="txtLoginEmail" name="txtEmail" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-lock"></i></div>
                                        <input type="password" class="form-control" id="txtLoginPassword" name="txtPassword" placeholder="Password" required></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mb-3 t-p">
                                        <div class="c-p" id="forgotBtn">Forgot password?</div>
                                    </div>
                                    <button type="submit" id="loginSubmit" class="btn btnc-primary w-100 mb-4" >Login</button>
                                    <div class="d-flex justify-content-center mb-3 t-p" >
                                        <div class="c-p" id="signBtn">Need an account?</div>
                                    </div>
                                </form>
                                <form id="formSign" class="d-none">
                                    <h2 class="mb-4">Sign up</h2>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-user"></i></div>
                                        <input type="text" class="form-control" id="txtSignName" name="txtSignName" placeholder="Name" required>
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-envelope"></i></div>
                                        <input type="email" class="form-control" id="txtSignEmail" name="txtSignEmail" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-lock"></i></div>
                                        <input type="password" class="form-control" id="txtSignPassword" name="txtSignPassword" placeholder="Password" required></textarea>
                                    </div>
                                    <p>By registering on our website, you agree to our <a href="#">privacy and use policies</a>.</p>
                                    <div class="d-flex justify-content-end mb-3 t-p" >
                                        <div class="c-p loginBtn">Already have an account? login</div>
                                    </div>
                                    <button type="submit" id="signSubmit" class="btn btnc-primary w-100 mb-4" >Sign up</button>
                                </form>
                                <form id="formConfirmSign" class="d-none">
                                    <h2 class="mb-4">Validate data</h2>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-lock-open"></i></div>
                                        <input type="text" class="form-control" id="txtCode" name="txtCode" placeholder="Code" required>
                                    </div>
                                    <p>We have been sent you an email with a code to validate your data.</p>
                                    <button type="submit" id="confimSignSubmit" class="btn btnc-primary w-100 mb-4" >Validate</button>
                                </form>
                                <form id="formReset" class="d-none">
                                    <h2 class="mb-4">Forgot my password</h2>
                                    <div class="mb-3 d-flex">
                                        <div class="d-flex justify-content-center align-items p-3 bg-primary text-white"><i class="fas fa-envelope"></i></div>
                                        <input type="email" class="form-control" id="txtEmailReset" name="txtEmailReset" placeholder="Email" required>
                                    </div>
                                    <p>We will send you an email with a link to reset your password</p>
                                    <div class="d-flex justify-content-end mb-3 t-p" >
                                        <div class="c-p loginBtn">Login</div>
                                    </div>
                                    <button type="submit" id="resetSubmit" class="btn btnc-primary w-100 mb-4" >Reset my password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
    modalItem.innerHTML = modal;
    let modalView = new bootstrap.Modal(document.querySelector("#modalElementLogin"));
    modalView.show();

    let formLogin = document.querySelector("#formLogin");
    let formReset = document.querySelector("#formReset");
    let formSign = document.querySelector("#formSign");
    let formConfirmSign = document.querySelector("#formConfirmSign");
    let btnForgot = document.querySelector("#forgotBtn");
    let btnLogin = document.querySelectorAll(".loginBtn");
    let btnSign = document.querySelector("#signBtn");

    btnForgot.addEventListener("click",function(){
        formReset.classList.remove("d-none");
        formLogin.classList.add("d-none");
    });
    btnSign.addEventListener("click",function(){
        formSign.classList.remove("d-none");
        formLogin.classList.add("d-none");
    });
    for (let i = 0; i < btnLogin.length; i++) {
        let btn = btnLogin[i];
        btn.addEventListener("click",function(){
            if(i == 0){
                formSign.classList.add("d-none");
                formLogin.classList.remove("d-none");
            }else{
                formReset.classList.add("d-none");
                formLogin.classList.remove("d-none");
            }
        })
    }

    formLogin.addEventListener("submit",function(e){
        e.preventDefault();
        let strEmail = document.querySelector('#txtLoginEmail').value;
        let strPassword = document.querySelector('#txtLoginPassword').value;
        let loginBtn = document.querySelector("#loginSubmit");
        if(strEmail == "" || strPassword ==""){
            Swal.fire("Error", "Please, fill the fields", "error");
            return false;
        }else{

            let url = base_url+'/Login/loginUser'; 
            let formData = new FormData(formLogin);
            loginBtn.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Wait...
            `;
            loginBtn.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                loginBtn.innerHTML=`Login`;
                loginBtn.removeAttribute("disabled");
                if(objData.status){
                    window.location.reload(false);
                    modalView.hide();
                    modalItem.innerHTML = "";
                }else{
                    Swal.fire("Error", objData.msg, "error");
                    document.querySelector('#txtPassword').value = "";
                }
            });
        }
    });
    formSign.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector('#txtSignName').value;
        let strEmail = document.querySelector('#txtSignEmail').value;
        let strPassword = document.querySelector('#txtSignPassword').value;
        let signBtn = document.querySelector("#signSubmit");

        if(strEmail == "" || strPassword =="" || strName ==""){
            Swal.fire("Error", "Please, fill the fields", "error");
            return false;
        }
        if(strPassword.length < 8){
            Swal.fire("Error","The password must have at least 8 characters","error");
            return false;
        }
        let url = base_url+'/Shop/validCustomer'; 
        let formData = new FormData(formSign);
        signBtn.innerHTML=`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Wait...
        `;
        signBtn.setAttribute("disabled","");
        request(url,formData,"post").then(function(objData){
            signBtn.innerHTML=`Sign up`;
            signBtn.removeAttribute("disabled");
            if(objData.status){
                formSign.classList.add("d-none");
                formConfirmSign.classList.remove("d-none");
            }else{
                Swal.fire("Error", objData.msg, "error");
                document.querySelector('#txtPassword').value = "";
            }
        });
    });
    formConfirmSign.addEventListener("submit",function(e){
        e.preventDefault();
        let strCode = document.querySelector('#txtCode').value;
        let strName = document.querySelector('#txtSignName').value;
        let strEmail = document.querySelector('#txtSignEmail').value;
        let strPassword = document.querySelector('#txtSignPassword').value;
        let signBtn = document.querySelector("#confimSignSubmit");

        if(strCode==""){
            Swal.fire("Error", "Please, fill the fields", "error");
            return false;
        }else{

            let url = base_url+'/Shop/setCustomer'; 
            let formData = new FormData(formConfirmSign);
            formData.append("txtSignName",strName);
            formData.append("txtSignEmail",strEmail);
            formData.append("txtSignPassword",strPassword);
            signBtn.innerHTML=`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Wait...
            `;
            signBtn.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                signBtn.innerHTML=`Validate`;
                signBtn.removeAttribute("disabled");
                if(objData.status){
                    window.location.reload(false);
                    modalView.hide();
                    modalItem.innerHTML = "";
                    
                }else{
                    Swal.fire("Error", objData.msg, "error");
                    document.querySelector('#txtCode').value = "";
                }
            });
        }
    });
    formReset.addEventListener("submit",function(e){
        e.preventDefault();
        let btnReset = document.querySelector("#resetSubmit");
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
                        window.location.reload(false);
                    }
                });
            }else{
                swal("Error",objData.msg,"error");
            }
        });
    });
}
//Quick view modal
function quickModal(){
    if(document.querySelectorAll(".product-btns .quickView")){
        let btns = document.querySelectorAll(".product-btns .quickView");
        for (let i = 0; i < btns.length; i++) {
            let btn = btns[i];
            btn.addEventListener("click",function(e){
    
                let idProduct = btn.parentElement.parentElement.parentElement.getAttribute("data-id");
                let formData = new FormData();
                formData.append("idProduct",idProduct);
                btn.innerHTML = `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
                btn.setAttribute("disabled","disabled");
                request(base_url+"/shop/getProduct",formData,"post").then(function(objData){
                    btn.removeAttribute("disabled");
                    btn.innerHTML = `<i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick view"></i>`;
                    if(objData.status){
    
                        let product = objData.data;
                        let images = product['image'];
                        let favorite = "";
                        let imagesHtml="";
                        let discount="";
                        let price =`<p class="fs-3"><strong>${product['price']}</strong></p>`;
                        let status="";
                        let rate="";
                        let ratetotal = 0;
                        let btns =`
                        <div class="product-cant me-3">
                            <div class="decrement"><i class="fas fa-minus"></i></div>
                            <input class="cant me-2 ms-2" type="number" min="1" max="${product['stock']}" value="1">
                            <div class="increment"><i class="fas fa-plus"></i></div>
                            <button type="button" class="ms-3" data-id="${product['idproduct']}" id="viewProductAddModal"><i class="fas fa-shopping-cart me-2"></i> Add</button>
                        </div>
                        `;
                        if(product['rate'].length>0){
                            ratetotal = product['rate'][0]['total'];
                        }
                        for (let i = 0; i < 5; i++) {
                            if( product['rate'].length>0 &&i >= product['rate'][0]['rate']){
                                rate+=`<i class="far fa-star"></i>`;
                            }else if(product['rate'].length == 0){
                                rate+=`<i class="far fa-star"></i>`;
                            }else{
                                rate+=`<i class="fas fa-star"></i>`;
                            }
                        }
    
                        if(product['favorite']==1){
                            favorite = `<button type="button" class="c-p quickModal btn"><i class="fas fa-heart product-addwishlistModal me-1 text-danger active"></i> <a href="${base_url+"/shop/wishlist"}"class="c-p">Check wishlist</a></button>`;
                        }else{
                            favorite = `<button type="button" class="c-p quickModal btn"><i class="far fa-heart product-addwishlistModal me-1"></i> <a class="c-d">Add to wishlist</a></button>`;
                        }
                        if(product['status']==1 && product['stock']>0){
                            status =`<p class="text-secondary m-0">Stock: (${product['stock']}) units</p>`;
                            if(product['discount']>0){
                                discount = `<p class="product-discount">-${product['discount']}%</p>`;
                                price = `
                                <p class="m-0 text-decoration-line-through t-p">${product['price']}</p>
                                <p class="fs-3"><strong>${product['priceDiscount']}</strong></p>`;
                            }
                        }else if(product['stock']==0 && product['status']==1){
                            status =`<p class="text-danger fw-bold">Sold out.</p>`;
                            btns="";  
                            price= "";  
                        }else{
                            status =`<p class="text-danger fw-bold">Currently unavailable.</p>`;
                            price= "";
                            btns=""; 
                        }
    
                        for (let i = 0; i < images.length; i++) {
                            if(i==0){
                                imagesHtml+=`<div class="product-image-item active"><img src="${images[i]['url']}" alt="${images[i]['name']}"></div>`;
                            }else{
                                imagesHtml+=`<div class="product-image-item"><img src="${images[i]['url']}" alt="${images[i]['name']}"></div>`;
                            }
                        }
                        let modalItem = document.querySelector("#modalItem");
                        let modal="";
                        modal= `
                        <div class="modal fade" id="modalElement">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="container">
                                        <div class="row ps-2 pe-2 pb-4">
                                            <div class="col-md-6">
                                                <div class="product-image">
                                                    ${discount}
                                                    <img src="${images[0]['url']}" class="d-block w-100" alt="${images[0]['name']}">
                                                </div>
                                                <div class="product-image-slider">
                                                    <div class="slider-btn-left"><i class="fas fa-angle-left"></i></div>
                                                    <div class="product-image-inner">
                                                        ${imagesHtml}
                                                    </div>
                                                    <div class="slider-btn-right"><i class="fas fa-angle-right"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 product-data">
                                                <h1><a href="${base_url+"/shop/product/"+product['route']}"><strong>${product['name']}</strong></a></h1>
                                                <a href="${base_url+"/shop/product/"+product['route']}" class="product-rate text-start mb-3">
                                                    ${rate}
                                                    (${ratetotal} reviews)
                                                </a>
                                                ${status}
                                                ${price}
                                                <p class="mb-3" id="description">${product['shortdescription']}</p>
                                                <p class="m-0">SKU: <strong>${product['reference']}</strong></p>
                                                <a href="${base_url+"/shop/category/"+product['routec']}" class="m-0">Category:<strong> ${product['category']}</strong></a>
                                                <div class="mt-4 mb-4 d-flex align-items-center">
                                                    ${btns}
                                                </div>
                                                <div class="alert alert-warning d-none" id="alert" role="alert">
                                                    Oops! Not enought stock, try with less or check your cart if you have added all our units before.
                                                </div>
                                                <div class="d-flex align-items-center mt-4">
                                                    <ul class="product-social">
                                                        <li title="Facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                        <li title="Twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                        <li title="Linkedin"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                        <li title="Telegram"><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
                                                    </ul>
                                                    ${favorite}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        modalItem.innerHTML = modal;
                        let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                        modalView.show();
                        let productImages = document.querySelectorAll(".product-image-item");
                        for (let i = 0; i < productImages.length; i++) {
                            let productImage = productImages[i];
                            productImage.addEventListener("click",function(e){
                                for (let j = 0; j < productImages.length; j++) {
                                    productImages[j].classList.remove("active");
                                    
                                }
                                productImage.classList.add("active");
                                let image = productImage.children[0].src;
                                document.querySelector(".product-image img").src = image;
                            })
                        }
                        
                        document.querySelector("#modalElement").addEventListener("hidden.bs.modal",function(){
                            document.querySelector("#modalItem").innerHTML="";
                        });
            
                        if(document.querySelector("#viewProductAddModal")){
                            let btnPrev = document.querySelector(".slider-btn-left");
                            let btnNext = document.querySelector(".slider-btn-right");
                            let inner = document.querySelector(".product-image-inner");
                            let decrement = document.querySelector(".decrement");
                            let increment = document.querySelector(".increment");
                            let cant = document.querySelector(".cant");
                            let viewProductAdd = document.querySelector("#viewProductAddModal");
                            viewProductAdd.addEventListener("click",function(){
                                let formData = new FormData();
                                let idProduct = viewProductAdd.getAttribute("data-id");
                                formData.append("idProduct",idProduct);
                                formData.append("txtQty",cant.value);
                                viewProductAdd.setAttribute("disabled",true);
                                viewProductAdd.innerHTML = `
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                `;
                                request(base_url+"/shop/addCart",formData,"post").then(function(objData){
                                    
                                    if(objData.status){
                                        viewProductAdd.innerHTML = `<i class="fas fa-check"></i> Added`;
                                        setTimeout(function(){
                                            viewProductAdd.removeAttribute("disabled");
                                            viewProductAdd.innerHTML = `<i class="fas fa-shopping-cart me-2"></i> Add`;
                                        },1000);
                                        document.querySelector("#alert").classList.add("d-none");
                                        document.querySelector("#qtyCart").innerHTML=objData.qty;
                                    }else{
                                        viewProductAdd.removeAttribute("disabled");
                                        viewProductAdd.innerHTML = `<i class="fas fa-shopping-cart me-2"></i> Add`;
                                        document.querySelector("#alert").classList.remove("d-none");
                                    }
                                });
                                
                            });
                            btnPrev.addEventListener("click",function(){
                                inner.scrollBy(-100,0);
                            })
                            btnNext.addEventListener("click",function(){
                                inner.scrollBy(100,0);
                            })
                            cant.addEventListener("change",function(){
                                if(cant.value <= 1){
                                    cant.value = 1;
                                }else if(cant.value >= product['stock']){
                                    cant.value = product['stock'];
                                }
                            })
                            decrement.addEventListener("click",function(){
                                if(cant.value<=1){
                                    return cant.value=1;
                                }
                                cant.value--;
                            });
                            increment.addEventListener("click",function(){
                                if(cant.value>=product['stock']){
                                    return cant.value=product['stock'];
                                }
                                cant.value++;
                            });
                        }
                        
                        
                        
                        if(document.querySelector(".product-addwishlistModal")){
                            let btn = document.querySelector(".product-addwishlistModal");
                            let formData = new FormData();
                            formData.append("idProduct",idProduct);
    
                            btn.addEventListener("click",function(){
                                btn.classList.toggle("active");
                                if(btn.classList.contains("active")){
                                    btn.parentElement.children[1].innerHTML= `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
                                    btn.setAttribute("disabled","disabled");
                                    request(base_url+"/shop/addWishList",formData,"post").then(function(objData){
                                        btn.removeAttribute("disabled");
                                        if(objData.status){
                                            btn.classList.replace("far","fas");
                                            btn.classList.add("text-danger");
                                            btn.parentElement.children[1].classList.replace("c-d","c-p");
                                            btn.parentElement.children[1].setAttribute("href",base_url+"/shop/wishlist");
                                            btn.parentElement.children[1].innerHTML="Check wishlist";
                                        }else{
                                            openLoginModal();
                                            btn.parentElement.children[1].innerHTML="Add to wishlist";
                                            btn.classList.replace("fas","far");
                                            btn.classList.remove("text-danger");
                                            btn.parentElement.children[1].classList.replace("c-p","c-d");
                                            btn.parentElement.children[1].removeAttribute("href");
                                        }
                                    });
                                    
                                }else{
                                    btn.parentElement.children[1].innerHTML= `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
                                    btn.setAttribute("disabled","disabled");
                                    request(base_url+"/shop/delWishList",formData,"post").then(function(objData){
                                        btn.removeAttribute("disabled");
                                        if(objData.status){
                                            btn.classList.replace("fas","far");
                                            btn.classList.remove("text-danger");
                                            btn.parentElement.children[1].classList.replace("c-p","c-d");
                                            btn.parentElement.children[1].removeAttribute("href");
                                            btn.parentElement.children[1].innerHTML="Add to wishlist";
                                        }else{
                                            openLoginModal();
                                            btn.parentElement.children[1].innerHTML="Add to wishlist";
                                            btn.classList.replace("fas","far");
                                            btn.classList.remove("text-danger");
                                            btn.parentElement.children[1].classList.replace("c-p","c-d");
                                            btn.parentElement.children[1].removeAttribute("href");
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
                
            });
        } 
    }
}
//Add product card button
function addProductCard(){
    if(document.querySelectorAll(".product-card-add")){
        let btnAddCart = document.querySelectorAll(".product-card-add");
        let popup = document.querySelector(".popup");
        let popupClose = document.querySelector(".popup-close"); 
        let timer;
        
        for (let i = 0; i < btnAddCart.length; i++) {
            let btnAdd = btnAddCart[i];
            btnAdd.addEventListener("click",function(e){
                let idProduct = btnAdd.parentElement.parentElement.parentElement.getAttribute("data-id");
                let formData = new FormData();
                formData.append("idProduct",idProduct);
                formData.append("txtQty",1);
                window.clearTimeout(timer);
                if(popup.classList.length>1){
                    popup.classList.remove("active");
                    setTimeout(function(){
                        popup.classList.add("active");
                    },100);
                }else{
                    popup.classList.add("active");
                }
                const runTime = function(){
                    timer = window.setTimeout(function(){
                        popup.classList.remove("active");
                    },6000);
                };
                runTime();
                request(base_url+"/shop/addCart",formData,"post").then(function(objData){
                    let title = document.querySelectorAll(".product-info a h3")[i].innerHTML;
                    if(objData.status){
                        document.querySelector("#qtyCart").innerHTML=objData.qty;
                        let url = document.querySelectorAll(".product-img img")[i].src;
                        
    
                        popup.children[1].children[0].src=url;
                        popup.children[1].children[0].alt=title;
                        popup.children[1].children[1].children[0].innerHTML=title;
                        popup.children[1].children[1].children[0].setAttribute("href",objData.url);
                        popup.children[1].children[1].children[1].innerHTML=objData.msg;
                        popup.addEventListener("mouseover",function(){
                            window.clearTimeout(timer);
                            runTime();
                        })
                        popupClose.addEventListener("click",function(){
                            popup.classList.remove("active");
                        });
                    }else{
    
                        popup.children[1].children[0].src=base_url+"/Assets/images/uploads/warning.png";
                        popup.children[1].children[0].alt="error";
                        popup.children[1].children[1].children[0].innerHTML=title;
                        popup.children[1].children[1].children[0].setAttribute("href",objData.url);
                        popup.children[1].children[1].children[1].innerHTML=`<strong class="text-danger">${objData.msg}</strong>`;
                        popup.addEventListener("mouseover",function(){
                            window.clearTimeout(timer);
                            runTime();
                        });
                        popupClose.addEventListener("click",function(){
                            popup.classList.remove("active");
                        });
                    }
                });
            });
        }
    }
}
//add to wishlist
function addWishList(){
    if(document.querySelectorAll(".product-btns .addWishList")){
        let btns = document.querySelectorAll(".product-btns .addWishList");
        for (let i = 0; i < btns.length; i++) {
            let btn = btns[i];
            btn.addEventListener("click",function(){
                let idProduct = btn.parentElement.parentElement.parentElement.getAttribute("data-id");
                let formData = new FormData();
                formData.append("idProduct",idProduct);
                btn.classList.toggle("active");
                if(btn.classList.contains("active")){
                    btn.innerHTML = `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
                    btn.setAttribute("disabled","disabled");
                    request(base_url+"/shop/addWishList",formData,"post").then(function(objData){
                        btn.removeAttribute("disabled");
                        if(objData.status){
                            btn.innerHTML = `<i class="fas fa-heart text-danger " title="Add to wishlist"></i>`;
                        }else{
                            openLoginModal();
                            btn.innerHTML = `<i class="far fa-heart" title="Add to wishlist"></i>`;
                        }
                    });
                }else{
                    btn.innerHTML = `<span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>`;
                    btn.setAttribute("disabled","disabled");
                    request(base_url+"/shop/delWishList",formData,"post").then(function(objData){
                        btn.removeAttribute("disabled");
                        if(objData.status){
                            btn.innerHTML = `<i class="far fa-heart" title="Add to wishlist"></i>`;
                        }else{
                            btn.innerHTML = `<i class="far fa-heart " title="Add to wishlist"></i>`;
                            openLoginModal();
                        }
                    });
                    
                }
            })
        }
    }
}
//Filter price
function filterPrice(){
    let filter = document.querySelectorAll(".filter-price input");
    let filterInfo = document.querySelector("#filter-price-info");
    let products = document.querySelectorAll(".product-item");
    for (let i = 0; i < filter.length; i++) {
        let range = filter[i];
        let min = filter[0];
        let max = filter[1];
        range.addEventListener("input",function(){
            filterInfo.innerHTML=`Price: ${MS+min.value+" "+MD} - ${MS+max.value+" "+MD}`;
            for (let j = 0; j < products.length; j++) {
                let price = products[j].getAttribute("data-price");
                if(price >= min.value && price <= max.value){
                    products[j].classList.remove("d-none");
                }else{
                    products[j].classList.add("d-none");
                    if(document.querySelector("#results")){
                        document.querySelector("#results").innerHTML =`Results: (${products.length-document.querySelectorAll(".product-item.d-none").length})`;
                    }
                }
            }
        });
    }
}
function rateProduct(){
    let stars = document.querySelectorAll(".starBtn");
    for (let i = 0; i < stars.length; i++) {
        let star = stars[i];
        star.addEventListener("click",function(){
            document.querySelector("#intRate").value = i+1;
            for (let j = 0; j < stars.length; j++) {
                if(j>i){
                    stars[j].innerHTML =`<i class="far fa-star"></i>`;
                }else{
                    stars[j].innerHTML =`<i class="fas fa-star"></i>`;
                }
            }
        })
    }
}
function editReview(id){
    let html="";
    let formData = new FormData();
    formData.append("idReview",id);
    request(base_url+"/shop/getReview",formData,"post").then(function(objData){
        for (let i = 0; i < 5; i++) {
            if(i >= parseInt(objData.rate)){
                html+=`<button type="button" class="starBtn"><i class="far fa-star"></i></button>`;
            }else{
                html+='<button type="button" class="starBtn"><i class="fas fa-star"></i></button>';
            }
        }
        document.querySelector(".review-rate").innerHTML=html;
        document.querySelector("#intRate").value = objData.rate;
        document.querySelector("#txtReview").value = objData.description;
        document.querySelector("#idProduct").value = objData.productid;
        document.querySelector("#idReview").value = objData.id;
        rateProduct();
    });
}
function deleteReview(id){
    let idProduct = document.querySelector("#idProduct").value;
    let formData = new FormData();
    formData.append("idProduct",idProduct);
    formData.append("idReview",id);
    request(base_url+"/shop/delReview",formData,"post").then(function(objData){
        if(objData.status){
            let rate = objData.rate;
            let rateStars ="";

            for (let i = 0; i < 5; i++) {
                if(i >= parseInt(rate.rate)){
                    rateStars+='<i class="far fa-star"></i>';
                }else{
                    rateStars+='<i class="fas fa-star"></i>';
                }
            }

            document.querySelector(".comment-list").innerHTML= objData.html;
            document.querySelectorAll(".product-rate")[0].innerHTML= rateStars+` (${rate.total} reviews)`;
            document.querySelectorAll(".product-rate")[1].innerHTML= rateStars;
            document.querySelector("#pills-reviews-tab").innerHTML=`Reviews (${rate.total})`;

            document.querySelector("#avgRate").innerHTML = `${parseFloat(rate.rate).toFixed(1)}<span class="fs-6">/ 5</span>`;
            document.querySelectorAll(".progress-bar")[0].style.width=`${(rate.five/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[0].ariaValueNow = (rate.five/rate.total)*100;
            document.querySelectorAll(".progress-bar")[1].style.width=`${(rate.four/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[1].ariaValueNow = (rate.four/rate.total)*100;
            document.querySelectorAll(".progress-bar")[2].style.width=`${(rate.three/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[2].ariaValueNow = (rate.three/rate.total)*100;
            document.querySelectorAll(".progress-bar")[3].style.width=`${(rate.two/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[3].ariaValueNow = (rate.two/rate.total)*100;
            document.querySelectorAll(".progress-bar")[4].style.width=`${(rate.one/rate.total)*100}%`;
            document.querySelectorAll(".progress-bar")[4].ariaValueNow = (rate.one/rate.total)*100;
            document.querySelectorAll(".review-stars span")[0].innerHTML =`(${rate.five})`;
            document.querySelectorAll(".review-stars span")[1].innerHTML =`(${rate.four})`;
            document.querySelectorAll(".review-stars span")[2].innerHTML =`(${rate.three})`;
            document.querySelectorAll(".review-stars span")[3].innerHTML =`(${rate.two})`;
            document.querySelectorAll(".review-stars span")[4].innerHTML =`(${rate.one})`;
        }
    });
}
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
/***************************Nav Events****************************** */
let btnBar = document.querySelector("#btnToggleNav");
let btnCart = document.querySelector("#btnToggleCart");
let btnClose = document.querySelector("#btnCloseNav");
let btnCloseCart = document.querySelector("#btnCloseCart");


btnBar.addEventListener("click",function(){
    document.querySelector(".nav-mobile-main").classList.toggle("active");
    document.querySelector(".nav-mobile").classList.toggle("active");
});
btnCart.addEventListener("click",function(){
    document.querySelector(".cart-panel-main").classList.toggle("active");
    document.querySelector(".cart-panel").classList.toggle("active");
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

if(document.querySelectorAll(".product-btns .fa-eye")){
    let btns = document.querySelectorAll(".product-btns .fa-eye");
    for (let i = 0; i < btns.length; i++) {
        let btn = btns[i];
        btn.addEventListener("click",function(e){
            let productCard = e.target.parentElement.parentElement;
            let discount = "";
            let price ="";
            let modalItem = document.querySelector("#modalItem");
            let modal="";
            let info = document.querySelectorAll(".product-info a");
            
            let url = document.querySelectorAll(".product-img img")[i].getAttribute("src");
            if(productCard.children[0].className =="product-discount"){
                discount = `<p class="product-discount"><strong>${productCard.children[0].innerHTML}</strong></p>`
            }
            if(info[i].children[2].children.length>1){
                price = `
                <p class="m-0 text-decoration-line-through t-p">${info[i].children[2].children[1].innerHTML}</p>
                <p class="fs-3"><strong>${info[i].children[2].children[0].innerHTML}</strong></p>`;
            }else{
                price = `
                <p class="fs-3"><strong>${info[i].children[2].children[0].innerHTML}</strong></p>`;
            }
            
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
                                        <img src="${url}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="product-image-slider">
                                        <div class="product-image-inner">
                                            <div class="product-image-item active">
                                                <img src="${url}">
                                            </div>
                                            <div class="product-image-item">
                                                <img src="${url}">
                                            </div>
                                            <div class="product-image-item">
                                                <img src="${url}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6 product-data">
                                    <h1><strong>${info[i].children[1].innerHTML}</strong></h1>
                                    <div class="product-rate mb-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        (6 reviews)
                                    </div>
                                    ${price}
                                    <p class="mb-3" id="description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolores illum quibusdam asperiores sed. Asperiores hic aliquam adipisci odit suscipit excepturi sit, nemo et velit ex, atque enim exercitationem facere corporis!</p>
                                    <p class="m-0">SKU: <strong>111-222-333</strong></p>
                                    <p class="m-0">Category: ${info[i].children[0].innerHTML}</p>
                                    <div class="mt-5 d-flex align-items-center">
                                        <div class="product-cant me-3">
                                            <div class="decrement"><i class="fas fa-minus"></i></div>
                                            <input class="cant me-2 ms-2" type="number" min="1" max="99" value="1">
                                            <div class="increment"><i class="fas fa-plus"></i></div>
                                            <div class="ms-3 product-btn"><i class="fas fa-shopping-cart me-2"></i> Add</div>
                                        </div>
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
                //productImages[i].classList.remove("active");
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

            let decrement = document.querySelector(".decrement");
            let increment = document.querySelector(".increment");
            let cant = document.querySelector(".cant");
            cant.addEventListener("change",function(){
                if(cant.value <= 1){
                    cant.value = 1;
                }else if(cant.value >= 99){
                    cant.value = 99;
                }
            })
            decrement.addEventListener("click",function(){
                if(cant.value<=1){
                    return cant.value=1;
                }
                cant.value--;
            });
            increment.addEventListener("click",function(){
                if(cant.value>=99){
                    return cant.value=99;
                }
                cant.value++;
            })
            
            /*let slider = document.querySelector(".product-image-slider");
            let inner = document.querySelector(".product-image-inner");
            let startx=0;
            let press = false;
            slider.addEventListener("mousedown",function(e){
                startx = e.offsetX - inner.offsetLeft;
                slider.style.cursor="grabbing";
                press = true;
            });
            slider.addEventListener("mouseup",function(e){
                slider.style.cursor="grab";
            });
            slider.addEventListener("mouseup",function(){
                press = false;
            })
            slider.addEventListener("mouseover",function(e){
                slider.style.cursor="grab";
            });
            slider.addEventListener("mousemove",function(e){
                if(press){
                    e.preventDefault();
                    inner.style.left=`${e.offsetX-startx}px`;
                }
            });*/
            
        });
    }  
}

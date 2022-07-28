export default class Orders{
    showItems(element){
        let url = base_url+"/Orders/getOrders";
        request(url,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        })
    }
    viewItem(id){
        window.location.href=base_url+"/Orders/order/"+id;
    }
    deleteItem(id){
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
                let url = base_url+"/Category/delCategory"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idCategory",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Deleted",objData.msg,"success");
                        url = base_url+"/Category/getCategories";
                        request(url,"","get").then(function(objData){
                            if(objData.status){
                                element.innerHTML = objData.data;
                            }else{
                                element.innerHTML = objData.msg;
                            }
                        })
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            }
        });
    }
}
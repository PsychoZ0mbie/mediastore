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
    refund(id){
        let btn = document.querySelector("#btnRefund");
        btn.innerHTML=`
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Wait...
        `;
        btn.setAttribute("disabled","");
        request(base_url+"/Orders/getTransaction/"+id,"","get").then(function(objData){
            btn.removeAttribute("disabled");
            btn.innerHTML=`<i class="fas fa-undo"></i> Refund`;

            if(objData.status){
                
                let transaction = objData.data;
                let idTransaction = transaction.purchase_units[0].payments.captures[0].id;
                let payer = transaction.purchase_units[0].shipping.name.full_name+'<br>'+transaction.payer.email_address;
                let grossAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.gross_amount.value;
                let feeAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.paypal_fee.value;
                let netAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.net_amount.value;
                console.log(transaction);
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Refund</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formItem" name="formItem" class="mb-4">
                                    <input type="hidden" id="idTransaction" name="idTransaction" value="${idTransaction}">
                                    <table class="table align-middle text-break">
                                        <tbody id="listItem">
                                            <tr>
                                                <td>Transaction: </td>
                                                <td>${idTransaction}</td>
                                            </tr>
                                            <tr>
                                                <td>Payer: </td>
                                                <td>${payer}</td>
                                            </tr>
                                            <tr>
                                                <td>Gross refund: </td>
                                                <td>${grossAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>Paypal fee: </td>
                                                <td>${feeAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>Net refund: </td>
                                                <td>${netAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>observaction: </td>
                                                <td><textarea name="txtDescription" id="txtDescription" rows="3" class="w-100 form-control"></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success text-white" id="btnRefundConfirm"><i class="fas fa-undo"></i> Refund</a>
                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                modalItem.innerHTML = modal;
                let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                modalView.show();

                let form = document.querySelector("#formItem");
                form.addEventListener("submit",function(e){
                    e.preventDefault();
                    
                    let strDescription = document.querySelector("#txtDescription").value;
                    let idTransaction = document.querySelector("#idTransaction").value;
                    let btnRefundConfirm = document.querySelector("#btnRefundConfirm");
                    
                    if(idTransaction == "" || strDescription == ""){
                        Swal.fire("Error","Please fill the fields ","error");
                        return false;
                    }
                    btnRefundConfirm.innerHTML=`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Wait...
                    `;
                    btnRefundConfirm.setAttribute("disabled","");
                    Swal.fire({
                        title:"Are you sure to refund it?",
                        icon: 'warning',
                        showCancelButton:true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:"Yes, refund",
                        cancelButtonText:"No, cancel"
                    }).then(function(result){
                        
                        let formData = new FormData(form);
                        if(result.isConfirmed){
                            request(base_url+"/Orders/setRefund",formData,"post").then(function(objData){
                                btnRefundConfirm.innerHTML=`<i class="fas fa-undo"></i> Refund`;
                                btnRefundConfirm.removeAttribute("disabled");
                                if(objData.status){
                                    window.location.reload();
                                }else{
                                    Swal.fire("Error",objData.msg,"error");
                                }
                            });
                        }else{
                            btnRefundConfirm.innerHTML=`<i class="fas fa-undo"></i> Refund`;
                            btnRefundConfirm.removeAttribute("disabled");
                        }
                    });
                });
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
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
                let url = base_url+"/Orders/delOrder"
                let formData = new FormData();
                let element = document.querySelector("#listItem");
                formData.append("idOrder",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Deleted",objData.msg,"success");
                        let url = base_url+"/Orders/getOrders";
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
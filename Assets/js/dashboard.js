'use strict';

$('.date-picker').datepicker( {
    closeText: 'Close',
    prevText: 'back',
    nextText: 'next',
    currentText: 'Today',
    monthNames: ['1 -', '2 -', '3 -', '4 -', '5 -', '6 -', '7 -', '8 -', '9 -', '10 -', '11 -', '12 -'],
    monthNamesShort: ['January','February','March','April', 'May','June','July','August','September', 'October','November','Dicember'],
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    showDays: false,
    onClose: function(dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
});

let btnSalesMonth = document.querySelector("#btnSalesMonth");
let btnSalesYear = document.querySelector("#btnSalesYear");
btnSalesMonth.addEventListener("click",function(){
    let salesMonth = document.querySelector(".salesMonth").value;
    if(salesMonth==""){
        Swal.fire("Error", "Please choose a date", "error");
        return false;
    }
    btnSalesMonth.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnSalesMonth.setAttribute("disabled","");
    let formData = new FormData();
    formData.append("date",salesMonth);
    request(base_url+"/dashboard/getSalesMonth",formData,"post").then(function(objData){
        btnSalesMonth.innerHTML=`<i class="fas fa-search"></i>`;
        btnSalesMonth.removeAttribute("disabled");
        $("#salesMonth").html(objData);
    });
});
btnSalesYear.addEventListener("click",function(){
    
    let salesYear = document.querySelector("#sYear").value;
    let strYear = salesYear.toString();

    if(salesYear==""){
        Swal.fire("Error", "Please put a year", "error");
        document.querySelector("#sYear").value ="";
        return false;
    }
    if(strYear.length>4){
        Swal.fire("Error", "Date is wrong.", "error");
        document.querySelector("#sYear").value ="";
        return false;
    }
    btnSalesYear.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnSalesYear.setAttribute("disabled","");

    let formData = new FormData();
    formData.append("date",salesYear);
    request(base_url+"/dashboard/getSalesYear",formData,"post").then(function(objData){
        btnSalesYear.innerHTML=`<i class="fas fa-search"></i>`;
        btnSalesYear.removeAttribute("disabled");
        console.log(objData);
        if(objData.status){
            $("#salesYear").html(objData.script);
        }else{
            Swal.fire("Error", objData.msg, "error");
            document.querySelector("#sYear").value ="";
        }
    });
});
window.id_specific_price;
window.id_deal;
window.activeOrDeactive;
window.rowId;
function editableTable()
{       
   var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                "bRetrieve": true,
                "bDestroy": true,
                // set the initial value
                "iDisplayLength": 10,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': true,
                        'aTargets': [0]
                    }
                ] 
                
            });
            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown
                 
}
function editRow(rowId)
{
    var className=$("#editRow_"+rowId).attr('class');
    if(className=='edit')
    {
        $("#reduction_"+rowId).removeClass('noBorder');
        $("#from_"+rowId).removeClass('noBorder');
        $("#to_"+rowId).removeClass('noBorder');
        $("#selectOption"+rowId).removeClass('noBorder');

        $("#activeOrDeactive_"+rowId).html("cancel");
        $("#editRow_"+rowId).html("save");

        $("#activeOrDeactive_"+rowId).removeClass("delete");
        $("#activeOrDeactive_"+rowId).addClass("cancel");

        $("#editRow_"+rowId).removeClass("edit");
        $("#editRow_"+rowId).addClass("save");

        $("#selectOption"+rowId).removeAttr('disabled');
        $("#reduction_"+rowId).removeAttr('disabled');
        $("#from_"+rowId).removeAttr('disabled');
        $("#to_"+rowId).removeAttr('disabled');

        $('.datepickerNew').datepicker({
                format: 'yyyy-mm-dd'
            });

    }
    else if(className=='save')
    {
        var id_specific_price=$("#row_"+rowId).attr('value');
        var sprice=0.00;
        var d_from=$("#from_"+rowId).val();;
        var d_to=$("#to_"+rowId).val();;
        var reduction=$("#reduction_"+rowId).val();
        var reduction_type=$("#selectOption"+rowId+" option:selected").val();
        var dealId=$("#row_"+rowId).find(".dealId").attr("value");
        if(!d_from && !d_to)
        {
            alert("Kindly Check date");
            return false;
        }
        else if(d_from > d_to)
        {
            alert("check from and to dates ");
            return false;
        }
        if(d_from.length<11)                 
        {
            d_from=d_from+" 00:00:00";  
        }
        if(d_to.length<11)
        {
            d_to=d_to+" 23:59:59";  
        }

         var dataparam = '&type='+4+'&id_specific_price='+id_specific_price+'&sprice='+sprice+'&from='+d_from+'&to='+d_to+'&reduction='+reduction+'&reduction_type='+reduction_type+'&id_customer='+id_customer+'&id_deal='+dealId+ '&id_employee=' + id_employee;         
        $.ajax({          
          type: 'POST',
          dataType: 'json',
          async: true,
          url: 'rm-deal.php', //
          data: dataparam,
          cache: true,
          success: function(data) 
          {
            showDeal();                    
          }
        });
    }
}

function activeDeactive(rowId)
{
    var className=$("#activeOrDeactive_"+rowId).attr('class');
    if(className=='cancel')
    {
        showDeal();
    }
    else if(className=='delete')
    {
        var date;
        var expiryDate
        var activeOrDeactive=0;

        window.id_deal=$("#row_"+rowId).find(".dealId").attr("value");
        window.id_specific_price=$("#row_"+rowId).attr('value');

        if($("#activeOrDeactive_"+rowId+" .actionBtn ").hasClass("btn-danger"))
        {
            window.rowId=rowId;

            $("#rmDealExpiryDate").modal('show');
            $(".datepicker").addClass("zindex");

            window.activeOrDeactive=1;
        }
        else if($("#activeOrDeactive_"+rowId+" .actionBtn ").hasClass("btn-primary"))
        {
            window.rowId=rowId;
            window.activeOrDeactive=2;
            activateDeal();
        }
        else
        {
            return;
        }
    }
}
function activateDeal()
{
    var expiryDate=0;
    if(window.activeOrDeactive==1)
    {
        $(".datepicker").removeClass("zindex");
        var d = new Date();
        var strDate = d.getFullYear() + "-" + ((d.getMonth()+1)<10 ? '0'+(d.getMonth()+1):''+(d.getMonth()+1) )+ "-" +((d.getDate())<10 ? '0'+(d.getDate()):''+(d.getDate()) );
        expiryDate=$("#deal-expiry-date").val();
        expiryDate=expiryDate+" 23:59:59";
        if(expiryDate<strDate)
        {
            toast("check Expiry date","warning");
            $("#rmDealExpiryDate").modal('show');
            $(".datepicker").addClass("zindex");
        }
    }
    else if(window.activeOrDeactive==2)
    {

    }
    

    var dataparam = '&type='+5+'&id_specific_price='+window.id_specific_price+'&id_deal='+window.id_deal+'&expiryDate='+expiryDate;
        $.ajax({                  
            type: 'POST',
            dataType: 'json',
            async: true,
            url: 'rm-deal.php', //
            data: dataparam,
            cache: true,
            success: function(data) 
            {
               if(window.activeOrDeactive==1)
               {
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").removeClass("btn-danger");
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").addClass("btn-primary");
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").html("Activated");

                     $("#rmDealExpiryDate").modal('hide');               
                    toast("Deal Activated Successfully","success");
                    //$("#row_"+window.rowId).attr("value")=data;
                    $("#row_"+window.rowId).attr("value",data);
                    window.activeOrDeactive=0;
               }
               else if(window.activeOrDeactive==2)
               {
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").removeClass("btn-primary");
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").addClass("btn-danger");
                    $("#activeOrDeactive_"+window.rowId+" .actionBtn ").html("Deactivated");

                    toast("Deal Deactivated Successfully","success");
                    window.activeOrDeactive=0;
               }
            }
        });
}
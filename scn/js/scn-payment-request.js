$(document).ready(function() {

    easySearch('payment-requests-scn');

    $('#payment-request-from-date,#payment-request-to-date').datepicker({
        prevText:"",
        nextText:"",
        dateFormat:"yy-mm-dd"
    });

    $("#vendorName").autocomplete("scn-viewpurchasebilldata.php?type=6", {
        minChars: 1,
        max: 10,
        dataType: "json",
        formatItem: function(data, i, max, value, term) {
            return value;
        },
        parse: function(data) {
            if (data == "") {
                $('#vendorName').val('');
                $('#vendorName').attr('placeholder', 'Vendor Not found');
                return data;
            } else {
                var mytab = new Array();
                for (var i = 0; i < data.length; i++)
                    mytab[mytab.length] = {
                        data: data[i].name + "~" + data[i].id_vendor + "~" + data[i].tin + "~" + data[i].cst,
                        value: "<div onclick='openVendorDetails(" + data[i].id_vendor + ", 1)'><span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>" + data[i].name + "</br>" + "Vendor Id:" + data[i].id_vendor + "</br>" + "Tin No: " + data[i].tin + "</span></div>"
                    };
                return mytab;
            }
        },
    }).result(
        function(event, data, formatted, value) {
            var seperate = data.split('~');
            vendor_id = seperate[1];
            openVendorDetails(vendor_id, 1);
        });
});

function openVendorDetails(vendor_id, type) {
    $('#index_viewport').html('');
    $(".ajaxLoaderModal").show();
    $("#index_viewport").load("payment-request.php?ajax=true&type=" + type + "&id_vendor=" + vendor_id + "", function(response, status, xhr) {
        $(".ajaxLoaderModal").hide();
    });
}

function getBankDetail(vendor_id, type) {
    var id_bank = $('#vendorBankDetail').val();

    if (id_bank == "") {
        id_bank = 0;
    }

    $('#index_viewport').html('');
    $(".ajaxLoaderModal").show();
    $("#index_viewport").load("payment-request.php?ajax=true&type=" + type + "&id_vendor=" + vendor_id + "&id_bank=" + id_bank + "", function(response, status, xhr) {
        $(".ajaxLoaderModal").hide();
    });
}

function submitRequest() {
    var dataparam = $('#submitRequest').serialize();
    $.post("payment-request.php", dataparam)
        .done(function() {
            toast("Request sent successfully", "success"); //on success show message
        })
        .fail(function() {
            toast("Problem with sending request", "error"); //for if any failure happened
        })
        .always(function() {
            paymentRequest(0);
        });
}

function createVendor() {
    var dataparam = $('#vendor-create-form').serialize();
    $.post("payment-request.php", dataparam)
        .done(function(data) {
            toast("Vendor Created successfully", "success"); //on success show message
            $('#vendorCreate').appendTo("body").modal('hide');
            openVendorDetails(data, 1);
        })
        .fail(function() {
            toast("Problem with Adding Vendor", "error"); //for if any failure happened
        })
        .always(function() {});
}

function createBankDetail() {
    var dataparam = $('#bank-detail-form').serialize();
    $.post("payment-request.php", dataparam)
        .done(function(data) {
            toast("Bank Detail Created successfully", "success"); //on success show message
            $('#bankDetailCreate').appendTo("body").modal('hide');
            openVendorDetails(data, 1);
        })
        .fail(function() {
            toast("Problem with Adding Bank Detail", "error"); //for if any failure happened
        })
        .always(function() {});
}

function openDetail(id_request)
{
    var type = 7;
    var dataparam= '&type='+type+'&id_request='+id_request;
         $.ajax({
            type: 'GET',
            async: false,
            dataType:'json',
            url: 'payment-request.php',
            data: dataparam,
            cache: false,
            success: function(data)
            {
                $('.payment-request-data').html("");
        
                for(var i = 0; i < data.length; i++)
                {
                    if(data[i].account_type == 1)
                        data[i].account_type = "Savings A/c";
                    else if(data[i].account_type == 2)
                        data[i].account_type = "Current A/c";
                    else if(data[i].account_type == 3)
                        data[i].account_type = "Credit A/c";

                    $('.payment-request-data').append('<tr><td><b>Requested By</b></td><td>'+data[i].emp_first_name+'</td></tr>\
                                                       <tr><td><b>Date</b></td><td>'+data[i].req_date_add+'</td></tr>\
                                                       <tr><td><b>Order Id(s)</b></td><td>'+data[i].order_numbers+'</td></tr>\
                                                       <tr><td><b>Amount</b></td><td>'+data[i].request_amount+'</td></tr>\
                                                       <tr><td><b>City</b></td><td>'+data[i].vendor_city+'</td></tr>\
                                                       <tr><td><b>FC</b></td><td>'+data[i].fc_city+'</td></tr>\
                                                       <tr><td><b>Comment</b></td><td>'+data[i].comments+'</td></tr>\
                                                       <tr><td><b>Vendor Name</b></td><td>'+data[i].vendor_name+'</td></tr>\
                                                       <tr>\
                                                        <td><b>Bank Details</b></td>\
                                                        <td>\
                                                            <table class="table table-bordered">\
                                                                <tbody>\
                                                                    <tr><td>Bank Name : '+data[i].bank_name+'</td></tr>\
                                                                    <tr><td>Branch : '+data[i].branch+'</td></tr>\
                                                                    <tr><td>Account Number : '+data[i].account_no+'</td></tr>\
                                                                    <tr><td>IFSC Code : '+data[i].ifsc_code+'</td></tr>\
                                                                    <tr><td>Account Type : '+data[i].account_type+'</td></tr>\
                                                                </tbody>\
                                                            <table>\
                                                        </td>\
                                                       </tr>');
                }

                $('.payment-request-pop').modal('show').css({'overflow' : 'hidden'});
            }
        });
}

function filterRequests(type){
    var req_from_date = $('#payment-request-from-date').val();
    var req_to_date = $('#payment-request-to-date').val();
    var vendor = $('#payment-vendor').val();
    var fc = $('#payment-fc').val();
    var payment_status = $('#payment-status').val();
    $('#index_viewport').html('');
    $("#index_viewport").load("payment-request.php?ajax=true&type="+type+"&req_from_date="+req_from_date+"&req_to_date="+req_to_date+"&vendorName="+vendor+"&id_fc="+fc+"&status="+payment_status+"", function(response, status, xhr) {
        $('#payment-request-from-date').val(req_from_date);
        $('#payment-request-to-date').val(req_to_date);
        $('#payment-vendor').val(vendor);
        $('#payment-fc').val(fc);
        $('#payment-status').val(payment_status);
    });
}

function deleteRequest(id_request)
{
     $.ajax({
        type: 'GET',
        async: false,
        dataType:'json',
        url: 'payment-request.php',
        data: '&type=11&id_request='+id_request,
        cache: false,
        success: function(data)
        {
            if(data == 1)
            {
                toast('Payment request deleted successfully','success');
                paymentRequest(9);
            }
        }
    });
}
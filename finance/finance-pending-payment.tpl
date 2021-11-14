<div class="panel" id="">
    <div class="panel-body">
     <div class="text-center panel-heading" align="center">   
            <header><b>Company's Outstanding Payment</b></header>
        </div><br>
    <section class="panel">
    
        <div class="row">
            <form id="form_fpp_excel" name="form_invoice" action="finance-pending-payment-excel.php" autocomplete="off" method="post">
                <div class="form-group col-md-offset-1 col-md-3 col-sm-3 col-xs-3 col-lg-3">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                        <select id="group_selection" name="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="" required>
                            <option value="0">Select Company</option>
                            {foreach $groups as $data}
                            <option value="{$data.id_group}">{$data.name}</option>
                            {/foreach}
                        </select>
                </div>
                <div class="form-group col-md-7 col-sm-7 col-xs-9 col-lg-4">
                   <span class="form-group col-md-3 col-sm-6 col-xs-6 col-lg-5">
                        <input type="text" id="fpp_from" name="fpp_from" placeholder="From" class="datepicker form-control">
                   </span>
                    <span class="form-group col-md-3 col-sm-6 col-xs-6 col-lg-5">
                        <input type="text" id="fpp_to" name="fpp_to" placeholder="To" class="datepicker form-control">
                    </span>
                </div>
            </form>
            
            <button id="searchFppButton" class="btn btn-primary clrbtn col-xs-offset-4 col-sm-offset-4 col-md-offset-0 col-lg-offset-0">Search</button>
            <button id="resetFppButton" class="btn btn-danger clrbtn col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0">Reset</button>
        </div>
        <table class="table table-striped table-hover table-bordered " id="finance_pending_payment_list">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Company</th>
                    <th>Order Id</th>					                    
                    <th>Invoice Number</th>                    
                    <th>Invoice Date</th>
                    <th>Invoice Value</th>                    
                    <th>Credit Days</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Action</th>
             	</tr>
            </thead>
            <tbody id="finance_pending_payment">
            {assign var=i value=1}
            {foreach $pending_payment as $payment}
                <tr>
                    <td>{$i}</td>
                    <td>{$payment.name}</td>
                    <td>{$payment.id_order}</td>
                    <td>IN00{$payment.invoice_number}</td>                    
                    <td class="table-date">{$payment.date_add|date_format}</td>
                    <td class="amount">{$payment.total_paid}</td>
                    <td>{$payment.credit_days} {*<i class="btn fa fa-edit credit-day" onclick="orderCredit({$payment.id_order},{$payment.credit_days});"></i>*}</td>
                    <td>{$payment.aging}</td>
                    <td>{$payment.order_status}</td>
                    <td>
                        {if $payment.order_status|lower =='Payment Pending'|lower}
                        <span class="fa fa-check-square-o btn btn-black" onclick="paymentReceived({$payment.id_order},this);" id="{$payment.id_order}">Payment Received</span>
                        {/if}
                    </td>
                </tr>
            {assign var=i value=$i+1}
            {/foreach}
            </tbody>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="amount"></th>
                <th></th>
                <th></th>
                <th></th>
             </tr>
			  
        </tfoot>
        </table>
        
     </section>
   </div>
</div>

<script type="text/javascript">
easySearch('finance_pending_payment_list');
    function easySearch(table_id)
    {       
        var oTable = $('#'+table_id).dataTable({
            "aLengthMenu": [
                /*[25, 50, 100, -1],
                [25, 50, 100, "All"]*/ // change per page values here
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            // set the initial value
            "iDisplayLength": 10,
                        
            "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page ",
                "sLoadingRecords": "Please wait - loading...",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            
            "aoColumnDefs": [{
                    'bSortable': true,
                    'aTargets': [0]
                }
            ],
            "fnFooterCallback": function (nRow, aasData, iStart, iEnd, aiDisplay) {

            var columnas = [6]; //the columns you wish to add            
            for (var j in columnas) {
                
                var columnaActual = columnas[j];

                var total = 0;
                for (var i = iStart; i < iEnd; i++) {
                    var str = aasData[aiDisplay[i]][columnaActual];
                    str = str.replace("Rs.",""); 
                    var res = str.replace(",",""); 
                    total = total + parseFloat(res);
                    
                }
                  $($(nRow).children().get(columnaActual)).html(moneyFormat(total));

            } 
            }
            
        });
                     
    }
    $("<button id='generateExcel' class='btn btn-primary clrbtn'>Download</button>").insertBefore("#finance_pending_payment_list_filter label");
    $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
    $('#group_selection').select2();
    $(document).ready( function() {
        //getGroups(1);
    });

    if(window.cop_from && window.cop_to)
    {
        $("#fpp_from").val(window.cop_from);
        $("#fpp_to").val(window.cop_to);
    }
    if(window.group_name_selected)
    {
        $("#select2-group_selection-container").html(window.group_name_selected);
        $("#group_selection").val(window.group_id_Selected);
    }    
 </script>
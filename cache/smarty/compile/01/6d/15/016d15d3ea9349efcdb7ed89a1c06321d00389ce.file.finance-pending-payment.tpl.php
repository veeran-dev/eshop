<?php /* Smarty version Smarty-3.1.19, created on 2018-09-06 11:59:05
         compiled from "finance\finance-pending-payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:299805b90c9317b7134-85793714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '016d15d3ea9349efcdb7ed89a1c06321d00389ce' => 
    array (
      0 => 'finance\\finance-pending-payment.tpl',
      1 => 1536155063,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '299805b90c9317b7134-85793714',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'groups' => 0,
    'data' => 0,
    'pending_payment' => 0,
    'i' => 0,
    'payment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5b90c931d672b3_73512287',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b90c931d672b3_73512287')) {function content_5b90c931d672b3_73512287($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp64\\www\\kobsterEshop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><div class="panel" id="">
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
                            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_group'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
</option>
                            <?php } ?>
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
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pending_payment']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value) {
$_smarty_tpl->tpl_vars['payment']->_loop = true;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['id_order'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['invoice_number'];?>
</td>                    
                    <td class="table-date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['payment']->value['date_add']);?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['payment']->value['total_paid'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['credit_days'];?>
 </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['aging'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['order_status'];?>
</td>
                    <td>
                        <?php if (mb_strtolower($_smarty_tpl->tpl_vars['payment']->value['order_status'], 'UTF-8')==mb_strtolower('Payment Pending', 'UTF-8')) {?>
                        <span class="fa fa-check-square-o btn btn-black" onclick="paymentReceived(<?php echo $_smarty_tpl->tpl_vars['payment']->value['id_order'];?>
,this);" id="<?php echo $_smarty_tpl->tpl_vars['payment']->value['id_order'];?>
">Payment Received</span>
                        <?php }?>
                    </td>
                </tr>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
            <?php } ?>
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

            var columnas = [5]; //the columns you wish to add            
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
 </script><?php }} ?>

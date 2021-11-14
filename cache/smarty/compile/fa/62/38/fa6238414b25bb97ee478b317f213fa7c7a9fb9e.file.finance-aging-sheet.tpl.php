<?php /* Smarty version Smarty-3.1.19, created on 2017-11-13 11:24:25
         compiled from "finance\finance-aging-sheet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:124255a093391155034-89447971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa6238414b25bb97ee478b317f213fa7c7a9fb9e' => 
    array (
      0 => 'finance\\finance-aging-sheet.tpl',
      1 => 1478086142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124255a093391155034-89447971',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agingData' => 0,
    'i' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a09339125e9b3_50613431',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a09339125e9b3_50613431')) {function content_5a09339125e9b3_50613431($_smarty_tpl) {?><!--<header class="rm_heading">Procurement Plan</header>
<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
		  <button class="btn btn-primary buttonColor dropdown-toggle padding20" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
		 </div>
	</div>
</div>
</div>-->
<div class="panel" id="">
    <div class="panel-body">
    <div class="text-center panel-heading"><b>Ageing Sheet<b></div>
    <section class="panel">
        <table class="table table-striped table-hover table-bordered" id="finance_aging_sheet">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Company</th>
					<th>0-30 Days</th>
                    <th>30-60 Days</th>
                    <th>60-90 Days</th>                    
                    <th>90+ Days</th>                    
                    <th>Total</th>
             	</tr>
            </thead>
            <tbody id="finance_procurement_plan">
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['agingData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['data']->value['0-30'];?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['data']->value['30-60'];?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['data']->value['60-90'];?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['data']->value['90+'];?>
</td>
                    <td class="amount"><?php echo $_smarty_tpl->tpl_vars['data']->value['Total'];?>
</td>
                </tr>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
            <?php } ?>
            </tbody>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th class="amount"></th>
                <th class="amount"></th>
                <th class="amount"></th>
                <th class="amount"></th>
                <th class="amount"></th>
             </tr>
			  
        </tfoot>
        </table>
     </section>
                  
   </div>
</div>
<script type="text/javascript">
    easySearch('finance_aging_sheet');
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
        "iDisplayLength": 100,
        
        
        "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page ",
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

        var columnas = [2,3,4,5,6]; //the columns you wish to add            
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
$("<a id='ageingsheet_download' class='btn btn-primary' href='finance-aging.php' target='_blank'>Download</a>").insertBefore("#finance_aging_sheet_filter label");
</script>
<?php }} ?>

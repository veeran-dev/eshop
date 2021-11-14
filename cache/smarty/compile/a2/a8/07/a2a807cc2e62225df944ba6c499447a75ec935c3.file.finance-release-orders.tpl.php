<?php /* Smarty version Smarty-3.1.19, created on 2018-09-21 19:21:54
         compiled from "finance\finance-release-orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40135ba4f77ab5a9a6-41508621%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a2a807cc2e62225df944ba6c499447a75ec935c3' => 
    array (
      0 => 'finance\\finance-release-orders.tpl',
      1 => 1537004253,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40135ba4f77ab5a9a6-41508621',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'groups' => 0,
    'data' => 0,
    'orders' => 0,
    'i' => 0,
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ba4f77ac31772_56641228',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba4f77ac31772_56641228')) {function content_5ba4f77ac31772_56641228($_smarty_tpl) {?><div class="row">
    <div class="panel-body">
        <div class="text-center panel-heading">
            <b>Release Orders</b>
        </div>
        <div class="panel">
        <form id="form_release_order" name="form_release_order" autocomplete="off" method="post">
        	<div class="col-md-12">
        		<div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
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
                        <select id="group_selection_ro" name="group_selection_ro" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getOrderDetails()" required>
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
        	</div>
        	<table class="table table-striped table-hover table-bordered " id="finance_release_order_list">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Order Id</th>					                    
                    <th>User</th>					                    
                    <th>Status</th>
                    <th>Action</th>
             	</tr>
            </thead>
            <tbody id="finance_release_order_tbody">
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value) {
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
            <tr>
            	<td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
            	<td><?php echo $_smarty_tpl->tpl_vars['order']->value['id_order'];?>
</td>
            	<td><?php echo $_smarty_tpl->tpl_vars['order']->value['email'];?>
</td>
            	<td><?php echo $_smarty_tpl->tpl_vars['order']->value['name'];?>
</td>
            	<td>
            		<input type="checkbox" name="ro_checkbox[]" class="ro_checkbox" value=<?php echo $_smarty_tpl->tpl_vars['order']->value['id_order'];?>
 id="ro_<?php echo $_smarty_tpl->tpl_vars['order']->value['id_order'];?>
" />
        		</td>
        	</tr>
        	<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
            <?php } ?>
            </tbody>
        </table>	
        </form>
        <div class="col-md-12 text-right">
        	<button id="releaseOrdersBtn" class="btn btn-success float-md-righ" onclick="submitReleaseOrders()">Release Orders</button>
        </div>
    	</div>
	</div>
</div>

<script type="text/javascript">

$('#group_selection_ro').select2();
if(window.group_name_selected)
{
    $("#select2-group_selection_ro-container").html(window.group_name_selected);
    $("#group_selection_ro").val(window.group_id_Selected);
}
easySearch('finance_release_order_list');



function getOrderDetails(){
	$('#finance_release_order_tbody').html("");
	$(".ajaxLoaderModal").show();
	var id_group = $('#group_selection_ro').val();
	
	$('#index_viewport').load('finance-release-orders.php?type=1&id_group='+id_group+'');

	// $.ajax({
	// 	type: 'GET',
	// 	dataType:'json',
	// 	async: true,
	// 	url: 'finance-release-order-data.php',
	// 	data: 'type=1&id_group='+id_group,
	// 	cache: true,
	// 	success: function(data)
	// 	{
	// 		console.log(data);
	// 		// for(var i=0; i < data.length; i++){
	// 		// 	$('#finance_release_order_tbody').append('<tr><td>'+(i+1)+'</td><td>'+data[i]["id_order"]+'</td><td>'+data[i]["email"]+'</td><td>'+data[i]["name"]+'</td><td><input type="checkbox" name="ro_checkbox[]" class="ro_checkbox" value='+data[i]["id_order"]+' id="ro_'+data[i]["id_order"]+'" /></td></tr>');
	// 		// }
	// 	}
	// });
	$(".ajaxLoaderModal").hide();
}

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
    	});
                 
}

function submitReleaseOrders(){
	var numberOfChecked = $('.ro_checkbox:checkbox:checked').length;
	console.log(numberOfChecked);
	if(numberOfChecked < 1){
		toast("Please select atleast one order","warning");	
		return false;	
	}
	else
	$(".ajaxLoaderModal").show();
	var id_group = $('#group_selection_ro').val();
	var group_name=$("#group_selection_ro option:selected").text();
	if(group_name){
		window.group_name_selected=group_name;
		window.group_id_Selected=id_group;
	}
	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'finance-release-order-data.php',
		data: 'type=2&'+$('#form_release_order').serialize(),
		cache: true,
		success: function(data)
		{
			console.log(data);
			getOrderDetails();
			toast("Orders released successfuly");
		}
	});
	$(".ajaxLoaderModal").hide();
}
</script><?php }} ?>

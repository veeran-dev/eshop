<?php /* Smarty version Smarty-3.1.19, created on 2018-10-30 18:44:21
         compiled from "rm\rm-waterDelivery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:244785bd8592dcacaf2-70956138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce84a39b93b270653fc4a9c4b41b4e7189a856f1' => 
    array (
      0 => 'rm\\rm-waterDelivery.tpl',
      1 => 1540904181,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '244785bd8592dcacaf2-70956138',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fcs' => 0,
    'data' => 0,
    'groups' => 0,
    'waterDeliveries' => 0,
    'i' => 0,
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5bd8592dda9089_64541726',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5bd8592dda9089_64541726')) {function content_5bd8592dda9089_64541726($_smarty_tpl) {?><div class="row">
    <div class="panel-body">
        <div class="text-center panel-heading">
            <b>Water Deliveries</b>
        </div>
        <div class="panel">
        <form id="form_release_order" name="form_release_order" autocomplete="off" method="post">
          <div class="col-md-12">
              <div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">Select FC</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                    <select id="group_selection_wd_fc" name="group_selection_wd_fc" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getOrderDetails()" required>
                        <option value="0">Select FC</option>
                        <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fcs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_fulfillment_centre'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['city_name'];?>
</option>
                        <?php } ?>
                    </select>
              </div>
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
                <select id="group_selection_wd" name="group_selection_wd" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getOrderDetails()" required>
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
            <div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
              <input type="text" readonly="" id="w_month" placeholder="Click & Select Month" data-date-minviewmode="months" data-date-viewmode="months" data-date-format="mm/yyyy" data-date="102/2012" value="" size="16" class="form-control month">
            </div>
            <div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
              <button class="btn" onclick="getWaterReport();" type="button">Download</button>
            </div>

          </div>
          <table class="table table-striped table-hover table-bordered " id="finance_release_order_list">
            <thead>
                <tr>
                  <th>S.No</th>
                  <th>Company</th>
                  <th>Alias</th>                             
                  <th>Address</th>                             
                  <th>Product</th>
                  <th>Delivered Can</th>
                  <th>Empty Can</th>
                  <th>Date</th>
                  <th>Download</th>
                </tr>
            </thead>
            <tbody id="water_delivery_tbody">
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['waterDeliveries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value) {
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
            <tr>
              <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['company'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['alias'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['address_format'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['product_name'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['delivered'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['empty'];?>
</td>
              <td><?php echo $_smarty_tpl->tpl_vars['order']->value['date_add'];?>
</td>
              <td>
                <a href=<?php echo $_smarty_tpl->tpl_vars['order']->value['link'];?>
>Download</a>
            </td>
          </tr>
          <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
            <?php } ?>
            </tbody>
        </table>  
        </form>
      </div>
      <div class="display-none">
        <form id="water_delivery_excel"  action="rm-waterDeliveryReport.php"  method="post" class="display-none">
          <div id="water-delivery-data">
          </div>
        </form>
      </div>
  </div>
</div>

<script type="text/javascript">

$('#group_selection_wd').select2();
if(window.group_name)
{
    $("#select2-group_selection_wd-container").html(window.group_name);
    $("#group_selection_wd").val(window.id_group);
}
if(window.fc_name)
{
    $("#select2-group_selection_wd_fc-container").html(window.fc_name);
    $("#group_selection_wd_fc").val(window.id_fc);
}
if(window.period)
{
    $(".month").val(window.period);
}

easySearch('finance_release_order_list');

$(document).ready(function()
{
  $('.month').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'mm-yy',
  });
  // $('#downloadReport').on('click',function(selected){
  //     var id_group = $('#group_selection_wd').val();
  //     var id_fc = $('#group_selection_wd_fc').val();
  //     var period = $('.month').val();
  //     console.log("clicke");

  //     // $('#water-delivery-data').html("");
  //     // ('#water-delivery-data').html('<input id="id_fc" type="text" name="id_fc" value=' + id_fc + '><input id="id_group" type="text" name="id_group" value='+id_group+'><input id="period" type="text" name="period" value='+period+'>');
  //     // $('#water_delivery_excel').submit();
  // });

  $('.month').on('change', function (selected) {
    console.log(selected);
    console.log($('.month').val());
    $('#water_delivery_tbody').html("");
    $(".ajaxLoaderModal").show();
    var id_group = $('#group_selection_wd').val();
    var id_fc = $('#group_selection_wd_fc').val();
    var period = $('.month').val();

    var group_name=$("#group_selection_wd option:selected").text();
    var fc_name=$("#group_selection_wd_fc option:selected").text();

    window.id_group = id_group;
    window.id_fc=id_fc;
    window.period = period;
    window.group_name = group_name;
    window.fc_name = fc_name;

    $('#index_viewport').load('rm-waterDelivery.php?id_group='+id_group+'&id_fc='+id_fc+'&period='+period+'');  
    $(".ajaxLoaderModal").hide();
  });
});

function getWaterReport(){
    var id_group = $('#group_selection_wd').val();
    var id_fc = $('#group_selection_wd_fc').val();
    var period = $('.month').val();
    console.log("clicke");

    $('#water-delivery-data').empty();
    $('#water-delivery-data').html('<input id="id_fc" type="text" name="id_fc" value=' + id_fc + '><input id="id_group" type="text" name="id_group" value='+id_group+'><input id="period" type="text" name="period" value='+period+'>');
    $('#water_delivery_excel').submit();
}
function getOrderDetails(){
  $('#water_delivery_tbody').html("");
  $(".ajaxLoaderModal").show();
  
  var id_group = $('#group_selection_wd').val();  
  var id_fc = $('#group_selection_wd_fc').val();
  var period = $('.month').val();

  var group_name=$("#group_selection_wd option:selected").text();
  var fc_name=$("#group_selection_wd_fc option:selected").text();

  window.id_group = id_group;
  window.id_fc=id_fc;
  window.period = period;
  window.group_name = group_name;
  window.fc_name = fc_name;

  $('#index_viewport').load('rm-waterDelivery.php?id_group='+id_group+'&id_fc='+id_fc+'&period='+period+'');  
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
</script><?php }} ?>

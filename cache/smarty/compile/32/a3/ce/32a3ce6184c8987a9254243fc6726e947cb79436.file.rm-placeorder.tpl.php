<?php /* Smarty version Smarty-3.1.19, created on 2018-03-02 18:47:20
         compiled from "rm\rm-placeorder.tpl" */ ?>
<?php /*%%SmartyHeaderCode:307815a994ee0aef166-84887744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32a3ce6184c8987a9254243fc6726e947cb79436' => 
    array (
      0 => 'rm\\rm-placeorder.tpl',
      1 => 1516789382,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '307815a994ee0aef166-84887744',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a994ee0c43da4_04007837',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a994ee0c43da4_04007837')) {function content_5a994ee0c43da4_04007837($_smarty_tpl) {?><header class="rm_heading">PLACE ORDERS FOR USER</header>
<script type="text/javascript">
    $(document).ready( function() { getGroups(1); });
    $('#group_selection, #customer_selection').select2();
</script>
<div class="row">
	<section class="panel-body">
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
			<div class="">
				<!-- SELECT CUSTOMER GROUP -->
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
                    <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(0)" required>
                    	<option value="0">Select Company</option>
                    </select>
                </div>
                <!-- SELECT CUSTOMER WITH EMAIL ID -->
				<div class="form-group col-md-6 col-sm-6 col-xs-6 col-lg-6">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                    	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                    		<span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                    		<abbr class="select2-search-choice-close"></abbr>
                    		<span class="select2-arrow" role="presentation">
                    			<b role="presentation"></b>
                    		</span>
                    	</a>
                    	<label for="s2id_autogen3" class="select2-offscreen"></label>
                    	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                    <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(1);" required>
                    	<option value="0">Select User</option>
                    </select>	 
                </div>
                <!-- Set region to place order -->
                <div class="form-group display-none col-md-3 col-sm-3 col-xs-3 col-lg-3" id="region-selection">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">Select Region</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                    <select id="region_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="region_selection" onchange="setRegion(1);" required>
                        <option value="0">Select Region</option>
                    </select>   
                </div>
			</div>
		</div>	
	</section>
</div>
<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>dash/js/dash-quickbuy.js"></script><?php }} ?>

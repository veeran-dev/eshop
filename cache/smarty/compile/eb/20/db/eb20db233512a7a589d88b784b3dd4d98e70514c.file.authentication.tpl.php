<?php /* Smarty version Smarty-3.1.19, created on 2018-03-31 16:04:10
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\authentication.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149485abf64224b5a10-24111260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb20db233512a7a589d88b784b3dd4d98e70514c' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\authentication.tpl',
      1 => 1502269009,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149485abf64224b5a10-24111260',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'email_create' => 0,
    'link' => 0,
    'navigationPipe' => 0,
    'back' => 0,
    'authentification_error' => 0,
    'account_error' => 0,
    'v' => 0,
    'img_dir' => 0,
    'inOrderProcess' => 0,
    'PS_GUEST_CHECKOUT_ENABLED' => 0,
    'genders' => 0,
    'gender' => 0,
    'days' => 0,
    'day' => 0,
    'sl_day' => 0,
    'months' => 0,
    'k' => 0,
    'sl_month' => 0,
    'month' => 0,
    'years' => 0,
    'year' => 0,
    'sl_year' => 0,
    'newsletter' => 0,
    'optin' => 0,
    'dlv_all_fields' => 0,
    'field_name' => 0,
    'required_fields' => 0,
    'countries' => 0,
    'sl_country' => 0,
    'stateExist' => 0,
    'postCodeExist' => 0,
    'dniExist' => 0,
    'one_phone_at_least' => 0,
    'inv_all_fields' => 0,
    'HOOK_CREATE_ACCOUNT_FORM' => 0,
    'states' => 0,
    's' => 0,
    'address' => 0,
    'vatnumber_ajax_call' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5abf6424654cd6_75078613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5abf6424654cd6_75078613')) {function content_5abf6424654cd6_75078613($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?>
	<?php if (!isset($_smarty_tpl->tpl_vars['email_create']->value)) {?><?php echo smartyTranslate(array('s'=>'Authentication'),$_smarty_tpl);?>
<?php } else { ?>
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Authentication'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Authentication'),$_smarty_tpl);?>
</a>
		<span class="navigation-pipe"><?php echo $_smarty_tpl->tpl_vars['navigationPipe']->value;?>
</span><?php echo smartyTranslate(array('s'=>'Create your account'),$_smarty_tpl);?>

	<?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<!--<h1 class="page-heading"><?php if (!isset($_smarty_tpl->tpl_vars['email_create']->value)) {?><?php echo smartyTranslate(array('s'=>'Authentication'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Create an account'),$_smarty_tpl);?>
<?php }?></h1>-->
<?php if (isset($_smarty_tpl->tpl_vars['back']->value)&&preg_match("/^http/",$_smarty_tpl->tpl_vars['back']->value)) {?><?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('login', null, 0);?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(false, null, 0);?>
<?php $_smarty_tpl->tpl_vars["postCodeExist"] = new Smarty_variable(false, null, 0);?>
<?php $_smarty_tpl->tpl_vars["dniExist"] = new Smarty_variable(false, null, 0);?>
<?php if (!isset($_smarty_tpl->tpl_vars['email_create']->value)) {?>
	<!--<?php if (isset($_smarty_tpl->tpl_vars['authentification_error']->value)) {?>
	<div class="alert alert-danger">
		<?php ob_start();?><?php echo count($_smarty_tpl->tpl_vars['authentification_error']->value);?>
<?php $_tmp7=ob_get_clean();?><?php if ($_tmp7==1) {?>
			<p><?php echo smartyTranslate(array('s'=>'There\'s at least one error'),$_smarty_tpl);?>
 :</p>
			<?php } else { ?>
			<p><?php echo smartyTranslate(array('s'=>'There are %s errors','sprintf'=>array(count($_smarty_tpl->tpl_vars['account_error']->value))),$_smarty_tpl);?>
 :</p>
		<?php }?>
		<ol>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['authentification_error']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<li><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</li>
			<?php } ?>
		</ol>
	</div>
	<?php }?>-->
	<div class="row">	 
        <div class="login-section">
            <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post" id="login_form" >
                <h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Already have an account?'),$_smarty_tpl);?>
</h3>
                <div class="subheading-hints"><?php echo smartyTranslate(array('s'=>'If you are already registered, Log in'),$_smarty_tpl);?>
 <span class="mobile-only-link">or <a class="mobile-register-link" href="#mobile-register-link">Register here</a></span></div>
                <div class="form_content clearfix">
                    <div class="form-group">
                        <label for="email"><?php echo smartyTranslate(array('s'=>'Email address'),$_smarty_tpl);?>
</label>
                        <input class="is_required validate account_input form-control" data-validate="isEmail" type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) {?><?php echo stripslashes($_POST['email']);?>
<?php }?>" />
                    </div>
                    <div class="form-group">
                        <label for="passwd"><?php echo smartyTranslate(array('s'=>'Password'),$_smarty_tpl);?>
</label>
                        <span id="mobile-register-link"></span>
                        <input class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="" />
                    </div>
                    <p class="lost_password form-group"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('password'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Recover your forgotten password'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Forgot password?'),$_smarty_tpl);?>
</a></p>
                    <p class="submit">
                        <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
                        <button type="submit" id="SubmitLogin" name="SubmitLogin" class="button-black">
                                <?php echo smartyTranslate(array('s'=>'Login'),$_smarty_tpl);?>

                        </button>
                    </p>
                    
                </div>
            </form>
        </div>
        <div class="register-section">
            <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post" id="create-account_form">
                <h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'New user?'),$_smarty_tpl);?>
</h3>
                <div class="form_content clearfix">
                 	
                    <div class="b2b-alert-container">
                    	<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
high-importance-16.png" class="importantance-icon" /> 
                        <ul class="b2b-text b2b-text-registration"> 
                         	<li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
                        </ul>
                    </div>
                 
                    <div class="alert alert-danger" id="create_account_error" style="display:none"></div>
                    <div class="form-group">
                        <label class="font-gray" for="email_create"><?php echo smartyTranslate(array('s'=>'Email'),$_smarty_tpl);?>
</label>
                        <input type="email" class="is_required validate account_input form-control" data-validate="isEmail" id="email_create" name="email_create" value="<?php if (isset($_POST['email_create'])) {?><?php echo stripslashes($_POST['email_create']);?>
<?php }?>" onkeyup="$('#create_account_error').html('').hide();" />
                    </div>
                    <div class="submit">
                        <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
                        <button class="button-black" type="submit" id="SubmitCreate" name="SubmitCreate">
                                <?php echo smartyTranslate(array('s'=>'Create an account'),$_smarty_tpl);?>

                        </button>
                        <input type="hidden" class="hidden" name="SubmitCreate" value="<?php echo smartyTranslate(array('s'=>'Create an account'),$_smarty_tpl);?>
" />
                    </div>
                    
                    
                    
                </div>
            </form>
        </div>
	</div>
	<?php if (isset($_smarty_tpl->tpl_vars['inOrderProcess']->value)&&$_smarty_tpl->tpl_vars['inOrderProcess']->value&&$_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value) {?>
		<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true,null,"back=".((string)$_smarty_tpl->tpl_vars['back']->value)), ENT_QUOTES, 'UTF-8', true);?>
" method="post" id="new_account_form" class="std clearfix">
			<div class="box">
				<div id="opc_account_form" style="display: block; ">
					<h3 class="page-heading bottom-indent"><?php echo smartyTranslate(array('s'=>'Instant checkout'),$_smarty_tpl);?>
</h3>
					<p class="required"><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</p>
					<!-- Account -->
					<div class="required form-group">
						<label for="guest_email"><?php echo smartyTranslate(array('s'=>'Email address'),$_smarty_tpl);?>
 <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isEmail" id="guest_email" name="guest_email" value="<?php if (isset($_POST['guest_email'])) {?><?php echo $_POST['guest_email'];?>
<?php }?>" />
					</div>
					<div class="cleafix gender-line">
						<label><?php echo smartyTranslate(array('s'=>'Title'),$_smarty_tpl);?>
</label>
						<?php  $_smarty_tpl->tpl_vars['gender'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['gender']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['genders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['gender']->key => $_smarty_tpl->tpl_vars['gender']->value) {
$_smarty_tpl->tpl_vars['gender']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['gender']->key;
?>
							<div class="radio-inline">
								<label for="id_gender<?php echo $_smarty_tpl->tpl_vars['gender']->value->id;?>
" class="top">
									<input type="radio" name="id_gender" id="id_gender<?php echo $_smarty_tpl->tpl_vars['gender']->value->id;?>
" value="<?php echo $_smarty_tpl->tpl_vars['gender']->value->id;?>
"<?php if (isset($_POST['id_gender'])&&$_POST['id_gender']==$_smarty_tpl->tpl_vars['gender']->value->id) {?> checked="checked"<?php }?> />
									<?php echo $_smarty_tpl->tpl_vars['gender']->value->name;?>

								</label>
							</div>
						<?php } ?>
					</div>
					<div class="required form-group">
						<label for="firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
 <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="<?php if (isset($_POST['firstname'])) {?><?php echo $_POST['firstname'];?>
<?php }?>" />
					</div>
					<div class="required form-group">
						<label for="lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
 <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isName" id="lastname" name="lastname" value="<?php if (isset($_POST['lastname'])) {?><?php echo $_POST['lastname'];?>
<?php }?>" />
					</div>
					<div class="form-group date-select">
						<label><?php echo smartyTranslate(array('s'=>'Date of Birth'),$_smarty_tpl);?>
</label>
						<div class="row">
							<div class="col-xs-4">
								<select id="days" name="days" class="form-control">
									<option value="">-</option>
									<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['day']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['days']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value) {
$_smarty_tpl->tpl_vars['day']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['day']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_day']->value==$_smarty_tpl->tpl_vars['day']->value)) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['day']->value;?>
&nbsp;&nbsp;</option>
									<?php } ?>
								</select>
								
							</div>
							<div class="col-xs-4">
								<select id="months" name="months" class="form-control">
									<option value="">-</option>
									<?php  $_smarty_tpl->tpl_vars['month'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['month']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['months']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value) {
$_smarty_tpl->tpl_vars['month']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['month']->key;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_month']->value==$_smarty_tpl->tpl_vars['k']->value)) {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>$_smarty_tpl->tpl_vars['month']->value),$_smarty_tpl);?>
&nbsp;</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xs-4">
								<select id="years" name="years" class="form-control">
									<option value="">-</option>
									<?php  $_smarty_tpl->tpl_vars['year'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['year']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['years']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['year']->key => $_smarty_tpl->tpl_vars['year']->value) {
$_smarty_tpl->tpl_vars['year']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['year']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_year']->value==$_smarty_tpl->tpl_vars['year']->value)) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
&nbsp;&nbsp;</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<?php if (isset($_smarty_tpl->tpl_vars['newsletter']->value)&&$_smarty_tpl->tpl_vars['newsletter']->value) {?>
						<div class="checkbox">
							<label for="newsletter">
							<input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if (isset($_POST['newsletter'])&&$_POST['newsletter']=='1') {?>checked="checked"<?php }?> />
							<?php echo smartyTranslate(array('s'=>'Sign up for our newsletter!'),$_smarty_tpl);?>
</label>
						</div>
					<?php }?>
					<?php if (isset($_smarty_tpl->tpl_vars['optin']->value)&&$_smarty_tpl->tpl_vars['optin']->value) {?>
						<div class="checkbox">
							<label for="optin">
							<input type="checkbox" name="optin" id="optin" value="1" <?php if (isset($_POST['optin'])&&$_POST['optin']=='1') {?>checked="checked"<?php }?> />
							<?php echo smartyTranslate(array('s'=>'Receive special offers from our partners!'),$_smarty_tpl);?>
</label>
						</div>
					<?php }?>
					<h3 class="page-heading bottom-indent top-indent"><?php echo smartyTranslate(array('s'=>'Delivery address'),$_smarty_tpl);?>
</h3>
					<?php  $_smarty_tpl->tpl_vars['field_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_name']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dlv_all_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_name']->key => $_smarty_tpl->tpl_vars['field_name']->value) {
$_smarty_tpl->tpl_vars['field_name']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['field_name']->value=="company") {?>
							<div class="form-group">
								<label for="company"><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
								<input type="text" class="form-control" id="company" name="company" value="<?php if (isset($_POST['company'])) {?><?php echo $_POST['company'];?>
<?php }?>" />
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="vat_number") {?>
							<div id="vat_number" style="display:none;">
								<div class="form-group">
									<label for="vat-number"><?php echo smartyTranslate(array('s'=>'GST number'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
									<input id="vat-number" type="text" class="form-control" name="vat_number" value="<?php if (isset($_POST['vat_number'])) {?><?php echo $_POST['vat_number'];?>
<?php }?>" />
								</div>
							</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="dni") {?>
							<?php $_smarty_tpl->tpl_vars['dniExist'] = new Smarty_variable(true, null, 0);?>
							<div class="required dni form-group">
								<label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<input type="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])) {?><?php echo $_POST['dni'];?>
<?php }?>" />
								<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="address1") {?>
							<div class="required form-group">
								<label for="address1"><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<input type="text" class="form-control" name="address1" id="address1" value="<?php if (isset($_POST['address1'])) {?><?php echo $_POST['address1'];?>
<?php }?>" />
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="address2") {?>
							<div class="form-group is_customer_param">
								<label for="address2"><?php echo smartyTranslate(array('s'=>'Address (Line 2)'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
								<input type="text" class="form-control" name="address2" id="address2" value="<?php if (isset($_POST['address2'])) {?><?php echo $_POST['address2'];?>
<?php }?>" />
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="postcode") {?>
							<?php $_smarty_tpl->tpl_vars['postCodeExist'] = new Smarty_variable(true, null, 0);?>
							<div class="required postcode form-group">
								<label for="postcode"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<input type="text" class="validate form-control" name="postcode" id="postcode" data-validate="isPostCode" value="<?php if (isset($_POST['postcode'])) {?><?php echo $_POST['postcode'];?>
<?php }?>" maxlength="6"/>
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="city") {?>
							<div class="required form-group">
								<label for="city"><?php echo smartyTranslate(array('s'=>'City'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<input type="text" class="form-control" name="city" id="city" value="<?php if (isset($_POST['city'])) {?><?php echo $_POST['city'];?>
<?php }?>" />
							</div>
							<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="Country:name"||$_smarty_tpl->tpl_vars['field_name']->value=="country") {?>
							<div class="required select form-group">
								<label for="id_country"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<select name="id_country" id="id_country" class="form-control">
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_country'];?>
"<?php if ((isset($_POST['id_country'])&&$_POST['id_country']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_POST['id_country'])&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
									<?php } ?>
								</select>
							</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="State:name") {?>
							<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(true, null, 0);?>
							<div class="required id_state select form-group">
								<label for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<select name="id_state" id="id_state" class="form-control">
									<option value="">-</option>
								</select>
							</div>
						<?php }?>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['stateExist']->value==false) {?>
						<div class="required id_state select unvisible form-group">
							<label for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<select name="id_state" id="id_state" class="form-control">
								<option value="">-</option>
							</select>
						</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['postCodeExist']->value==false) {?>
						<div class="required postcode unvisible form-group">
							<label for="postcode"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="validate form-control" name="postcode" id="postcode" data-validate="isPostCode" value="<?php if (isset($_POST['postcode'])) {?><?php echo $_POST['postcode'];?>
<?php }?>" maxlength="6"/>
						</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['dniExist']->value==false) {?>
						<div class="required form-group dni">
							<label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="text form-control" name="dni" id="dni" value="<?php if (isset($_POST['dni'])&&$_POST['dni']) {?><?php echo $_POST['dni'];?>
<?php }?>" />
							<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
						</div>
					<?php }?>
					<div class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>required <?php }?>form-group">
						<label for="phone_mobile"><?php echo smartyTranslate(array('s'=>'Mobile phone'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?> <sup>*</sup><?php }?></label>
						<input type="text" class="form-control" name="phone_mobile" id="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php }?>" />
					</div>
					<input type="hidden" name="alias" id="alias" value="<?php echo smartyTranslate(array('s'=>'My address'),$_smarty_tpl);?>
" />
					<input type="hidden" name="is_new_customer" id="is_new_customer" value="0" />
					<div class="checkbox">
						<label for="invoice_address">
						<input type="checkbox" name="invoice_address" id="invoice_address"<?php if ((isset($_POST['invoice_address'])&&$_POST['invoice_address'])||(isset($_POST['invoice_address'])&&$_POST['invoice_address'])) {?> checked="checked"<?php }?> autocomplete="off"/>
						<?php echo smartyTranslate(array('s'=>'Please use another address for invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div id="opc_invoice_address"  class="unvisible">
						<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(false, null, 0);?>
						<?php $_smarty_tpl->tpl_vars['postCodeExist'] = new Smarty_variable(false, null, 0);?>
						<?php $_smarty_tpl->tpl_vars['dniExist'] = new Smarty_variable(false, null, 0);?>
						<h3 class="page-subheading top-indent"><?php echo smartyTranslate(array('s'=>'Invoice address'),$_smarty_tpl);?>
</h3>
						<?php  $_smarty_tpl->tpl_vars['field_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_name']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['inv_all_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_name']->key => $_smarty_tpl->tpl_vars['field_name']->value) {
$_smarty_tpl->tpl_vars['field_name']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['field_name']->value=="company") {?>
						<div class="form-group">
							<label for="company_invoice"><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
							<input type="text" class="text form-control" id="company_invoice" name="company_invoice" value="<?php if (isset($_POST['company_invoice'])&&$_POST['company_invoice']) {?><?php echo $_POST['company_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="vat_number") {?>
						<div id="vat_number_block_invoice" style="display:none;">
							<div class="form-group">
								<label for="vat_number_invoice"><?php echo smartyTranslate(array('s'=>'GST number'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
								<input type="text" class="form-control" id="vat_number_invoice" name="vat_number_invoice" value="<?php if (isset($_POST['vat_number_invoice'])&&$_POST['vat_number_invoice']) {?><?php echo $_POST['vat_number_invoice'];?>
<?php }?>" />
							</div>
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="dni") {?>
						<?php $_smarty_tpl->tpl_vars['dniExist'] = new Smarty_variable(true, null, 0);?>
						<div class="required form-group dni_invoice">
							<label for="dni_invoice"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="<?php if (isset($_POST['dni_invoice'])&&$_POST['dni_invoice']) {?><?php echo $_POST['dni_invoice'];?>
<?php }?>" />
							<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="firstname") {?>
						<div class="required form-group">
							<label for="firstname_invoice"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="form-control" id="firstname_invoice" name="firstname_invoice" value="<?php if (isset($_POST['firstname_invoice'])&&$_POST['firstname_invoice']) {?><?php echo $_POST['firstname_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="lastname") {?>
						<div class="required form-group">
							<label for="lastname_invoice"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="form-control" id="lastname_invoice" name="lastname_invoice" value="<?php if (isset($_POST['lastname_invoice'])&&$_POST['lastname_invoice']) {?><?php echo $_POST['lastname_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="address1") {?>
						<div class="required form-group">
							<label for="address1_invoice"><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="form-control" name="address1_invoice" id="address1_invoice" value="<?php if (isset($_POST['address1_invoice'])&&$_POST['address1_invoice']) {?><?php echo $_POST['address1_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="address2") {?>
						<div class="form-group is_customer_param">
							<label for="address2_invoice"><?php echo smartyTranslate(array('s'=>'Address (Line 2)'),$_smarty_tpl);?>
<?php if (in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
							<input type="text" class="form-control" name="address2_invoice" id="address2_invoice" value="<?php if (isset($_POST['address2_invoice'])&&$_POST['address2_invoice']) {?><?php echo $_POST['address2_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="postcode") {?>
						<?php $_smarty_tpl->tpl_vars['postCodeExist'] = new Smarty_variable(true, null, 0);?>
						<div class="required postcode_invoice form-group">
							<label for="postcode_invoice"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="validate form-control" name="postcode_invoice" id="postcode_invoice" data-validate="isPostCode" value="<?php if (isset($_POST['postcode_invoice'])&&$_POST['postcode_invoice']) {?><?php echo $_POST['postcode_invoice'];?>
<?php }?>"/>
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="city") {?>
						<div class="required form-group">
							<label for="city_invoice"><?php echo smartyTranslate(array('s'=>'City'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="form-control" name="city_invoice" id="city_invoice" value="<?php if (isset($_POST['city_invoice'])&&$_POST['city_invoice']) {?><?php echo $_POST['city_invoice'];?>
<?php }?>" />
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="country"||$_smarty_tpl->tpl_vars['field_name']->value=="Country:name") {?>
						<div class="required form-group">
							<label for="id_country_invoice"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<select name="id_country_invoice" id="id_country_invoice" class="form-control">
								<option value="">-</option>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_country'];?>
"<?php if ((isset($_POST['id_country_invoice'])&&$_POST['id_country_invoice']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_POST['id_country_invoice'])&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php } ?>
							</select>
						</div>
						<?php } elseif ($_smarty_tpl->tpl_vars['field_name']->value=="state"||$_smarty_tpl->tpl_vars['field_name']->value=='State:name') {?>
						<?php $_smarty_tpl->tpl_vars['stateExist'] = new Smarty_variable(true, null, 0);?>
						<div class="required id_state_invoice form-group" style="display:none;">
							<label for="id_state_invoice"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<select name="id_state_invoice" id="id_state_invoice" class="form-control">
								<option value="">-</option>
							</select>
						</div>
						<?php }?>
						<?php } ?>
						<?php if (!$_smarty_tpl->tpl_vars['postCodeExist']->value) {?>
						<div class="required postcode_invoice form-group unvisible">
							<label for="postcode_invoice"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<input type="text" class="form-control" name="postcode_invoice" id="postcode_invoice" value="<?php if (isset($_POST['postcode_invoice'])&&$_POST['postcode_invoice']) {?><?php echo $_POST['postcode_invoice'];?>
<?php }?>"/>
						</div>
						<?php }?>
						<?php if (!$_smarty_tpl->tpl_vars['stateExist']->value) {?>
						<div class="required id_state_invoice form-group unvisible">
							<label for="id_state_invoice"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
							<select name="id_state_invoice" id="id_state_invoice" class="form-control">
								<option value="">-</option>
							</select>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['dniExist']->value==false) {?>
							<div class="required form-group dni_invoice">
								<label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
								<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="<?php if (isset($_POST['dni_invoice'])&&$_POST['dni_invoice']) {?><?php echo $_POST['dni_invoice'];?>
<?php }?>" />
								<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
							</div>
						<?php }?>
						<div class="form-group is_customer_param">
							<label for="other_invoice"><?php echo smartyTranslate(array('s'=>'Additional information'),$_smarty_tpl);?>
</label>
							<textarea class="form-control" name="other_invoice" id="other_invoice" cols="26" rows="3"></textarea>
						</div>
						<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>
							<p class="inline-infos required is_customer_param"><?php echo smartyTranslate(array('s'=>'You must register at least one phone number.'),$_smarty_tpl);?>
</p>
						<?php }?>
						<div class="form-group is_customer_param">
							<label for="phone_invoice"><?php echo smartyTranslate(array('s'=>'Home phone'),$_smarty_tpl);?>
</label>
							<input type="text" class="form-control" name="phone_invoice" id="phone_invoice" value="<?php if (isset($_POST['phone_invoice'])&&$_POST['phone_invoice']) {?><?php echo $_POST['phone_invoice'];?>
<?php }?>" />
						</div>
						<div class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>required <?php }?>form-group">
							<label for="phone_mobile_invoice"><?php echo smartyTranslate(array('s'=>'Mobile phone'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?> <sup>*</sup><?php }?></label>
							<input type="text" class="form-control" name="phone_mobile_invoice" id="phone_mobile_invoice" value="<?php if (isset($_POST['phone_mobile_invoice'])&&$_POST['phone_mobile_invoice']) {?><?php echo $_POST['phone_mobile_invoice'];?>
<?php }?>" />
						</div>
						<input type="hidden" name="alias_invoice" id="alias_invoice" value="<?php echo smartyTranslate(array('s'=>'My Invoice address'),$_smarty_tpl);?>
" />
					</div>
					<!-- END Account -->
				</div>
				<?php echo $_smarty_tpl->tpl_vars['HOOK_CREATE_ACCOUNT_FORM']->value;?>

			</div>
			<p class="cart_navigation required submit clearfix">
				<span><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</span>
				<input type="hidden" name="display_guest_checkout" value="1" />
				<button type="submit" class="button btn btn-default button-medium" name="submitGuestAccount" id="submitGuestAccount">
					<span>
						<?php echo smartyTranslate(array('s'=>'Proceed to checkout'),$_smarty_tpl);?>

					</span>
				</button>
			</p>
		</form>
	<?php }?>
<?php } else { ?>
	
<div class="row"> 
    <div class="register-form-section">
        <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post" id="account-creation_form" enctype="multipart/form-data">
        <!--Acc creation part 1 staerts here -->
        
            	<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Create an account'),$_smarty_tpl);?>
</h3>
                
                <div class="account_creation">
                    <!--Company & firstname-->
                    <div class="row">       
                        <div class="required form-group">
                            <input placeholder="Company" type="text" class="is_required  form-control" id="company" name="company" value="<?php if (isset($_POST['company'])) {?><?php echo $_POST['company'];?>
<?php }?>" />
                        </div>   
                        <div class="required form-group">
                            <input placeholder="Your Name" onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="<?php if (isset($_POST['customer_firstname'])) {?><?php echo $_POST['customer_firstname'];?>
<?php }?>" />
                        </div>   
                    </div>
                    
                    <!--Email & password-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="Email" type="email" class="is_required validate form-control" data-validate="isEmail" id="email" name="email" value="<?php if (isset($_POST['email'])) {?><?php echo $_POST['email'];?>
<?php }?>" />
                        </div>
                        <div class="required password form-group">
                            <input placeholder="Password" type="password" class="is_required validate form-control" data-validate="isPasswd" name="passwd" id="passwd" />
                        </div>  
                    </div>
                    
                    <!--Address line 1&2-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="Address Line 1" type="text" class="is_required form-control" name="address1" id="address1" 
                            data-validate="isAddress" value="<?php if (isset($_POST['address1'])) {?><?php echo $_POST['address1'];?>
<?php }?>" />
                            <!--<span class="inline-infos"><?php echo smartyTranslate(array('s'=>'Street address, P.O. Box, Company name, etc.'),$_smarty_tpl);?>
</span>-->
                        </div>
                        <div class="required form-group">
                            <input type="text" placeholder="Address Line 2" class=" form-control" name="address2" id="address2" value="<?php if (isset($_POST['address2'])) {?><?php echo $_POST['address2'];?>
<?php }?>" />
                        </div>  
                    </div>
                    
                    <!--City & pincode-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="City" type="text" class="is_required form-control" name="city" id="city" 
                            data-validate="isCityName" value="<?php if (isset($_POST['city'])) {?><?php echo $_POST['city'];?>
<?php }?>" />
                        </div> 
                        <div class="required form-group">
                            <input placeholder="Pin code" type="text" class="is_required form-control noUniform" name="postcode" id="postcode" data-validate="isPostCode" value="<?php if (isset($_POST['postcode'])) {?><?php echo $_POST['postcode'];?>
<?php }?>" maxlength="6"/>
                        </div>  
                    </div>
                    
                    <!--State and country-->
                    <div class="row">
                        <div class="required select form-group">
                            <?php  $_smarty_tpl->tpl_vars['field_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_name']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dlv_all_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_name']->key => $_smarty_tpl->tpl_vars['field_name']->value) {
$_smarty_tpl->tpl_vars['field_name']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['field_name']->value=="Country:name"||$_smarty_tpl->tpl_vars['field_name']->value=="country") {?>
                                    <select name="id_country" id="id_country" class="form-control noUniform">
                                        <option value="">Country</option>
                                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_country'];?>
"<?php if ((isset($_POST['id_country'])&&$_POST['id_country']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_POST['id_country'])&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                                        <?php } ?>
                                    </select>
                                <?php }?>
                            <?php } ?>
                        </div>
                        <div class="required id_state form-group">
                            <select name="id_state" id="id_state" class="form-control noUniform">
                                <option value="">State</option>
                                <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['states']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
                                    <option value=""><?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <!--Mobile and User type-->
                    <div class="row">
                        <div class="required form-group">
                        	<input type="text" class="form-control" placeholder="Mobile Number" data-validate="isPhoneNumber" name="phone_mobile" id="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php }?>" />
                        </div>
                    </div>
                    
                    <!--Document & customer Type section-->
                    <div class="row">
                        <div class="form-group hidden">
                            <span class="radio-label">Verification Document   </span>
                            <div class="radio-inline">
                                <div class="radio-vertical doc">
                                    <input  type="radio" value="1" checked="" id="upload_now" name="upload_document" class="form-control noUniform" > <label for="upload_now">Upload now</label>
                                </div>
                                <div class="radio-vertical doc">
                                    <input type="radio" checked="checked" value="2" id="upload_later" name="upload_document" class="form-control noUniform" > <label for="upload_later">Upload later</label>
                                </div>
                            </div>
                        </div>
                        <div class="required form-group">
                            <span class="radio-label">Choose type</span>
                            <div class="radio-inline">
                                <div class="radio-vertical">
                                    <input type="radio" value="9" class="form-control" checked="checked" id="Corporate" name="id_buyer"> <label for="Corporate">Corporate</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="5" class="form-control retailer" id="SMEs"  name="id_buyer"> <label for="SMEs">SMEs</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="6" class="form-control retailer" id="Retailer"  name="id_buyer"> <label for="Retailer">Retailer</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="8" class="form-control retailer" id="Individual"  name="id_buyer"> <label for="Individual">Individual</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="7" class="form-control retailer" id="Others"  name="id_buyer"> <label for="Others">Others</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="upload">
                            <input type="file" name="uploadBuyerDocument" id="uploadBuyerDocument">
                            <p>Maximum file size: <span>5 MB</span></p>
                            <p>Acceptable formats: <span>gif, png, jpg, docx, doc, pdf, rtf & zip</span></p>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="g-recaptcha" data-sitekey="6LcA3CsUAAAAANCf2BK4omFwMaklT85kRNHjiD56"></div>
                    </div>
                    <!-- Submit Registeration -->
                    <div class="row">
                        <div class="submit ">
                            <input type="hidden" name="email_create" value="1" />
                            <input type="hidden" name="is_new_customer" value="1" />
                            <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
                            <button type="submit" name="submitAccount" id="submit_registration" class="button-black"><?php echo smartyTranslate(array('s'=>'Register'),$_smarty_tpl);?>
 </button>
                        </div>  
                    </div>
                    <br />
                    <div class="b2b-alert-container col-md-6">
                    	<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
high-importance-16.png" class="importantance-icon" /> 
                        <ul class="b2b-text b2b-text-registration"> 
                         	<li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
                        </ul>
                    </div>
                </div>
        </form>
    </div>
<!--End of Part 1-->
<!--Start of part 2-->         

<!--User Benefits Section -->
	<div class="user-benefits-section">
		
        <div class="b2b-alert-container">
            <img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
high-importance-16.png" class="importantance-icon" /> 
            <ul class="b2b-text b2b-alert-auth-side"> 
                <li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
            </ul>
        </div>
 
		<!-- Start Benefits for Company -->
		<!--<div class="benefits-container company" data-user-type="company">
            <h3>Benefits for Company</h3>
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-payment-icon"></div>
                    <p>Centralize Sourcing</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Pan India Delivery Network</li>
                    <li>Consolidate Sourcing to Save Cost</li>
					<li>Repeat your Orders</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-moq-icon"></div>
                    <p>Huge Catalog. Best Prices</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Lakhs of Genuine Products</li>
					<li>Thousands of Brands</li>
					<li>Best Prices for Bulk Purchase</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon direct-shipment-icon"></div><p>Online Procurement Tool - Kobster Elite</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Customized e-procurement Tool</li>
                    <li>Approval Workflows</li>
                    <li>Track expenses, Reports, Analytics and Savings</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon return-policy-icon"></div><p>On-time Delivery</p>
                </div>
                <ul class="key-benefits dash">
                    <li>100% On-Time Delivery</li>
                    <li>Pan India Coverage</li>
                    <li>No Questions asked Return Policy</li>
                </ul>
            </div>
        </div>-->
        <!-- End Benefits for Company -->

        <!-- Start Benefits for Retailer -->
		<!--<div class="benefits-container retailer" data-user-type="retailer">
        	<h3>Benefits for Retailer</h3>
			<div class="benefit">
            	<div class="title">
                	<div class="icon flexible-payment-icon"></div>
                    <p>Flexible Payment Terms & MOQ</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Buy Now, Pay Latter. Long Credit Periods</li>
                    <li>Flexible MOQs at same best price</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon flexible-moq-icon"></div>
                    <p>Direct from Brand</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Get unbelievable prices</li>
					<li>Access to new Products in the market</li>
					<li>Enjoy great schemes</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon direct-shipment-icon"></div><p>Direct Shipment to Customers</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Ship directly to your customers</li>
                    <li>Save costs on Logistics</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon return-policy-icon"></div><p>Unbelievable Return Policy</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Return of Unsold Goods</li>
                    <li>Stock Clearance Support</li>
                    <li>Extension of Credit Days</li>
                </ul>
            </div>
		</div>-->
		<!-- End Benefits for Retailer -->
    </div>
</div>
<?php }?>
<?php if (isset($_POST['id_state'])&&$_POST['id_state']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>intval($_POST['id_state'])),$_smarty_tpl);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['address']->value->id_state)&&$_smarty_tpl->tpl_vars['address']->value->id_state) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>intval($_smarty_tpl->tpl_vars['address']->value->id_state)),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_POST['id_state_invoice'])&&isset($_POST['id_state_invoice'])&&$_POST['id_state_invoice']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedStateInvoice'=>intval($_POST['id_state_invoice'])),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedStateInvoice'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_POST['id_country'])&&$_POST['id_country']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>intval($_POST['id_country'])),$_smarty_tpl);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['address']->value->id_country)&&$_smarty_tpl->tpl_vars['address']->value->id_country) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>intval($_smarty_tpl->tpl_vars['address']->value->id_country)),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_POST['id_country_invoice'])&&isset($_POST['id_country_invoice'])&&$_POST['id_country_invoice']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountryInvoice'=>intval($_POST['id_country_invoice'])),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountryInvoice'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['countries']->value)) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('countries'=>$_smarty_tpl->tpl_vars['countries']->value),$_smarty_tpl);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value)&&$_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('vatnumber_ajax_call'=>$_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value),$_smarty_tpl);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['email_create']->value)&&$_smarty_tpl->tpl_vars['email_create']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('email_create'=>$_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['boolval'][0][0]->boolval($_smarty_tpl->tpl_vars['email_create']->value)),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('email_create'=>false),$_smarty_tpl);?>
<?php }?>
<script>
$(document).ready(function(){
	showUploadDocument();
});

$(document).ready(function(){
	
	// Authentication page b2b validation 
	$('.radio-inline input[name=id_buyer]').change(function() {
        if (this.value == '8') {
			$("#submit_registration").attr("disabled",true);
			$(".b2b-text-registration").css("color", "red");
        }
        else  {
			$("#submit_registration").attr("disabled",false);
			$(".b2b-text-registration").css("color", "grey");
        }
    });
	
	// Reseller and Company Switch Content for Registration
	/*$('#doc1').click(function(){
		$('.user-benefits-section [data-user-type="company"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');
	});
	$('#doc2').click(function(){
		$('.user-benefits-section [data-user-type="retailer"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="company"]').addClass('hidden');
	});
	$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');*/
});
</script>
<script src='https://www.google.com/recaptcha/api.js'></script><?php }} ?>

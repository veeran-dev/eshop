<?php /* Smarty version Smarty-3.1.19, created on 2018-04-01 14:47:56
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\perks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5835ac0a3c428a682-76538634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7989b5ccf1e923b4f5ebdca76162a267156aad5b' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\perks.tpl',
      1 => 1522488503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5835ac0a3c428a682-76538634',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
    'cus_id' => 0,
    'confirmation' => 0,
    'false_domain' => 0,
    'tpl_uri' => 0,
    'back' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ac0a3c45694b1_55773087',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac0a3c45694b1_55773087')) {function content_5ac0a3c45694b1_55773087($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="perks-auth">

    <!-- Signin Window -->
    <div class="login-window">

        <?php if ($_smarty_tpl->tpl_vars['error']->value!='') {?>
            <div class="alert alert-danger">
                <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

            </div>
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['cus_id']->value>1) {?>
            <div class="alert alert-success">
                <strong>Thank you for confirming your email ID!</strong> Login and enjoy your exciting offers.
            </div>   
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['confirmation']->value==1) {?>
            <div class="alert alert-info">
                <strong>We have sent an confirmation Email!</strong> Kindly verify it.
            </div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['false_domain']->value==1) {?>
            <div class="alert alert-info">
                <strong>Sorry your Company is not onboarded</strong>
            </div>
        <?php }?>

        <h4 class="form-title">Login with your Registered Email ID</h4>
        <div class="message error no-config">
            <strong>Invalid username or password!</strong>
        </div>
        <form id="loginForm" method="post">
            <input type="text" name="email" id="email" placeholder="Official Email Address">
            <input type="password" name="passwd" id="passwd" placeholder="Password">
            <p class="forget-password"><a href="#" data-toggle="modal" data-target="#forgetPassword">Forgot Password?</a></p>
            <button type="submit" id="SubmitLogin" value="1" name="SubmitLogin">LOGIN & START SHOPPING <img class="inline-loading login" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/perks-white-loading.gif" alt="loading"/></button>
            <button type="submit" id="gotoRegister">NEW USER REGISTRATION</button>
        </form>
    </div>

    <div class="register-window">
        <form method="post" id="account-creation_form">
            <!--Acc creation part 1 staerts here -->
            <h4 class="form-title"><?php echo smartyTranslate(array('s'=>'Register & Verify now with your Business Email ID'),$_smarty_tpl);?>
</h4>
            <div class="message error" id="registerErr"></div>
            <div class="message okay" id="registerOk"></div>
            <div class="message info" id="registerInfo"></div>
                <div class="account_creation">
                    <!-- Name and Phone -->
                    <div class="row">   
                        <div class="required col-md-12">
                            <input placeholder="Your Name" onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="<?php if (isset($_POST['customer_firstname'])) {?><?php echo $_POST['customer_firstname'];?>
<?php }?>" />
                        </div>      
                    </div>
                    <div class="row">
                        <div class="required col-md-12">
                            <input type="text" class="form-control" placeholder="Mobile Number" name="phone_mobile" id="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php }?>" />
                        </div> 
                    </div>
                    <!-- Email -->
                    <div class="row">
                        <div class="required col-md-12" id="company-domain">
                            <input placeholder="Official Email Address" type="email" class="is_required validate form-control" data-validate="isEmail" id="email" name="email" value="<?php if (isset($_POST['email'])) {?><?php echo $_POST['email'];?>
<?php }?>" />
                        </div>
                    </div>
                    <!-- Password & Confirmation-->
                    <div class="row">
                        <div class="required password col-md-6 col-sm-6">
                            <input placeholder="Password" type="password" class="validate form-control" name="passwd1" id="passwd1" />
                        </div>
                        <div class="required password col-md-6 col-sm-6">
                            <input placeholder="Confirm Password" type="password" class="validate form-control" name="passwd2" id="passwd2" />
                        </div>  
                    </div>
                    <!-- <div class="row">
                        <div class="required col-md-12">
                            <div class="g-recaptcha" data-sitekey="6LcA3CsUAAAAANCf2BK4omFwMaklT85kRNHjiD56"></div>
                        </div>
                    </div> -->
                    <div class="row">
                        <span class="checkbox">
                            <div class="">
                                <input type="checkbox" class="validate form-control" value="1" name="newsletter" id="newsletter">
                                <label for="newsletter">I'm also subscribing to newsletter.</label>
                            </div>
                        </span>
                    </div>
                    
                    <!-- Submit Registeration -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 footer-actions">
                            <input type="hidden" name="perks_auth" value="1" />
                            <input type="hidden" name="email_create" value="1" />
                            <input type="hidden" name="is_new_customer" value="1" />
                            <input type="hidden" name="is_perks_customer" value="1" />
                            <input type="hidden" value="10" class="form-control" id="id_buyer" name="id_buyer">
                            <input type="hidden" value="1" class="form-control" id="perksRegister" name="perksRegister">
                            <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
                            <button type="submit" name="submitAccount" value="1" id="submit_registration" class=""><?php echo smartyTranslate(array('s'=>'Register'),$_smarty_tpl);?>
 <img class="inline-loading register" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/perks-white-loading.gif" alt="loading"/></button>
                        </div>
                        <div class="col-md-6 col-sm-6 footer-actions">
                            <a href="#" id="gotoLogin">Login</a>
                        </div>
                    </div>                    
                </div>
        </form>
    </div>
</div>
<!-- Forget Password -->
<div class="modal fade perks-modal" id="forgetPassword" tabindex='-1' role="dialog" data-keyboard="true" >
	<div class="modal-dialog">
		<div class="modal-content">
		    <button type="button" class="close" data-dismiss="modal">&nbsp;</button>
		    <div class="modal-body">
                <div class="forget-password-window">
                    <h4 class="form-title">Forgot Your Password?</h4>
                    <p class="description">Kindly enter your email ID below to reset your password.</p>
                    <form id="passwordResetForm">
                        <div class="message default" id="passResetInfo"></div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email ID" id="email" name="email" required/>
                            <input type="hidden" value="1" name="from_perks">
                        </div>
                        <div class="footer-actions">
                            <button name="forgotPassword" value="1" type="submit"><?php echo smartyTranslate(array('s'=>'SUBMIT'),$_smarty_tpl);?>
 <img class="inline-loading forgot-passwd" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/perks-white-loading.gif" alt="loading"/></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request For Demo Modal -->
<div class="modal fade perks-modal" id="requestForDemo" tabindex='-1' role="dialog" data-keyboard="true" >
	<div class="modal-dialog">
		<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">&nbsp;</button>
		<div class="modal-body">
			<div class="form-container">
				<div class="register-window-alt">
        <form method="post" id="requestForExplore">
            <!--Acc creation part 1 staerts here -->
                <div class="account_creation">
                    <div class="row">
                        <h4 class="form-title"><?php echo smartyTranslate(array('s'=>'Explore More by Registering here!'),$_smarty_tpl);?>
</h4>
                        <p class="description">Kobster Perks is an exclusive platform for Kobster Elite Customers. If you want to shop at Kobster Perks you must be a Kobster Elite Customer first. Go ahead and fil the form, we will contact you to onboard.</p>
                    </div>
                    <!-- Name and Phone -->
                    <div class="row">   
                        <div class="required col-md-12">
                            <input placeholder="Your Name" onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="cust_name2" name="cust_name2" value="<?php if (isset($_POST['customer_firstname'])) {?><?php echo $_POST['customer_firstname'];?>
<?php }?>" />
                        </div>     
                    </div>
                    <!-- Comapny -->
                    <div class="row">
                        <div class="required col-md-12">
                            <input placeholder="Company" type="text" class="is_required validate form-control" id="company_name2" name="company_name2" value="<?php if (isset($_POST['company'])) {?><?php echo $_POST['company'];?>
<?php }?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="required select col-md-12">
                            <select id="customer_type2" name="customer_type2" class="form-control">
                                <option value="">I'm a </option>
                                <option value="Reseller">Reseller</option>
                                <option value="Corporate Admin">Corporate Admin</option>
                                <option value="SME">SME</option>
                            </select>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="row">
                        <div class="required col-md-12">
                            <input placeholder="Business Email ID" type="email" class="is_required validate form-control" data-validate="isEmail" id="email2" name="email2" value="<?php if (isset($_POST['email'])) {?><?php echo $_POST['email'];?>
<?php }?>" />
                        </div>
                    </div>

                    <!-- Phone and City -->
                    <div class="row">
                        <div class="required col-md-8">
                            <input type="text" class="form-control" placeholder="Mobile Number" id="mobile2" name="mobile2" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php }?>" />
                        </div>
                        <div class="required col-md-4">
                            <select id="city2" name="city2" class="form-control noUniform">
                                <option value="">Select City *</option>
                                <option value="1">Chennai</option>
                                <option value="2">Mumbai</option>
                                <option value="3">Hyderabad</option>
                                <option value="4">Bengaluru</option>
                                <option value="5">Delhi</option>
                            </select>
                        </div>
                    </div>
                    <!-- Submit Registeration -->
                    <div class="row">
                        <div class="col-md-12 footer-actions">
                            <input type="hidden" class="form-control" id="page" name="page" value="0" />
                            
                            <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
                            <button type="submit"  class="REGISTER & VERIFY NOW!"><?php echo smartyTranslate(array('s'=>'CONTACT ME'),$_smarty_tpl);?>
 </button>
                        </div>
                    </div>                    
                </div>
        </form>
    </div>
			</div>
		</div>
		
		</div>
	</div>
</div>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="./themes/default-bootstrap/js/perks-registration.js"></script>
<script>
  
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-101262119-1', 'auto');
        ga('send', 'pageview');
  
</script><?php }} ?>

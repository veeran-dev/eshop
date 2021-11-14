<?php /* Smarty version Smarty-3.1.19, created on 2020-08-28 15:59:56
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\modules\blockuserinfo\nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17370533945f48dca4720654-64917658%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46539a2ed2222c7d00469581ba99ec8cd232e40c' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\modules\\blockuserinfo\\nav.tpl',
      1 => 1521273309,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17370533945f48dca4720654-64917658',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cookie' => 0,
    'page_name' => 0,
    'link' => 0,
    'tpl_uri' => 0,
    'is_logged' => 0,
    'cart_qties' => 0,
    'hasProof' => 0,
    'base_dir' => 0,
    'logo_image_width' => 0,
    'logo_image_height' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f48dca4768d11_28209231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f48dca4768d11_28209231')) {function content_5f48dca4768d11_28209231($_smarty_tpl) {?><div class="topbar">
<?php if ($_smarty_tpl->tpl_vars['cookie']->value->is_perks==1||$_smarty_tpl->tpl_vars['page_name']->value=='perks') {?>
    <div class="left-links">
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('perksDeals',true), ENT_QUOTES, 'UTF-8', true);?>
" alt="Kobster - Sourcing Simplified">
            <img class="kobster-logo" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/kobster-logo.png" />
        </a>
    </div>
    <div class="center-logo">
        <a class="mobile-kob-logo" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('perksDeals',true), ENT_QUOTES, 'UTF-8', true);?>
" alt="Kobster - Sourcing Simplified">
            <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/mobile-logo.png" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('perksDeals',true), ENT_QUOTES, 'UTF-8', true);?>
" alt="Kobster - Sourcing Simplified">
            <img class="perks-logo" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/perks-logo.png" />
        </a>
    </div>
    <div class="right-links">
        <?php if (intval($_smarty_tpl->tpl_vars['is_logged']->value)==1) {?>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('perksDeals',true), ENT_QUOTES, 'UTF-8', true);?>
" class="perks-top-button" title="<?php echo smartyTranslate(array('s'=>'Home','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
            <span class="perks-top-icon home-icon"></span><span class="perks-top-label"><?php echo smartyTranslate(array('s'=>'Home','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
        </a>

        <a class="perks-top-button" title="<?php echo smartyTranslate(array('s'=>'View my cart','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true), ENT_QUOTES, 'UTF-8', true);?>
">
            <span class="perks-top-icon cart-icon"></span>
            <span class="perks-top-label"><?php echo smartyTranslate(array('s'=>'My Cart','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
            <span class="cart-count" id="cart_qties2">
                <?php if ($_smarty_tpl->tpl_vars['page_name']->value=='module-ebs-response') {?>
                    <?php echo smartyTranslate(array('s'=>'0'),$_smarty_tpl);?>

                <?php } elseif ($_smarty_tpl->tpl_vars['cart_qties']->value>999) {?>
                    <?php echo smartyTranslate(array('s'=>'999+'),$_smarty_tpl);?>

                <?php } else { ?>
                    <?php echo $_smarty_tpl->tpl_vars['cart_qties']->value;?>

                <?php }?>
            </span>
        </a>

        <div class="dropdown black-dropdown">
            <a class="perks-top-button" id="myAcc" data-toggle="dropdown"  href="#" title="<?php echo smartyTranslate(array('s'=>'My Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
                <span class="perks-top-icon profile-icon <?php if (!$_smarty_tpl->tpl_vars['hasProof']->value) {?>in-complete<?php }?>"></span><span class="perks-top-label"><?php echo smartyTranslate(array('s'=>'My Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="myAcc">
                <?php if (!$_smarty_tpl->tpl_vars['hasProof']->value) {?>
                    <li>
                        <div class="profile-completeness">
                            <p>Complete your Profile and get Rs.100 cashback!</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">75%<span class="sr-only">70% Complete</span>
                                </div>
                            </div>
                            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('identity#scrollToIDProof',true), ENT_QUOTES, 'UTF-8', true);?>
"><span>COMPLETE NOW!</span><br/> by uploading your Professional ID</a>
                        </div>
                    </li>
                <?php }?>
                <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
">Your Orders</a></li>
                <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
">Settings</a></li>
                <li><a data-toggle="modal" data-target="#feedbackModal" href="#">Feedback</a></li>
                <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="btn btn-large logout">Logout</a></li>
            </ul>
        </div>
        
        <div class="dropdown black-dropdown help">
            <a class="perks-top-button" id="contactInfo" data-toggle="dropdown"  href="#" title="<?php echo smartyTranslate(array('s'=>'Help/FAQs','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
                <span class="perks-top-icon help-icon"></span><span class="perks-top-label"><?php echo smartyTranslate(array('s'=>'Help','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="contactInfo">
                <li><a href="index.php?controller=cms?id_cms=23">FAQ</a></li>
                <li><a href="tel:18001210405">1800-121-0405</a></li>
                <li><a href="mailto:perks@kobster.com">perks@kobster.com</a></li>
            </ul>
        </div>
        <?php }?>
    </div>
<?php } else { ?>
    <div class="left-links">
        <!--<a class="current_state" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Change Pincode','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['cookie']->value->pincode;?>
</a>-->
        <!--<a class="header_deals" href="https://www.kobster.com/diwali-gifts.php" target="_blank">DIWALI GIFTS</a>-->
    </div> 
    
    <div class="center-logo">
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="">
            <div class="logo" <?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value)&&$_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value)&&$_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?>></div>
        </a>
    </div>
    <!-- <div class="center-logo">
        <div class="logo"></div>
    </div> -->

    
    <div class="right-links">
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true), ENT_QUOTES, 'UTF-8', true);?>
">
        <div class="shopping-cart-count <?php if ($_smarty_tpl->tpl_vars['cart_qties']->value==0) {?> unvisible<?php }?>" id="cart_qties">
            <span><?php echo $_smarty_tpl->tpl_vars['cart_qties']->value;?>
</span>
        </div>
        </a>
        <!-- Block user information module NAV  -->
        <?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
            <div class="header_user_info">
                <div class="user-avatar">
                    <a href="#" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account dropdown-toggle" data-toggle="dropdown" rel="nofollow"><span class="hidden-sm hidden-xs"><?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
</span></a>
                    <ul class="dropdown-menu triangle-top user-avatar-link">
                        <?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
                            <li class="notMe"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">My Account</a></li>
                            <li class="notMe">
                                <a class="logout" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                  <!--
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account mobile-user-link" rel="nofollow">&nbsp;</a>
              
                <a class="logout hidden-sm hidden-xs" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
                <?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockuserinfo'),$_smarty_tpl);?>

                </a>
                -->
            </div>
        <?php } else { ?>
            <div class="header_user_info">
                <a class="login" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log in to your customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
                <span><?php echo smartyTranslate(array('s'=>'LOGIN /','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span> <?php echo smartyTranslate(array('s'=>'REGISTER','mod'=>'blockuserinfo'),$_smarty_tpl);?>

                </a>
                <a class="mobile-user-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log in to your customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
                <span>&nbsp;</span>
                </a>
            </div>
         <?php }?>
        
        <!-- /Block usmodule NAV -->
        
        <div class="customer-support">
            <span>1800-121-0405</span>
        </div>
        
        <div class="vertical-more-button">
            <div class="dropdown"><span class="dropdown-toggle" data-toggle="dropdown">&nbsp;</span>
                <ul class="dropdown-menu triangle-top">
                    <!--<li><a id="current_state" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Change Pincode','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['cookie']->value->pincode;?>
</a></li>-->
                    <li><a class="header_deals" href="diwali-gifts.php" title="Deals"><?php echo smartyTranslate(array('s'=>'DEALS','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</a></li>
                    
                    
                </ul>
            </div>
        </div> 
    </div>
<?php }?>
</div>
<!-- /Block usmodule NAV --><?php }} ?>

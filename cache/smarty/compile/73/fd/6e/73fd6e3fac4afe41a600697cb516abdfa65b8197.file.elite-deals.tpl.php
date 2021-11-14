<?php /* Smarty version Smarty-3.1.19, created on 2019-09-10 13:10:00
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\campaigns\elite-deals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40145d7753506e30e8-63081264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73fd6e3fac4afe41a600697cb516abdfa65b8197' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\campaigns\\elite-deals.tpl',
      1 => 1551865971,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40145d7753506e30e8-63081264',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl_uri' => 0,
    'media' => 0,
    'fc' => 0,
    'centre' => 0,
    'id_fc' => 0,
    'products' => 0,
    'j' => 0,
    'k' => 0,
    'l' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d775350af82f5_43322726',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d775350af82f5_43322726')) {function content_5d775350af82f5_43322726($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Online Office Pantry Supplies & Equipment at Best Price | Kobster</title>
    <meta name="description" content="Get instant access to healthy snacks and beverages for your office pantry at competitive prices in Chennai, Bangalore, Mumbai, Hyderabad and Delhi.">
    <meta name="author" content="Kobster">
    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
css/campaigns/elite-deals.min.css" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" /> 
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="flex flex-etoe flex-vc">
                <a href="https://www.kobster.com" class="logo">
                    <img class="kobster-logo" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/kobster-logo-tm.png" />
                </a>
                <div class="wrapper">
                    <a href="tel:18001210405" class="call">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/pantry/call.svg" alt="Call"/> 1800-121-0405 
                    </a>
                    <a href="mailto:support@kobster.com" class="call">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/pantry/mail.svg" alt="Email"/> support@kobster.com 
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <div class="categories-section">
        <div class="container">
            <h2 class="section-title">Upto 25 - 50% Discount</h2>
            <p class="section-lead">ON ALL AVAILABLE PRODUCTS</p>
            <div class="filter-section" id="product-section">
                <div class="filter-container">
                    <div class="wrapper">
                        <?php  $_smarty_tpl->tpl_vars['centre'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['centre']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fc']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['centre']->key => $_smarty_tpl->tpl_vars['centre']->value) {
$_smarty_tpl->tpl_vars['centre']->_loop = true;
?>
                            <a href="/elite-deals?id_fc=<?php echo $_smarty_tpl->tpl_vars['centre']->value['id_fulfillment_centre'];?>
#product-section" class=<?php echo $_smarty_tpl->tpl_vars['centre']->value['id_fulfillment_centre']==$_smarty_tpl->tpl_vars['id_fc']->value ? 'active' : '';?>
><?php echo $_smarty_tpl->tpl_vars['centre']->value['city_name'];?>
</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="cart-container">
                    <div class="cart">
                        <div class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/elite-deals/cart.svg"><span class="count">0</span></div>
                    </div>
                    <div class="cart-box">
                        <div class="header">
                            <h3>Your Products</h3>
                            <p>You have selected <span class="count">0</span> items</p>
                        </div>
                        <div class="items-list">
                            
                        </div>
                        <div class="button-wrapper">
                            <button href="#" onclick="submitForm();">Get Quote</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="brand-slider owl-carousel owl-theme">
            <?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable(0, null, 0);?>
            <?php $_smarty_tpl->tpl_vars['l'] = new Smarty_variable(0, null, 0);?>
            <?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['products']->value), null, 0);?>
            <?php while ($_smarty_tpl->tpl_vars['j']->value>0) {?>
                <div class="brand-slider-item item">
                    <div class="wrapper" >
                    <?php while ($_smarty_tpl->tpl_vars['k']->value<20&&$_smarty_tpl->tpl_vars['j']->value>0) {?>
                        <div class="product">
                            <div class="topSection">
                                <div class="select-product">
                                    <input type="checkbox" class="selectProduct" id="selectProduct<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['id_product'];?>
" name="selectProduct" value="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['id_product'];?>
" disabled>
                                    <label for="selectProduct<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['id_product'];?>
"></label>
                                </div>
                                <div class="stock">
                                    <div class="number"><?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['total']>9999) {?>9999<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['total'];?>
<?php }?></div>
                                    <div class="text">Available</div>
                                </div>
                            </div>
                            <div class="image">
                                <img src=<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['imageLink2'];?>
 />
                            </div>
                            <div class="product-details">
                                <p class="product-name" id="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['id_product'];?>
_name"><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['name'];?>
</p>
                                <p class="price">Rs. <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['price']);?>
</p>
                                <button id="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->tpl_vars['l']->value]['id_product'];?>
_add" class="addProduct">Get Quote</button>
                            </div>
                        </div>                        
                    <?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable($_smarty_tpl->tpl_vars['j']->value-1, null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable($_smarty_tpl->tpl_vars['k']->value+1, null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['l'] = new Smarty_variable($_smarty_tpl->tpl_vars['l']->value+1, null, 0);?>
                    <?php }?>
                    <?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable(0, null, 0);?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <ul id="snackbar-wrapper"></ul>
    </div>
    <footer>
        <div class="container">
            <div class="footer-pattern">
                <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/pantry/city-pattern.png" />
            </div>
            <div class="footer-links-container flex">
                <div class="footer-link-column">
                    <div class="wrapper">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/pantry/free-shipping.png" />
                        <img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/campaigns/pantry/credit.png" />
                    </div>
                </div>
                <div class="footer-link-column">
                    <ul>
                        <li><a href="https://www.kobster.com/about.php">About</a></li>
                        <li><a href="https://www.kobster.com/careers.php">Careers</a></li>
                        <li><a href="https://www.kobster.com/contact.php">Contact</a></li>
                        <li>
                            <div class="social-links" itemscope="" itemtype="http://schema.org/Organization"><link itemprop="url" href="https://www.kobster.com"> <a itemprop="sameAs" class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="twitter" href="http://www.twitter.com/kobsterOfficial" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="google-plus" href="https://plus.google.com/+KobsterIndia" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a> <a class="rss" href="https://www.kobster.com/blogs/" target="_blank">&nbsp;</a></div>
                        </li>
                    </ul>
                </div>
                <div class="footer-link-column">
                    <ul>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=6">Privacy Policy</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=3">Terms and Conditions</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=9">Cancellation and Return</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=10">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>
            <p class="copyright">&copy; <a href="https://www.kobster.com" target="_blank">Kobster.com</a> 2018. All rights reserved.</p>
        </div>
    </footer>
    <script src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
js/campaigns/elite-deals.min.js"></script>
    <script src='//cdn.zarget.com/184811/503705.js'></script>
</body>
</html><?php }} ?>

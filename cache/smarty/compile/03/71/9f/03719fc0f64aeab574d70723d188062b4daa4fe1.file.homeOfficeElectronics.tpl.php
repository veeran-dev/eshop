<?php /* Smarty version Smarty-3.1.19, created on 2018-06-28 13:36:56
         compiled from "C:\wamp64\www\kobsterEshop\modules\homeOfficeElectronics\homeOfficeElectronics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:76585b34972090f2c0-88470719%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03719fc0f64aeab574d70723d188062b4daa4fe1' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\homeOfficeElectronics\\homeOfficeElectronics.tpl',
      1 => 1500012985,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '76585b34972090f2c0-88470719',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
    'category_details' => 0,
    'category' => 0,
    'content_dir' => 0,
    'top_selling' => 0,
    'product' => 0,
    'PS_CATALOG_MODE' => 0,
    'PS_STOCK_MANAGEMENT' => 0,
    'img_dir' => 0,
    'restricted_country_mode' => 0,
    'priceDisplay' => 0,
    'reduction_amount' => 0,
    'add_prod_display' => 0,
    'static_token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5b349721580bb5_10294261',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b349721580bb5_10294261')) {function content_5b349721580bb5_10294261($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars["kob_cdn"] = new Smarty_variable("https://www.kobster.co/img/", null, 0);?>
<div id="customer_selecetor" class="container">
	

	<!-- Start Search and Offers Block -->
	<div class="home-search-block">
        <!-- Start Searchbar for both Companies and Retailers -->
		<div class="search-block searchbar">
        	<h1>Search in India's largest B2B platform.!</h1>
            <form id="searchbox-home" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
                <input type="hidden" name="controller" value="search" />
                <input type="hidden" name="orderby" value="position" />
                <input type="hidden" name="orderway" value="desc" />
                <input type="hidden" name="search_category" class="search_category_id" id="search_category" value="" />
                <input class="search_query search-input ac_input" type="text" id="search_query_home" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Type Product name or Product Code or Manufacturer code','mod'=>''),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" autocomplete="off"/>
                <select class="form-control category-dropdown">
                    <option value="">All Categories</option>
                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_details']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
						if(<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
 != "41200075")
							<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</option>
                    <?php } ?>
                </select>
                
                <button type="submit" name="submit_search" class="search-button">
                    <span class="sr-only"><?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
</span>
                </button>
            </form>	
            
            <p class="home-trending-products">Trending Products:  
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(949310), ENT_QUOTES, 'UTF-8', true);?>
">Sandisk 16 GB Pendrive Pack of 5</a>,
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(262640), ENT_QUOTES, 'UTF-8', true);?>
">Instapower LEDs</a>,
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(950354), ENT_QUOTES, 'UTF-8', true);?>
">Champs Sports Shoe</a>  
            </p>	

           
           	<div class="home_slider_container"> 
                <ul id="home_slider">
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink(266031);?>
"><img src="themes/default-bootstrap/img/home-slider/logitech.jpg"></a>
                    </li>
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink(986052);?>
"><img src="themes/default-bootstrap/img/home-slider/HP.jpg"></a>
                    </li>
                    <li>
                        <a href="pantry.php"><img src="themes/default-bootstrap/img/home-slider/Pantry.jpg"></a>
                    </li>
                    <!--
                    <li>
                        <a href="/deals#Plumbing-deals"><img src="themes/default-bootstrap/img/home-slider/Plumbing.jpg"></a>
                    </li>
                    <li>
                        <a href="/deals?page=2#Tool-deals"><img src="themes/default-bootstrap/img/home-slider/tools.jpg"></a>
                    </li>
                    <li>
                        <a href="/wholesale-deals"><img src="themes/default-bootstrap/img/home-slider/Wholesale.jpg"></a>
                    </li>
                    <li>
                        <a href="http://www.housejoy.in"><img src="themes/default-bootstrap/img/home-slider/housejoy.jpg"></a>
                    </li>
                    -->
                </ul>
            </div>
            
            
		</div>
        <!-- End Searchbar for Retailers -->

        <!-- Start Offers Block for Company -->
        <div class="offers-block">
            <div id="offers-slider">
                <div class="slide">
                    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(986101), ENT_QUOTES, 'UTF-8', true);?>
"><img src="themes/default-bootstrap/img/home/SB1.jpg"></a>
                </div>
                <div class="slide">
                    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(986110), ENT_QUOTES, 'UTF-8', true);?>
"><img src="themes/default-bootstrap/img/home/SB2.jpg"></a>
                </div>

            </div>
		</div>
        <!-- End Offers Block for Company -->

        

    </div>
    <!-- End Search and Offers Block-->

    <!-- Popular Deals -->
    <div class="hidden popular-category-showcase row-no-padding">
    	<h2>Corporate Diwali Offers</h2>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
img/menu/header-category-images/1.jpg" alt="Weekly Deals"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
img/menu/header-category-images/2.jpg" alt="lighting"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
img/menu/header-category-images/3.jpg" alt="taparia-brand-launch"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
img/menu/header-category-images/4.jpg" alt="Mega Wholesale deals"></a>
        </div>
    </div>
    <!-- Popular Deals -->

	
    <div class="browse-categories row-no-padding">
    	<h2>Top Categories</h2>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201940), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-wholesale"></span> Wholesale</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201941), ENT_QUOTES, 'UTF-8', true);?>
">Footwear</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201942), ENT_QUOTES, 'UTF-8', true);?>
">Sunglasses</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201996), ENT_QUOTES, 'UTF-8', true);?>
">Mobile &amp; Accessories</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201997), ENT_QUOTES, 'UTF-8', true);?>
">Automobile</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201998), ENT_QUOTES, 'UTF-8', true);?>
">Electronics</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41202016), ENT_QUOTES, 'UTF-8', true);?>
">Watches</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41202017), ENT_QUOTES, 'UTF-8', true);?>
">Plasticware</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41202019), ENT_QUOTES, 'UTF-8', true);?>
">Bags</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41202018), ENT_QUOTES, 'UTF-8', true);?>
">General Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41201940), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200073), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-electrical"></span> Electrical</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200205), ENT_QUOTES, 'UTF-8', true);?>
">LED Bulbs</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200197), ENT_QUOTES, 'UTF-8', true);?>
">LED Ceiling Lights</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200199), ENT_QUOTES, 'UTF-8', true);?>
">Street Lights</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200198), ENT_QUOTES, 'UTF-8', true);?>
">Flood Lights</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200211), ENT_QUOTES, 'UTF-8', true);?>
">High Bay Fixtures</a>
                
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200306), ENT_QUOTES, 'UTF-8', true);?>
">Switches</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200296), ENT_QUOTES, 'UTF-8', true);?>
">Circuit Breakers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200256), ENT_QUOTES, 'UTF-8', true);?>
">Wire &amp; Cable</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200330), ENT_QUOTES, 'UTF-8', true);?>
">Power Supply</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200073), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-safety"></span> Safety</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101003), ENT_QUOTES, 'UTF-8', true);?>
">Safety Shoes</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101004), ENT_QUOTES, 'UTF-8', true);?>
">Safety Gloves</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101005), ENT_QUOTES, 'UTF-8', true);?>
">Safety Helmets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101007), ENT_QUOTES, 'UTF-8', true);?>
">Safety Eyewear</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101013), ENT_QUOTES, 'UTF-8', true);?>
">Fall Protection</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101011), ENT_QUOTES, 'UTF-8', true);?>
">Workwear</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101010), ENT_QUOTES, 'UTF-8', true);?>
">Hearing Protection</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101020), ENT_QUOTES, 'UTF-8', true);?>
">Safety Kits</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101012), ENT_QUOTES, 'UTF-8', true);?>
">Safety Signage</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4101), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4104), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-tools"></span> Tools</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040113), ENT_QUOTES, 'UTF-8', true);?>
">Hand Tool sets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040137), ENT_QUOTES, 'UTF-8', true);?>
">Screwdriver &amp; sets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040105), ENT_QUOTES, 'UTF-8', true);?>
">Hammers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040114), ENT_QUOTES, 'UTF-8', true);?>
">Pliers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200072), ENT_QUOTES, 'UTF-8', true);?>
">Wrenches</a>	
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040020), ENT_QUOTES, 'UTF-8', true);?>
">Air Blowers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040044), ENT_QUOTES, 'UTF-8', true);?>
">Drills</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040067), ENT_QUOTES, 'UTF-8', true);?>
">Power Tool kits</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41040019), ENT_QUOTES, 'UTF-8', true);?>
">Angle Grinders</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4104), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4105), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-plumbing"></span> Plumbing</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41050001), ENT_QUOTES, 'UTF-8', true);?>
">Bathroom Faucets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41050008), ENT_QUOTES, 'UTF-8', true);?>
">Kitchen Faucets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200160), ENT_QUOTES, 'UTF-8', true);?>
">Health Faucets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200038), ENT_QUOTES, 'UTF-8', true);?>
">Shower</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200042), ENT_QUOTES, 'UTF-8', true);?>
">Drains</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200040), ENT_QUOTES, 'UTF-8', true);?>
">Sinks &amp; Basins</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200074), ENT_QUOTES, 'UTF-8', true);?>
">Pipes &amp; Fittings</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200041), ENT_QUOTES, 'UTF-8', true);?>
">Water closet/urinals</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200037), ENT_QUOTES, 'UTF-8', true);?>
">Water Heaters</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4105), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4002), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-electronics"></span> Electronics</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42014), ENT_QUOTES, 'UTF-8', true);?>
">PC/Laptop Accessories</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42007), ENT_QUOTES, 'UTF-8', true);?>
">Printers &amp; Scanners</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42012), ENT_QUOTES, 'UTF-8', true);?>
">Storage Devices</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43140), ENT_QUOTES, 'UTF-8', true);?>
">Multimedia Projectors</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42010), ENT_QUOTES, 'UTF-8', true);?>
">Network Peripherals</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43123), ENT_QUOTES, 'UTF-8', true);?>
">Headphones</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43071), ENT_QUOTES, 'UTF-8', true);?>
">Powerbank</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42008), ENT_QUOTES, 'UTF-8', true);?>
">Computer &amp; Tablets</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200192), ENT_QUOTES, 'UTF-8', true);?>
">Monitors</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4002), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4001), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-supplies"></span> Office supplies</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42001), ENT_QUOTES, 'UTF-8', true);?>
">Stationery Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42002), ENT_QUOTES, 'UTF-8', true);?>
">Writing Collection</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42003), ENT_QUOTES, 'UTF-8', true);?>
">Food &amp; Breakroom</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42004), ENT_QUOTES, 'UTF-8', true);?>
">Housekeeping Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43001), ENT_QUOTES, 'UTF-8', true);?>
">Files &amp; Folders</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(44052), ENT_QUOTES, 'UTF-8', true);?>
">Copier Papers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42007), ENT_QUOTES, 'UTF-8', true);?>
">Printers &amp; Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43019), ENT_QUOTES, 'UTF-8', true);?>
">Dispensers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42011), ENT_QUOTES, 'UTF-8', true);?>
">Office Software</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4001), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4114), ENT_QUOTES, 'UTF-8', true);?>
"> <span class="catagory-icon catagory-icon-measuremnt"></span> Test &amp; measurement</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200095), ENT_QUOTES, 'UTF-8', true);?>
">Multimeter</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200102), ENT_QUOTES, 'UTF-8', true);?>
">Voltage Detectors</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200056), ENT_QUOTES, 'UTF-8', true);?>
">Calipers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200055), ENT_QUOTES, 'UTF-8', true);?>
">Measuring Tools</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200126), ENT_QUOTES, 'UTF-8', true);?>
">Light &amp; Moisture Testers</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200121), ENT_QUOTES, 'UTF-8', true);?>
">Humidity Testers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4114004), ENT_QUOTES, 'UTF-8', true);?>
">Temperature Testers</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200113), ENT_QUOTES, 'UTF-8', true);?>
">Clamp Meter</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(41200103), ENT_QUOTES, 'UTF-8', true);?>
">Testers &amp; Indicators</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4114), ENT_QUOTES, 'UTF-8', true);?>
" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a> <span class="catagory-icon catagory-icon-other"></span> More Categories</a></h3>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4102), ENT_QUOTES, 'UTF-8', true);?>
">Hardware</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4002), ENT_QUOTES, 'UTF-8', true);?>
">Electronics</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4103), ENT_QUOTES, 'UTF-8', true);?>
">Security systems</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4107), ENT_QUOTES, 'UTF-8', true);?>
">Paints</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4112), ENT_QUOTES, 'UTF-8', true);?>
">Medical supplies</a>
            </div>
            <div class="home-sub-category">
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4113), ENT_QUOTES, 'UTF-8', true);?>
">Lab Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4110), ENT_QUOTES, 'UTF-8', true);?>
">Packing Supplies</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4116), ENT_QUOTES, 'UTF-8', true);?>
">Pumps &amp; Motors</a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(4106), ENT_QUOTES, 'UTF-8', true);?>
">Automobile Supplies</a>
                
            </div>
        </div>
        
        
    
    </div>
    
    
    <section class="product-slider">
        <div class="page-product-box blockproductscategory">
            <div class="product-slider-title">
                <h3 class="productscategory_h3">Top Selling Products</h3>
            </div>
            <div class="clearfix" >
            
                <ul class="bxslider company-slider clearfix">		
                <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['top_selling']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
                    <li class="ajax_block_product">
                    <!-- Product Start -->
                    <div class="product-container">
                        <div class="product">
                        	<div class="product-visual">
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value&&$_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value&&(!$_smarty_tpl->tpl_vars['product']->value['available_for_order']))) {?>
                                        <div class="out-of-stock"><span>Out of stock</span></div>
                                    <?php }?>
                                    
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
product-preloader.gif" data-src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'large'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" title="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                </a>
                                <a class="quick-view" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <span><?php echo smartyTranslate(array('s'=>'Quick view'),$_smarty_tpl);?>
</span>
                                </a>
                            </div>
                            <div class="product-name">
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
                                    <h3 title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],50,'...'), ENT_QUOTES, 'UTF-8', true);?>
</h3>
                                </a>
                            </div>
                            
                            
                                                	
                            
                            <div class="product-details">
                            
                            	
                                <div class="product-standard">
                                    <div class="star_content product-rating">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['name'] = "i";
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = (int) 0;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total']);
?>
                                        <?php if ($_smarty_tpl->tpl_vars['product']->value['ratings']['grade']<=$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']) {?>
                                            <div class="star"></div>
                                        <?php } else { ?>
                                            <div class="star star_on"></div>
                                        <?php }?>
                                    <?php endfor; endif; ?>
                                    </div>
                                   
                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['nbComments']) {?>
                                    <div class="comments"><?php echo $_smarty_tpl->tpl_vars['product']->value['nbComments'];?>
 Reviews</div>
                                    <?php } else { ?>
                                    <div class="comments"><?php echo smartyTranslate(array('s'=>'No Reviews'),$_smarty_tpl);?>
</div>
                                    <?php }?>
                                </div>
                                <div class="product-value">
                                	<?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value&&((isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price'])||(isset($_smarty_tpl->tpl_vars['product']->value['available_for_order'])&&$_smarty_tpl->tpl_vars['product']->value['available_for_order'])))) {?>
                                    	<?php if (isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
                                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'before_price'),$_smarty_tpl);?>

                                            <div class="product-price">
                                                <span>
                                                <?php if (((!$_smarty_tpl->tpl_vars['priceDisplay']->value)&&($_smarty_tpl->tpl_vars['product']->value['price']>0))) {?>
                                                	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>

                                              	<?php } elseif ((($_smarty_tpl->tpl_vars['priceDisplay']->value)&&($_smarty_tpl->tpl_vars['product']->value['price_tax_exc']>0))) {?>
                                                	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);?>

                                                <?php }?>
                                                </span>
                                            </div>
                                        <?php }?>
                                    
                                        <?php $_smarty_tpl->tpl_vars["reduction_amount"] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['product']->value['price'], null, 0);?>
                            			<?php if (($_smarty_tpl->tpl_vars['reduction_amount']->value>0)) {?>
                                        <div class="market-price">
                                            <?php if ($_smarty_tpl->tpl_vars['product']->value['price_without_reduction']>0&&isset($_smarty_tpl->tpl_vars['product']->value['specific_prices'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']&&isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']>0) {?>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl);?>

                                                	<meta itemprop="priceCurrency"/>
                                                	<span class="retail-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction']),$_smarty_tpl);?>
</span>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'id_product'=>$_smarty_tpl->tpl_vars['product']->value['id_product'],'type'=>"old_price"),$_smarty_tpl);?>

                                                
                                            <?php }?> 
                                        </div>
                                        <?php }?>
                                	<?php }?>
                                </div>
                                
                                
                                
                            </div>
                            <div class="product-actions">
                            
                            	<?php if (((!$_smarty_tpl->tpl_vars['priceDisplay']->value)&&($_smarty_tpl->tpl_vars['product']->value['price']<=0))) {?>
                                	<button class="button-outline" onclick="online_chat();">Contact us for price</button>
                                <?php } elseif ((($_smarty_tpl->tpl_vars['priceDisplay']->value)&&($_smarty_tpl->tpl_vars['product']->value['price_tax_exc']<=0))) {?>
                                	<button class="button-outline" onclick="online_chat();">Contact us for price</button>
                                <?php } else { ?>
                                
                                <?php if (($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']==0||(isset($_smarty_tpl->tpl_vars['add_prod_display']->value)&&($_smarty_tpl->tpl_vars['add_prod_display']->value==1)))&&$_smarty_tpl->tpl_vars['product']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['product']->value['customizable']!=2&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
                                <div class="product-quantity">
                                    <div class="product-quantity-row">
                                        <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : <?php echo $_smarty_tpl->tpl_vars['product']->value['minimal_quantity'];?>
</span>
                                        <div class="product-quantity-selector">
                                            <a href="#" data-field-qty="qty" data-field-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" class="btn btn-default button-minus product_quantity_down">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>
" data-field-quantity="<?php echo $_smarty_tpl->tpl_vars['product']->value['minimal_quantity'];?>
"  id="quantity_wanted_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" class="text numbersOnly" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']>1) {?><?php echo $_smarty_tpl->tpl_vars['product']->value['minimal_quantity'];?>
<?php } else { ?>1<?php }?>" ><a href="#" data-field-qty="qty" data-field-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" class="btn btn-default button-plus product_quantity_up">+</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <?php if ((!isset($_smarty_tpl->tpl_vars['product']->value['customization_required'])||!$_smarty_tpl->tpl_vars['product']->value['customization_required'])&&$_smarty_tpl->tpl_vars['product']->value['allow_oosp']) {?>
                                        <?php $_smarty_tpl->_capture_stack[0][] = array('default', null, null); ob_start(); ?>add=1&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php if (isset($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'])&&$_smarty_tpl->tpl_vars['product']->value['id_product_attribute']) {?>&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['static_token']->value)) {?>&amp;token=<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                                        <button class="ajax_add_to_cart_button" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
" data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']>=1) {?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']);?>
<?php }?>">
                                            <?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>

                                        </button>
                                    <?php } else { ?>
                                        <button class="ajax_add_to_cart_button disabled">
                                            <?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>

                                        </button>
                                    <?php }?>
                                </div>
                                <?php }?>
                                
                                <?php }?> 
                                
                            </div>
                        </div>
                    </div>
                    <!-- Product End --> 
                    </li>
                <?php } ?>		
                </ul>
            </div>
        </div>
    </section>
   
    
   <div class="top-brands row-no-padding">
    	<h2>Top Brands</h2>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(163), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="taparia" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/taparia.jpg" alt="Taparia" title="Taparia" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(588), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="fluke" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/fluke.jpg" alt="Fluke" title="Fluke" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(164), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="bosch" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/bosch.jpg" alt="Bosch" title="Bosch" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(463), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="Schneider" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/Schneider.jpg" alt="Schneider" title="Schneider" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(292), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="havells" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/havells.jpg" alt="Havells" title="Havells" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(285), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="karam" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/karam.jpg" alt="Karam" title="Karam" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(331), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="cumi" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/cumi.jpg" alt="CUMI" title="CUMI" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(464), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="jackly" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/jackly.jpg" alt="Jackly" title="Jackly" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(334), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="instapower" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/instapower.jpg" alt="Instapower" title="Instapower" />
        </a>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink(40), ENT_QUOTES, 'UTF-8', true);?>
" class="home-brand-container">
        	<img class="JK-Paper" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top-brands/JK-Paper.jpg" alt="JK Paper Ltd" title="JK Paper Ltd" />
        </a>
    </div>
    
    <!-- End Benefits Block -->
	<div class="benefits-block row-no-padding">
        <!-- Start Benefits for Retailer -->
		<div class="benefits-container reseller" >
        	<h3>Benefits for Retailer</h3>
			<div class="benefit">
            	<div class="title">
                	<div class="icon flexible-payment-icon"></div>
                    <p>Flexible Payment Terms & MOQ</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Buy Now, Pay Later. Long Credit Periods</li>
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
		</div>
        <!-- End Benefits for Retailer -->
        
        <!-- Start Benefits for Company -->
		<div class="benefits-container company" >
            <h3>Benefits for Company</h3>
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-payment-icon"></div>
                    <p>Centralized Sourcing</p>
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
                    <p>Great Options - Great Prices</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Lakhs of Genuine Products</li>
					<li>Thousands of Brands</li>
					<li>Best Prices for Bulk Purchase</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon direct-shipment-icon"></div><p>Kobster Elite Procurement Tool</p>
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
                    <li>Question Free Return Policy</li>
                </ul>
            </div>
        </div>
        <!-- End Benefits for Company -->

	</div>
    <!-- End Benefits Block -->
    </div>



    

    

    <?php }} ?>

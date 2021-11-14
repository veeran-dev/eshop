<?php /* Smarty version Smarty-3.1.19, created on 2020-08-28 15:59:56
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\modules\blocktopmenu\blocktopmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14416361915f48dca4b0ec74-92841143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '216682412987c162c5b205ce28f4a54d5abc8479' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\modules\\blocktopmenu\\blocktopmenu.tpl',
      1 => 1500012982,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14416361915f48dca4b0ec74-92841143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'isPerks' => 0,
    'content_dir' => 0,
    'kob_cdn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f48dca4b6d942_68248393',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f48dca4b6d942_68248393')) {function content_5f48dca4b6d942_68248393($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['isPerks']->value!=1) {?>
<?php $_smarty_tpl->tpl_vars["kob_cdn"] = new Smarty_variable("https://www.kobster.co/img/", null, 0);?>
    <div class="menubar">
        <div id="block_top_menu" class="sf-contener">
            <div class="cat-title">
            	<span><?php echo smartyTranslate(array('s'=>'Products Menu','mod'=>'blocktopmenu'),$_smarty_tpl);?>
</span>
                <span class="hamburger-icon"></span>
            </div>
            <ul class="sf-menu clearfix menu-content">
            
            <!-- Static Menu  Starts -->
                <li class="">
                    <a href="#/" title="Manufacturing" class="sf-with-ul">Manufacturing</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101003-safety-shoes">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/manufacturing/safety-shoes.png" alt="Safety Shoes"> -->
                                        <span class="menu-thumbs manufacturing-first-product"></span>
                                        <span>Safety Shoes</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104001-power-tools">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/manufacturing/power-tool.png" alt="Power Tools"> -->
                                        <span class="menu-thumbs manufacturing-second-product"></span>
                                        <span>Power Tools</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200217-material-handling">
                                        <!--  <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/manufacturing/material-handling.png" alt="Material Handling"> -->
                                        <span class="menu-thumbs manufacturing-third-product"></span>
                                        <span>Material Handling</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104083-hand-tools">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/manufacturing/hand-tool.png" alt="Hand Tools"> -->
                                        <span class="menu-thumbs manufacturing-fourth-product"></span>
                                        <span>Hand Tools</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Manufacturing Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Abrasives" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200214-abrasives">Abrasives</a></li>
                                    <li><a title="Hearing Protection" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101010-hearing-protection">Hearing Protection</a></li>
                                    <li><a title="Safety Signages" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101012-safety-signages">Safety Signages</a></li>
                                    <li><a title="Electrical Test Equipment" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4114002-electrical-test-equipment">Electrical Test Equipment</a></li>
                                    <li><a title="Measuring Equipment" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200055-measuring-equipment">Measuring Equipment</a></li>
                                    <li><a title="Fasteners" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200215-fasteners">Fasteners</a></li>
                                    <li><a title="Pneumatics" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200216-pnematics">Pneumatics</a></li>
                                    <li><a title="Pencils" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104001-power-tools">Power Tools</a></li>
                                    <li><a title="Welding" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200190-Industrial-Welding-Cables">Welding</a></li>
                                   <li><a title="Waste & Recycling" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200217-material-handling">Material handling</a></li>
                                   <li><a title="Power Supply" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42009-power-hub">Power Supply</a></li>
                                   <li><a title="Fire Protection" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101009-fire-protection">Fire Protection</a></li>
                                   <li><a title="Hand Tools" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104083-hand-tools">Hand Tools</a></li>
                                   <li><a title="Weighing Scales" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4112003-height-weight-scales">Weighing Scales</a></li>
                                </ul>
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/karam.png" alt="Karam" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
home/215914-karam-ep04-corded-reusable-ear-plugs.html">
                                    <div class="menu-deals first-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="#/" title="Construction" class="sf-with-ul">Construction</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200156-lightning">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/construction/led-bulbs.png" alt="LED Bulbs"> -->
                                        <span class="menu-thumbs construction-first-product"></span>
                                        <span>LED Bulbs</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200256-wires-cables">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/construction/wires-cables.png" alt="Wires and Cables"> -->
                                        <span class="menu-thumbs construction-second-product"></span>
                                        <span>Wires and Cables</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101005-safety-helmets">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/construction/helmets.png"> -->
                                        <span class="menu-thumbs construction-third-product"></span>
                                        <span>Helmets</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4105-plumbing">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/construction/plumbing.png"> -->
                                        <span class="menu-thumbs construction-fourth-product"></span>
                                        <span>Plumbing</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Construction Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Reflective Jackets" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41010061-reflective-jackets">Reflective Jackets</a></li>
                                    <li><a title="Lighting" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200156-lightning">Lighting</a></li>
                                    <li><a title="Hardware" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4102-hardware">Hardware</a></li>
                                    <li><a title="Paints" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4107-paints">Paints</a></li>
                                    <li><a title="Cutting Tools" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104083-Hand-Tools">Cutting Tools</a></li>
                                    <li><a title="Switches" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43075-switches">Switches</a></li>
                                    <!--<li><a title="Fencing" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
">Fencing</a></li>-->
                                    <li><a title="Motors" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4116-motors">Motors</a></li>
                                    <li><a title="Security Systems" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4103-security-systems">Security Systems</a></li>
                                    <!--<li><a title="Gardening & Landscape" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
">Gardening & Landscape</a></li>-->
                                    <li><a title="Water Storage Tanks" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41150048-Water-storage">Water Storage Tanks</a></li>
                                    <li><a title="Work Wear" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101011-workwear">Work Wear</a></li>
                                    <li><a title="Fall Protection" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101013-fall-protection">Fall Protection</a></li>
                                    <li><a title="Cordless Tools" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41040022-cordless-tools
">Cordless Tools</a></li>
                                    <li><a title="Power Drills" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41040044-drills">Power Drills</a></li>
                                    <li><a title="Faucets" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
208625-faucets">Faucets</a></li>
                                    <!-- <li><a title="Pumps & Motors" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4115001-domestic-pumps">Pumps & Motors</a></li> -->
                                    <li><a title="Switches" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200306-">Switches</a></li>
                                    <li><a title="Circuit Breakers" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200296-">Circuit Breakers</a></li>
                                </ul>
                                
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/polycab.png" alt="Polycab Wires and Cables" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
electricals/210620-polycab-15-sqmm-flame-retardant-low-smoke-copper-wires-180mm-red.html">
                                    <div class="menu-deals second-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="#/" title="Office Supplies" class="sf-with-ul">Office Supplies</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
44052-papers">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/office-supplies/copier-papers.png" alt="Papers"> -->
                                        <span class="menu-thumbs office-first-product"></span>
                                        <span>Papers</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42001-stationery-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/office-supplies/stationery.png" alt="Stationery"> -->
                                        <span class="menu-thumbs office-second-product"></span>
                                        <span>Stationery</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42003-food-and-breakroom">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/office-supplies/pantry.png" alt="Food And Breakroom"> -->
                                        <span class="menu-thumbs office-third-product"></span>
                                        <span>Food And Breakroom</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43017-cleaning-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/office-supplies/cleaning-items.png" alt="Cleaning Supplies"> -->
                                        <span class="menu-thumbs office-fourth-product"></span>
                                        <span>Cleaning Supplies</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Office Supplies</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <!-- <li><a title="White boards" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43175-boards">White boards</a></li> -->
                                    <li><a title="Multi Function Printer" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43057-multi-function-printer">Multi Function Printer</a></li>
                                    <!--<li><a title="Gifting" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
">Gifting</a></li>-->
                                    <li><a title="Furniture" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4003-furniture">Furniture</a></li>
                                    <li><a title="Appliances" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42005-appliances">Appliances</a></li>
                                    <!-- <li><a title="Office Software Tools" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42011-office-software-tools">Office Software Tools</a></li> Commented as link-->
                                    <li><a title="Networking Peripherals" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42010-networking-peripherals">Networking Peripherals</a></li>
                                    <li><a title="Waste & Recycling" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200217-material-handling">Waste & Recycling</a></li>
                                    <li><a title="Pen & Pencils" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43006-pen-pencils">Pen & Pencils</a></li>
                                    <li><a title="House Keeping Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42004-housekeeping-supplies">House Keeping Supplies</a></li>
                                    <li><a title="Trash bags & Cans" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43021-trash-bags-cans">Trash bags & Cans</a></li>
                                    <li><a title="Presentation Boards" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43008-presentation-boards">Presentation Boards</a></li>
                                    <li><a title="Files & Folders" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43001-files-folders">Files & Folders</a></li>
                                    <li><a title="Conference Room Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42017-conference-room-supplies">Conference Room Supplies</a></li>
                                </ul>
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
writing-collection/10125-jk-copier-paper-a4-size-75gsm-500-sheets.html">
                                    <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/jk.png" alt="JK Copier Papers" width="197" height="197"/> -->
                                    <div class="menu-deals third-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="#/" title="Hospital & Lab" class="sf-with-ul">Hospital & Lab</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4112008-first-aid">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hospital/first-aid.png" alt="First aid"> -->
                                        <span class="menu-thumbs hospital-first-product"></span>
                                        <span>First aid</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4113-lab-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hospital/lab-utensils.png" alt="First aid"> -->
                                        <span class="menu-thumbs hospital-second-product"></span>
                                        <span>Lab Supplies</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4112007-hospital-furniture">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hospital/labware.png" alt="Labware"> -->
                                        <span class="menu-thumbs hospital-third-product"></span>
                                        <span>Hospital furniture</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200225-consumables">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hospital/hospital-consumables.png" alt="Consumables"> -->
                                        <span class="menu-thumbs hospital-fourth-product"></span>
                                        <span>Consumables</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Hospital & Laboratory Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Safety equipments" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4101-safety">Safety Equipments</a></li>
                                    <li><a title="Furniture" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4003-furniture">Furniture</a></li>
                                    <li><a title="Medical supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4112-medical-supplies">Medical supplies</a></li>
                                    <li><a title="Digital Weighing Scales" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4113002-Scales-And-Balances">Digital Weighing Scales</a></li>
                                    
                                    <li><a title="Waste & Recycling" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200219-Waste-Recycling">Waste & Recycling</a></li>
                                    <li><a title="Lighting" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200156-lightning">Lighting</a></li>
                                    <li><a title="Labware" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4113007-labware">Labware</a></li>
                                    <li><a title="Pipettes" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41130015-pipettes-pipettors">Pipettes</a></li>
                                    

                                </ul>
                                
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/cole-parmer.png" alt="Cole Parmer" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
hospital-furniture/927015-kraft-132-manual-fowler-bed-2-function-deluxe.html">
                                    <div class="menu-deals fourth-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="#/" title="Electronics" class="sf-with-ul">Electronics</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43068-desktops">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/electronics/desktops.png" alt="Desktops" width="150" height="100"> -->
                                        <span class="menu-thumbs electronics-first-product"></span>
                                        <span>Desktops</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42014-desktop-laptop-accessories-and-peripherals">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/electronics/laptops.png" alt="Laptops" width="150" height="100"> -->
                                        <span class="menu-thumbs electronics-second-product"></span>
                                        <span>Laptops</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42007-printers-and-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/electronics/printing-scanning.png" alt="Printers and Scanners" width="150" height="100"> -->
                                        <span class="menu-thumbs electronics-third-product"></span>
                                        <span>Printers and Scanners</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42012-storage-devices">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/electronics/storage-devices.png" alt="Storage Devices" width="150" height="100"> -->
                                        <span class="menu-thumbs electronics-fourth-product"></span>
                                        <span>Storage Devices</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Electronics Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Appliances" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42005-appliances">Appliances</a></li>
                                    <li><a title="Multimedia Projectors" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43140-multimedia-projectors">Multimedia Projectors</a></li>
                                    <!--<li><a title="HD LED LCD TV" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43048-hd-led-lcd-tv">HD LED LCD TV</a></li>
                                    <li><a title="Mobile Phones" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43121-mobile-phones">Mobile Phones</a></li>
                                    <li><a title="Networking Peripherals" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42010-networking-peripherals">Networking Peripherals</a></li>
                                    <li><a title="Audio System" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41060038-audio-system">Audio System</a></li>
                                    <li><a title="Camera or Photo & Accessories" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43038-camera-photo-accessories">Camera/Photo Accessories</a></li>-->
                                    <li><a title="Computer & Tablets" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42008-computer-and-tablets">Computer & Tablets</a></li>
                                    <li><a title="Networking Peripherals" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42010-networking-peripherals">Networking Peripherals</a></li>
                                    <li><a title="Computer Accessories" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42014-desktop-laptop-accessories-and-peripherals">Computer Accessories</a></li>
                                    <li><a title="Head Phones" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42015-phones">Head Phones</a></li>
                                </ul>
                                
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/apple.png" alt="Apple Laptops" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
all-in-one-pc/207377-apple-macbook-pro-13-inch-mf839hn-a-retina-core-i5-27ghz-8gb-128gb-iris-graphics-6100.html">
                                    <div class="menu-deals fifth-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li class="">
                    <a href="#/" title="Educational Institutions" class="sf-with-ul">Educational Institution</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42001-stationery-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/education/stationery.png" alt="Stationery" width="150" height="100"> -->
                                        <span class="menu-thumbs education-first-product"></span>
                                        <span>Stationery</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43175-white-board">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/education/white-boards.png" alt="" width="150" height="100"> -->
                                        <span class="menu-thumbs education-second-product"></span>
                                        <span>White Boards</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200231-auditorium-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/education/auditorium-supplies.png" alt="Auditorium Supplies" width="150" height="100"> -->
                                        <span class="menu-thumbs education-third-product"></span>
                                        <span>Auditorium Supplies</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42004-housekeeping-supplies">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/education/house-keeping.png" alt="House Keeping" width="150" height="100"> -->
                                        <span class="menu-thumbs education-fourth-product"></span>
                                        <span>House Keeping</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Educational Institution Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Pen & Pencils" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43006-pen-pencils">Pen & Pencils</a></li>
                                    <li><a title="Notebooks & Registers" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
208620-notebooks-registers">Notebooks & Registers</a></li>
                                    <!--
                                    <li><a title="Sports & Recreation" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200232-sports-recreation">Sports & Recreation</a></li>
                                    <li><a title="Gifting" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
">Gifting</a></li>
                                    <li><a title="Events & Celebration" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200233-events-celebration">Events & Celebration</a></li>
                                    <li><a title="Lab Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4113-lab-supplies">Lab Supplies</a></li>
                                    <li><a title="Electronics and Machines" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4002-electronics-and-machines">Electronics and Machines</a></li>
                                    -->
                                    <li><a title="Furniture" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4003-furniture">Furniture</a></li>
                                    <li><a title="Food And Breakroom" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42003-food-and-breakroom">Food And Breakroom</a></li>
                                    
                                    <li><a title="General Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43004-general-supplies">General Supplies</a></li>
                                    <li><a title="Printers & Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42007-printers-and-supplies">Printers & Supplies</a></li>
                                </ul>
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/alkosign.png" alt="Alkosign White Boards" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
boards/205569-alkosign---astra-white-board---non-magnetic---600x900mm.html?search_query=alkosign+600">
                                    <div class="menu-deals seventh-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="#/" title="Hotels & Restaurants" class="sf-with-ul">Hotels & Restaurants</a>
                    <div class="submenu-container clearfix first-in-line-xs" style="">
                    	<div class="category-links-column">
                        	<div class="row">
                                <div class="popular-category-links">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43023-cleaning-appliances">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hotels/cleaning-items.png" alt="Stationery" width="150" height="100"> -->
                                        <span class="menu-thumbs hotels-first-product"></span>
                                        <span>Cleaning Items</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4003-furniture">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hotels/furniture.png" alt="Stationery" width="150" height="100"> -->
                                        <span class="menu-thumbs hotels-second-product"></span>
                                        <span>Furniture</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200156-lightning">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hotels/led-bulbs.png" alt="Stationery" width="150" height="100"> -->
                                        <span class="menu-thumbs hotels-third-product"></span>
                                        <span>Led Bulbs</span>
                                    </a>
                                </div>
                                <div class="popular-category-links">
                                	<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4104-tools">
                                        <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-four/hotels/hand-tool.png" alt="Hand Tools" width="150" height="100"> -->
                                        <span class="menu-thumbs hotels-fourth-product"></span>
                                        <span>Hand Tools</span>
                                    </a>
                                </div>
                        	</div>
                            <div class="row">
                            	<div class="category-title">
                                	<h3>Other Hotels & Restaurant Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="cat-links-column">
                                    <li><a title="Furniture" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4003-furniture">Furniture</a></li>
                                    <li><a title="Utensils" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200234-utensils">Utensils</a></li>
                                    <li><a title="Cleaning Appliances" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43018-Cleaning-Tools-And-Accessories">Cleaning Appliances</a></li>
                                    <li><a title="Faucets" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
208625-faucets">Faucets</a></li>
                                    <!--<li><a title="Packing Supplies" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
4110-packing-supplies">Packing Supplies</a></li>-->
                                    <li><a title="Fans" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
43032-fans">Fans</a></li>
                                    <li><a title="Sinks & Basins" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200040-sinks">Sinks & Basins</a></li>
                                    <li><a title="Cameras" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41030016-cameras">Cameras</a></li>
                                    <li><a title="Power Supply" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
42009-power-hub">Power Supply</a></li>
                                    <li><a title="Lighting" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200156-lightning">Lighting</a></li>
                                    <li><a title="Waste & Recycling" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
41200219-Waste-Recycling">Waste & Recycling</a></li>
                                </ul>
                                
                        	</div>
                        </div>
                        <div class="offers-column">
                        	<div class="offers-container">
                                <span>Deals</span>
                                <h3>Top Deals</h3>
                                <!-- <img src="<?php echo $_smarty_tpl->tpl_vars['kob_cdn']->value;?>
menu/top-deal/apple.png" alt="Hotels and Restaurants" width="197" height="197"/> -->
                                <a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
utensils/926773-cambro-bc340kd-plastic-large-utility-cart-black.html?search_query=cambro+">
                                    <div class="menu-deals eighth-deal"></div>
                                    <span>Click here to view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                
            </ul>
        </div>
    </div>
    <?php }?><?php }} ?>

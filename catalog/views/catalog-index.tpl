<div class="ajaxLoaderModal">
  <div class="preloader-animation">
    <div class="gif"></div>
    <p>{l s='Progressing...'}</p>
  </div>
</div>
<section id="container">
    <header class="header fixed-top clearfix">
        <div class="brand" id="elite">
            <!--Hamburger Icon-->
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
            <!--Logo-->
            <a href="#catalog.php" class="logo">
                <img src="dash/images/catalog-logo.png" alt="kobster-catalog-logo" title="Your Office Our Supplies">
            </a>
            <!--Mobile Navbar Actions Mobile Only-->
            <div class="top-nav">
                <div class="hidden-lg hidden-md hidden-sm visible-xs"></div>
            </div>
        </div>

        <div class="top-nav clearfix hidden-xs">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li id="top-corporuser-info" class="dropdown dash-corporate-user-logo">
                    <div id="top-corpuse-info-img" data-toggle="dropdown" class="dropdown-toggle dash-corporate-user-logo cur-poi"> <img id="corporate-logo" src="img/scn_logo.png" alt="" onerror="imgError(this);"> <span class="username">{$cookie->firstname}</span> <b class="caret"></b> </div>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="{$link->getPageLink('catalog-auth.php&catalogLogout')}" title="{l s='LOG OUT'}"><i class="fa fa-key"></i> {l s='Log out'}</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
                <!--search & user info end-->
        </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <div class="user-section-mobile hidden-lg hidden-md- hidden-sm">
                    <img class="image-section" src="img/scn_logo.png" alt="User Profile Icon" onerror="imgError(this);">
                    <div class="link-section">
                        <div class="username-section">
                            <span class="username">{$cookie->firstname}</span>
                            <span class="pull-right">
                <div class="dropdown">
                  <div data-toggle="dropdown" class="dropdown-toggle cur-poi"><i class="fa fa-ellipsis-v more-icon"></i></div>
                  <ul class="dropdown-menu dropdown-menu-right more-options">
                     <li>
                       <a href="{$link->getPageLink('catalog-auth.php?catalogLogout')}"  title="{l s='LOG OUT'}"><i class="fa fa-key"></i>
                        {l s='Log out'}
                       </a>
                     </li>
                  </ul>
                </div>
              </span>
                        </div>
                    </div>
                </div>
                <ul class="sidebar-menu" id="nav-accordion">
                    <li class="sub-menu dcjq-parent-li">
                        <a class="active" href="#/">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    {if $cookie->id_role == 2}
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#products/1/0/waiting">
                            <i class="fa fa-refresh"></i>
                            <span>Products to be approved</span>
                        </a>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a class="cur-poi"> 
                          <i class="fa fa-eye"></i> 
                          <span>View Vendors Products</span> 
                        </a>
                        <ul class="sub">
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/2/0/approved" class="cur-poi">Approval Pending</a>
                          </li>
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/3/0/live" class="cur-poi">Live</a>
                          </li>
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/4/0/rejected" class="cur-poi">Rejected</a>
                          </li>
                        </ul>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a class="cur-poi"> 
                          <i class="fa fa-user"></i> 
                          <span>View Your Products</span> 
                        </a>
                        <ul class="sub">
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/2/1/approved" class="cur-poi">Approval Pending</a>
                          </li>
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/3/1/live" class="cur-poi">Live</a>
                          </li>
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/4/1/rejected" class="cur-poi">Rejected</a>
                          </li>
                        </ul>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#product/upload">
                            <i class="fa fa-book"></i>
                            <span>Upload New Product</span>
                        </a>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#product/indexing">
                            <i class="fa fa-file-text"></i>
                            <span>Indexing Products</span>
                        </a>
                    </li>
                    {elseif $cookie->id_role == 3}
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#products/2/waiting">
                            <i class="fa fa-book"></i>
                            <span>Products to be approved</span>
                        </a>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a class="cur-poi"> 
                          <i class="fa fa-eye"></i> 
                          <span>View Products Status</span> 
                        </a>
                        <ul class="sub">
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/3/live" class="cur-poi">Live</a>
                          </li>
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#products/4/rejected" class="cur-poi">Rejected</a>
                          </li>
                        </ul>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a class="cur-poi"> 
                          <i class="fa fa-gear"></i> 
                          <span>Settings</span> 
                        </a>
                        <ul class="sub">
                          <li class="sub-menu dcjq-parent-li">
                            <a href="#category/attribute/settings" class="cur-poi">Set Attributes to Category</a>
                          </li>
                        </ul>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#product/indexing">
                            <i class="fa fa-file-text"></i>
                            <span>Indexing Products</span>
                        </a>
                    </li>
                    {else}
                        <li class="sub-menu dcjq-parent-li">
                            <a href="#product/upload">
                                <i class="fa fa-book"></i>
                                <span>Upload New Product</span>
                            </a>
                        </li>
                        <li class="sub-menu dcjq-parent-li">
                            <a href="#products">
                                <i class="fa fa-edit"></i>
                                <span>View / Edit Uploaded Product</span>
                            </a>
                        </li>
                    {/if}
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#product/buyingPrice">
                            <i class="fa fa-book"></i>
                            <span>Buying Price</span>
                        </a>
                    </li>
                    <li class="sub-menu dcjq-parent-li">
                        <a href="#product/perksPrice">
                            <i class="fa fa-book"></i>
                            <span>Perks Price</span>
                        </a>
                    </li>
                </ul>
                <div id="dsr-copyright">
                    <p>&copy; Copyright 2016 - Kobster.com</p>
                </div>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="top-stats-panel" id="index_viewport">
                <div>
                    <div ng-view></div>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
</section>
<form action="{$link->getPageLink('catalog-auth.php&catalogLogout')}" method="POST" id="logoutForm"></form>
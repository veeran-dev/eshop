<div class="topbar">
{if $cookie->is_perks == 1 || $page_name == 'perks'}
    <div class="left-links">
        <a href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" alt="Kobster - Sourcing Simplified">
            <img class="kobster-logo" src="{$tpl_uri}img/perks/kobster-logo.png" />
        </a>
    </div>
    <div class="center-logo">
        <a class="mobile-kob-logo" href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" alt="Kobster - Sourcing Simplified">
            <img src="{$tpl_uri}img/perks/mobile-logo.png" />
        </a>
        <a href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" alt="Kobster - Sourcing Simplified">
            <img class="perks-logo" src="{$tpl_uri}img/perks/perks-logo.png" />
        </a>
    </div>
    <div class="right-links">
        {if $is_logged|intval == 1}
        <a href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" class="perks-top-button" title="{l s='Home' mod='blockuserinfo'}">
            <span class="perks-top-icon home-icon"></span><span class="perks-top-label">{l s='Home' mod='blockuserinfo'}</span>
        </a>

        <a class="perks-top-button" title="{l s='View my cart' mod='blockuserinfo'}" href="{$link->getPageLink(order, true)|escape:'html':'UTF-8'}">
            <span class="perks-top-icon cart-icon"></span>
            <span class="perks-top-label">{l s='My Cart' mod='blockuserinfo'}</span>
            <span class="cart-count" id="cart_qties2">
                {if $page_name == 'module-ebs-response'}
                    {l s='0'}
                {else if $cart_qties > 999}
                    {l s='999+'}
                {else}
                    {$cart_qties}
                {/if}
            </span>
        </a>

        <div class="dropdown black-dropdown">
            <a class="perks-top-button" id="myAcc" data-toggle="dropdown"  href="#" title="{l s='My Account' mod='blockuserinfo'}">
                <span class="perks-top-icon profile-icon {if !$hasProof}in-complete{/if}"></span><span class="perks-top-label">{l s='My Account' mod='blockuserinfo'}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="myAcc">
                {if !$hasProof}
                    <li>
                        <div class="profile-completeness">
                            <p>Complete your Profile and get Rs.100 cashback!</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">75%<span class="sr-only">70% Complete</span>
                                </div>
                            </div>
                            <a href="{$link->getPageLink('identity#scrollToIDProof', true)|escape:'html':'UTF-8'}"><span>COMPLETE NOW!</span><br/> by uploading your Professional ID</a>
                        </div>
                    </li>
                {/if}
                <li><a href="{$link->getPageLink(history, true)|escape:'html':'UTF-8'}">Your Orders</a></li>
                <li><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">Settings</a></li>
                <li><a data-toggle="modal" data-target="#feedbackModal" href="#">Feedback</a></li>
                <li><a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}" class="btn btn-large logout">Logout</a></li>
            </ul>
        </div>
        
        <div class="dropdown black-dropdown help">
            <a class="perks-top-button" id="contactInfo" data-toggle="dropdown"  href="#" title="{l s='Help/FAQs' mod='blockuserinfo'}">
                <span class="perks-top-icon help-icon"></span><span class="perks-top-label">{l s='Help' mod='blockuserinfo'}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="contactInfo">
                <li><a href="index.php?controller=cms?id_cms=23">FAQ</a></li>
                <li><a href="tel:18001210405">1800-121-0405</a></li>
                <li><a href="mailto:perks@kobster.com">perks@kobster.com</a></li>
            </ul>
        </div>
        {/if}
    </div>
{else}
    <div class="left-links">
        <!--<a class="current_state" rel="nofollow" title="{l s='Change Pincode' mod='blockuserinfo'}">{$cookie->pincode}</a>-->
        <!--<a class="header_deals" href="https://www.kobster.com/diwali-gifts.php" target="_blank">DIWALI GIFTS</a>-->
    </div> 
    
    <div class="center-logo">
        <a href="{$base_dir}" title="{*$shop_name|escape:'html':'UTF-8'*}">
            <div class="logo" {if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}></div>
        </a>
    </div>
    <!-- <div class="center-logo">
        <div class="logo"></div>
    </div> -->

    
    <div class="right-links">
        <a href="{$link->getPageLink(order, true)|escape:'html':'UTF-8'}">
        <div class="shopping-cart-count {if $cart_qties == 0} unvisible{/if}" id="cart_qties">
            <span>{$cart_qties}</span>
        </div>
        </a>
        <!-- Block user information module NAV  -->
        {if $is_logged}
            <div class="header_user_info">
                <div class="user-avatar">
                    <a href="#" title="{l s='View my customer account' mod='blockuserinfo'}" class="account dropdown-toggle" data-toggle="dropdown" rel="nofollow"><span class="hidden-sm hidden-xs">{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
                    <ul class="dropdown-menu triangle-top user-avatar-link">
                        {if $is_logged}
                            <li class="notMe"><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}">My Account</a></li>
                            <li class="notMe">
                                <a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">{l s='Sign out' mod='blockuserinfo'}</a>
                            </li>
                        {/if}
                    </ul>
                </div>
                  <!--
                <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account mobile-user-link" rel="nofollow">&nbsp;</a>
              
                <a class="logout hidden-sm hidden-xs" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
                {l s='Sign out' mod='blockuserinfo'}
                </a>
                -->
            </div>
        {else}
            <div class="header_user_info">
                <a class="login" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
                <span>{l s='LOGIN /' mod='blockuserinfo'}</span> {l s='REGISTER' mod='blockuserinfo'}
                </a>
                <a class="mobile-user-link" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
                <span>&nbsp;</span>
                </a>
            </div>
         {/if}
        
        <!-- /Block usmodule NAV -->
        
        <div class="customer-support">
            <span>1800-121-0405</span>
        </div>
        
        <div class="vertical-more-button">
            <div class="dropdown"><span class="dropdown-toggle" data-toggle="dropdown">&nbsp;</span>
                <ul class="dropdown-menu triangle-top">
                    <!--<li><a id="current_state" rel="nofollow" title="{l s='Change Pincode' mod='blockuserinfo'}">{$cookie->pincode}</a></li>-->
                    <li><a class="header_deals" href="diwali-gifts.php" title="Deals">{l s='DEALS' mod='blockuserinfo'}</a></li>
                    
                    {*<li><a class="company" href="#" title="I'm a Company">{l s='COMPANY' mod='blockuserinfo'}</a></li>
                    <li><a class="retailer" href="#" title="I'm a Retailer">{l s='RETAILER' mod='blockuserinfo'}</a></li>*}
                </ul>
            </div>
        </div> 
    </div>
{/if}
</div>
<!-- /Block usmodule NAV -->
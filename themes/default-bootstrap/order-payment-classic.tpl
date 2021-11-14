{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="payment_block">
    <!--<div id="HOOK_TOP_PAYMENT">{$HOOK_TOP_PAYMENT}</div>-->
    {if $HOOK_PAYMENT}
        {if !$opc}
           <!-- end order-detail-content -->
            <div class="row">
                <div class="col-md-12 step-heading">
                    <h2>Payment Method</h2>
                </div>
                <div class="col-md-12" id="payment_block_text">
                    <p class="payment-amount-info">{l s ="Please choose your preferred payment method to pay Rs."}<strong>&nbsp;{$total_price}</strong></p>
                </div>
                {if $noSales != 1}
                <div class="col-md-12">
                    <div class="payment_section" id="payment_block_all">
                        <div class="b2b-alert-container-all">
                            <div class="b2b-alert-icon">
                                <img src="{$img_dir}high-importance-16.png" class="importantance-icon" />
                            </div>
                            <div>
                                We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.
                            </div>
                        </div>
                        
                        <ul class="button-pay-li">
                            {if $id_buyer !=3}
								<li id="pay_credit" onclick=callEBS("{$link->getModuleLink('ebs', 'payment', [9317], true)}");>
                                    <span class="payment-icon credit-card"></span>
                                    <span>CREDIT CARD</span>
                                </li> 
                                <li id="pay_debit" onclick=callEBS("{$link->getModuleLink('ebs', 'payment', [9314], true)}");>
                                    <span class="payment-icon debit-card"></span>
                                    <span>DEBIT CARD</span>
                                </li>
                                <li id="pay_net" onclick=callEBS("{$link->getModuleLink('ebs', 'payment', [9315], true)}");>
                                    <span class="payment-icon net-banking"></span>
                                    <span>NET BANKING</span>
                                </li>
                                <!--- <li id="pay_credit"><a href="{$link->getModuleLink('ebs', 'payment', [], true)}">CREDIT/DEBIT CARDS or NETBANKING</a></li> --> 
                                <!---<li id="pay_neft" onclick="paymentType(4);">NEFT/RTGS</li>
								
                                <li id="pay_cheque" onclick="paymentType(5);">{l s='CHEQUE' mod='cheque'}</li>-->
                                {if $cookie->id_state != 325 && $total_price >= 1500}
                                    <li  id="pay_cash" onclick="paymentType(6);">
                                        <span class="payment-icon cod"></span>
                                        <span>CASH ON DELIVERY</span>
                                    </li>
                                {else}
                                    <li  id="pay_cash" style="cursor: not-allowed; opacity: 0.2" onclick="javascript:void(0);" data-toggle="tooltip" title="COD is available only for orders above ₹1,500" data-placement="bottom">
                                        <span class="payment-icon cod"></span>
                                        <span>CASH ON DELIVERY</span>
                                    </li>
                                {/if}
                            {else}
                                {if $available_payment}
                                    {foreach from=$available_payment key=key  item=i}	
                                        
                                            {if $i.id_payment == 1}											 
                                                <li id="pay_cash" onclick="paymentType(6);">{$i.payment_name}</li>
                                            {elseif $i.id_payment == 2}
                                                <li id="pay_cheque" onclick="paymentType(5);">{$i.payment_name}</li>
                                            {elseif $i.id_payment == 3}
                                                <li id="pay_neft" onclick="paymentType(4);">{$i.payment_name}</li>
                                            {elseif $i.id_payment == 4}
                                                <li id="pay_net" onclick=callEBS("{$link->getModuleLink('ebs', 'payment', [9037], true)}");>{$i.payment_name}</li>
                                            {elseif $i.id_payment == 5}
                                                <li id="pay_send_for_approval" onclick="paymentType(7);">{$i.payment_name}</li>
                                            {elseif $i.id_payment == 7}
                                                <li id="pay_epaylater" onclick="paymentType(9);">{$i.payment_name}</li>
                                            {/if}
                                    {/foreach}
                                {else}
                                        <p><strong>{l s="No payment option is configured in your account. Please contact your Relationship Manager."}</strong></>
                                {/if}
                            {/if}
                        </ul>
                    </div>
                </div>
                {/if}
                <div class="col-md-12">
                	
                    <div class="margin120">
                     <!--Payment details section-->   
                         <div class="unvisible" id="payment_cheque">
                            <form action="{$link->getModuleLink('cheque', 'validation', [], true)|escape:'html'}" method="post">
                                <div>
            
                                     <h3>{l s='Please send us a cheque with:' mod='cheque'}<h3>
                                    <p>{l s='An amount of: ' mod='cheque'}<strong>Rs. {$total_price}</strong></p>
                                    <p>{l s='In favour of: ' mod='cheque'}{if $check_details.chequeName}<strong>{$check_details.chequeName}</strong>{else}___________{/if}</p>
                                    <p>{l s='Send it to the following address: ' mod='cheque'}{if $check_details.chequeAddress}<strong>{$check_details.chequeAddress}</strong>{else}___________{/if}</p>
                                    <p>{l s='Your order will be sent as soon as we receive your payment.' mod='cheque'}</p>
                                    <p>{l s='For any questions or for further information, please contact our' mod='cheque'} <a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='cheque'}</a></p>
                                </div>
                                <p class="cart_navigation" id="cart_navigation">
                                    <input type="submit" value="{l s='I confirm my order' mod='cheque'}" class="button-black"/>
                                </p>
                            </form>   
                        </div>
                        <div class="unvisible" id="payment_bankwire">
                            <form action="{$link->getModuleLink('bankwire', 'validation', [], true)|escape:'html'}" method="post">
                               
                          
                               <h3>{l s='Please send us a bank wire with' mod='bankwire'}</h3>
                                <p> {l s='Amount: ' mod='bankwire'} <strong>Rs. {l s=$total_price}&nbsp;</strong>{if $use_taxes == 1}{l s='(tax incl.)' mod='bankwire'}
                                {/if}</p>
                                <p>{l s='Name of account owner: ' mod='bankwire'}  <strong>{if $bank_wire_details.bankwire_owner}{$bank_wire_details.bankwire_owner} {else}___________{/if}</strong></p>
                                <p> {l s='Include these details: ' mod='bankwire'}  <strong>{if $bank_wire_details.bankwire_details}{$bank_wire_details.bankwire_details}{else}___________{/if}</strong></p>
                                <p>{l s='Bank name: ' mod='bankwire'}  <strong>{if $bank_wire_details.bankwire_address}{$bank_wire_details.bankwire_address}{else}___________{/if}</strong></p>
                               	<p>{l s='An email has been sent with this information.' mod='bankwire'}</p>
                                <p><strong>{l s='Your order will be sent as soon as we receive payment.' mod='bankwire'}</strong></p>
                                <p>{l s='If you have questions, comments or concerns, please contact our' mod='bankwire'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='expert customer support team' mod='bankwire'}</a>.</p>
                            </span>
                            
                                <p class="cart_navigation" id="cart_navigation">
                                <input type="submit" value="{l s='I confirm my order' mod='bankwire'}" class="button-black" />
                                <!--<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='bankwire'}</a>-->
                                </p>
                            </form>
                        </div>
                        <div class="unvisible" id="payment_credit_debit">
                           <div class="row">
                           		<form  method="post" >
 								   <div class="row">
                                       <div class="form-group">
                                            <h3 id="payment_head">	</h3>
                                            <p><strong>Card number</strong></p>
                                            <input type="text" class="form-control" autocomplete="off" id="card_no" name="card_no" value="" placeholder="Enter your Card Number"/>
                                       </div>
								   </div>
                                   <div class="row row-no-padding">
                                        <div class="col-sm-8 col-xs-8">
                                            <p><strong>Expiration Date</strong></p>
                                            <div class="col-sm-6 col-xs-6 form-group">
                                                <select class="form-control noUniform" id="id_exp_month" name="id_exp_month">
                                                    <option value="1">--</option>
                                                    <option value="1">Jan</option>
                                                    <option value="2">Feb</option>
                                                    <option value="3">Mar</option>
                                                    <option value="4">Apr</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">Aug</option>
                                                    <option value="9">Sept</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-xs-6 form-group">
                                                <select id="id_exp_year" name="id_exp_year" class="form-control noUniform">
                                                    <option value="1">--</option>
                                                    {for $i=2016 to 2035}
                                                    <option value="1">{$i}</option>
                                                    {/for}
                                                </select>
                                            </div>
                                         </div>
                                         
                                        <div class="col-sm-4 col-xs-4 no-padding-left">
                                            <p><strong>CVV</strong></p>
                                            <div class="form-group">
                                                <input type="password" placeholder="..." class="form-control" maxlength="3" size="3" autocomplete="off"  id="id_cvv" name="id_cvv" />
                                            </div>
                                        </div>
                                    </div>
									<div class="row">   
										<div class="form-group">
											<input type="text" value="" class="form-control" placeholder="Card holder's name" id="card_name" name="card_name" />
										</div>
									</div>-->
 									<div class="row">                           
										<p class="cart_navigation" id="cart_navigation">
										<input onclick="goToEBS();" type="button" value="{l s='Make Payment' mod='bankwire'}" class="button-black" />
										<!--<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='bankwire'}</a>-->
										</p>
									</div>
								</form>
                             </div>
                        </div>
                        <div class="unvisible" id="payment_cod">
                            <form action="{$link->getModuleLink('cashondelivery', 'validation', [], true)|escape:'html'}" method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                        <input type="hidden" name="confirm" value="1" />
                                        <h3>{l s='Pay by Cash on delivery.' mod='cashondelivery'}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                    	{l s='Pay with cash or swipe with card when your order is delivered' mod='cashondelivery'}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                        <p class="cart_navigation" id="cart_navigation">
                                        <input type="submit" value="{l s='I confirm my order' mod='cashondelivery'}" class="button-black" />
                                        </p>
                                	</div>
                                </div>
                            </form>
                           
                        </div>
						<div class="unvisible" id="payment_approval">
                            {*<form action="{$link->getModuleLink('cashondelivery', 'validation', [], true)|escape:'html'}" method="post">*}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                        <input type="hidden" name="confirm" value="1" />
                                        <h3>{l s='Send For Approval.' }</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                    	{l s='Click the "I confirm my order" button to place the order and send for approval.'}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 no_left_padding">
                                        <p class="cart_navigation" id="cart_navigation">
                                        <input type="button" onclick="sendForApproval()" value="{l s='I confirm my order'}" class="button-black" />
                                        </p>
                                	</div>
                                </div>
                            {*</form>*}
                           
                        </div>
                        <div class="unvisible" id="payment_epaylater">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 no_left_padding">
                                    <input type="hidden" name="confirm" value="1" />
                                    <h3>{l s='Pay with Epaylater.' }</h3>
                                </div>
                            </div>
                            <div class="row" id="epaylater_payment_hint">
                                <div class="col-xs-12 col-sm-12 no_left_padding">
                                    {l s='Click the "I confirm my order" button to place the order via Epaylater.'}
                                </div>
                            </div>
                            <div class="row" id="epaylater_payment_btn">
                                <div class="col-xs-12 col-sm-12 no_left_padding">
                                    <p class="cart_navigation" id="cart_navigation">
                                    <input type="button" onclick="confirmEpaylaterPayment()" value="{l s='I confirm my order'}" class="button-black" />
                                    <input type="hidden" name="pay_later_id" id="pay_later_id">
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="epaylater_not_eligible">
                                <div class="col-xs-12 col-sm-12 no_left_padding">
                                    <p>You are not eligible to use this payment type. For more details please contact your Relationship Manager (RM).</p>
                                </div>
                            </div>
                            <div class="row" id="epaylater_error">
                                <div class="col-xs-12 col-sm-12 no_left_padding">
                                    <p>Problem while placing your order. For more details please contact contact your Relationship Manager (RM).</p>
                                </div>
                            </div>
                        </div>
                        
                  	</div>
                    
                    
                    
                    
                </div>
            </div>
        {/if}
        {if $opc}
            <div id="opc_payment_methods-content">
        {/if}
        
        <div id="HOOK_PAYMENT">
            {$HOOK_PAYMENT}
        </div>
        {if $noSales == 1}
        <div class="payment-gst-alert">Sorry we are not taking order from 28th JUNE 2017 to 5th JULY 2017 due to GST implementations!</div>
        {/if}
        {*{if !$opc}
            </div> <!-- end opc_payment_methods-content -->
        {/if}*}
    {else}
        <p class="alert alert-warning">{l s='No payment modules have been installed.'}</p>
    {/if}
    {if !$opc}
    <p class="cart_navigation clearfix">
        <!--<a href="{$link->getPageLink('order', true, NULL, "step=2")|escape:'html':'UTF-8'}" title="{l s='Previous'}" class="button-exclusive btn btn-default">
            <i class="icon-chevron-left"></i>
            {l s='Continue shopping'}
        </a>-->
        
        {*<a href="{$base_dir}" title="{l s='kobster'}" class="button-exclusive btn btn-default">
            <i class="icon-chevron-left"></i>
            {l s='Continue shopping'}
        </a>*}
        
    </p>
    {else}
</div> <!-- end opc_payment_methods -->
{/if}
</div> <!-- end HOOK_TOP_PAYMENT -->


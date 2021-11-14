{if $cookie->role==1}
<section class="panel panelHeight">
            <header class="panel-heading">
                Order Status
            </header>
            <div class="panel-body">
            	
            	<img src="dash/images/sand-clock.png" class="img_height" style="float:left;" width="260" />
                <div class="chat-conversation orderStatus">
                    <div class="text-pending" align="center">Order Placed, Pending Approval</div>
                    <div class="thankyou-alignment" align="center"> For any assistance please contact our Support team at <b>1800 121 0405</b> or <a href="mailto:'support@kobster.com'" class="mailto-alignment email-underline">support@kobster.com</a>   </div>
					
					<div id="thankyou_points" class="pointsalign" align="center"></div>
					</div>
                         <div class="orderConfirmMarginTop orderconfirmpending" align="center" ><a href="dash-index.php" class="btn btn-primary kob_button continue-shopping-alignment">Continue Shopping</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
{/if}
{if $cookie->role!=1}
        <section class="panel panelHeight">
            <header class="panel-heading">
                Order Status
            </header>
            <div class="panel-body">
			
               
			   {if $cookie->payment_type!=5}
				
				 
					<img src="dash/images/success.jpg" style="float:left;" />
					<div class="chat-conversation orderStatus">
						<div class="text-success" align="center">Thank you for the Order.</div><br />
						<div class="thankyou-alignment" align="center"> For any assistance please contact our Support team at <b>1800 121 0405</b> or <a href="mailto:'support@kobster.com'" class="mailto-alignment email-underline">support@kobster.com</a>   </div>
						
						<div id="thankyou_points" class="points-alignment" align="center"></div>
						</div>
							 <div class="orderConfirmMarginTop orderconfirmok" align="center"><a href="dash-index.php" class="btn btn-primary kob_button continue-shopping-alignment" align="center">Continue Shopping</a></div>
							</div>
						</div>
					</div>
				{else}
				<img src="dash/images/sand-clock.png" class="img_height" style="float:left;" width="260" />
					<div class="chat-conversation orderStatus">
						<div class="text-pending" align="center">Order Placed, Pending Approval</div>
						<div class="thankyou-alignment" align="center"> For any assistance please contact our Support team at <b>1800 121 0405</b> or <a href="mailto:'support@kobster.com'" class="mailto-alignment email-underline">support@kobster.com</a>   </div>
						
						<div id="thankyou_points" class="pointsalign" align="center"></div>
						</div>
							 <div class="orderConfirmMarginTop orderconfirmpending" align="center" ><a href="dash-index.php" class="btn btn-primary kob_button continue-shopping-alignment">Continue Shopping</a></div>
							</div>
						</div>
					</div>
				{/if}
			
				
            </div>
        </section>
        {/if}
<!-- Offer Conversion: Kobster -->
<iframe src="https://tracking.affiliatehub.co.in/SL1OR" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<!-- // End Offer Conversion -->
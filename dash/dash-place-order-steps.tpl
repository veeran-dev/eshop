<!--
	<div id="quick-buy" class="row">
		<div class="col-xs-12 col-md-6">
				<div class="col-xs-8 col-md-8">
                <h5 >Product Name or Code </h5>
                <input id="focusedInput" class="form-control  dash-search-box"  onKeyPress="toHideEmptyResult();" placeholder="Search"  type="text" tabindex="1">
                <div id="quickbuy-product-not-found" class="pro"><span id="product-not-found-span">Product not found.</span></div>
                </div>
                <div class="col-xs-2 col-md-2">
                <h5 class="tex-ali-cen">Quantity</h5>
         		<input id="dash-corporate-user-quantity-value" class="form-control tex-ali-cen dash-search-box dash-corporate-user-quantity-value"   
                value="1" type="text" maxlength="4" tabindex="2" />
                
                </div>
                <div class="col-xs-2 col-md-2">
               <a id="dash-corporate-user-add-to-cart"   class="btn btn-primary kob_button ">ADD
                 <i class="fa fa-arrow-right"></i>
                 </a>
                </div> 
        </div>
        <div class="col-xs-12 col-md-6">
    	<section class="panel">
		<div class="panel-body ">
        	<div class="top-stats-panel">
           		<div id="quick-buy-list" > 
				<table id="quick-buy-table"   class="table  table-hover general-table">
				<thead>
				<tr >
                <th  >Product Name </th>
                <th class="tex-ali-cen" >Quantity</th>
                <th >Price</th>
                <th >Delete</th>
                </tr>
                </thead>
                <tbody id="quickbuy-list-body" role="alert" aria-live="polite"  aria-relevant="all">
      
                </tbody>
                </table>
 
            </div> 
		</div>
     </div>
     </section>
     </div>         
      <a id="quickbuy-add-to-cart" onClick="loadAddressPage();" class='btn btn-primary kob_button'>Place Order</a>
           
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="noproduct" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Kobster</h4>
                      </div>
   
                      <div class="modal-body">
                      No Products to add
                      </div>
                                <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                      </div>

                  </div>
              </div>
          </div>
          
          
          
          
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="minimumquantity" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Kobster</h4>
                      </div>
   
                      <div class="modal-body"> 
                      Please, Enter the Minimum  Quantity
                      </div>
                                <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                      </div>

                  </div>
              </div>
         </div>-->
<script>
   var id_state_vat='{$cookie->id_state_vat}';
   var name_state_vat='{$cookie->name_state_vat}';
</script>
<script>
    $(function ()
    {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft"
        });

        $("#wizard-vertical").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical"
        });
    });
$('#wizard-p-1').hide();
$('#wizard-p-2').hide();
$('#wizard-p-3').hide();

</script> 
<script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/js/dash-user-address.js"></script>
<div class="row">
<div class="col-sm-12">
<section class=" margin-align-bottom">
<div class="panel-body steps-heading height540">
<div id="wizard">
  <h2>Select your Products</h2>
  <section> </section>
  <h2>Select your Address</h2>
  <section>
  <div id="dash-customer-address">
    <div id='cop_user_profile'>
      <div id='cop_user' class='col-md-12 tex-ali-cen'><b>Choose Your Delivery Address</b> </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="address-valid-true" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Kobster</h4>
          </div>
          <div class="modal-body"> Address Updated Successfully </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
          </div>
        </div>
      </div>
    </div>
    </section>
    <h2>Confirmation</h2>
    <section id="shopping-summary-view-port">
      <div id="cart-products-main" class="col-md-8  col-xs-12">
        <section class='panel margin-align-bottom'>
          <div class='panel-body padding-align-bottom ' >
            <div class='top-stats-panel' id="shoppingSummary">
              <h5 class="font-weight">YOUR PRODUCT LIST</h5>
              <table class="table  table-hover general-table" style="margin:0px;">
                <thead>
                    <tr>
                      <th class="col-md-1">S.NO</th>
                      <th class="col-md-2">Product </th>
                      <th class="col-md-5"> Name </th>
                      <th class="col-md-2">Quantity</th>
                      <th class="col-md-3">Price</th>
                      <th>Delete</th>
                    </tr>
                </thead>
              </table>
              <div id="cart-products">
                <table id="cart-products-table" class="table  table-hover general-table">
                  
                  <tbody id="cart-products-list-body"  role="alert" aria-live="polite"  aria-relevant="all">
                  </tbody>
                </table>
              </div>
              <div id="cart-product-price">
                <div class='pull-left '>
                  <span>
                    <input type='text' value='' placeholder='Enter Voucher Code' id='name_vouchercode' name='name_vouchercode' />
                  </span>
                  <span id='voucher_apply' class='btn btn-info btn-xs' onclick='addDiscount(0,1);'>
                    Apply
                  </span>&nbsp;/&nbsp;
                  <span class='btn btn-info btn-xs' id='voucherCount' onclick=openVoucher();>
                    View Vouchers
                  </span>
				 <div class='upload_block_po'>
                    <span>
                      <input type ="text" value='' placeholder = 'Enter PO Number' class='' id = 'name_po'  name='name_po'/>
                    </span>
                    <span>
                      <input type='file' name='uploadFile' id='uploadFile'>
                        <span>
                          <input type='text' value='' id='name_upload_po' placeholder='Upload Your PO' name='name_upload_po' disabled />&nbsp;&nbsp;
                          <span>
                            <input type='submit' id='po_upload' class='btn btn-info btn-xs' name='po_upload' value='Upload'/>
                            <div class="help-block">(Maximum file Size 2 MB)</div>
                            <div class="help-block-poNumber">(Enter PO Number)</div>
                          </span>
				  </div>
				  
                </div>
                <div class='priceincart'>
                  <span class='price-margin-right'>
                    <i class=''></i>
                      Discount :
                  </span>
                  <span class='price-font' id="discount">
                  </span>
                </div>
                <br/>
                <div class='priceincart'>
                  <span class='price-margin-right'>
                    <i class='fa fa-truck shipping-truck'></i>
                      Shipping Cost :
                  </span>
                  <span class='price-font' id="shopping-cost">
				  Free
                  </span>
                </div>
                <br/>
                <div class='priceincart'>
                  <span class='price-margin-right'>
                    <i class='fa fa-money total-money'>
                    </i>
                      Tax :
                  </span>
                  <span class='price-font' id="tax">
                  </span>
                </div>
                <br/>
                 <div class='priceincart'>
                  <span class='price-margin-right'>
                    <i class='fa fa-gift lightred_text'>
                    </i>
                      Loyalty Points :
                  </span>
                  <span class='price-font' id="loyalty_points_summary">
                  </span>
                </div>
				<br/>
				<div class='priceincart'>
                  <span class='price-margin-right'>
                    <i class='fa fa-money total-money'></i>
                      Total :
                  </span>
                  <div class='price-font' id="total-shopping-cost"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div id="payment-address" class="col-md-4 col-xs-12">
        <div  class="col-md-12 col-xs-12 padding-align-left padding-align-right ">
          <section class='panel  payment-address-align'>
            <div class='panel-body  padding-align-left padding-align-right padding-align-top' >
              <div class='top-stats-panel'>
                <div id="confirmed-address">
                </div>
              </div>
            </div>
          </section>
       <!--   <section class='panel  payment-address-align'>
            <div class='panel-body  padding-align-left padding-align-right padding-align-top' >
              <div class='top-stats-panel'>
                <div id="discount-voucher">
                	
                </div>
              </div>
            </div>
          </section>-->
        </div>
        
        <div id="payment-option-div"  class="col-md-12 col-xs-12 padding-align-left padding-align-right">
          <section class='panel margin-align-bottom error-head'>
            <div class='panel-body padding-align-bottom padding-align-top padding-align-left padding-align-right' >
              <div id="payment_options">
              </div>
            </div>
          </section>
        </div>
        <div id="hidden-info"  class="hidden"> </div>
      </div>
    </section>
    <h2>Complete</h2>
    <section> </section>
  </div>
</div>
</section>
<script src="dash/js/dash-PurchaseList.js"></script>

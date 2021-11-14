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
<script type="text/javascript" src="rm/js/rm-user-address.js"></script>
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
			<span id="listTitle" class="btn btn-primary buttonColor"></span>
		</div>
	</div>
</div>
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
              <div id="cart-products">
                <table id="cart-products-table" class="table  table-hover general-table">
                  <thead>
                    <tr>
                      <th class="col-md-1">S.No</th>
                      <th class="col-md-2"  >Product </th>
                      <th class="col-md-3"  > Name </th>
                      <th class="col-md-2" >Quantity</th>
                      <th class="col-md-2">Price</th>
                      <th class="col-md-2" >Delete</th>
                    </tr>
                  </thead>
                  <tbody id="cart-products-list-body"  role="alert" aria-live="polite"  aria-relevant="all">
                  </tbody>
                </table>
              </div>
              <div id="cart-product-price">
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
                      <label for="uploadFile" class="btn btn-info btn-xs" id="labelPo">Upload PO</label>
                      <input type='file' name='uploadFile' id='uploadFile'>
                      <div class="help-block">(Maximum file Size 2 MB)</div>
                      <input type="hidden" name="po_mandatory" id="po_mandatory" value="">
                    </span>
                    </span>
                  	<div class="voucher_margin">
					</div>
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
        </div>
        <div id="payment-option-div"  class="col-md-12 col-xs-12 padding-align-left padding-align-right">
          <section class='panel margin-align-bottom'>
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

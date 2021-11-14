<section class="panel">
     <div class="row" align="center">   
            <header class="panel-heading"><b>Configure a New Vendor<b></header>
        </div>
</section>
 <a id='vendor-details-add'  class='col-md-3 btn btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border' ><i class='fa fa-plus'>Add New Vendor</i></a>


<div id='vendor-details-main-div' class='col-md-4'>
  <section class='panel'>
  <div class='panel-body' >
    <div class='top-stats-panel'>
    <span class='col-md-12' >Vendor Details</span>
      <form  id='vendor-details-validate' method='post' class='std'>
        <div class='required col-md-12 vendor-form-margin-top'>
          <input id='vendorName' class='col-md-12 form-control' type='text'  onkeydown='alphabetsOnly(event);' placeholder='Name' name='vendorName'/>
        </div>
        <div class='col-md-12 vendor-form-margin-top'>
          <input  id='vendorGstNo' class='col-md-12 form-control' type='text' placeholder='GST NO' name='vendorGstNo' />
        </div>
        <div  class='col-md-12 vendor-form-margin-top'>
          <input id='vendorPanNo' class='col-md-12 form-control' type='text' placeholder='PAN NO' name='vendorPanNo'  />
        </div>
        <div  class='col-md-12 vendor-form-margin-top'>
          <input id='vendorPhoneNo' class='col-md-12 form-control' type='text' onkeydown='numbersOnly(event);' placeholder='Phone/Mobile NO' name='vendorPhoneNo'  />
        </div>
        
        <div  class=' col-md-12 vendor-form-margin-top' >
          <input id='websiteLink' class='col-md-12 form-control' type='text'   placeholder='Website Link' name='website' />
         </div>
        <div  class='col-md-12 vendor-form-margin-top'>
          <input id='creditDays' class=' col-md-12 form-control' type='text' onkeydown='numbersOnly(event);' placeholder='Credit Days' name='creditDays'  />
          </div>
          <div  class='col-md-12 vendor-form-margin-top' id='fulfillmentCentre'>
          </div>
       <div  class='col-md-12 vendor-form-margin-top'>
          <select id='PaymentMode' class=' col-md-12 form-control color' type='text' name='payment'>
          <option value="">Select Payment Mode</option>
          	 <option value='1'>CASH ON DELIVERY</option>
  			<option value='2'>CHEQUE</option>
 		 	<option value='3'>NEFT/RTGS</option>
  			<option value='4'>EBS</option>
          </select>
          </div>
          <div  class='col-md-12 vendor-form-margin-top'>
          Delivery Available:&nbsp;&nbsp;
          <input type='radio' name='Delivery' value='1'>&nbsp;Yes&nbsp;
			<input type='radio' name='Delivery' value='0'>&nbsp;No
          </div>
         <div  class='col-md-12 vendor-form-margin-top'>
          Replacement Available:&nbsp;&nbsp;
          <input value='1' type='radio' name='Replacement' value=''/>&nbsp;Yes&nbsp;
			<input value='0' type='radio' name='Replacement' value=''/>&nbsp;No
          </div>
          <div  class=' col-md-12 vendor-form-margin-top'>
          Comments:<br>
          <textarea rows='3' id='Comments' class=' col-md-12 form-control' type='text'  placeholder='Comments' name='Comments'>
          </textarea>
        </div>
        <a  id='vendor-detail-save'  class='col-md-5 btn btn-primary vendor-form-margin-top remove-border' onclick="vendorSave();">Save</a>
        <button type="button" id="vendor-detail-edit-save" class="display-none col-md-5 btn btn-primary vendor-form-margin-top remove-border" onclick="vendorEditSave()">Save</button>

			 <a id='vendor-details-Cancel'  class='col-md-5 btn btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border'  >Cancel</a>

      </form>
  </div>
</div>
</section>
</div>


<div id="vendor-address-main-div" class='col-md-4'>
  <section class='panel'>
  <div class='panel-body' >
    <div class='top-stats-panel'>
    <span class='col-md-12' id="vendor-address" >Vendor Address</span>
              <a id='vendor-address-add'  class='col-md-3 btn  btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border' ><i class='fa fa-plus'>ADD</i></a>
				<a id='vendor-address-edit' s class='col-md-3 vendor-address-button btn btn-primary vendor-form-margin-top remove-border'>Edit</a>
      
  </div>
</div>
</section>
</div>


<div id="vendor-poc-main-div" class='col-md-4'>
  <section class='panel'>
  <div class='panel-body' >
    <div class='top-stats-panel'>
    <span id="vendor-poc" class='col-md-12' >Vendor POC</span>
                    <a id='vendor-poc-add'  class='col-md-3 btn btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border' ><i class='fa fa-plus'>ADD</i></a>
				<a id='vendor-poc-edit' s class='col-md-3 vendor-address-button btn btn-primary vendor-form-margin-top remove-border'>Edit</a>

  </div>
</div>
</section>
</div>
 <a id='vendor-details-complete'  onclick="clearForm();" class='col-md-2 btn btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border fa fa-check-circle' ><i class="fa"> Complete</i></a>
 <script type="text/javascript" src="dash/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="scn/js/scn-vendor-form.js"></script>

<script type="text/javascript" src="dash/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="scn/js/scn-bank-details.js"></script>

<div id='vendor-details-main-div' class='col-md-12'>
<div class="col-md-12 text-center panel-heading"><b>Bank Details</b></div>
  <section class='panel col-md-12'>
  <div class='panel-body col-md-4 col-md-offset-4' >
    <div class='top-stats-panel'> 
    
      <form  id='bank-details-validate' method='post' class='std'>
        <div class='required col-md-12 vendor-form-margin-top'>
  <select id='selectVendor' class=' col-md-12 form-control color' type='text' name='selectVendor'  onchange="selectAddress();" >
          	 <option value=''>Select Vendor</option>
          </select>         
         </div>
          <div class='required col-md-12 vendor-form-margin-top'>
  <select id='vendorAddress' class=' col-md-12 form-control color' type='text' name='vendorAddress'  >
          	 <option  value=''>Select Vendor Address</option>
          </select>         
         </div>
        <div class='col-md-12 vendor-form-margin-top'>
          <input  id='bankName' class='col-md-12 form-control' type='text'   placeholder='Bank Name' name='bankName' />
          </div>
           <div  class='col-md-12 vendor-form-margin-top'>
          <input id='bankBranch' class='col-md-12 form-control' type='text'   placeholder='Branch' name='bankBranch'  />
          </div>
           <div  class='col-md-12 vendor-form-margin-top'>
          <textarea id='bankAddress' class='col-md-12 form-control' type='text'   placeholder='Branch Address' name='vendorPanNo'  /></textarea>
          </div>
           <div  class='col-md-12 vendor-form-margin-top'>
          <input id='accountName' class='col-md-12 form-control' type='text'   placeholder='Account Name' name='accountName'  />
          </div>
        
        <div  class=' col-md-12 vendor-form-margin-top' >
          <select id='accountType' class='col-md-12 form-control color' type='text'   placeholder='Account Type' name='accountType' >
           <option value=''>Select Account Type</option>
  			<option value='1'>Savings A/c</option>
 		 	<option value='2'>Current A/c</option>
  			<option value='3'>Credit A/c</option>
          </select>
         </div>
        <div  class='col-md-12 vendor-form-margin-top'>
          <input id='accountNumber' class=' col-md-12 form-control' type='text'   placeholder='Account Number' name='accountNumber'  />
          </div>
       <div  class='col-md-12 vendor-form-margin-top'>
                   <input id='ifsccode' class=' col-md-12 form-control' type='text'   placeholder='IFSC Code' name='ifsccode'  />

          </div>
          <a  id='bank-detail-save'  class='col-md-3 btn btn-primary vendor-form-margin-top remove-border' onclick="saveBankDetails();">Save</a>

			 <a id='bank-details-Cancel'  class='col-md-2 btn btn-primary padding-align-left vendor-lang-add vendor-form-margin-top padding-align-right remove-border' onclick="cancelBankDetails();"  >Cancel</a>

      </form>
  </div>
</div>
</section>
</div>



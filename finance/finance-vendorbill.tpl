<script src="finance/js/finance-purchasebill.js"></script>
<div class="panel">
    <div class="panel-body">
    <div class="row">
      <div class="col-sm-12">
      <header class="panel-heading">Add Purchase Bill</header>
          <section class="panel-body" id="vendor_bill">
                        <div class="col-lg-3"> 
                        <input type="text" class="form-control billPart" placeholder="Vendor Name" id="vendor_name" onkeypress="loadingprocess(1);" name="vendor_name" value="" />
                        <input type="hidden" id="vendor_id" name="vendor_id" value="" />
                         <div id="quickbuy-vendor-not-found" class="pro"></div>
                        <div  class="purchaseBill purchase vendorSearch">Processing........
                            <div class="progress progress-striped active progress-sm">
                                <div style="width:100%; color:#1FB5AD;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success">
                                    <span class="sr-only">100% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-3">
                        <input type="text" class="form-control billPart" placeholder="Bill NO" id="billno" name="billno" value="" />
                    </div>
                       <div class="col-lg-3"> 
                        <input type="text" value="" placeholder="Select date" size="16" id="bill_date" class="form-control form-control-inline input-medium default-date-picker billPart">
                    </div>
                    <div class="col-lg-3"> 
                        <!--<input type="text" value="" placeholder="Select date" size="16" id="bill_date" class="form-control form-control-inline input-medium default-date-picker billPart">-->
                        <select  class="form-control billPart" id="vendor_bill_payment_mode">
                        		<option value="0">Select payment type</option>
                                <option value="1">Cash On Delivery</option>
                                <option value="2">Cheque</option>
                                <option value="3">NEFT</option>
                                <option value="4">Credit</option>
                         </select>
                    </div>
                    
             <!--<div class="col-lg-8">
                    <div class="col-lg-6"> 
                        
                    </div>
                </div>-->
           </section><br/>
                <div class="col-sm-12">
                   <div class="col-lg-4"></div>
                   <div class="col-lg-2"><input type="button" class="btn btn-primary col-lg-12" id="clearfileds" onclick="clearfields(0)" value="Clear"/></div>
                   <div class="col-lg-2"><input type="button" class="btn btn-primary col-lg-12 billPart" id="billdetails" value="Save" onclick="savePurchaseBill();" /></div>
               </div>
           </div> 
         </div>
          <div class="row" style="margin-top:5%">
          <div class="col-sm-12 ">
             <section class="panel-body" id="vendor_bill_detail">
                     <div class="col-lg-5">
                        <input type="text" class="form-control billProductPart" id="vendor_bill_product" name="vendor_bill_product" value="" onkeypress="loadingprocess(2);" placeholder="Product Name"/>
                        <div id="quickbuy-product-not-found" class="pro productNotFound"><span id="product-not-found-span">Product not found.</span></div>
                        <div  class="purchaseBill bill vendorSearch">Processing........
                            <div class="progress progress-striped active progress-sm">
                                <div style="width:100%; color:#1FB5AD;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success">
                                    <span class="sr-only">100% Complete</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_product" name="id_product" value="" />
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control billProductPart" id="vendor_bill_product_qty" name="vendor_bill_product_qty" value="" placeholder="QTY"/>
                    </div>
                      
                     <div class="col-lg-2">
                        <input type="text" class="form-control billProductPart" id="vendor_bill_product_unit_price" name="vendor_bill_product_unit_price" value="" placeholder="Unit Price"/>
                        <span class="help-block">(Tax Excl..)</span>
                    </div>
                    <div class="col-lg-3">
                        <!--<input type="text" class="form-control billProductPart" id="vendor_bill_product_unit_price" name="vendor_bill_product_unit_price" value="" placeholder="Tax"/>-->
                        <select  class="form-control billProductPart tax_rules_group">
                         </select>
                    </div>
              </section><br/>
              <div class="col-sm-12">
               <div class="col-lg-4"> </div>
                <div class="col-lg-4"><input type="button" id="save_purchase_bill_details" class="btn btn-primary billProductPart disabled col-lg-12" onclick="savePurcahseBillDetails();" value="Save" /></div>
                <div class="col-lg-4"><div id="success_add" class="text-success">product added successfuly!</div></div>
           </div>
         </div>
      </div>
  </div>
</div>
 
 
<script src="scn/js/scn-vendorlist.js"></script>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <header class="panel-heading"><b>Vendors List</b></header>
     <div class="panel-body" id="vendorList">
	 
      <div class="panel-body" id="vendorTab">
            <table class="table col-md-12 col-sm-12 table-condensed table-bordered" id="vendorListTab"><!--<table class="table table-hover general-table">-->
              <thead>
                <tr>
                  <th class="serial_no">S.No</th>
                  <th class="table_action">Action</th>
                  <th class="table_name">Name</th>
                  <th class="fixed_width">GST NO</th>
                  <th class="fixed_width">PAN NO</th>
                  <th class="fixed_width">Phone NO</th>
                  <th class="fixed_width">Fulfillment Centre</th>
                  <th class="fixed_width">Payment Mode</th>
                  <th class="fixed_width">Credit Days</th>
                  <th class="fixed_width">Bank Details</th>
                  <th class="fixed_width">Address</th>
                  <th class="fixed_width">POC</th>
                  <th class="fixed_width">Website</th>
                  <th class="fixed_width">Delivery</th>
                  <th class="fixed_width">Replacement</th>
                  <th class="fixed_width">Comments</th>
                 </tr>
              </thead>
           
              <tbody id="vendorTable">
              </tbody>
      
            </table>
        
        </div>
      </div>
     </section>
  </div>
</div>
<div aria-hidden="true" aria-labelledby="showAddress" role="dialog" tabindex="-1" id="showAddress" class="modal fade">
        <div class="modal-dialog popup-width">
          <div class="modal-content col-sm-12" id="address_popup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" >Vendor Address <span id="order_id"></span></h4>
            </div>
             
             <div class="row" id="addressSide">
              <div class="col-sm-4" id="aliseAddress"></div>
              <div class="col-sm-8" >
              	<div id="detailEditAddress">
                	<form id="editVendor">
                    	
                        <input type="text" placeholder="Name Of The Address" value="" id="alise" name="alise" class="form-control marginTopBottom" />
                        <textarea id="address1" name="address1" class="form-control marginTopBottom" placeholder="Address"></textarea>
                        <input type="text" placeholder="City" value="" id="city" name="city" class="form-control marginTopBottom" />
                        <select class="form-control marginTopBottom input-sm m-bot15" onchange="getState(0)" id="country"></select>
                        <select class="form-control marginTopBottom input-sm m-bot15" id="state"></select>
                        <input type="text" placeholder="Pincode" value="" id="pincode" name="pincode" class="form-control marginTopBottom" />
                        <input type="text" placeholder="Landmark" value="" id="landmark" name="landmark" class="form-control marginTopBottom" />
                        <input type="text" placeholder="Phone" value="" id="phone" name="phone" class="form-control marginTopBottom" />
                        <input type="text" placeholder="fax" value="" id="fax" name="fax" class="form-control marginTopBottom" />
                        <input type="text" placeholder="Working Days" value="" id="WorkingDays" name="WorkingDays" class="form-control marginTopBottom" />
                        <input type="text" placeholder="Working Hours" value="" id="WorkingHours" name="WorkingHours" class="form-control marginTopBottom" />
                        <div class="form-control marginTopBottom">
                            Delivery Available:&nbsp;&nbsp;
                            <input type="radio" value="1" id="deliveryYes" name="AddressDelivery">&nbsp;Yes&nbsp;
                            <input type="radio" value="0" id="deliveryFalse" name="AddressDelivery">&nbsp;No
                        </div>
                        <div class="form-control marginTopBottom">
                            Default Address:&nbsp;&nbsp;
                            <input type="radio" value="1" id="defaultYes" name="defaultAddress">&nbsp;Yes&nbsp;
                            <input type="radio" value="0" id="defaultNo" name="defaultAddress">&nbsp;No
                        </div>
                         <textarea type="text" class=" col-md-12 form-control marginTopBottom" id="comments" rows="2"></textarea>
                     </form>
                </div>
              </div>
            </div>
             
            <div class="modal-footer">
               <button  class="btn btn-primary" onclick="saveEditValue()" type="button">Save</button>
               <button data-dismiss="modal" class="btn btn-warning" type="button">Cancel</button>
               <!--<button style="float:left" class="btn btn-primary  margin" onclick="clear(1)" type="button">Clear Form</button>-->
               <input type="hidden" name="id_vendor" id="id_vendor" value="" />
               <input type="hidden" name="id_address" id="id_address" value="" />
            </div>
          </div>
        </div>
      </div>
      <div aria-hidden="true" aria-labelledby="showPoc" role="dialog" tabindex="-1" id="showPoc" class="modal fade">
        <div class="modal-dialog popup-width">
          <div class="modal-content col-sm-12" id="poc_popup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" >Vendor Point Of Contact <span id=""></span></h4>
            </div>
              <div class="row">
              <div class="col-sm-4 " id="pocName"></div>
              <div class="col-sm-8 " id="pocDetails">
              	<div id="editPoc">
                 	<input type="text" placeholder="POC Name" value="" id="firstname" name="firstname" class="form-control marginTopBottom" />
                    <input type="text" placeholder="Designation" value="" id="designation" name="designation" class="form-control marginTopBottom" />
                    <input type="text" placeholder="Phone"  value="" id="phone1" name="phone1" class="form-control marginTopBottom" />
                    <input type="text" placeholder="Mobile" value=""  id="mobile" name="mobile" class="form-control marginTopBottom" />
                	<select class="form-control marginTopBottom input-sm m-bot15" id="language"></select>
                    <button  class="btn btn-info btn-xs " onclick="saveLangValue()" type="button">Add Language</button>
                    <div id="poc_lang"></div>
                    <input type="text" placeholder="Email" value="" id="email" name="email" class="form-control marginTopBottom" />
                    <select class="form-control marginTopBottom input-sm m-bot15" id="address_poc"></select>
                    <div class="form-control marginTopBottom">
                        Smart Phone User:&nbsp;&nbsp;
                        <input type="radio" value="1" id="smartphoneYes" name="Smartphone">&nbsp;Yes&nbsp;
                        <input type="radio" value="0" id="smartphoneNo" name="Smartphone">&nbsp;No
                    </div>
                    <div class="form-control marginTopBottom">
                        Default POC:&nbsp;&nbsp;
                        <input type="radio" value="1" id="defaultPocYes" name="defaultPoc">&nbsp;Yes&nbsp;
                        <input type="radio" value="0" id="defaultPocNo" name="defaultPoc">&nbsp;No
                    </div>
                    <textarea type="text" class=" col-md-12 form-control marginTopBottom" id="pocComments" rows="2"></textarea>
                </div>
              </div>
            </div>
             
            <div class="modal-footer Reorder">
              <button  class="btn btn-primary" onclick="savePocEditValue()" type="button">Save</button>
              <button data-dismiss="modal" class="btn btn-warning" type="button">Close</button>
              <!--<button style="float:left" class="btn btn-primary  margin" onclick="clear(2)" type="button">Clear Form</button>-->
              <input type="hidden" name="id_vendor" id="id_poc" value="" />
              <input type="hidden" name="id_vendor" id="id_vendor_poc" value="" />
            </div>
          </div>
        </div>
      </div>
      <div aria-hidden="true" aria-labelledby="showPoc" role="dialog" tabindex="-1" id="showBank" class="modal fade">
        <div class="modal-dialog popup-width">
          <div class="modal-content col-sm-12" id="bank_popup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" >Edit:Vendor Bank Details <span id=""></span></h4>
            </div>
              <div class="row">
              <div class="col-sm-4 " id="BankName"></div>
              <div class="col-sm-8 " id="bankDetails">
              	<div id="editBank">
         			
                 	
                    <input  id='selectVendor' class="form-control marginTopBottom" type='text' readonly="readonly"   name='selectVendor' />
                    <select id='vendorAddress' class="form-control marginTopBottom input-sm m-bot15" type='text' name='vendorAddress'  >
                    	<option  value=''>Select Vendor Address</option>
                    </select>
                    <input  id='bankName' class="form-control marginTopBottom" type='text'   placeholder='Bank Name' name='bankName' />
                    <input id='bankBranch' class="form-control marginTopBottom" type='text'   placeholder='Branch' name='bankBranch'  />
                    <textarea id='bankAddress' class="form-control marginTopBottom" type='text'   placeholder='Branch Address' name='vendorPanNo'  /></textarea>
                    <input id='accountName' class="form-control marginTopBottom" type='text'   placeholder='Account Name' name='accountName'  />
                    <select id='accountType' class="form-control marginTopBottom" type='text'   placeholder='Account Type' name='accountType' >
                      <option value=''>Select Account Type</option>
                      <option value='1'>Savings A/c</option>
                      <option value='2'>Current A/c</option>
                      <option value='3'>Credit A/c</option>
                    </select>
                    <input id='accountNumber' class="form-control marginTopBottom" type='text'   placeholder='Account Number' name='accountNumber'  />
                    <input id='ifsccode' class="form-control marginTopBottom" type='text'   placeholder='IFSC CODE' name='ifsccode'  />
                </div>
              </div>
            </div>
             
            <div class="modal-footer Reorder">
              <button  class="btn btn-primary" onclick="saveBankEditValue()" type="button">Save</button>
              <button data-dismiss="modal" class="btn btn-warning" type="button">Close</button>
              <!--<button style="float:left" class="btn btn-primary  margin" onclick="clear(2)" type="button">Clear Form</button>-->
              <input type="hidden" name="id_bank" id="id_bank" value="" />
              <input type="hidden" name="id_bank_vendor" id="id_bank_vendor" value="" />
            </div>
          </div>
        </div>
      </div>
 <script>
function vendorListSearch(table_id)
{   
  var oTable = $('#'+table_id).dataTable({
    scrollY:500,
    scrollX:100,
    fixedColumns:   {
            leftColumns: 3
        },
    "autoWidth": true,    
    "aLengthMenu": [
      /*[25, 50, 100, -1],
      [25, 50, 100, "All"]*/ // change per page values here
      [10, 50, 100, -1],
      [10, 50, 100, "All"]
    ],
    // set the initial value
    "iDisplayLength": 10,
    
    
    "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
    "sPaginationType": "bootstrap",
    "oLanguage": {
      "sLengthMenu": "_MENU_ records per page ",
      "oPaginate": {
        "sPrevious": "Prev",
        "sNext": "Next"
      }
    },      

    "aoColumnDefs": [{
        'bSortable': true,
        'aTargets': [0]
      }
    ],
    "fnFooterCallback": function (nRow, aasData, iStart, iEnd, aiDisplay) {

        var columnas = [5]; //the columns you wish to add            
        for (var j in columnas) 
        {
            var columnaActual = columnas[j];

            var total = 0;
            for (var i = iStart; i < iEnd; i++) 
            {
                var str = aasData[aiDisplay[i]][columnaActual];
                str = str.replace("Rs.",""); 
                var res = str.replace(",",""); 
                        total = total + parseFloat(res);
        
            }

            if(profile != 6)
              $($(nRow).children().get(columnaActual)).html(moneyFormat(total));
            else
              $($(nRow).children().get(columnaActual)).html(total);
        } 
    }
    
  });
           
}   
</script>
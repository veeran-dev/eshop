<script src="finance/js/finance-purchasebill.js"></script>

<div class="panel">
    <div class="panel-body">
    <header class="panel-heading">View Purchase Bill</header>
      <div class="panel-body">
        <form id="form_fpp_excel" name="form_invoice" action="finance-pending-payment-excel.php" autocomplete="off" method="post">
          <div class="col-md-3">
            <input type="text" class="form-control billPart" placeholder="Vendor Name" id="vendor_name" onkeypress="loadingprocess(1);" name="vendor_name" value="" 
            />
            <input type="hidden" id="vendor_id" value="">
          </div>
          <div class="form-group col-md-7 col-sm-7 col-xs-9 col-lg-4">
             <span class="form-group col-md-3 col-sm-6 col-xs-6 col-lg-5">
                  <input type="text" id="fpp_from" name="fpp_from" placeholder="From" class="datepicker form-control">
             </span>
              <span class="form-group col-md-3 col-sm-6 col-xs-6 col-lg-5">
                  <input type="text" id="fpp_to" name="fpp_to" placeholder="To" class="datepicker form-control">
              </span>
          </div>
      </form>
      <button id="searchPurchaseBill" class="btn btn-primary clrbtn col-xs-offset-4 col-sm-offset-4 col-md-offset-0 col-lg-offset-0">Search</button>
      <button id="resetPurchaseBill" onclick='resetPurchaseBill();' class="btn btn-danger clrbtn col-xs-offset-4 col-sm-offset-4 col-md-offset-0 col-lg-offset-0">Reset</button>
      </div>
      
    </div>
</div> 
<div class="panel {if !isset($purchaseBill)}successSearch{/if}" id="viewPurchaseBill">
    <div class="panel-body">
    <section class="panel">
        <table class="table table-striped table-hover table-bordered " id="purchasebils">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Bill NO</th>
                    <th>Bill Date</th>
                    <th>Vendor Name</th>
                    <th>Payment Mode</th>
                    <th>Total(Tax Excl.)</th>
                    <th class="action">Action</th>
             	</tr>
            </thead>
            <tbody id="bill_view">
            {if isset($purchaseBill)}
            {assign var=i value=1}
            {foreach $purchaseBill as $bill}
            <tr class='cur-poi' id='purchase_bill_{$bill.billno}'>
              <td id='{$bill.billno}' class='purchase-bill-row-no' >{$i}</td>
              <td>
                <input class='noBorder' readonly type=text id='bill_no_{$bill.billno}' value="{$bill.billno}">
              </td>
              <td>
                <input class='noBorder disabled' readonly id='bill_date_{$bill.billno}' value='{$bill.bill_date}'/>
              </td>
              <td id='vendor_{$bill.billno}' >{$bill.name}</td>
              <td id='payment_{$bill.billno}' >{if $bill.id_payment==1}COD {else if $bill.id_payment==2}Cheque{else if $bill.id_payment==3}NEFT{else}Credit{/if}</td>
              <td id='total_{$bill.billno}'  class='fa fa-inr col-lg-2 totalPayment_{$bill.billno}' id='total_{$bill.billno}'>{$bill.total}</td>
              <td class='purcahseBillListTd '>
                <input type='hidden' id='delete_row_"+i+"'  value='"+i+"' />
                <span class='fa fa-save col-lg-1 savePart_{$bill.billno}' style='display:none' onclick='updateBillDetails("{$bill.billno}");' ></span>
                <span class='fa fa-reply col-lg-1 savePart_{$bill.billno}' style='display:none' onclick='cancelBillDetails("{$bill.billno}");' ></span>
                <span class='fa fa-eye col-lg-1 editPart_{$bill.billno}' onclick='openBillDetails("{$bill.id_vendor}","{$bill.billno}");' ></span>
                <span id='edit_{$bill.billno}' class='fa fa-pencil-square-o col-lg-1 editPart_{$bill.billno}' onclick='editDateBill("{$bill.billno}");'></span>
                <span id="{$bill.billno}" class='fa fa-trash-o col-lg-1 editPart_{$bill.billno}' onclick='deleteBill("{$bill.id_vendor}",0,0,0,0,"+i+",this);'></span>
                </td>
              </tr>
              {assign var=i value=$i+1}
              {/foreach}
              {/if}
            </tbody>
        </table>
     </section>
     <!--pop up for bill details -->
     <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="purchase_bill_details" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title" id="modal-heading">Purchase Bill Details - Bill No <span id="head_bill_no"></span></h4>
          </div>
            <div class="modal-body" id="statusorders"> 
                <table class="table general-table"  ><!--<table class="table table-hover general-table">-->
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Bill No</th>
                            <th>Bill Date</th>
                            <th>Product Name</th>
                            <th>QTY</th>
                            <th>Unit Price</th>
                            <th>Total Price(Tax Excl..)</th>
                            <th>Tax</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bill_details"></tbody>
                </table>
            </div>
          <div class="modal-footer">
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-8">Total (Tax Excl): &nbsp;&nbsp;<b><span id="total_exc">0</span></b></div>
            <!--  <div class="col-lg-6 col-md-5 col-sm-5 col-xs-5">Total (Tax Incl):&nbsp;&nbsp;<b><span id="total_inc">0</span></b></div> -->
             <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                
                
                
          </div>
        </div>
      </div>
    </div>
     
     
  </div>
</div>
<!-- <script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="dash/js/data-tables/DT_bootstrap.js"></script>-->
 <script type="text/javascript">
    $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
    easySearch("purchasebils");
    $(document).ready(function(){
      $("#fpp_from").val(window.vpb_fpp_from);
      $("#fpp_to").val(window.vpb_fpp_to);
      $("#vendor_id").val(window.vpb_vendor_id);
      $("#vendor_name").val(window.vpb_vendor_name);
  });
 </script>
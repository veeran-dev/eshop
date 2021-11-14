

<div id="purchaselist">
   <!--<div class="col-sm-12"> -->
        <div class="col-sm-4"> 
          <section class="margin-align-bottom">
            <!--<img src="dash/images/start.png" />-->
            <div class="btn-group selectlist">
              <button class="btn btn-primary buttonColor dropdown-toggle padding20 purchase-tip" id="open_list" type="button" data-toggle="dropdown">
                <span id="listTitle">Open a List</span><span class="caret cust_caret"></span>
              </button>
              <ul role="menu" class="dropdown-menu" id="lists"></ul>
             </div>
           </section>
           <div class="text-muted">Click "Open a List" to Continue</div>
        </div>

    <!--</div>-->
    <!--Start of products in purchase list-->
    <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <section class="" id="list_of_products" style="display:none;">
              <header class="panel-heading no-border" id="list_heading" style="display:none">Products of purchase list</header>
              <table id="pur_list_products_head">
                  <thead>
                    <tr style="width: 100%;border-bottom:1px solid #ccc;">
                      <th style="width: 12%;padding: 7px;">Image</th>
                      <th style="width: 30%;padding: 7px;">Description</th>
                      <th style="width:25%;"><input type="text" id="search-pur-list" placeholder="Search from List" class="form-control"/></th>
                      <th style="width: 15%;padding: 7px;" class="price ">Average Consumption</th>
                      <th style="width: 10%;padding: 7px;" class="price ">Quantity</th>
                      <th style="width: 10%;padding: 7px;" class="price ">Price</th>
                    </tr>
                  </thead>
              </table>
              <div id="product_list" class="panel">
                <table class="table  table-hover general-table table-striped" id="pur_list_products">

                  <tbody id="listofproducts">
                  </tbody>
                </table>
              </div>        
             <!--<input type="button" id="next_page"  class="btn btn-primary buttonColor kob_button_padding-override floatright test" value="NEXT" onclick="next();"/>-->
             <div class="row"></div>
             <div class="row">
             	 <div class="col-sm-12">
              		<input type="button"  class="btn btn-primary buttonColor kob_button_padding-override floatright" value="Click Here to Add Items" onclick="addToSummary(0,0)"/>
                 </div>
			</div>
            </section>
                          
            <section class="purchaseStaticMsg"  id="start_msg">
              <div><span class="lead"></span></div>
            </section>
          </div>
          
        </div>
    </div>
    <!--End of total details-->
    <input type="hidden" value="0" id="list_id" />
    <input type="hidden" value="2" id="save_status" />
     
  </div>
  
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="alert_msg" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Alert !!!</h4>
      </div>
      <div class="modal-body"> <span id="id_alert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>
<script src="dash/js/dash-PurchaseList.js"></script>
 
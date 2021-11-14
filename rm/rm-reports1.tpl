<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
		  <button class="btn btn-primary buttonColor dropdown-toggle padding" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
		 </div>
	</div>
</div>
</div>
<div class="row" >
  <div class="col-sm-11 ">
    <div id="history_report" style="display:none; height:420px;">
      <section class="panel">
        <!--<header class="panel-heading no-border" id="list_heading"> Reports</header>
        <div id="loading_img" style="margin-left:45%;padding-top:13%;pading-bottom:12%; display:none" >
        	<img src="dash/images/loader1.gif"/>
         </div>-->
		 
        <div id="cus_spinContainer"></div>
		
		<div  id="spinContainer_1"></div> 
		 <div  id="spinContainer_2"></div> 
		 <div  id="spinContainer_3"></div> 
		 <div  id="spinContainer_4"></div> 
      </section>
    </div>
    <div id="categories_report" style="display:none; height:420px;">
      <section class="panel">
        <!--<header class="panel-heading no-border" id="list_heading"> Reports</header>-->
        <div id="chartContainer"></div>
		<div style="display:none;" id="chartContainer_1"></div> 
		 <div style="display:none;" id="chartContainer_2"></div> 
		 <div style="display:none;" id="chartContainer_3"></div> 
		 <div style="display:none;" id="chartContainer_4"></div> 
        
      </section>
    </div>
    <div id="topproducts_report" style="display:none;height:420px;">
      <section class="panel">
        <div id="barChartContainer"></div>
		<div style="display:none;" id="barChartContainer_1"></div> 
		<div style="display:none;" id="barChartContainer_2"></div> 
		<div style="display:none;" id="barChartContainer_3"></div> 
		<div style="display:none;" id="barChartContainer_4"></div> 
      </section>
    </div>
    <div id="locationBasedReport_div" style="display:none;height:420px;">
      <section class="panel">
		<div id="locationBasedReport"></div>
        <div style="display:none;" id="locationBasedReport_1"></div> 
		<div style="display:none;" id="locationBasedReport_2"></div> 
		<div style="display:none;" id="locationBasedReport_3"></div> 
		<div style="display:none;" id="locationBasedReport_4"></div>
      </section>
    </div>
	<div id="top_10_product_in_cate_div" style="display:none;height:420px;">
      <section class="panel">
		<div id="top_10_product_in_cate"></div>
        <div style="display:none;" id="top_10_product_in_cate_1"></div> 
		<div style="display:none;" id="top_10_product_in_cate_2"></div> 
		<div style="display:none;" id="top_10_product_in_cate_3"></div> 
		<div style="display:none;" id="top_10_product_in_cate_4"></div>
      </section>
    </div>
  </div>
</div>

<div id="address_filter" style="display:none;" >
    <div class="col-sm-3">
        <section class=" ">
            <div class="panel-body">
            <select id="addressId" onchange="durationReport(0)" class="form-control ">
            <option value="0" selected="selected">All Address</option>
            </select>
             </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-sm-11">
	 
		<section style="display:none;"  class="repo_filter col-sm-3">
			<div class="panel-body">
				<select id="orderid" onchange="durationReport(0,0);" class="form-control ">
					<option value="0" selected="selected">All Orders</option>
				</select>
			 </div>
		</section>
		<section style="display:none;"  class="repoCategoryFilter col-sm-3">
			<div class="panel-body">
				<select id="category_id" onchange="durationReport(0,0);" class="form-control ">
					<option value="0" selected="selected">--Select Category--</option>
				</select>
			 </div>
		</section>
 		<section class="col-sm-9">
			<div class="panel-body staticButtons">
				<button class="btn btn-danger kob_button" onclick="durationReport(4,0);" type="button">All</button>
				<button class="btn btn-danger kob_button" onclick="durationReport(1,0);" type="button">Last 3 Months</button>
				<button class="btn btn-danger kob_button" onclick="durationReport(2,0);" type="button">Last 6 Months</button>
				<button class="btn btn-danger kob_button" onclick="durationReport(3,0);" type="button">Last 1 Year</button>
				<button class="btn btn-primary" id="pdfclick" onclick="exportReport();" type="button">Export as PDF</button>
			   
			</div>
		</section>
    </div>
</div>
<img src="http://localhost/kobstereshop/img/logo_invoice.jpg"  style="display:none" id="kobster_logo"/>
 		 <canvas id="report_logo" style="display:none"></canvas>
		 <canvas id="cus_logo" style="display:none"></canvas>

<script type="text/javascript" src="dash/js/dash-reports.js"></script>
<script type="text/javascript" src="dash/js/jspdf.min.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	getCustomerList(6);
});
</script>
 

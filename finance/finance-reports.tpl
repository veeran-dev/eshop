<div id="pick-customer" class="row" style="display:none">
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
		 
        <div id="spinContainer"></div>
		
		<div  id="spinContainer_1"></div> 
		 <div  id="spinContainer_2"></div> 
		 <div  id="spinContainer_3"></div> 
		 <div  id="spinContainer_4"></div> 
      </section>
    </div>
    <!--<div id="categories_report" style="display:none; height:420px;">
      <section class="panel">-->
        <!--<header class="panel-heading no-border" id="list_heading"> Reports</header>-->
        <!-- <div id="chartContainer"></div>
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
</div>-->
<div class="row">
    <div class="col-sm-11">
	 
		<!--<section style="display:none;"  class="repo_filter col-sm-3">
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
		</section>-->
 		<section class="col-sm-9">
			<div class="panel-body staticButtons">
				<button class="btn btn-danger kob_button" onclick="financeDuractionReport(4);" type="button">All</button>
				<button class="btn btn-danger kob_button" onclick="financeDuractionReport(1);" type="button">Last Months</button>
				<button class="btn btn-danger kob_button" onclick="financeDuractionReport(2);" type="button">Last Quarter</button>
				<button class="btn btn-danger kob_button" onclick="financeDuractionReport(3);" type="button">Last 1 Year</button><br/><br/>
				<div >
 					<div class="col-md-8 col-xs-8 col-lg-8 col-sm-8">
						<div data-date-format="mm/dd/yyyy" data-date="13/07/2013" class="input-group input-large">
							<span class="input-group-addon">From</span>
							<input type="text" name="from_date" id="from_date" class="form-control dpd1">
							<span class="input-group-addon">To</span>
							<input type="text" name="to_date" id="to_date"  class="form-control dpd2">
						</div>
						<span class="help-block">Select date range</span>
					</div>
				</div>
				<button class="btn btn-primary" id="pdfclick" onclick="financeDuractionReport(5);" type="button">Search</button>
			   
			</div>
		</section>
		
    </div>
</div>
<script type="text/javascript" src="finance/js/finance-report.js"></script>
<!--<img src="img/logo_invoice.jpg"  style="display:none" id="kobster_logo"/>
<img src=""  style="display:none" id="customer_logo"/>
 <canvas id="report_logo" style="display:none"></canvas>
<canvas id="cus_logo" style="display:none"></canvas>

<script type="text/javascript" src="dash/js/dash-reports.js"></script>
 <script type="text/javascript" src="dash/js/jspdf.min.js"></script>-->
 

 

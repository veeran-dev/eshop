
<script type="text/javascript" src="scn/js/scn-reports.js">
</script>
<div class="row" >
  <div class="col-sm-12">
    <div id="history_report" class="display-none">
      <header class="panel-heading m-bot20">Vendor Performance Report</header>
      <form class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-6">
            <label for="scn-vendor-list-select" class="col-sm-4 control-label">Search a Vendor :</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="scn-vendor-list-select" placeholder="Please type key to search vendor.">
            </div>
          </div>
          <div class="col-sm-6 filter-block display-none">
            <div class="col-sm-4">
            <input type="text" name="vendor-perform-date-from" id="vendor-perform-date-from" class="form-control" placeholder="From Date" />
            </div>
            <div class="col-sm-4">
              <input type="text" name="vendor-perform-date-to" id="vendor-perform-date-to" class="form-control" placeholder="To Date" />
            </div>
            <div class="col-sm-4 filter-block-btns">
            </div>
          </div>
        </div>
      </form>
      <section class="panel">
        <div id="spinContainer" class="display-none">
        </div>
      </section>
    </div>
    <div id="topvendors_report" class="display-none">
    <header class="panel-heading m-bot20">Top Ten Vendors Report</header>
    <div class="m-bot20 col-sm-4">
      <select class="form-control" id="fulFillmentCentre" onchange="topVendors()"></select>
      <div class="help-block">Note:- Report duration: Last 6 months.</div>
    </div>
    <div class="m-bot20 col-sm-2">
      <input type="text" name="top-ven-date-from" id="top-ven-date-from" class="form-control" placeholder="From Date" />
    </div>
    <div class="m-bot20 col-sm-2">
      <input type="text" name="top-ven-date-to" id="top-ven-date-to" class="form-control" placeholder="To Date"/>
    </div>
    <button type="button" class="btn btn-primary" onclick="topVendors()">Submit</button>
    <button type="button" class="btn btn-default" onclick="reports(3)">Reset</button>
    <div class="col-sm-12">
      <section class="panel">
        <div id="barChartContainer">
        </div>
      </section>
    </div>
    </div>
  </div>
</div>
 
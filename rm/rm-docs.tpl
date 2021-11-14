<div class="panel panel-default" id="dwnld-docs">
  <div class="panel-heading">Download DR / Invoice</div>
  <div class="panel-body">    
    <div class="container">
      <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#home">Delivery Receipt</a></li>
        <li><a data-toggle="pill" href="#menu1">Invoice Copy</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" class="form-control" id="dr" placeholder="Enter DR Number" />
            </div>
            <div class="col-md-6">
              <button class="btn btn-primary" onclick="downloadDocs(1)">Search</button>
            </div>
            <div id="dwnldDr" class="col-md-6 float-right">          
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane fade">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" class="form-control" id="invoice" placeholder="Enter Invoice Number" />
            </div>
            <div class="col-md-6">
              <button class="btn btn-primary" onclick="downloadDocs(2)">Search</button>
            </div>
            <div id="dwnldInv" class="col-md-6 float-right">          
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  #dwnld-docs .nav{
    margin: 1% 30%;
  }
</style>

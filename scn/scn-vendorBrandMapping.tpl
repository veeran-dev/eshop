
<script type="text/javascript" src="scn/js/scn-vendor-product-map.js"></script>

<div class="col-md-12" >
  <section class="panel" >
    <header class="panel-heading no-border white" id="list_heading">Brand Vendor Mapping</header>
	<div class="text-muted change"> Maps the vendor based on brand of the products they sell</div>
	</section>
</div>
<div class="row col-md-3">
  <div class="col-md-12">
    <section class="panel">
      <div class='body padding-align-left padding-align-right' >
        <input type="text" placeholder="Vendor Name" id="vendor-name" class="form-control border-color-black"/>
      </div>
    </section>
  </div>
  <div class="col-md-12">
    <section class="panel">
      <div class='body' >
        <select id="vendor-address" class="form-control border-color-black selecttext">
          <option value=''>Select Vendors Address</option>
        </select>
      </div>
    </section>
  </div>
  <div class="col-md-12">
    <section class="panel">
      <div class='body' >
        <select id="vendor-poc" class="form-control border-color-black selecttext" >
          <option value=''>Select Vendors POC</option>
        </select>
      </div>
    </section>
  </div>
  <div class="col-md-12">
    <section class="panel">
      <div class='body' >
        <select id="vendor-type" class="form-control border-color-black selecttext" >
         <option value='1'>Select Vendors Type</option>
         <option class='col-md-12' value='1'>DISTRIBUTOR</option>
         <option class='col-md-12' value='2'>RESELLER</option>
         <option class='col-md-12' value='3'>MANUFACTURER</option>
        </select>
      </div>
    </section>
  </div>
</div>
  <div class="col-md-4">
    <section class="panel">
      <div class='body' >
        <input type="text" placeholder="Brand Name" id="brand-name" class="form-control border-color-black"/>
      </div>
    </section>
  </div>
        <a   id="brand-map-add-button" class="col-md-1 btn btn-primary map-add-button" >ADD</a>
   <div class="col-md-4">
    <section class="panel">
      <div class='panel-body' >
            <div id="brand-vendor-table-list" >

			<table id="brand-vendor-table"   class="table col-md-12  table-hover general-table ">
				<thead>
				<tr >
                <th  >Product Name </th>
                </tr>
                </thead>
                <tbody id="vendor-brand-list-body" role="alert" aria-live="polite"  aria-relevant="all">
      
                </tbody>
                </table> 
                </div> 
                        <a   id="brand-map-Clear-button" class="col-md-2 btn btn-primary">Clear</a>
                        <a   id="brand-map-Save-button" class="col-md-2 btn btn-primary map-Save-button" >Save</a>

    
       </div>
    </section>
  </div>
</div> 
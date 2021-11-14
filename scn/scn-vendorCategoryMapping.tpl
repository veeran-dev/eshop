<script type="text/javascript" src="scn/js/scn-vendor-product-map.js"></script>

<div class="col-md-12" >
  <section class="panel" >
    <header class="panel-heading no-border white" id="list_heading">Category Vendor Mapping</header>
		<div class="text-muted change"> Maps the vendor based on categories</div>
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
        <select id="vendor-poc" class="form-control border-color-black selecttext">
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
        <input type="text" placeholder="Category Name" id="category-name" class="form-control border-color-black"/>
      </div>
    </section>
  </div>
        <a   id="category-map-add-button" class="col-md-1 btn btn-primary map-add-button" >ADD</a>
   <div class="col-md-4">
    <section class="panel">
      <div class='panel-body' id="category-vendor-table-div" >
            <div id="product-vendor-table-list" >

			<table id="category-vendor-table"   class="table col-md-12  table-hover general-table ">
				<thead>
				<tr >
                <th  >Product Name </th>
                </tr>
                </thead>
                <tbody id="vendor-category-list-body" role="alert" aria-live="polite"  aria-relevant="all">
      
                </tbody>
                </table>  
                </div>
                        <a   id="category-map-Clear-button" class="col-md-2 btn btn-primary">Clear</a>
                        <a   id="category-map-Save-button" class="col-md-2 btn btn-primary map-Save-button" >Save</a>

    
       </div>
    </section>
  </div>
</div> 
    <div class="">
        <div class="col-sm-12">
          
			<div class="row from-group">
				<div class= "padding0">
					<!--<select id="product_categories" onchange="filterCategoryList();" style="width: 300px" class="form-control">-->
					<div class="" > 
						  <div class="margin-align-bottom margin-align-bottom-override">
							 <div class="btn-group selectlist selectlist-override">
							  <button class="btn btn-primary buttonColor dropdown-toggle purchase-tip custom_button cataloguelist-searchbutton" id="cat_open_list" type="button" data-toggle="dropdown">
								<span id="listTitle">All Category</span><span class="caret cust_caret"></span>
							  </button>
							  <ul role="menu" class="dropdown-menu" id="product_categories"></ul>
							 </div>
							 <input type="text" class="form-control cataloguelist-searchfield" id="search_rate_contract" placeholder="Search for products (Ex: pencils, Paper)" name="search_rate_contract" value="" /><button id="cat_search_button" onclick="search_rate_contract_products();" class="fa fa-search btn btn-primary btn-sm custom_button cataloguelist-searchbutton"></button>

						   </div>
 						</div>
 				<!-- </select> -->
				</div>
				<!-- <div class= "padding0" >
					
				</div> -->
				<!-- <div class= "col-lg-1 padding0" >
					
				</div> -->
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
				  <!--<header class="panel-heading no-border" id="list_heading" >List Of Products</header>-->
					<table id="pur_list_products_head" >
					<thead>
					<tr style="width: 100%;border-bottom:1px solid #ccc;">
					<th style="width: 12%;padding:7px;">Image</th>
					<th style="width: 30%;padding: 7px;">Description</th>
					<!--<th style="width:25%;"><input type="text" id="search-pur-list" placeholder="Search from List" class="form-control"/></th>-->
					<th style="width: 15%;padding: 7px;" class="price ">Average Consumption</th>
					<th style="width: 10%;padding: 7px;" class="price ">Quantity</th>
					<th style="width: 10%;padding: 7px;" class="price ">Price</th>
					</tr>
					</thead>

					</table>
					<div id="category_product_list" class="panel">
						<table class="table  table-hover general-table table-striped" id="category_list">
							<tbody id="catalogue_list"> </tbody>
						</table>

					</div>     
					 <!--<input type="button" id="next_page"  class="btn btn-primary buttonColor kob_button_padding-override floatright test" value="NEXT" onclick="next();"/>-->
					 <div class="row"></div>
					 <div class="row">
						 <div class="col-sm-12">
							<input type="button"  class="btn btn-primary buttonColor kob_button_padding-override add-items-button floatright " value="Click Here to Add Items" onclick="addToSummary(0,0)"/>
						 </div>
					</div>
					</section>
							  
					<section class="purchaseStaticMsg"  id="start_msg">
					  <div><span class="lead"></span></div>
					</section>
				</div>
			</div>
          
       
    </div>
<script src="dash/js/dash-catalogue.js"></script>
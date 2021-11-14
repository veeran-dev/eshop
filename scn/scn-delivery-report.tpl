<div class="row">
    <div class="panel-body">
            <header class="rm_heading">
                Delivery Performance Report
            </header>
            <div class="padding10"></div>
            <div class="col-md-12 text-center padding5">
	            <form class="form-inline" action="" onsubmit="filterRequests(1); return false;" id="box-filter-submit">
	              <div class="form-group">
	                    <input type="text" class="form-control" id="dr-from-date" placeholder="From Date">
	                    <input type="text" class="form-control" id="dr-to-date" placeholder="To Date">
	              </div>
				  
					<button type="submit" class="btn btn-primary cur-poi" title="Filter data by specific">Filter</button>
	            </form>
	        
				<div class="padding5"></div>
            	{if isset($result) && $result != ""}
            	<table class="table table-bordered">
            		<thead>
            			<tr>
            				<th><span class="padding5">Fulfilment Center</span></th>
            				<th><span class="padding5">Total Orders</span></th>
							<th><span class="padding5">On-Time Delivery</span></th>
							<th><span class="padding5">Delayed Delivery</span></th>
							<th><span class="padding5">Success Percentage</span></th>
							<th><span class="padding5">Download</span></th>
            			</tr>
            		</thead>
            		<tbody class="panel">
						{foreach from=$result item=row}
							<tr>
								<td align="center">{$row['fc']}</td>
								<td align="center">{$row['total']}</td>
								<td align="center">{$row['yeses']}</td>
								<td align="center">{$row['nos']}</td>
								<td align="center">{(($row['yeses']/$row['total'])*100)|string_format:"%.2f"} %</td>
								<td align="center">
									<form onSubmit="generatePerReport({$row['id_fulfillment_centre']}); return false;"  method="post">
										<input type="submit" name="download_report" value="Download"/>
									</form>
									
							</tr>
						{/foreach}
            		</tbody>
            	</table>
            	{/if}
            </div>
    </div>
</div>


<script type="text/javascript" src="scn/js/scn-delivery-report.js"></script>
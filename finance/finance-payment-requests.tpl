<div class="row">
        <div class="panel-body">
                <div class="text-center panel-heading">
                    <b>Payment Requests</b>
                </div>
                <div class="panel">
                <div class="no-more-tables panel-body">
                	<form class="form-inline" action="" onsubmit="filterRequests(6); return false;" id="filter-submit">
					  <div class="form-group">
					    <input type="text" class="form-control input-sm" id="payment-requestor" placeholder="By Requestor">
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control input-sm" id="payment-vendor" placeholder="By Vendor">
					  </div>
					  <div class="form-group">
					  	<div class="padding5">
				  			<input type="text" class="form-control input-sm" id="payment-request-from-date" placeholder="From Date">
				  		</div>
				  		<div class="padding5">
					    	<input type="text" class="form-control input-sm" id="payment-request-to-date" placeholder="To Date">
					    </div>
					  </div>
					  <!-- <div class="form-group">
					    <input type="text" class="form-control input-sm" id="payment-city" placeholder="By City">
					  </div> -->
					  <div class="form-group">
					   <select class="form-control input-sm" id="payment-fc" name="id_fc">
                            <option value="">Select FC</option>
                            {foreach from=$fc_array item=data}
                            <option value="{$data.id_fulfillment_centre}">{$data.city_name}</option>
                            {/foreach}
                        </select>
					  </div>
					  <div class="form-group">
					    <select class="form-control input-sm" id="payment-status" name="id_fc">
                            <option value="">Select request status</option>
                            <option value="1">Payment Pending</option>
                            <option value="2">Paid</option>
                        </select>
					  </div>
					  <div class="form-group">
					  	<button type="submit" class="btn btn-primary btn-sm cur-poi" title="Filter data by specific">Filter</button>
					  	<button type="button" class="btn btn-danger btn-sm cur-poi" title="Reset to Default View" onclick="openPaymentRequests(6);">Reset</button>
				  		</div>
					</form>
					
                	<form class="form-horizontal" id="payment-requests-form" action="payment-request-excel.php" autocomplete="off" method="post">
                		<div class="checkbox">
						    <label>
						      <input type="checkbox" title="Select all rows in below table" class="check-all">Select All
						      <div class="help-block">(Select All to download multiple requests)</div>
						    </label>
					  	</div>
	                	<table class="table col-md-12 padding5 col-sm-12 table-bordered table-striped table-condensed cf panel" id="payment-requests">
	                		<thead>
	                			<tr>
	                				<th>
	                					Select
	                				</th>
	                				<th>Id</th>
	                				<th>Requested By</th>
	                				<th>Vendor Name</th>
	                				<th>Date</th>
	                				<th>Amount</th>
	                				<!-- <th>City</th> -->
	                				<th>FC</th>
	                				<th>Payment Status</th>
	                				<th>Detail</th>
	                			</tr>
	                		</thead>
	                		<tbody>
	                		{foreach from=$req_details item=data}
	                			<tr>
	                				<td data-title="Select">
	                					<div class="checkbox">
										    <label>
										    {if $data.status == 0}
										      <input type="checkbox" class="check-bank-detail cur-poi" name="id_request[]" value="{$data.id_request}">
										    {else}
										    	<input type="checkbox" class="cur-poi" disabled="">
										    {/if}
										    </label>
									  	</div>
	                				</td>
	                				<td data-title="Id">{$data.id_request}</td>
	                				<td data-title="Request Made By">{$data.emp_first_name}</td>
	                				<td data-title="Vendor Name">{$data.vendor_name}</td>
	                				<td data-title="Request Created Date" class="table-date">
	                					{$data.req_date_add|date_format}
	                				</td>
	                				<td data-title="Amount" class="amount">{$data.request_amount}</td>
	                				<!-- <td data-title="City">{if $data.vendor_city}{$data.vendor_city}{else}--{/if}</td> -->
	                				<td data-title="FC">{$data.fc_city}</td>
	                				<td data-title="Status">
	                					{if $data.status == 0}
	                						<button type="button" class="btn btn-primary btn-sm" onclick="changeStatus({$data.id_request},0,0)" title="Change Status to Paid" class="col-md-4">
		                						Paid
		                					</button>
		                					<button type="button" class="btn btn-danger btn-sm" onclick="changeStatus({$data.id_request},1,1)">
		                						Reject
		                					</button>
	                					{elseif $data.status == 1}
	                						<div disabled="" class="text-info">Paid on {$data.req_date_upd|date_format:"%D"} {if $data.reference}with <strong>Reference number : {$data.reference}</strong>{/if}</div>
	                					{else}
	                						<div class="text-danger">Rejected</div>
	                					{/if}
	                				</td>
	                				<td data-title="View">
	                					<button type="button" class="btn btn-info btn-sm" onclick="openDetail({$data.id_request})" title="View Request Details">
	                						View
	                					</button>
	                				</td>
	                			</tr>
	                		{/foreach}
	                		</tbody>
	                	</table>
	                	<div>
	                		<button type="submit" class="btn btn-primary pull-right" title="Download Request Details as Excel Sheet">Download</button>
	                		<div class="clear"></div>
	                		<div class="help-block pull-right">( Select appropriate checkboxes to download request details )</div>
	                	</div>
	                </form>
	            	</div>
                </div>
        </div>
</div>
<div class="modal fade in" id="payment-request-pop" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="text-center">Payment Request</h4>
                </div>
                <div class="modal-body">
                        <table class="table">
                            <thead class="cf panel-title">
                                <tr>
                                    <th class="numeric"></th>
                                    <th class="numeric"></th>
                                </tr>
                            </thead>
                            <tbody class="payment-request-data">
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                	<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="payment-bank-pop" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="text-center">Select Bank</h4>
                </div>
                <div class="modal-body">
                	<div class="panel-body">
                		<div class="form-group">
                			<input class="form-control" type="text"  id="payment-reference" placeholder="Enter payment reference"/>
                		</div>
                		<div class="form-group">
	                        <select class="form-control" id="select-corporate-bank">
	                        	<option value="">Select Bank</option>
	                        	{foreach from=$corporate_bank_details item=data}
	                        		<option value="{$data.id}">{$data.name} - {$data.acc_no}</option>
	                        	{/foreach}
	                        </select>
	                    </div>
                        <input type="hidden" name="id_request" id="id_request"/>
                    </div>
                </div>
                <div class="modal-footer">
                	<button class="btn btn-primary" onclick="changeStatus('',0,1)">Submit</button>
                	<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="finance/js/finance-payment-requests.js"></script>
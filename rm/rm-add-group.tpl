<script type="text/javascript" src="rm/js/rm-customer-configure.js"></script>
<script type="text/javascript">
	$('#group_select').select2();
</script>
<div class="row">
	<section class="panel-body">
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
			<header class="panel-heading">Assign Group</header>
			<div class="panel">
				<div class="panel-body">
					<div class="form-group">
                        	<span class="padding5"><i class="fa fa-toggle-down"></i> Select Company</span>
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            		<span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                            		<abbr class="select2-search-choice-close"></abbr>
                            		<span class="select2-arrow" role="presentation">
                            			<b role="presentation"></b>
                            		</span>
                            	</a>
                            	<label for="s2id_autogen3" class="select2-offscreen"></label>
                            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="group_select" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getGroupDetails(12)" required>
                            		<option value="0">Select Company</option>
                            		{foreach from=$groups item=data}
                            			{if $group_name[0].id_group == $data.id_group}
                            			<option value="{$data.id_group}" selected="">
                            				{$data.name}
                            			</option>
                            			{else}
                            			<option value="{$data.id_group}">
                            				{$data.name}
                            			</option>
                            			{/if}
                            		{/foreach}
                            </select>
                    </div>
                    <div class="form-group">
                        	<input type="text" class="form-control" id="group_customer_detail" placeholder="Please search and select customer"/>
                        	<input type="hidden" class="form-control" name="customers_to_group[]" id="customers_to_group"/>
                    </div>
                    <div class="padding5 hidden">
	                    <label class="checkbox-inline">
		                    <input type="checkbox" id="check-default" name="default-selection" value="1">
		                    Assign this Company as default
		                </label>
                    </div>
                    <div class="padding5">
                    	{if $group_name[0].id_group}
                    	<button class="btn btn-info" onclick="addCustomersToGroup({$group_name[0].id_group},1)">Add User to Company</button>
                    	{else}
                    	<button class="btn btn-info" onclick="addCustomersToGroup(0,1)">Add User to Company</button>
                    	{/if}
                    </div>
				</div>
			</div>
		</div>
		<!-- <div class="col-md-4 col-xs-12 col-sm-12 panel-body">
			<header class="panel-heading">
				Create New Company
			</header>
			<div class="panel">
				<div class="panel-body position-center">
					<a href="#groupCreate" data-toggle="modal"><button class="btn btn-primary">
						<i class="fa fa-plus"></i>
							 Create New Company
					</button></a>
				</div>
			</div> -->
			<!-- <header class="panel-heading">
				Company Name
			</header>
			<div class="panel">
				<div class="panel-body position-center">
				{if $group_name[0].name}
					<div class="position-center">
						{$group_name[0].name}
					</div>
				{else}
					<div class="position-center">
						---
					</div>
				{/if}
				</div>
			</div> -->
		<!-- </div> -->
		<div class="col-md-12 col-xs-12 col-sm-12 panel-body">
			<header class="panel-heading">
				User In Selected Company
			</header>
			<div class="panel">
				<div class="panel-body">
					<table class="table table-bordered" id="group_customers">
						<thead>
							<th>
								S.No
							</th>
							<th>
								Name
							</th>
							<th>
								Email
							</th>
							<th>
								Action
							</th>
						</thead>	
						<tbody>
						{assign var=counter value=1}
						{foreach from=$group_customers item=data}
							<tr>
								<td>
									{$counter++}
								</td>
								<td>
									{$data.firstname}
								</td>
								<td>
									{$data.email}
								</td>
								<td>
									<a href="#" title="Remove customer from group" 
									onclick="removeCusGroup({$data.id_customer},{$group_name[0].id_group},1)">
										<div>
											<i class="fa fa-trash-o"></i> Remove
										</div>
									</a>
								</td>
							</tr>
						{/foreach}
						</tbody>				
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="groupExists" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Company Exists</h3>
                </div>
                <div class="modal-body position-center">
                	<div class="panel-body">
                		<span for="customer_name">Customer Name : </span>
                    	<span class="customer_name padding5"></span>
                	</div>
                	<div class="panel-body">
                		<span for="customer_mail">Customer Email : </span>
                    	<span class="customer_mail padding5"></span>
                	</div>
                	<div class="panel-body">
                		<span for="group_name">Customer Company : </span>
                    	<span class="group_name padding5"></span>
                	</div>
                </div>
                <div class="modal-footer">
                	<input type="button" name="cancel" data-dismiss="modal" class="btn btn-info" value="Continue"/>
                	<input type="button" name="cancel" data-dismiss="modal" onclick="addCustomersToGroup(0,2)" class="btn btn-default" value="Cancel"/>
                </div>
            </div>
        </div>
    </div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="groupCreate" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Create New Company</h3>
                </div>
                <div class="modal-body position-center">
                	<form role="form" onsubmit="addGroup();return false;" id="group-create-form">
	                	<div class="form-group">
	                        <input type="text" class="form-control" id="" name="group_name" placeholder="Group Name" value="" maxlength="100" required onblur="showGroupHint()"/>
	                        <div class="help-block">Invalid characters: 0-9!<>,;?=+()@#"�{}_$%:</div>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control" name="group_discount" placeholder="Discount in %" value="" maxlength="5"/>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control" name="group_credit" placeholder="Credit days" value="" required/>
	                    </div>
	                    <div class="form-group">
	                    	<label for="price-display-method">Price Display Method</label>
	                    	<select class="form-control" name="price_display_method" required>
	                    		<option value="1">
	                    			Tax Excluded
	                    		</option>
	                    		<option value="0">
	                    			Tax Included
	                    		</option>
	                    	</select>
	                    </div>
	                    <div class="form-group">
		                	<button type="submit" class="btn btn-primary">Create</button>
		                	<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
		                </div>
		                <input type="hidden" name="type" value="4"/>
	                </form>
	            </div>
            </div>
        </div>
    </div>
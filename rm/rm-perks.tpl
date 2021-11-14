<script type="text/javascript">
$(document).ready( function() {
 	getGroups(3);
 	$('.group_selection').select2();
 });
	
 </script>

<section class="panel">
	<div class="panel-head">
		<div class="panel-heading">
			<span class="text-center">PERKS LIST</span>
			<button href="#" onclick="openModal()" class="col-md-1 pull-right btn btn-info">Add New</button>
		</div>
	</div>
	<div class="panel-body table-responsive">
		<table class="table">
		    <thead>
		        <tr>
		            <th>#</th>
		            <th>Company Name</th>
		            <th>Domain</th>
		            <th>Address</th>
		        </tr>
		    </thead>
		    <tbody>
		    {if $domains != ""}
		    	{assign var=i value=0}
		    	{foreach $domains as $domain}
		        <tr>
		            <th scope="row">{$i+1}</th>
		            <td>{$domain.name}</td>
		            <td>{$domain.email}</td>
		            <td>
		            	{if $domain.address1 != ""}
		            		{$domain.address1}<br />
		            		{$domain.city}<br />
		            		{$domain.state}<br />
		            		{$domain.postcode}<br />
	            		{else}
	            			--
	            		{/if}
            		</td>
		        </tr>
		        {assign var=i value=$i+1}
		        {/foreach}
	        {else}
	        	<tr>No Data Found</tr>
	        {/if}
		    </tbody>
		</table>

	</div>
	<!-- Create Company Modal -->
		<div id="newPerks" class="modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h4 class="modal-title">Configure Companies for Perks </h4>
		            </div>
		            <div class="modal-body">
			            <div>
		                <div class="form-group">
					            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
					            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
					            		<span class="select2-chosen" id="select2-chosen-3">Select Company</span>
					            		<abbr class="select2-search-choice-close"></abbr>
					            		<span class="select2-arrow" role="presentation">
					            			<b role="presentation"></b>
					            		</span>
					            	</a>
					            	<label for="s2id_autogen3" class="select2-offscreen"></label>
					            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
					        	</div>
								<select id="group_selection" class="group_selection populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id"  required>
					        		<option value="0">Select Company</option>            		
					            </select>
		                </div>
		                <div class="form-group">
		               		<input type="text" placeholder="Domain" id="email" name="email" class="form-control" /> 	
		               		<span class="text-muted col-md-12">Ex: @paypal.com, @kobster.com</span>
		                </div>
		                </div>
						<div class="col-md-12 perks-address">
							 	<div class="form-group">
							 		<h3>Address</h3>
							 		<span >Note :</span>
							 		<div>1. Address details are not mandatory</div>
							 		<div>2. if you are adding, please add only the default address of the company</div>
							 	</div>

							 	<div class="form-group"> <!-- Message field -->
									<label class="control-label " for="message">Address1</label>
									<textarea class="form-control" cols="40" id="address1" name="address1" rows="5"></textarea>
								</div>

								<div class="form-group"> <!-- Name field -->
									<label class="control-label " for="name">City</label>
									<select class="form-control" id="city" name="city">
									<option></option>
										{foreach $cities as $city}
											<option value="{$city.city_name}">{$city.city_name}</option>
										{/foreach}
									</select>
								</div>
								
								<div class="form-group"> <!-- Email field -->
									<label class="control-label requiredField" for="email">State</label>
									<select class="form-control" id="state" name="state">
									<option></option>
										{foreach $states as $state}
											<option value="{$state.id_state}">{$state.name}</option>
										{/foreach}
									</select>
								</div>
								
								<div class="form-group"> <!-- Subject field -->
									<label class="control-label " for="subject">postcode</label>
									<input class="form-control" id="postcode" name="postcode" type="text"/>
								</div>
						</div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
		                <button class="btn btn-primary" onclick="savePerks()" id="company_name" >Save</button>
		            </div>
		        </div>
		    </div>
		</div>
	<!-->
</section>

<script >

</script>
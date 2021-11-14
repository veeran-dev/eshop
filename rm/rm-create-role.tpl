<script type="text/javascript" src="rm/js/rm-customer-configure.js"></script>
<script type="text/javascript">
	$('.group_select').select2();
</script>
<div class="row">
    <section class="panel-body">
		<header class="rm_heading">Create Roles</header>
    	<div class="col-md-5 col-xs-12 panel-body">
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
                <select class="populate placeholder select2-offscreen form-control group_select" tabindex="-1" title="" name="group_id" onchange="getGroupCustomers(9)" required>
                		<option value="">Select Company</option>
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
        {if $group_name[0].id_group}
        <div class="col-md-8 col-xs-12 panel-body">
        <form action="" onsubmit="assignRole(); return false;" id="role-form">
        	<div class="panel">
        		<header class="panel-heading">User in selected company</header>
        		<div class="panel">
        			<table class="table table-bordered table-stripped" id="roles-table">
	        			<thead>
	        					<th>S.No</th>
	        					<th>User Name</th>
	        					<th>Set Role</th>
	        			</thead>
	    				<tbody>
	    				{assign var=counter value=1}
						{foreach from=$group_customers item=data}
	    					<tr>
								<td>{$counter++}</td>
								<td>{$data.firstname}({$data.email})</td>
								<input type="hidden" name="id_customer[]" value="{$data.id_customer}">
	    						<td>
	    							<select class="form-control" name="roles[]" required>
	    								<option value="">Select Role</option>
	    								{foreach from=$roles item=role_data}
	    									{if $data.customer_role == $role_data.role}
	    									<option value="{$role_data.role}" selected="">{$role_data.role_name}</option>
	    									{else}
	    									<option value="{$role_data.role}">{$role_data.role_name}</option>
	    									{/if}
	    								{/foreach}
	    							</select>
	    						</td>
	    					</tr>
	    				{/foreach}
	    				</tbody>
        			</table>
        		</div>
        	</div>
        	<button type="submit" class="btn btn-primary">
				Save
			</button>
			<input type="hidden" name="type" value="6"/>
    		</form>
        </div>
        {/if}
    </section>
</div>
<script type="text/javascript" src="rm/js/rm-customer-configure.js"></script>
<script type="text/javascript">
	$('.group_select').select2();
</script>
<div class="row">
    <section class="panel-body">
		<header class="panel-heading">
                   Assign Roles
                </header>
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
                	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                </div>
                <select class="populate placeholder select2-offscreen form-control group_select" tabindex="-1" title="" name="group_id" onchange="getGroupCustomers(11)" required>
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
        <div class="col-md-12 col-xs-12 panel-body">
        <form class="m-bot15" action="" onsubmit="assignParent(); return false;" id="assign-parent">
          <div class="col-md-8 m-bot15 paddleft0">
            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                    <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                    <abbr class="select2-search-choice-close"></abbr>
                    <span class="select2-arrow" role="presentation">
                        <b role="presentation"></b>
                    </span>
                </a>
                <label for="s2id_autogen3" class="select2-offscreen sr-only"></label>
                <input class="select2-focusser select2-offscreen form-control m-bot15" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
            </div>
            <select class="populate placeholder select2-offscreen form-control group_select" tabindex="-1" title=""
             name="creator[]">
                    <option value="">Select Creator</option>
                    {foreach from=$group_customers key=cus_index item=cus_data}
                        {foreach from=$roles item=role_data}
                            {if $cus_data.customer_role == $role_data.role}
                                {if $cus_data.customer_role == 1}
                                    <option value="{$cus_data.id_customer}">
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    </option>
                                {elseif $cus_data.customer_role == 2}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    <!-- </option> -->
                                {elseif $cus_data.customer_role == 3}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    <!-- </option> -->
                                {/if}
                            {/if}
                        {/foreach}
                    {/foreach}
            </select>
          </div>
          <div class="col-md-8 m-bot15 paddleft0">
            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                    <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                    <abbr class="select2-search-choice-close"></abbr>
                    <span class="select2-arrow" role="presentation">
                        <b role="presentation"></b>
                    </span>
                </a>
                <label for="s2id_autogen3" class="select2-offscreen sr-only"></label>
                <input class="select2-focusser select2-offscreen form-control m-bot15" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
            </div>
            <select class="populate placeholder select2-offscreen form-control group_select" tabindex="-1" title="" name="level_one[]">
                    <option value="">Select Level-1 Approver</option>
                    {foreach from=$group_customers key=cus_index item=cus_data}
                        {foreach from=$roles item=role_data}
                            {if $cus_data.customer_role == $role_data.role}
                                {if $cus_data.customer_role == 1}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                   <!--  </option> -->
                                {elseif $cus_data.customer_role == 2}
                                    <option value="{$cus_data.id_customer}">
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    </option>
                                {elseif $cus_data.customer_role == 3}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    <!-- </option> -->
                                {/if}
                            {/if}
                        {/foreach}
                    {/foreach}
            </select>         
          </div>
          <div class="col-md-8 m-bot15 paddleft0">
            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                    <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                    <abbr class="select2-search-choice-close"></abbr>
                    <span class="select2-arrow" role="presentation">
                        <b role="presentation"></b>
                    </span>
                </a>
                <label for="s2id_autogen3" class="select2-offscreen sr-only"></label>
                <input class="select2-focusser select2-offscreen form-control m-bot15" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
            </div>
            <select class="populate placeholder select2-offscreen form-control group_select" tabindex="-1" title="" name="level_two[]">
                    <option value="">Select Level-2 Approver</option>
                    {foreach from=$group_customers key=cus_index item=cus_data}
                        {foreach from=$roles item=role_data}
                            {if $cus_data.customer_role == $role_data.role}
                                {if $cus_data.customer_role == 1}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    <!-- </option> -->
                                {elseif $cus_data.customer_role == 2}
                                    <!-- <option value="{$cus_data.id_customer}"> -->
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                   <!--  </option> -->
                                {elseif $cus_data.customer_role == 3}
                                    <option value="{$cus_data.id_customer}">
                                       {$cus_data.firstname}({$cus_data.email}) - {$role_data.role_name}
                                    </option>
                                {/if}
                            {/if}
                        {/foreach}
                    {/foreach}
            </select>
          </div>
          <div class="col-md-8 paddleft0">
            <button type="submit" class="paddleft0 col-md-3 btn btn-primary m-bot15">Save</button>
          </div>
          <input type="hidden" name="type" value="7"/>
        </form>
        <div class="clear"></div>
        <form action="" id="parent-form">
            <div class="panel" style="height:450px !important;overflow-x:scroll;">
                <header class="panel-heading">User in selected company</header>
                    <table class="table table-bordered table-condensed table-stripped" id="parents-table">
                        <thead>
                                <th>S.No</th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Level-1 Approver</th>
                                <th>Level-2 Approver( Super Approver )</th>
                        </thead>
                        <tbody>
                        {assign var=counter value=1}
                        {foreach from=$group_customers key=cus_index item=cus_data}
                            <tr>
                                <td>{$counter++}</td>
                                <td>{$cus_data.firstname}({$cus_data.email})</td>
                                <input type="hidden" name="id_customer[]" value="{$data.id_customer}">
                                <td>
                                    {foreach from=$roles item=role_data}
                                        {if $cus_data.customer_role == $role_data.role}
                                            {if $cus_data.customer_role == 1}
                                                <span class="text-primary"><strong>{$role_data.role_name}</strong></span>
                                            {elseif $cus_data.customer_role == 2}
                                                <span class="text-warning"><strong>{$role_data.role_name}</strong></span>
                                            {elseif $cus_data.customer_role == 3}
                                                <span class="text-success"><strong>{$role_data.role_name}</strong></span>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                </td>
                                <td>
                                {if $parent_array[$cus_index]}
                                        {foreach from=$parent_array[$cus_index] item=data}
                                            {if $data.id_role == 2}
                                            <div>
                                                <span>
                                                     <div class="input-group">
                                                        <span>{$data.name}({$data.email})</span>
                                                        <!-- <span class="input-group-addon btn-white cur-poi" onclick="removeCustomer({$cus_data.id_customer},{$data.id_customer},0)">
                                                            <i class="fa fa-times"></i>
                                                        </span> -->
                                                    </div>
                                                </span>
                                            </div>
                                            {/if}
                                        {/foreach}
                                {/if}
                                </td>
                                <td>
                                {if $parent_array[$cus_index]}
                                        {foreach from=$parent_array[$cus_index] item=data}
                                            {if $data.id_role == 3}
                                            <div>
                                                <span>
                                                    <div class="input-group">
                                                        <span>{$data.name}({$data.email})</span>
                                                        <!-- <span class="input-group-addon btn-white cur-poi" onclick="removeCustomer({$cus_data.id_customer},{$data.id_customer},1)">
                                                            <i class="fa fa-times"></i>
                                                        </span> -->
                                                    </div>
                                                </span>
                                            </div>
                                            {/if}
                                        {/foreach}
                                {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
            </div>
            </form>
        </div>
        {/if}
    </section>
</div>
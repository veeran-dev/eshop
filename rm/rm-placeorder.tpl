<header class="rm_heading">PLACE ORDERS FOR USER</header>
<script type="text/javascript">
    $(document).ready( function() { getGroups(1); });
    $('#group_selection, #customer_selection').select2();
</script>
<div class="row">
	<section class="panel-body">
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
			<div class="">
				<!-- SELECT CUSTOMER GROUP -->
				<div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
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
                    <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(0)" required>
                    	<option value="0">Select Company</option>
                    </select>
                </div>
                <!-- SELECT CUSTOMER WITH EMAIL ID -->
				<div class="form-group col-md-6 col-sm-6 col-xs-6 col-lg-6">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                    	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                    		<span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                    		<abbr class="select2-search-choice-close"></abbr>
                    		<span class="select2-arrow" role="presentation">
                    			<b role="presentation"></b>
                    		</span>
                    	</a>
                    	<label for="s2id_autogen3" class="select2-offscreen"></label>
                    	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                    <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(1);" required>
                    	<option value="0">Select User</option>
                    </select>	 
                </div>
                <!-- Set region to place order -->
                <div class="form-group display-none col-md-3 col-sm-3 col-xs-3 col-lg-3" id="region-selection">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">Select Region</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                    <select id="region_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="region_selection" onchange="setRegion(1);" required>
                        <option value="0">Select Region</option>
                    </select>   
                </div>
			</div>
		</div>	
	</section>
</div>
<script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/js/dash-quickbuy.js"></script>
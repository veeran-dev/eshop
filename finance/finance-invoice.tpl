<div class="panel" id="">
    <div class="col-md-12 text-center panel-heading"><b>Invoice Consolidation</b></div>
    <br><br>
    <div class="panel-body">
    <section class="panel">
        <div class="row">
            <div class="form-group col-md-offset-2 col-sm-offset-2 col-md-3 col-sm-3 col-xs-3 col-lg-3">
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
                    <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getAddress()" required>
                        <option value="0">Select Company</option>
                        {if isset($groups)}
                        {foreach $groups as $group }
                            <option value="{$group.id_group}">{$group.name}</option>
                        {/foreach}
                        {/if}
                    </select>
            </div>
            <div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
                <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                    <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                        <span class="select2-chosen" id="select2-chosen-3">Select State</span>
                        <abbr class="select2-search-choice-close"></abbr>
                        <span class="select2-arrow" role="presentation">
                            <b role="presentation"></b>
                        </span>
                    </a>
                    <label for="s2id_autogen3" class="select2-offscreen"></label>
                    <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                </div>
                    <select id="address_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="" required>
                        <option value="0">Select State</option>
                        {if isset($address_data)}
                        {foreach $address_data as $address }                            
                            <option value="{$address.id_address}">{$address.company}-{$address.address1}-{$address.city}-{$address.state}</option>
                        {/foreach}
                        {/if}
                    </select>
            </div>
            
            <button id="searchInvoiceButton" class="btn btn-primary clrbtn">Search</button>
        </div>
        <table class="table table-striped table-hover table-bordered successSearch" id="consolidate_invoice_table">
            <thead>
                <tr>
                	<th>Select</th>
                    <th>Order Id</th>
                    <th>Fulfillment Centre</th>
					<th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
             	</tr>
            </thead>
            <tbody id="finance_invoice_table">
            </tbody>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
             </tr>
			  
        </tfoot>
        </table>
        <button class='btn btn-primary successSearch' id='gen_cons_inv'>Generate Invoice</button>
     </section>
   </div>
</div>

<script type="text/javascript">
    $('#group_selection, #address_selection').select2();
    
 </script>
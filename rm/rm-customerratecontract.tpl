<div class="panel-heading">
    <header class="rm_heading">VIEW USER RATE CONTRACT PRODUCTS</header>
</div>
<!-- Products display block starts -->
<div class="panel">	
	<div class="">
		<section class="panel">	
    		<div class="panel-body">
                <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getRateContract(2);" required>
                        <option value="">Select Company</option>
                        {foreach from=$groups item=data}
                            <option value="{$data.id_group}" {if $data.id_group == $id_group}selected="true"{/if}>{$data.name}</option>
                        {/foreach}
                    </select>
                </div>
                {if isset($products) && !empty($products)}
                <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
                    <div class="dropdown">
                      <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Bulk Actions
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="javascript::void(0)" onclick="checkDelBoxes(true); return false;">
                                <i class="fa fa-check-square"></i>&nbsp;Select all
                            </a>
                        </li>
                        <li>
                            <a href="javascript::void(0)" onclick="checkDelBoxes(false); return false;">
                                <i class="fa fa-square"></i>&nbsp;Unselect all
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="javascript::void(0)" onclick="extendContract({$id_group}, true, 3); return false;">
                                <i class="fa fa-expand" aria-hidden="true"></i>&nbsp;Extend Contract
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a class="dropdown-item" href="javascript::void(0)" onclick="expirePrice(null, {$id_group}, 2, true, true)">
                                <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;Expire Selection
                            </a>
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="">
                    <form action="" id="rate-contract-form">
            			<table class="table table-striped table-bordered no-more-tables table-hover" id="customer_rate_contract_table">
            				<thead>
            					<tr>
                                  <th>
                                    <input type="checkbox" disabled="true" />
                                  </th>
            					  <th>Product Code</th>
            					  <th>Name</th>
            					  <th>Price (tax excl)</th>
                                  <th>Valid Till</th>
                                  <th>Published Date</th>
                                  <th>Available Regions</th>
                                  <th>Status</th>
            					  <th class="action">Action</th>					
            					</tr>
            				</thead>
            				<tbody id="ratecontract_products">
                                {foreach from=$products item=data}
                                    <tr>
                                        <td data-title="--">
                                            <input type="checkbox" class="specific-product-checkbox" name="specific-product-checkbox" value="{$data.id_specific_price}" />
                                        </td>
                                        <td data-title="Product Code">{$data.reference}</td>
                                        <td data-title="Name">{$data.name}</td>
                                        <td data-title="Price (Tax Excl.)">{Tools::displayPrice($data.sp_price)}</td>
                                        <td data-title="Valid Till">
                                            <input 
                                                type="text" 
                                                readonly="true" 
                                                value="{$data.to}" 
                                                title="You can change the rate contract date for this product by clicking here." 
                                                id="{$data.id_specific_price}_date" 
                                                class="form-control" 
                                                onchange="changeDate({$data.id_specific_price}, {$id_group}, 1, '{$data.to}', this)" 
                                            />
                                        </td>
                                        <td data-title="Published Date">{$data.date_update}</td>
                                        <td data-title="Available Regions">{$data.available_regions}</td>
                                        <td data-title="Status">{$data.product_status}</td>
                                        <td data-title="Action">
                                            <span class="cur-poi text-danger btn-round" title="Expire this price." onclick="expirePrice({$data.id_specific_price}, {$id_group}, 2, null)">
                                                <i class="fa fa-trash-o">&nbsp;Expire</i>
                                            </span>
                                        </td>
                                    </tr>
                                    {literal}
                                        <script type="text/javascript">
                                            $("#{/literal}{$data.id_specific_price}{literal}_date").datepicker({format: 'yyyy-mm-dd hi:s:a'});
                                        </script>
                                    {/literal}
                                {/foreach}
             				</tbody>
            			</table> 
                    </form>
                </div>
                {/if}
            </div>
		</section>
	</div>
</div>

<!-- Expire confirmation modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="confirmation-modal-expire">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Expire Price</h3>
            </div>
            <div class="modal-body">
                <div class="display-content">
                    Are you sure want to expire all the selected products?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="expirePrice(null, {$id_group}, 2, true, false)">
                    Continue
                </button>
                <button class="btn btn-default modal-close cancel-selection" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Extend confirmation modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="confirmation-modal-extend">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Extend Rate Contract</h3>
            </div>
            <div class="modal-body">
                <div class="display-content">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Please select date to extend" id="rate-contract-extend-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="extendContract({$id_group}, false, 3)">
                    Continue
                </button>
                <button class="btn btn-default modal-close cancel-selection" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Extend response modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="modal-extend-response">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-danger modal-text-font">Error occurred in extending rate contract</h3>
            </div>
            <div class="modal-body">
                <div class="display-content">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Reason</th>
                        </thead>
                        <tbody id="rate-contract-extend-response">
                            <tr>
                                <td>Test name</td>
                                <td>Test reason</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default modal-close cancel-selection" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="rm/js/rm-rate-contract.js"></script>

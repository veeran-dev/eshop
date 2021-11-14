<div class="row">
    <section class="panel-body">
                <header class="panel-heading">
                    Bulk Quotes
                </header>
    <div class="no-more-tables">
        <table class="table col-md-12 col-sm-12 table-bordered table-striped table-condensed cf panel padding5" id="bootstrap-table">
            <thead class="cf panel-title">
                <tr>
                    <th class="numeric">Request Id</th>
                    <th>Company Name</th>
                    <th class="numeric">PIN Code</th>
                    <th class="numeric">Product Code</th>
                    <th>Product Name</th>
                    <th class="numeric">Quantity</th>
                    <th class="numeric">Target Price</th>
                    <th class="numeric">Action</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$bq_array|json_decode item=data}
                <tr>
                    <td data-title="Request Id" class="numeric">{$data->request_id}</td>
                    <td data-title="Company Name">{$data->name}</td>
                    <td data-title="PIN Code" class="numeric">{$data->pincode}</td>
                    <td data-title="Prod Code" class="numeric">{$data->product_code}</td>
                    <td data-title="Product Name">{$data->product_name}</td>
                    <td data-title="Quantity" class="numeric">{$data->qty}&nbsp;{$data->qty_unit}</td>
                    <td data-title="Target Price" class="numeric">{$data->target_price}</td>
                    {if $data->triggered == ""}
                    <td data-title="Action"></td>
                    {else if $data->triggered == 1}
                    <td data-title="Action" class="numeric"><div disabled class='label label-success label-mini btn-round'>Triggered</div></td>
                    {else}
                    <td data-title="Action" class="numeric"><div onclick='triggerBulkQuote({$data->product_code},{$data->request_id},1)' class='label label-primary cur-poi label-mini btn-round'><i class='fa fa-cog'></i>Trigger</div></td>
                    {/if}
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</section>
</div>

<div class="modal modal-response" id="vendor-list-response" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center">Do you want to continue?</h3>
                </div>
                <div class="modal-body">
                    <p>
                        Once you trigger this quote, an email with quotation details will be sent to each vendor shown below.  
                    </p>
                    <span class="bq-request-loader" style="display:none;">
		               <img src="img/gif-load.gif" alt="loader" />
		            </span>
                    <div style="height:250px;overflow-y:scroll;">
                        <table class="table table-bordered" id="vendor-table">
                            <thead class="cf panel-title">
                                <tr>
                                    <th class="numeric">S.No</th>
                                    <th class="numeric">Name of the Vendors</th>
                                </tr>
                            </thead>
                            <tbody class="vendor-table-data">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer vendor-list-footer">
                </div>
            </div>
        </div>
    </div>

<div class="modal modal-response" id="vendor-list-response-fail" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center">Alert!</h3>
                </div>
                <div class="modal-body">
                    <p>
                        No vendors available for this product.  
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="scn/js/scn-bq-requests.js"></script>
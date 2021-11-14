{if !$payment_request_view}
<div class="row">
    <div class="col-md-8">
        <div class="panel-body">
            <div class="panel">
                <div class="text-center panel-heading">
                    Payment Request Form
                </div>
                <form class="form-horizontal" onsubmit="submitRequest(); return false;" id="submitRequest">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="vendorName" class="col-sm-3 control-label">Select Vendor</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{if $vendor_array}{$vendor_array[0].name}{/if}" required id="vendorName" placeholder="Please search vendor here">
                                <input type="hidden" value="{$vendor_array[0].id_vendor}" name="id_vendor">
                                <div class="pull-right cur-poi">
                                    <a href="#vendorCreate" data-toggle="modal"><u class="text-primary">Click here to Add New Vendor</u></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vendorBankDetail" class="col-sm-3 control-label">Bank Detail</label>
                            <div class="col-sm-9">
                                <select class="form-control" required id="vendorBankDetail" onchange="getBankDetail({$vendor_array[0].id_vendor},2)">
                                    <option value="">Select Bank</option>
                                    {foreach from=$vendor_bank_array key=key item=data} {if $data.account_no == $bank_array[0].account_no}
                                    <option value="{$data.id_bank}" selected="">{$data.bank_name} - {$data.account_no}</option>
                                    {else}
                                    <option value="{$data.id_bank}">{$data.bank_name} - {$data.account_no}</option>
                                    {/if} {/foreach}
                                </select>
                                <input type="hidden" value="{$bank_array[0].id_bank}" name="id_bank" /> {if $vendor_array}
                                <div class="pull-right cur-poi">
                                    <a href="#bankDetailCreate" data-toggle="modal">
                                        <u class="text-primary">Click here to Add New Bank Detail</u>
                                    </a>
                                </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="orderId" class="col-sm-3 control-label">Enter Order Id(s)</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" id="orderId" name="id_order" placeholder="Please enter order Id's">
                                <span class="help-block">(Use commas to seperate order Id(s). For Example : 120, 121, 122)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reqAmount" class="col-sm-3 control-label">Enter Amount</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" id="reqAmount" name="amount" placeholder="Please enter amount">
                                <span class="help-block">(Use decimal format mentioned here. For Example : 12100.567)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reqComments" class="col-sm-3 control-label">Comments</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="reqComments" name="comments" placeholder="Please drop comments here"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" value="3" name="type" />
                                <button type="submit" class="btn btn-primary pull-right">Submit Request</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {if $bank_array}
    <div class="col-md-4">
        <div class="panel-body">
            <div class="panel">
                <div class="text-center panel-heading">
                    Selected Bank Details
                </div>
                <div class="padding5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bank Name</td>
                                <td>{$bank_array[0].bank_name}</td>
                            </tr>
                            <tr>
                                <td>Branch</td>
                                <td>{$bank_array[0].branch}</td>
                            </tr>
                            <tr>
                                <td>Account Name</td>
                                <td>{$bank_array[0].account_name}</td>
                            </tr>
                            <tr>
                                <td>Account type</td>
                                {if $bank_array[0].account_type == 1}
                                <td>Savings A/c</td>
                                {elseif $bank_array[0].account_type == 2}
                                <td>Current A/c</td>
                                {else}
                                <td>Credit A/c</td>
                                {/if}
                            </tr>
                            <tr>
                                <td>Account Number</td>
                                <td>{$bank_array[0].account_no}</td>
                            </tr>
                            <tr>
                                <td>IFSC Code</td>
                                <td>{$bank_array[0].ifsc_code}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {/if}
</div>
{else}
<div class="row">
        <div class="panel-body">
                <div class="text-center panel-heading">
                    Payment Requests
                </div>
                <div class="panel">
                <div class="no-more-tables panel-body">
                <form class="form-inline" action="" onsubmit="filterRequests(10); return false;" id="filter-submit">
                      <div class="form-group">
                        <div class="padding5">
                            <input type="text" class="form-control" id="payment-request-from-date" placeholder="From Date">
                        </div>
                        <div class="padding5">
                            <input type="text" class="form-control" id="payment-request-to-date" placeholder="To Date">
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" id="payment-vendor" placeholder="By Vendor">
                      </div>
                      <div class="form-group">
                       <select class="form-control" id="payment-fc" name="id_fc">
                            <option value="">Select FC</option>
                            {foreach from=$fc_array item=data}
                            <option value="{$data.id_fulfillment_centre}">{$data.city_name}</option>
                            {/foreach}
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" id="payment-status" name="id_fc">
                            <option value="">Select request status</option>
                            <option value="1">Payment Pending</option>
                            <option value="2">Paid</option>
                            <option value="3">Rejected</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary" title="Filter data by specific">Filter</button>
                      <button class="btn btn-default" type="button" title="Reset to Default View" onclick="paymentRequest(9);">
                        Reset
                     </button>
                    </form>

                        <table class="table col-md-12 padding5 col-sm-12 table-bordered table-striped table-condensed cf panel" id="payment-requests-scn">
                            <thead>
                                <tr>
                                    <th>Requested Id</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Vendor Name</th>
                                    <th>FC</th>
                                    <th>Payment Status</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             {foreach from=$req_details item=data}
                                <tr>
                                    <td data-title="Request Made By">{$data.id_request}</td>
                                    <td data-title="Request Created Date">{$data.req_date_add}</td>
                                    <td data-title="Amount">{Tools::displayPrice($data.request_amount, 4, false)}</td>
                                    <td data-title="City">{if $data.vendor_name}{$data.vendor_name}{else}--{/if}</td>
                                    <td data-title="FC">{$data.fc_city}</td>
                                    <td data-title="Status">
                                        {if $data.status == 0}
                                            <div class="text-warning">Payment Pending</div>
                                        {elseif $data.status == 1}
                                            <div disabled="" class="text-info">Paid.{if $data.reference} Reference number : {$data.reference}{/if}</div>
                                        {elseif $data.status == 2}
                                            <div class="text-danger">Rejected</div>
                                        {/if}
                                    </td>
                                    <td data-title="View">
                                        <button type="button" onclick="openDetail({$data.id_request})" title="View Request Details" class="cur-poi btn btn-info btn-sm">
                                                view                              
                                        </button>
                                    </td>
                                    <td data-title="Delete">
                                        {if $data.status == 1}
                                            <span>---</span>
                                        {else}
                                            <button type="button" onclick="deleteRequest({$data.id_request})" title="Delete request" class="cur-poi btn btn-danger btn-sm">
                                                Delete                             
                                            </button>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </form>
                    </div>
                </div>
        </div>
</div>
{/if}

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="vendorCreate" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Create New Vendor</h3>
            </div>
            <div class="modal-body">
                <form role="form" id="vendor-create-form" action="" onsubmit="createVendor(); return false;">
                    <div class="form-group">
                        <input type="text" required class="form-control" id="vendorName" name="vendorName" placeholder="Enter Vendor Name">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" minlength="15" maxlength="15" id="gstNo" name="gstNo" placeholder="Enter GST Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="panNo" name="panNo" placeholder="Enter PAN Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" id="mobileNo" placeholder="Enter Mobile Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="website" id="webLink" placeholder="Enter Website Link">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="credit_days" id="creditDays" placeholder="Enter Credit Days">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="selectFc" name="id_fc">
                            <option value="">Select FC</option>
                            {foreach from=$fc_array item=data}
                            <option value="{$data.id_fulfillment_centre}">{$data.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="selectPaymentMode" required name="payment_mode">
                            <option value="">Select payment Mode</option>
                            {foreach from=$payment_array item=data}
                            <option value="{$data.id_payment}">{$data.paymentMode}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label paddleft0">Delivery Available</label>
                        <label class="radio-inline">
                            <input type="radio" name="deliveryAvailable" id="deliveryAvailable1" value="1"> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="deliveryAvailable" id="deliveryAvailable0" value="0"> No
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label paddleft0">Replacement Available</label>
                        <label class="radio-inline">
                            <input type="radio" name="replaceAvailable" id="replaceAvailable1" value="1"> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="replaceAvailable" id="replaceAvailable0" value="0"> No
                        </label>
                    </div>
                    <input type="hidden" value="4" name="type" />
                    <button type="submit" class="btn btn-primary">Create Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="bankDetailCreate" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Add Bank Detail</h3>
            </div>
            <div class="modal-body">
                <form role="form" id="bank-detail-form" action="" onsubmit="createBankDetail(); return false;">
                    <div class="form-group">
                        <input type="text" required class="form-control" id="bankName" name="bankName" placeholder="Enter Bank Name">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" id="bankBranch" name="bankBranch" placeholder="Enter Branch Name">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" id="accountHolder" name="accountHolder" placeholder="Enter Account Holder Name">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" id="accountNumber" name="accountNumber" placeholder="Enter Account Number">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" id="ifscCode" name="ifscCode" placeholder="Enter IFSC Code">
                    </div>
                    <div class="form-group">
                        <select class="form-control" required id="selectAccountType" name="acc_type">
                            <option value="">Select Account Type</option>
                            <option value="1">Savings A/c</option>
                            <option value="2">Current A/c</option>
                            <option value="3">Credit A/c</option>
                        </select>
                    </div>
                    <input type="hidden" name="id_vendor" value="{$vendor_array[0].id_vendor}">
                    <input type="hidden" name="type" value="5" />
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in payment-request-pop" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
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

<script type="text/javascript" src="scn/js/scn-payment-request.js"></script>
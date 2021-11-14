{if $box_array}
	{*Total Boxes Count starts*}
	{$kob_box_count = 0}{$other_box_count = 0}
	{foreach from=$delivey_detail item=data}
		{$kob_box_count = $kob_box_count + $data.kob_boxes}
		{$other_box_count = $other_box_count + $data.other_boxes}
	{/foreach}
	{*Total Boxes Count ends*}
<div class="row">
    <div class="panel-body">
            <header class="rm_heading">
                Box Details
            </header>
            <div class="padding10"></div>
            <div class="col-md-8 col-md-offset-2 padding5">
	            <form class="form-inline" action="" onsubmit="filterRequests(0); return false;" id="box-filter-submit">
	              <div class="form-group">
	                    <input type="text" class="form-control" id="dr-from-date" placeholder="From Date">
	                    <input type="text" class="form-control" id="dr-to-date" placeholder="To Date">
	              </div>
	              <div class="form-group">
	               <select class="form-control" id="box-fc" name="id_fc">
	                    <option value="">Select FC</option>
	                    {foreach from=$fc_array item=data}
	                    <option value="{$data.id_fulfillment_centre}">{$data.city_name}</option>
	                    {/foreach}
	                </select>
	              </div>
	              <button type="submit" class="btn btn-primary" title="Filter data by specific">Filter</button>
	              <button class="btn btn-default" type="button" title="Reset to Default View" onclick="trackDelBox(0);">
	                Reset
	             </button>
	            </form>
	        </div>
	        <div class="padding5"></div>
            <div class="col-md-6 col-md-offset-2 padding5">
            	<table class="table table-bordered delivery-box-table">
            		<thead>
            			<tr>
            				<th align="center"><img src="img/kobster_box.png"><span class="padding5">Kobster Boxes</span></th>
            				<th align="center"><img src="img/other-box.png"><span class="padding5">Other Boxes</span></th>
            			</tr>
            		</thead>
            		<tbody class="panel">
            			<tr>
            				<td align="center">
            					{$kob_box_count}
            				</td>
            				<td align="center">
            					{$other_box_count}
            				</td>
            			</tr>
            		</tbody>
            	</table>
            </div>
    </div>
</div>
{elseif $box_sent}
<div class="row">
    <div class="panel-body">
        <div class="panel">
            <div class="text-center panel-heading">
                Number of boxes sent to Company
            </div>
            <div class="no-more-tables panel-body">
           	<form action="" onsubmit="filterRequests(1); return false;" id="box-filter-submit">
              <div class="col-sm-3">
                <div class="padding5">
                    <input type="text" class="form-control" id="dr-from-date" placeholder="From Date">
                </div>
                <div class="padding5">
                    <input type="text" class="form-control" id="dr-to-date" placeholder="To Date">
                </div>
              </div>
              <div class="col-sm-2">
               <select class="form-control" id="box-fc" name="id_fc">
                    <option value="">Select FC</option>
                    {foreach from=$fc_array item=data}
                    <option value="{$data.id_fulfillment_centre}">{$data.city_name}</option>
                    {/foreach}
                </select>
              </div>
              <div class="col-sm-2">
              	<input type="text" class="form-control" placeholder="Order ID" id="id_order_box" />
              </div>
              <div class="col-sm-2">
                <input type="text" class="form-control" placeholder="Company" id="company"/>
              </div>
              <div class="col-sm-2">
                  <button type="submit" class="btn btn-primary cur-poi" title="Filter data by specific">Filter</button>
                  <button class="btn btn-default" type="button" title="Reset to Default View" onclick="trackDelBox(1);">
                    Reset
                 </button>
              </div>
              <div class="clear"></div>
            </form>
               <table class="table col-md-12 padding5 col-sm-12 table-bordered table-striped table-condensed cf panel" id="box-sent-received">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Company</th>
                            <th>Kobster Boxes</th>
                            <th>Other Boxes</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach from=$delivey_detail item=data}
                        {if $data.order_id != ""}
                            {if ($data.kob_boxes != "" AND $data.kob_boxes != 0) OR ($data.other_boxes != "" AND $data.other_boxes != 0)}
                                <tr>
                                    <td data-title="Order Id">{$data.order_id}</td>
                                    <td data-title="Company">
                                    	{if $data.cus_company != ""}
                                    		{$data.cus_company}
                                    	{elseif $data.address_company != ""}
                                    		{$data.address_company}
                                    	{elseif $data.cus_firstname != ""}
                                    		{$data.cus_firstname}
                                    	{else}
                                    		Not Available
                                    	{/if}
                                    </td>
                                    <td data-title="Kobster Boxes">{$data.kob_boxes}</td>
                                    <td data-title="Other Boxes">{$data.other_boxes}</td>
                                </tr>
                            {/if}
                        {/if}
                    {/foreach}
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
</div>
{else}
<div class="row">
    <div class="panel-body">
        <header class="rm_heading">
            Boxes Returned
        </header>
        <div class="col-md-12" style="padding:10px;">
          <div class="col-md-6 col-md-offset-3">
            <input type="text" class="form-control" id="customer-select-boxfeature" placeholder="Please search to select user from company.">
          </div>
        </div>
        {if $box_detail}
        <div class="col-md-8 col-md-offset-2">
            <div class="panel-body">
                <div class="panel">
                    <div class="text-center panel-heading">
                        {if $box_detail[0]['cus_company'] != ""}
                            {$box_detail[0]['cus_company']}
                        {elseif $box_detail[0]['address_company'] != ""}
                            {$box_detail[0]['address_company']}
                        {elseif $box_detail[0]['cus_firstname'] != ""}
                            {$box_detail[0]['cus_firstname']}
                        {/if}
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            {if $box_detail[0]['total_box']}
                                <tr>
                                    <td>Number of Kobster Boxes Sent to User</td>
                                    <td>{if $box_detail[0]['total_box']}{$box_detail[0]['total_box']}{else}0{/if}</td>
                                </tr>
                                <tr>
                                    <td>Number of Boxes Returned</td>
                                    <td>{if $box_detail[0]['returned_boxes']}{$box_detail[0]['returned_boxes']}{else}0{/if}</td>
                                </tr>
                                <tr>
                                    <td>Boxes yet to be Returned</td>
                                    <td>{$box_detail[0]['total_box'] - $box_detail[0]['returned_boxes']}</td>
                                </tr>
                               
                                <tr>
                                    <td>User has Returned</td>
                                    <td>
                                        <form class="form-inline" onsubmit="saveBoxNumber({$box_detail[0]['total_box']},{if $box_detail[0]['returned_boxes']}{$box_detail[0]['returned_boxes']}{else}0{/if},{$box_detail[0]['id_customer']}); return false;">
                                          <div class="form-group">
                                            <div class="input-group">
                                              <input type="text" {if ($box_detail[0]['total_box'] - $box_detail[0]['returned_boxes']) == 0}disabled=""{/if} class="form-control" id="box-return-count" placeholder="Enter the Number">
                                            </div>
                                          </div>
                                          <button type="submit" {if ($box_detail[0]['total_box'] - $box_detail[0]['returned_boxes']) == 0}disabled=""{/if} class="btn btn-primary">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            {else}
                                <tr>
                                    <td align="center" class="text-danger">None of boxes delivered to this user.</td>
                                </tr>
                            {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {/if}
    </div>
</div>   
{/if}
<script type="text/javascript" src="scn/js/scn-delivery-box-track.js"></script>
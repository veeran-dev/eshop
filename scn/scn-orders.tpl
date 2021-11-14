{if !$conversation}
<div class="row" id="ordersTemplate">
    <div class="panel-body">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="navTab">
                <li role="presentation" class="{if !$order_detail}active{/if}">
                    <a href="#allOrdersList" id="tab_0" aria-controls="allOrdersList" role="tab" data-toggle="tab">
                        <i class="icon-time"></i> All Orders List
                    </a>
                </li>
                <li role="presentation">
                    <a href="#singleOrderView" id="tab_1" class="{if !$single_order}disabledTab{/if}{if $tab == 1} active{/if}" aria-controls="singleOrderView" role="tab" data-toggle="tab">
                        <i class="icon-money"></i> Single Order View
                    </a>
                </li>
                <li role="presentation">
                    <a href="#customerInfo" id="tab_2" class="{if !$single_order}disabledTab{/if}{if $tab == 2} active{/if}" aria-controls="customerInfo" role="tab" data-toggle="tab">
                        <i class="icon-user"></i> Customer Info & DRs
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" id="tabContent">
                <div role="tabpanel" class="tab-pane fade{if !$order_detail}in active{/if}" id="allOrdersList">
                    <div class="panel-body">
                        <div class="col-md-12 m-bot20">
                            <div class="ordersFullList" id="ordersFullList">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <ul class="pagination">
                                            <li>
                                                <a href="javascript:void(0)" aria-label="First" onclick="openOrders(0,0,'',1,'{$orderBy}','{$orderWay}',1, {$page})">
                                                    <span aria-hidden="true">
									        		&laquo;
									        	</span>
                                                </a>
                                            </li>
                                            {if $page == 0}
                                            <li class="disabled">
                                                <a href="javascript:void(0)">
                                                    <span>
										    			Prev
										    		</span>
                                                </a>
                                            </li>
                                            {else}
                                            <li>
                                                <a href="javascript:void(0)" onclick="openOrders(0,{$page-1},'',1,'{$orderBy}','{$orderWay}',1, {$page})">
                                                    <span>
										    			Prev
										    		</span>
                                                </a>
                                            </li>
                                            {/if} {if $page == $paginationCount}{$pages = $page}{else}{$pages = ($page+6)}{/if} {if $page >= 0} {for $i = ($page) to $pages} {if $i >= $paginationCount} {else}
                                            <li id="{$i}_no" class="{if $page == $i}active{/if}">
                                                <a href="javascript:void(0)" onclick="openOrders(0,{$i},'',1,'{$orderBy}','{$orderWay}',1, {$page})">
											              {$i+1}
											          </a>
                                            </li>
                                            {/if} {/for} {/if} {if $page == ($paginationCount-1)}
                                            <li class="disabled">
                                                <a href="javascript:void(0)">
                                                    <span>
										    			Next
										    		</span>
                                                </a>
                                            </li>
                                            {else}
                                            <li>
                                                <a href="javascript:void(0)" onclick="openOrders(0,{$page+1},'',1,'{$orderBy}','{$orderWay}',1, {$page})">
                                                    <span>
										    			Next
										    		</span>
                                                </a>
                                            </li>
                                            {/if}
                                            <li>
                                                <a href="javascript:void(0)" aria-label="Last" onclick="openOrders(0,{$paginationCount-1},'',1,'{$orderBy}','{$orderWay}',1, {$page})">
                                                    <span aria-hidden="true">
									         	&raquo;
									         </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" placeholder="Jump to Page" class="form-control input-sm scn-order-jump-page scn-order-page-margin" value="{if $jump_page && $jump_page != 0}{$jump_page+1}{/if}">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm scn-order-per-page scn-order-page-margin" name="order-per-page" onchange="openOrders(0,0,'',1,'{$orderBy}','{$orderWay}',1, {$page})">
									  <option value="20" {if $perPage == 20}selected="true"{/if}>20</option>
									  <option value="50" {if $perPage == 50}selected="true"{/if}>50</option>
									  <option value="100" {if $perPage == 100}selected="true"{/if}>100</option>
									  <option value="300" {if $perPage == 300}selected="true"{/if}>300</option>
									</select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary scn-order-page-margin btn-sm" onclick="openOrders(0,0,'',0,'{$orderBy}','{$orderWay}',1, {$page})">Submit</button>
                                        <button type="button" class="btn btn-default btn-sm" onclick="openOrders(0,0,50,1,'id_order','DESC',0)">Reset</button>
                                    </div>
                                    <table class="table table-striped table-condensed no-more-tables" id="scn-orders">
                                        <thead>
                                            <tr class="scn-orders-head">
                                                <th>Id
                                                    <a href="#" onclick="openOrders(0,0,50,1,'id_order','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'id_order','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Company
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>User
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','ASC',1)">
                                                        <span class='cur-poi'>
                                                            <i class="fa fa-sort-asc"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','DESC',1)">
                                                        <span class='cur-poi'>
                                                            <i class="fa fa-sort-desc"></i>
                                                        </span>
                                                    </a>
                                                </th>
                                                <th>Type
                                                    <a href="#" onclick="openOrders(0,0,50,1,'buyer_type','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'buyer_type','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Delivery State
                                                    <a href="#" onclick="openOrders(0,0,50,1,'state_name','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'state_name','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Total
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_total','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_total','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Payment
                                                    <a href="#" onclick="openOrders(0,0,50,1,'payment','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'payment','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Status
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_state_name','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_state_name','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Fc
                                                    <a href="#" onclick="openOrders(0,0,50,1,'fc_city','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'fc_city','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Date
                                                    <a href="#" onclick="openOrders(0,0,50,1,'date_added','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'date_added','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="scn-orders-filters">
                                                <td data-title="Id">
                                                    <input type="text" value="{if $id_order}{$id_order}{/if}" name="id_order" class="form-control input-sm" id="idOrder">
                                                </td>
                                                <td data-title="Company">
                                                    <input type="text" name="company" value="{if $group}{$group}{/if}" class="form-control input-sm" id="companyName">
                                                </td>
                                                <td data-title="Customer">
                                                    <input type="text" name="customer" value="{if $customer}{$customer}{/if}" class="form-control input-sm" id="customerName">
                                                </td>
                                                <td data-title="Type">
                                                    <select class="form-control input-sm" name="id_buyer" id="idBuyer">
					            					  <option value="">--</option>
													  <option value="3" {if $buyer_type == 3}selected=""{/if}>B</option>
													  <option value="9" {if $buyer_type == 9}selected=""{/if}>C</option>
                                                      <option value="10" {if $buyer_type == 10}selected=""{/if}>P</option>
													</select>
                                                </td>
                                                <td data-title="Delivery State">
                                                    <select class="form-control input-sm" name="id_state" id="idState">
					            					    <option value="">-------</option>
													  {foreach from=$state_array item=data}
													  	<option value="{$data.id_state}" {if $state == $data.id_state}selected=""{/if}>{$data.name}</option>
													  {/foreach}
													</select>
                                                </td>
                                                <td data-title="Total">
                                                    <input type="text" value="{if $order_total_list}{$order_total_list}{/if}" name="order_total" class="form-control input-sm" id="orderTotal">
                                                </td>
                                                <td data-title="Payment">
                                                    <input type="text" value="{if $payment}{$payment}{/if}" class="form-control input-sm" name="payment_type" id="paymentType">
                                                </td>
                                                <td data-title="Status">
                                                    <select class="form-control input-sm" name="id_order_state" id="idOrderState">
					            						<option value="">-------</option>
					            					  {foreach from=$order_state item=data}
													  	<option value="{$data.id_order_state}" {if $order_status == $data.id_order_state}selected=""{/if}>
													  		{$data.name}
													  	</option>
													  {/foreach}
													</select>
                                                </td>
                                                <td data-title="Fc">
                                                    <select class="form-control input-sm" name="id_fc" id="idFc">
					            						<option value="">----</option>
													  {foreach from=$fc item=data}
														<option value="{$data.id_fulfillment_centre}" 
														{if $id_fc == $data.id_fulfillment_centre}selected="true"{/if}>
															{$data.city_name}
														</option>
													  {/foreach}
													</select>
                                                </td>
                                                <td data-title="Date" class="scn-orders-filters-date-search">
                                                    <div class="scn-orders-filters-date">
                                                        <input type="text" value="{if $from_date}{$from_date}{/if}" name="from_date" id="order-date-from" placeholder="From Date" class="form-control input-sm">
                                                        <input type="text" name="to_date" value="{if $to_date}{$to_date}{/if}" id="order-date-to" placeholder="To Date" class="form-control input-sm">
                                                    </div>
                                                    <div class="scn-orders-filters-search">
                                                        <button type="submit" id="submitFilterButtonorder" name="submitFilter" class="btn btn-white btn-sm" data-list-id="order" onclick="openOrders(0,0,50,0,'id_order','DESC',1)">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            {foreach from=$orders item=data}
                                            <tr class="order-data-scn" id={$data.id_order}>
                                                <td data-title="Id" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {if $data.splitOrder}
                                                        <i class="splitOrderAction fa fa-plus-circle" id="i_{$data.id_order}"></i>
                                                    {/if}
                                                    {$data.id_order}                                                     
                                                </td>
                                                <td data-title="Company" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {if $data.company && $data.company != 'Default'}{$data.company}{elseif $data.address_company}{$data.address_company}{elseif $data.cus_name}{$data.cus_name}{else}----{/if}
                                                </td>
                                                <td data-title="User" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {if $data.cus_name}{$data.cus_name}{else}----{/if}
                                                </td>
                                                <td data-title="Type" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {if $data.buyer_type == 3}
                                                    <span>(B)</span>
                                                    {elseif $data.buyer_type == 10}
                                                    <span>(P)</span> {else}
                                                    <span>(C)</span> {/if}
                                                </td>
                                                <td data-title="Delivery State" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {$data.state_name}
                                                </td>
                                                <td data-title="Total" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {displayPrice price=(Tools::ps_round(Tools::convertPrice($data.order_total, $currency))) currency=$currency->id}
                                                </td>
                                                <td data-title="Payment" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {$data.payment}
                                                </td>
                                                <td data-title="Status" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    <span class="label color_field" style="color: #383838;background-color: {$data.color};">{$data.order_state_name}</span>
                                                </td>
                                                <td data-title="FC" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {if $data.fc_city}{$data.fc_city}{else}---{/if}
                                                </td>
                                                <td data-title="Date" onclick="orderDetail({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})" class="cur-poi">
                                                    {$data.date_added}
                                                </td>
                                                
                                            </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {if $tab != ""}
                <div role="tabpanel" class="tab-pane fade" id="singleOrderView">
                    <div class="panel-body">
                        <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="col-md-9 m-bot15">
                                <h4>#{$order_id} - {$company->name[1]} - ( {$stateObj->name} )</h4>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="cur-poi btn btn-round btn-primary pull-right" onclick="orderDetail({$order_id},0, '{$orderBy}', '{$orderWay}', 1, {$page})">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Order Status</header>
                                <div class="panel-body panel scn-fc-grid">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <h5><strong>{$currentState.name}</strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="img/statusIcon/32/{$currentState.id_order_state}.png" class="img-rounded">
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control input-sm" name="order_state_change" id="order_state_change">
		                                    {foreach from=$states item=data}
		                                        <option value="{$data.id_order_state}" {if $data.id_order_state == $currentState.id_order_state}selected=""{/if}>{$data.name}</option>
		                                    {/foreach}
		                                </select>
                                    </div>
                                    <div class="col-md-3 m-bot20">
                                        <button class="btn btn-primary btn-sm" onclick="changeStatus(2,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})" {if $block_account}disabled{/if}>
		                                    Change
		                                </button>
                                    </div>
                                    {if $block_account}
                                    <div class="col-md-12 text-danger_new">
                                        Sorry we cannot process this order
                                    </div>
                                    {/if}
                                    <div class="col-md-12 pull-left">
                                        <a href="#viewAllStatus_{$order_id}" class="view-all-status-scn" data-toggle="modal">View Status History</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Fulfillment Centre</header>
                                <div class="panel-body panel scn-fc-grid">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <h5><strong>{$fc_city->city_name}</strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="img/icons/city-icons/{$order->id_fc}.png" class="image-responsive scn-icons-opacity" width="30" height="30">
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control input-sm" id="fc_block_{$order_id}">
                                            {foreach from=$fc item=data}
                                                <option value="{$data.id_fulfillment_centre}" 
                                                {if $data.id_fulfillment_centre == $order->id_fc}selected=""{/if}>
                                                    {$data.city_name}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="changeFc(7,{$order_id},'{$orderBy}','{$orderWay}', 1, {$page})">
		                                    Change
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Estimated Delivery time</header>
                                <div class="panel-body panel scn-est-del-grid" style="position: relative; width: auto; height: 190px;">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-0"></div>
                                        <div class="col-md-12">
                                            <h5><strong>
    	                                    	{if $order->estimated_delivery_time == "0000-00-00 00:00:00"}
    	                                    		<span class="text-danger">Not Available</span>
    	                                    	{else}
    	                                    		{$order->estimated_delivery_time|date_format:"%B %e, %Y, %I:%M %p"}
    	                                    	{/if}</strong>
                                        	</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-calendar-check-o" style="font-size:30px;"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control input-sm" id="estimated_delivery_time" value="{$order->estimated_delivery_time}">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="changeDelTime(8,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">
		                                    Change
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Shipping Details</header>
                                <div class="panel-body panel scn-est-del-grid" style="position: relative; overflow: hidden; width: auto; height: 190px;">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                             <select class="form-control input-sm" id="tracking_no_{$order_id}">
                                            {foreach from=$carriers item=data}
                                                <option value="{$data.id_carrier}" 
                                                {if $data.id_carrier == $order->id_carrier}selected=""{/if}>
                                                    {$data.name}
                                                </option>
                                            {/foreach}
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-truck"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control input-sm" id="tracking_number" value="{$order->shipping_number}">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="setTrackingNumber(9,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">
		                                    Save
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 m-bot15">
                                <div class="col-md-12">
                                <header class="panel-heading">Order Detail</header>
                                <div class="panel scn-order-detail">
                                    <!-- <div class="m-bot25"> -->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Original Cart</td>
                                                    <td><strong>Cart #{sprintf('%06d', $cart->id)}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Mode</td>
                                                    <td class="payment_mode">
                                                        <strong>
                                                        {if $order->payment}{Tools::substr($order->payment, 0, 32)}{else}---{/if}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Customer PO</td>
                                                    <td>
                                                        <strong>
                                                        {if $order_po_name}
                                                            {$order_po_name} 
                                                            {if $budget}
                                                                <form id="budgetPoDownload" action="{$baseDir}purchase-order.php">
                                                                    <a href="javascript::void(0)" title="Download Customer PO" onclick="downloadBudgetPo()" class="text-success">
                                                                        ( <span class="fa fa-download"> )</span>
                                                                    </a>
                                                                    <input type="hidden" name="type" value="4" />
                                                                    <input type="hidden" name="po_string" value="{$order_po_name|lower}" />
                                                                </form>
                                                            {else}
                                                                <a href="customer_PO/{$order_po_name}" title="Download Customer PO" download class="text-success">
                                                                    ( <span class="fa fa-download"> )</span>
                                                                </a>
                                                            {/if}
                                                        {else}
                                                            {if isset($order->po_number) && $order->po_number}<span>{$order->po_number}</span>{else}---{/if}
                                                        {/if}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                {if isset($order_placed_by) && $order_placed_by}
                                                    <tr>
                                                        <td>Order Placed By</td>
                                                        <td>
                                                            <strong>
                                                            {$order_placed_by}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                {/if}
                                                <tr>
                                                    <td>Product Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        {Tools::displayPrice($order->total_paid_tax_excl, $currency, false)}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tax Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        {Tools::displayPrice(($order->total_paid_tax_incl - $order->total_paid_tax_excl), $currency, false)}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Discount Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        {Tools::displayPrice($order->total_discounts, $currency, false)}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                {* <tr>
                                                    <td>Wrapping Cost</td>
                                                    <td align="right">
                                                        <strong>
                                                        {Tools::displayPrice($order->total_wrapping, $currency, false)}
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Cost</td>
                                                    <td align="right">
                                                        <strong>
                                                        {Tools::displayPrice($order->total_shipping, $currency, false)}
                                                        </strong>
                                                    </td>
                                                </tr> *}
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td align="right"><strong>{Tools::displayPrice($order->total_paid_tax_incl, $currency, false)}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- </div> -->
                                </div>
                                </div>
                            </div>
                            <div class="col-md-8 m-bot15">
                                <div class="col-md-12">
                                    <header class="panel-heading">Order Comments <i class="fa fa-expand pull-right text-info cur-poi" onclick="getFullConversation({$order_id},{$cookie->id_employee})" title="Expand Conversation" aria-hidden="true"></i></header>
                                    <div class="panel-body panel" id="orderMessages_{$order_id}">
                                    	<div class="message-body-order" style="height:200px;">
                                            {if $order_messages} 
                                                {if ($cookie->profile == 5 )}
                                                    {foreach from=$order_messages item=data}
                                                        {if $data.private != 4}
                                                            {if $cookie->id_employee == $data.id_employee}
                                                                <div class="col-md-12 m-bot20">
                                                                    <div class="col-md-6 col-md-offset-5">
                                                                        <div class="talk-bubble tri-right right-top">
                                                                            <div class="talktext">
                                                                                <p>
                                                                                    {if $data.private == 1}
                                                                                        <span class="text-danger">Private:</span><br/> 
                                                                                    {/if} 
                                                                                    {$data.message|unescape:'html'}<br>
                                                                                    <span class="order-comment-time">
                                                                                        {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                                                            {$data.date_add|date_format:"%I:%M %p"}
                                                                                        {else}
                                                                                            {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                                                                        {/if}
                                                                                    </span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {else}
                                                                <div class="col-md-12 m-bot20">
                                                                    <div class="col-md-6">
                                                                        <div class="talk-bubble tri-right left-top">
                                                                            <div class="talktext">
                                                                                <p>
                                                                                    {if $data.private == 1}
                                                                                        <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                                                                    {/if} 
                                                                                    <span class="text-info">
                                                                                        <strong>From {if $data.efirstname}
                                                                                                    {$data.efirstname} {$data.elastname}
                                                                                                {else}
                                                                                                    {$data.cfirstname} {$data.clastname}
                                                                                                {/if}
                                                                                        </strong>
                                                                                    </span><br/> 
                                                                                    {$data.message|unescape:'html'} <br>
                                                                                    <span class="order-comment-time">
                                                                                        {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                                                            {$data.date_add|date_format:"%I:%M %p"}
                                                                                       {else}
                                                                                            {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                                                                       {/if}
                                                                                    </span><br />
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {/if} 
                                                        {/if}
                                                    {/foreach}
                                                {elseif $cookie->profile == 6}
                                                    {foreach from=$order_messages item=data} 
                                                        {if $cookie->id_employee == $data.id_employee}
                                                        <div class="col-md-12 m-bot20">
                                                            <div class="col-md-6 col-md-offset-5">
                                                                <div class="talk-bubble tri-right right-top">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            {if $data.private == 1}
                                                                                <span class="text-danger">Private:</span><br/>
                                                                            {elseif $data.private == 4}
                                                                                <span class="text-danger">SCN Only</span><br/>
                                                                            {/if} 
                                                                            {$data.message|unescape:'html'}<br>
                                                                            <span class="order-comment-time">
                                                                                {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                                                    {$data.date_add|date_format:"%I:%M %p"}
                                                                                {else}
                                                                                    {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                                                                {/if}
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {else}
                                                        <div class="col-md-12 m-bot20">
                                                            <div class="col-md-6">
                                                                <div class="talk-bubble tri-right left-top">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            {if $data.private == 1}
                                                                                <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                                                            {/if} 
                                                                            <span class="text-info">
                                                                                <strong>From {if $data.efirstname}
                                                                                            {$data.efirstname} {$data.elastname}
                                                                                        {else}
                                                                                            {$data.cfirstname} {$data.clastname}
                                                                                        {/if}
                                                                                </strong>
                                                                            </span><br/> 
                                                                            {$data.message|unescape:'html'} <br>
                                                                            <span class="order-comment-time">
                                                                                {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                                                    {$data.date_add|date_format:"%I:%M %p"}
                                                                               {else}
                                                                                    {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                                                               {/if}
                                                                            </span><br />
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {/if} 
                                                    {/foreach}
                                                {/if}
                                            {else}
                                                <h5 class="text-center text-danger">Messages Not Available.</h5>
                                            {/if}
                                        </div>
                                        <form action="" onsubmit="submitMessage({$order_id},1,'{$orderBy}','{$orderWay}',1, {$page}); return false;" id="submitMessage">
    	                                    <div class="col-md-12" id="scn-add-order-comment">
    	                                    	<div class="col-md-6">
    	                                    		<textarea class="form-control" placeholder="Type comment here" name="message" id="text_message" rows="2" required maxlength="1600"></textarea>
    	                                    	</div>
                                                {if ($cookie->profile == 5 )}
    		                               		<div class="col-md-3 orderCommentDisplay">
    			                               			<label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusFalse" value="1" checked="checked"> Kobster
                                                            </label>
    				                                         <label class="radio-inline">
    				                                          <input type="radio" name="visibility" id="displayToCusTrue" value="0"> Customer
    				                                        </label> 
    				                                    </label>
    		                               		</div>
                                                {/if}
                                                {if ($cookie->profile == 6 )}
                                                <div class="col-md-3 orderCommentDisplay">
                                                        <label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusFalse" value="1" checked="checked"> RM + SCN
                                                            </label>
                                                             <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusTrue" value="4"> SCN only
                                                            </label> 
                                                        </label>
                                                </div>
                                                {/if}
    		                               		<div class="col-md-1">
    		                               			<a class="cur-poi" title="Send" onclick="$('#submitMessageBtn').click();"><img src="img/icons/chat_send.png" class="image-responsive scn-icons-opacity"></a>
    			                               	    <button type="submit" id="submitMessageBtn" class="btn btn-primary display-none">Submit</button>
                                                </div>
    			                               	<input type="hidden" name="id_order_single" value="{$order_id}">
    				                            <input type="hidden" name="type" value="1">
    				                            <input type="hidden" name="smarty" value="0">
    				                            <input type="hidden" name="tab" value="{$tab}">
                                                
    		                               	</div>
    	                               	</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                <header class="panel-heading">{if $order->getTaxCalculationMethod() == $tax_exclusive}PRODUCT LIST (TAX EXCL.){else}PRODUCT LIST(TAX INCL.){/if}</header>
                                {if $perksCustomerFile != ''}
                                <div class="col-md-12 btn-success">
                                  <div class="col-md-12">
                                    <span><h3>Perks Order</h3></span>
                                    <p>Please download and verify the ID PROOF by clicking <a href="{$perksCustomerFile}" target="_blank" style="color: #F44336;text-decoration: underline;">here</a> and process the order.</p>
                                  </div>
                                </div>
                                {/if}
                                <div class="panel-body panel">
                                    {if $product_detail}
                                    <div class="m-bot20">{if !Configuration::get('PS_ORDER_RETURN')}( Merchandise returns are disabled ){else}{/if}</div>
                                    <form id="productListOrder" action="" method="post">
                                        <div class="no-more-tables">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th></th>
                                                        <th>Product</th>
                                                        <th class="text-right">Price</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-right">Total</th>
                                                        <th class="text-center">Delivered</th>
                                                        <th>
                                                            <label class="checkbox-inline">
				                                              <input type="checkbox" id="select-all-product" class="input-sm" value=""> Select
				                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {$i = 1} {foreach from=$product_detail key=k item=data}
                                                    <tr>
                                                        <td data-title="S.No">
                                                            {$i++}
                                                        </td>
                                                        <td data-title="">
                                                            <img src="{$data.image_link}" alt="..." class="img-rounded">
                                                        </td>
                                                        <td data-title="Name">
                                                            <div>{$data.product_name}</div>
                                                            <div>{if $data.product_reference}Ref: {$data.product_reference}{else}{/if}</div>
                                                            <div>{if $data.product_supplier_reference}Ref Supplier: {$data.product_supplier_reference}{else}{/if}</div>
                                                        </td>
                                                        <td data-title="Price" class="text-right">
                                                            {Tools::displayPrice($data.product_price_true, $currency, false)}
                                                        </td>
                                                        <td data-title="Quantity" class="text-center">
                                                            {$data.product_quantity_true}
                                                            <input type="hidden" id="updateQuantity_{$data.id_order_detail}" value="{$data.product_quantity_true}">
                                                        </td>
                                                        <td data-title="Total" class="text-right">
                                                            {displayPrice price=(Tools::ps_round($data.product_price_true, 2) * ($data.product_quantity - $data.customizationQuantityTotal)) currency=$currency->id}
                                                        </td>
                                                        <td id="delivered_qty_{$data.id_order_detail}" data-title="Delivered" class="text-center">
                                                            {$data.product_quantity_delivered}
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline cancelCheck">
				                                              <input type="checkbox" name="id_order_detail[{$k}]" onchange="setCancelQuantity(this, {$data.id_order_detail}, {$data.product_quantity_in_stock - $data.customizationQuantityTotal - $data.product_quantity_reinjected})" class="quantity-checkbox input-sm" value="{$data.id_order_detail}">
				                                              <input type="hidden" name="totalQtyReturn" class="totalQtyReturn" value="{$data.product_quantity_return}" />
															  <input type="hidden" name="totalQty" class="totalQty" value="{$data.product_quantity_true}" />
															  <input type="hidden" name="productName" class="productName" value="{$data.product_name}" />
				                                              <input type="text" name="cancelQuantity[{$k}]" id="quantity_box_{$data.id_order_detail}" class="form-control cancelQuantity input-sm quantity_box_{$data.id_order_detail}">
                                                              <input type="hidden" id="po_number" name="po_number" value="{$order->po_number}">
                                                              <input type="hidden" id="po_file" name="po_file" value="{if $order_po_name}{$order_po_name}{/if}" >
				                                            </label>
                                                        </td>
                                                    </tr>
                                                    {/foreach}
                                                </tbody>
                                            </table>
                                            {if $block_account}
                                            <div class="col-md-12 text-danger_new">
                                                Kindly request the user to process the pending payments to resume our services
                                            </div>
                                            {else}
                                            
                                            <div class="padding10">
                                                {if Configuration::get('PS_ORDER_RETURN') AND !$order->isInvoiceGenerated()}
                                                <label class="checkbox-inline">
				                                      <input type="checkbox" name="generateDiscount" id="generateDiscount" value="1" onclick="toogleShippingCost(this)"> Generate a Voucher
				                                    </label>
                                                <label class="checkbox-inline display-none" id="spanShippingBack">
				                                      <input type="checkbox" name="shippingBack" id="repayShippingCheck" value="1"> Repay Shipping Costs
				                                    </label> {/if}
                                            </div>
                                            
                                            <div class="text-center col-md-12 m-bot15">
                                                {if !$order->hasBeenDelivered()}
                                                <button type="button" class="btn btn-primary btn-sm prod-action-btn" onclick="cancelProduct(1,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">Cancel/Remove Products</button> 
                                                {else}
                                                    <button type="button" disabled="" class="btn btn-primary btn-sm prod-action-btn-disabled" onclick="cancelProduct(1,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">Cancel/Remove Products</button> 
                                                {/if}
                                                {*{if !$order->isInvoiceGenerated() AND ($order->hasBeenShipped() OR $order->hasBeenPartiallyShipped())}
                                                    <button type="button" class="btn btn-primary btn-sm prod-action-btn" onclick="returnProduct(1,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">Replace Products</button> 
                                                {else}
                                                    <button type="button" disabled="" class="btn btn-primary btn-sm prod-action-btn-disabled" onclick="returnProduct(1,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})">No Replacements</button> 
                                                {/if} *}
                                                {if ($order->hasBeenShipped() OR $order->hasBeenPartiallyShipped() OR $order->packedandreadytobeshipped()) AND !$order->isInvoiceGenerated()}
                                                    <button type="button" class="btn btn-primary btn-sm prod-action-btn" onclick="$('#dr-label-{$data.id_delivery}').slideToggle();">Generate DR</button>
                                                {else}
                                                    <button type="button" class="btn btn-primary btn-sm prod-action-btn-disabled" disabled="" onclick="$('#dr-label-{$data.id_delivery}').slideToggle();">Generate DR</button>
                                                {/if}
                                                {if !$order->hasBeenShipped() && !$order->hasBeenPartiallyShipped() && !$order->packedandreadytobeshipped() && $order->total_discounts == 0}
                                                    <button type="button"  {if $order->payment != 'EBS'}{else}disabled=""{/if} class="btn btn-sm btn-primary prod-action-btn-danger {if count($product_detail) ==1 && $product_detail[0].product_quantity_true == 1}hidden{/if}" onclick="confirmSplit(1,{$order_id},'{$orderBy}','{$orderWay}', 1, {$page})">Split Order</button>
                                                {/if}
                                            </div>
                                            {/if}
                                            <div class="col-md-2"></div>
                                            <div class="clear"></div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8 scn-label-grid">
                                                <div class="padding10 box-edit display-none" id="dr-label-{$data.id_delivery}">
                                                    <div class="form-group">
                                                        <label for="kobsterLabel">Kobster boxes</label>
                                                        <input type="text" name="kob_box" class="form-control" id="kobsterLabel" required placeholder="Enter required kobster boxes" value="0">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="otherLabel">Other boxes</label>
                                                        <input type="text" name="other_box" class="form-control" id="otherLabel" required placeholder="Enter required other boxes" value="0">
                                                    </div>
                                                    <button type="button" onclick="generateDR(1,{$order_id},'{$orderBy}','{$orderWay}',1, {$page})" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <input type="hidden" name="tab" value="{$tab}" />
                                        <input type="hidden" name="id_order_single" value="{$order_id}" />
                                    </form>
                                    {else}
                                    <h5 class="text-center text-danger">No Products Available</h5> {/if}
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="customerInfo">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-md-9 m-bot15">
                                <h4>#{$order_id} - {$company->name[1]} - ( {$stateObj->name} )</h4>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="cur-poi btn btn-round btn-primary pull-right" onclick="orderDetail({$order_id},0, '{$orderBy}', '{$orderWay}', 2, {$page})">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <header class="panel-heading">Customer Details</header>
                            <div class="col-md-12 panel scn-customer-detail">
                                <!-- <div class="m-bot25"> -->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Company</td>
                                                <td><strong>{$company->name[1]}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>
                                                    <strong>
                                                    {$customerObj->firstname}{$customerObj->lastname}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User ID</td>
                                                <td>
                                                    <strong>
                                                    {$customerObj->id}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User Email</td>
                                                <td>
                                                    <strong>
                                                    {$customerObj->email}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Registered On</td>
                                                <td>
                                                    <strong>
                                                    {$customerObj->date_add|date_format:"%A, %B %e, %Y, %r"}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Orders Placed Since</td>
                                                <td>
                                                    <strong>
                                                    {$cus_total_performance.nb_orders}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tansaction Amount Total</td>
                                                <td>
                                                    <strong>
                                                    {displayPrice price=(Tools::ps_round(Tools::convertPrice($cus_total_performance.total_orders, $currency))) currency=$currency->id}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Shipping Address</header>
                                <div class="padding10 panel scn-address-grid">
                                    {$shipping_address}
                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice Address</header>
                                <div class="padding10 panel scn-address-grid">
                                    {$invoice_address}
                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice</header>
                                <div class="panel-body panel scn-invoice-grid">
                                    {if Configuration::get('PS_INVOICE') && $consolidated_invoice!='' && $order->invoice_number}
                                    <h5 class="text-center">Download Invoice</h5>
                                    <h5 class="text-center">
			                            <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token={$token}&submitAction=generateConsolidatedInvoicePdf{$consolidated_invoice}" download>
			                                #IN{$invoice_number}  (<i class="fa fa-download text-success" title="Download Invoice"></i>)
			                            </a>
			                        </h5> 
                                    {elseif Configuration::get('PS_INVOICE') && count($invoices_collection) && $order->invoice_number}
                                    <h5 class="text-center">Download Invoice</h5>
                                    <h5 class="text-center">
			                            <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token={$token}&submitAction=generateInvoicePDF&id_order={$order->id|intval}" download>
			                                #IN{$invoice_number} (<i class="fa fa-download text-success" title="Download Invoice"></i>)
			                            </a>
			                        </h5> 
                                    {else}
                                    <h5 class="text-center text-danger">Invoice Not Available</h5> 
                                    {/if}
                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice Acknowledgement</header>
                                <div class="panel-body panel scn-invoice-grid">
                                {if $invoice_file != ""}
                                    <h5 class="text-center">Download Invoice Acknowledgement</h5>
                                    <h4 class="text-center">
                                        <a href="{$invoice_file}" download>
                                            (<i class="fa fa-download text-success" title="Download Invoice ACK"></i>)
                                        </a>
                                    </h4> 
                                {else}
                                    <h5 class="text-center text-danger">Invoice Acknowledgement Not Available</h5> 
                                {/if}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <header class="panel-heading">Delivery Receipt & Label</header>
                            <div class="panel-body panel">
                                {if $delivery_slip}
                                <div class="col-md-12">
                                    <div class="col-md-2"><h5 class="text-left">Download DR</h5></div>
                                    <div class="col-md-2"><h5 class="text-left">Download Label</h5></div>
                                    <div class="col-md-8"></div>
                                </div>
                                <div class="col-md-12">
                                    {foreach from=$delivery_slip item=data}
                                    <form onsubmit="updateDeliverySlip('scanned-dr-{$data.id_delivery}',{$data.id_delivery}, 2,{$order_id},'{$orderBy}','{$orderWay}', {$page}); return false;" id="submit-document-{$data.id_delivery}" method="post" enctype="multipart/form-data">
                                        <div class="col-md-2">
                                            <h5>
    		                                        <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token={$token}&submitAction=generatePartialDeliverySlipPDF&id_order={$id_order}&id_delivery={$data.id_delivery}" download title="Download Delivery Slip">#{$data.delivery_number} ( <i class="fa fa-download text-success"></i> )
    		                                        </a>
    		                                    </h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>
    		                                        <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token={$token}&submitAction=generateDeliveryLabel&id_delivery_label={$data.id_delivery}" download title="Download Label"> #{$data.delivery_label} ( <i class="fa fa-download text-success"></i> )
    		                                        </a>
    		                                    </h5>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="btn btn-white" onclick="$('#dr-label-{$data.id_delivery}').slideToggle();">
                                                        Edit Label <i class="fa fa-edit"></i>
                                                    </div>
                                                    <span class="btn btn-white btn-file">
    		                                                        <span class="fileupload-new">
    		                                                            <i class="fa fa-paper-clip"></i> 
    		                                                                Select Scanned DR copy <i class="fa fa-hand-o-up"></i>
    		                                                            </span>
                                                    <span class="fileupload-exists">
    		                                                            <i class="fa fa-undo"></i> Change
    		                                                            </span>
                                                    <input type="file" id="scanned-dr-{$data.id_delivery}" class="default">
                                                    </span>
                                                    <span class="fileupload-preview marginleft5"></span>
                                                    <button class="btn btn-info" type="submit" title="Click here to upload scanned DR."><i class="fa fa-cloud-upload"> Upload</i></button> 
                                                    {if $data.dr_file_name && empty($data.files)}
                                                    <a href="scanedDRs/{$data.dr_file_name}" download>
                                                        <span class="btn btn-primary">Download Scanned Copy 
    		                                                                <i class="fa fa-download"></i>
    		                                                            </span>
                                                    </a>
                                                    {else}
                                                        {foreach $data.files as $file}
                                                            <a class="text-info" href="{$file}" download>#{$data.delivery_number}</a>
                                                        {/foreach}
                                                    {/if}
                                                    <a href="#" class="close fileupload-exists scn-fileupload-exists marginleft5" data-dismiss="fileupload"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-7 col-md-offset-4 padding10 display-none" id="dr-label-{$data.id_delivery}">
                                        <div class="padding10 box-edit">
                                            <form onsubmit="updateLabels('',{$data.id_delivery}, 2,{$order_id},'{$orderBy}','{$orderWay}',{$page}); return false;">
                                                <div class="form-group">
                                                    <label for="kobsterLabel">Kobster boxes</label>
                                                    <input type="text" class="form-control" id="kobsterLabel_{$data.id_delivery}" required placeholder="Enter required kobster boxes" value="{$data.kob_boxes}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="otherLabel">Other boxes</label>
                                                    <input type="text" class="form-control" id="otherLabel_{$data.id_delivery}" required placeholder="Enter required other boxes" value="{$data.other_boxes}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    {/foreach}</div>{else}
                                <h5 class="text-center text-danger">Delivery Slip Not Available</h5> {/if}
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewAllStatus_{$order_id}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center modal-text-font">Order Status History</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-center">
                            <table class="table">
                                <tbody>
                                 {foreach from=$history item=data}
                                    <tr>
                                        <td class="{if $data.id_order_state == $currentState['id_order_state']}order_status_active{/if}">
                                            <img src="img/statusIcon/32/{$data.id_order_state}.png" class="img-rounded">
                                        </td>
                                        <td class="{if $data.id_order_state == $currentState['id_order_state']}order_status_active{/if}">
                                            {$data.ostate_name} 
                                        </td>
                                        <td class="{if $data.id_order_state == $currentState['id_order_state']}order_status_active{/if}">
                                            {$data.employee_firstname} {$data.employee_lastname}
                                        </td>
                                        <td class="{if $data.id_order_state == $currentState['id_order_state']}order_status_active{/if}">
                                            {$data.date_add}
                                        </td>
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK" />
            </div>
        </div>
    </div>
</div>
{else}
   <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
   <link href="dash/css/style.css" rel="stylesheet">
   <div class="panel-body panel" id="orderMessages_{$order_id}">
    <div class="message-body col-md-10 col-md-offset-1">
    <header class="rm_heading m-bot20">Order Comment History for Order #{$order_id}</header>
    {if $messages} 
        {if ($cookie->profile == 5 )}
            {foreach from=$messages item=data}
                {if $data.private != 4}
                    {if $cookie->id_employee == $data.id_employee}
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-6 col-md-offset-5">
                                <div class="talk-bubble tri-right right-top">
                                    <div class="talktext">
                                        <p>
                                            {if $data.private == 1}
                                                <span class="text-danger">Private:</span><br/> 
                                            {/if} 
                                            {$data.message|unescape:'html'}<br>
                                            <span class="order-comment-time">
                                                {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                    {$data.date_add|date_format:"%I:%M %p"}
                                                {else}
                                                    {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                                {/if}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {else}
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-6">
                                <div class="talk-bubble tri-right left-top">
                                    <div class="talktext">
                                        <p>
                                            {if $data.private == 1}
                                                <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                            {/if} 
                                            <span class="text-info">
                                                <strong>From {if $data.efirstname}
                                                            {$data.efirstname} {$data.elastname}
                                                        {else}
                                                            {$data.cfirstname} {$data.clastname}
                                                        {/if}
                                                </strong>
                                            </span><br/> 
                                            {$data.message|unescape:'html'} <br>
                                            <span class="order-comment-time">
                                                {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                                    {$data.date_add|date_format:"%I:%M %p"}
                                               {else}
                                                    {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                               {/if}
                                            </span><br />
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if} 
                {/if}
            {/foreach}
        {elseif $cookie->profile == 6}
            {foreach from=$messages item=data} 
                {if $cookie->id_employee == $data.id_employee}
                <div class="col-md-12 m-bot20">
                    <div class="col-md-6 col-md-offset-5">
                        <div class="talk-bubble tri-right right-top">
                            <div class="talktext">
                                <p>
                                    {if $data.private == 1}
                                        <span class="text-danger">Private:</span><br/>
                                    {elseif $data.private == 4}
                                        <span class="text-danger">SCN Only</span><br/>
                                    {/if} 
                                    {$data.message|unescape:'html'}<br>
                                    <span class="order-comment-time">
                                        {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                            {$data.date_add|date_format:"%I:%M %p"}
                                        {else}
                                            {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                        {/if}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {else}
                <div class="col-md-12 m-bot20">
                    <div class="col-md-6">
                        <div class="talk-bubble tri-right left-top">
                            <div class="talktext">
                                <p>
                                    {if $data.private == 1}
                                        <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                    {/if} 
                                    <span class="text-info">
                                        <strong>From {if $data.efirstname}
                                                    {$data.efirstname} {$data.elastname}
                                                {else}
                                                    {$data.cfirstname} {$data.clastname}
                                                {/if}
                                        </strong>
                                    </span><br/> 
                                    {$data.message|unescape:'html'} <br>
                                    <span class="order-comment-time">
                                        {if ($smarty.now|date_format:"%D") == ($data.date_add|date_format:"%D")}
                                            {$data.date_add|date_format:"%I:%M %p"}
                                       {else}
                                            {$data.date_add|date_format:"%I:%M %p, %B %e, %Y"}
                                       {/if}
                                    </span><br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {/if} 
            {/foreach}
        {/if}
    {else}
        <h5 class="text-center text-danger">Messages Not Available.</h5>
    {/if}
{/if}


<div class="split-modal modal fade in" id="orderResultModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm prod-action-btn" id="new_order_btn"></button>
        <button type="button" class="splitClose btn btn-primary btn-sm prod-action-btn" data-dismiss="modal" id="old_order_btn"></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="split-modal modal fade in" id="splitcnfrm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Split Order - Confirmation</h4>
      </div>
      <div class="modal-body">
        <p>The Order <span id="splitcnfrmId"></span> will be split into different orders.The selected orders will be removed from this order and a new order will be placed.</p>
        <br>
        <p>Do you really want to split this order?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="splitClose btn btn-sm red-btn" id="new_order_btn">NO</button>
        <button type="button" class="btn btn-sm green-btn"  id="old_order_btn" onclick="splitOrder({$data.id_order},0,'{$orderBy}','{$orderWay}',1, {$page})">YES, SPLIT THE ORDER</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="split-modal modal fade in" id="splitError">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="splitClose modal-title">Split Order - Failed</h4>
      </div>
      <div class="modal-body">
        <p>Unable to split the order <span id="splitErrorId"></span></p>
        <p>Please check if you have selected correct products,if this issue still exists kindly contact your manager.</p>
        <br>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="scn/js/scn-orders.js"></script>
<script src="scn/js/htmlbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var hb = $("#text_message").htmlbox({
        icons:"default",
        skin:"default"
    });
    $("#text_message_html").height("100");
    $(".text_message_tb").hide();
</script>
<style type="text/css">
    .text-danger_new{
        padding: 8px;
        background-color: #dc2d3c;
        color: white;
    }
</style>
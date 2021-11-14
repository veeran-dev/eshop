<script type="text/javascript" src="./rm/js/rm-catalog.js"></script>

<div id="quotation-history-hidden" class="display-none">
    <form id="form_quotation_excel" name="form_invoice" action="scn-quote-excel.php" autocomplete="off" method="post" class="display-none">
        <div id="quotation-history-hidden-data">
        </div>
    </form>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Customer - Catalog history</div>
    <div class="panel-body">
    	<table id="example" class="display" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th class="table-header">
	                	<div>
	                		<div class="btn-container"><span class="btn btn-price active">Price</span><span class="btn btn-others">Others</span></div>
                		</div>
                	</th>
	            </tr>
	        </thead>
	        <tbody>
	        	{foreach $customer_details as $customer}
	        	<tr id="{$customer.id_group}">
	        		<td class="details-control"><span>{$customer.name}</span> <label>{$customer.read_count}</label><span class="fa fa-chevron-down"></span></td>
	        	</tr>
	        	{/foreach}	        	
	        </tbody>
	    </table>

		<div id="hidden_product_details" class="hidden">
		{assign var=group value="0"}
		{assign var=i value=1}
		{assign var=k value=1}


		{foreach $product_details_others as $product}
		{if $product.type != 3 && $product.type !=4}
			{if $group != $product.id_group }
				{assign var=group value=$product.id_group}
				<div id="show_others_{$product['id_group']}" class="active">
				<table class="product_details" id="{$product['id_group']}_product_details">
					<thead>
						<th>S.no</th>
						<th>Product</th>
						<th>Notification</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTableDate(0, this, 'others', {$product['id_group']})"></span>
							</span>
							Date added
						</th>
						<th>Rate Contract</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTable(0, this, 'others')"></span>
							</span>
							Read / Unread 
							<input type="checkbox" onclick="readNotifications(this, 'show_others', '{$product['id_group']}_product_details')" class="read_all">
						</th>
					</thead>
					<tbody class="show_others">
						<tr data-row-value="{$product.status}" data-row-id="{$product.sort_date}">
							<td>{$k}</td>
							<td>{$product.name} <br /> Ref: {$product.reference}</td>
							<td>{$product.notification}</td>
							<td class="date">{$product.date_added|date_format:"%b %e, %Y"}</td>
							<td>{$currency} {$product.sp|round:2} upto <br />{$product.expires}</td>
							<td>
								{if $product.status == 0}
									{assign var=read value="fa-exclamation-circle"}
								{else}
									{assign var=read value="fa-check-circle"}
								{/if}
								<span id="{$product.id_catalog_change}" onclick="readNotification(this, 'product_details', '{$k}_read', {$product.id_group});" class="read_notification fa {$read}"></span>
								<input value="{$product.id_catalog_change}_checkbox" onchange="checkRows('{$product.id_group}_product_details', '{$k}_read', this)" class="read_check {$k}_read" type="checkbox" name="" >
								<input type="hidden" class="{$k}_read_id_catalog_change hidden_id_catalog_change">
							</td>
						</tr>
				{if $product_details_others[$i-1]['id_group'] != $product_details_others[$i]['id_group']}
					</tbody>
				</table>
				<div class="action-row">
					<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, {$product.id_group}, 'product_details')">Mark as read/unread</button>
				</div>
				</div>
				{/if}
			{else if $group == $product['id_group']}
						<tr class="{$k}_row" data-row-value="{$product.status}" data-row-id="{$product.sort_date}">
							<td>
								{if ($product_details_others[$i-2]['name'] == $product_details_others[$i-1]['name'] && $product_details_others[$i-2]['sort_date'] != $product_details_others[$i-1]['sort_date']) || ($product_details_others[$i-2]['name'] != $product_details_others[$i-1]['name']) }
								{assign var=k value=$k+1}
									{$k}
								{else}
								{/if}
							</td>
							<td>
								{if ($product_details_others[$i-2]['name'] == $product_details_others[$i-1]['name'] && $product_details_others[$i-2]['sort_date'] != $product_details_others[$i-1]['sort_date']) || ($product_details_others[$i-2]['name'] != $product_details_others[$i-1]['name']) }
									{$product.name} <br /> Ref: {$product.reference}
									{assign var=hide value=""}
								{else}
									{assign var=hide value="hidden"}
								{/if}
							</td>
							<td> {$product.notification }</td>
							<td class="date"> {$product.date_added|date_format:"%b %e, %Y"}</td>
							<td>
								{if ($product_details_others[$i-2]['name'] == $product_details_others[$i-1]['name'] && $product_details_others[$i-2]['sort_date'] != $product_details_others[$i-1]['sort_date']) || ($product_details_others[$i-2]['name'] != $product_details_others[$i-1]['name']) }
									{$currency} {$product.sp|round:2} upto <br />{$product.expires}
								{/if}
							</td>
							<td>
								{if $product.status == 0}
									{assign var=read value="fa-exclamation-circle"}
								{else}
									{assign var=read value="fa-check-circle"}
								{/if}
							
								<span id="{$product.id_catalog_change}" onclick="readNotification(this, 'product_details', '{$k}_read', {$product.id_group});" class="read_notification fa {$read} {$hide}"></span>
								<input value="{$product.id_catalog_change}_checkbox" onchange="checkRows('{$product.id_group}_product_details', '{$k}_read', this)" class="read_check {$hide} {$k}_read" type="checkbox" name="" >
								{if $hide == ""}
									<input type="hidden" class="{$k}_read_id_catalog_change hidden_id_catalog_change">
								{/if}							
							</td>
						</tr>
				{if $product_details_others[$i-1]['id_group'] != $product_details_others[$i]['id_group']}
						</tbody>
					</table>
					<div class="action-row">
						<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, {$product.id_group}, 'product_details')">Mark as read/unread</button>
					</div>
				</div>
				{assign var=k value=1}
				{/if}
			{/if}
			{assign var=i value=$i+1}
		{/if}	
		{/foreach}

		{assign var=group2 value="0"}
		{assign var=j value=1}
		{assign var=l value=1}
		{foreach $product_details_price as $product}
		{if $product.type == 3 || $product.type ==4}
			{if $group2 != $product.id_group }
				{assign var=group2 value=$product.id_group}
				<div id="show_price_{$product['id_group']}" class="unactive">
				<table class="product_details" id="{$product['id_group']}_price_details">
					<thead>
						<th>S.no</th>
						<th>Product</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTableDate(0, this, 'price', {$product['id_group']})"></span>
							</span>
							Date added
						</th>
						<th>Location</th>
						<th>Changes</th>
						<th>Rate Contract</th>
						<th>New Quote</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTable(0, this, 'price')"></span>
							</span>
							Read / Unread 
							<input type="checkbox" onclick="readNotifications(this, 'show_price', '{$product['id_group']}_price_details')" class="read_all">
						</th>
					</thead>
					<tbody class="show_price">
						<tr data-row-value="{$product.status}" data-row-id="{$product.sort_date}">
							<td>{$l}</td>
							<td>{$product.name} <br /> Ref: {$product.reference}</td>
							<td class="date">{$product.date_added|date_format:"%b %e, %Y"}</td>
							<td>{if $product.city_name}{$product.city_name}{else}All India{/if}</td>
							<td>{$product.from} -- {$product.to}</td>
							<td>{$currency} {$product.sp|round:2} upto <br />{$product.expires}</td>
							<td class="rate_contract">
								<div>
									<input type="text" placeholder="New Price" name="Price" class="price">
								</div>
								<div>
									<input type="text" placeholder="Expiry" name="Expiry" class="datepicker">
								</div>
								<input type="hidden" value="{$product.id_product}" name="id_product" class="product_id" />
								<input type="hidden" value="{$product.product_price}" name="product_price" class="product_price" />
								<input type="hidden" value="{$product.name}" name="product_name" class="product_name" />
							</td>
							<td>
								{if $product.status == 0}
									{assign var=read value="fa-exclamation-circle"}
								{else}
									{assign var=read value="fa-check-circle"}
								{/if}
								<span id="{$product.id_catalog_change}" onclick="readNotification(this, 'price_details', '{$l}_read', {$product.id_group});" class="read_notification fa {$read}"></span>
								<input value="{$product.id_catalog_change}_checkbox" onchange="checkRows('{$product.id_group}_price_details', '{$l}_read', this)" class="read_check {$l}_read" type="checkbox" name="" >
								<input type="hidden" class="{$l}_read_id_catalog_change hidden_id_catalog_change">
							</td>
						</tr>
					{if $product_details_price[$j-1]['id_group'] != $product_details_price[$j]['id_group']}
					</tbody>
				</table>
				<div class="action-row">
					<button class="btn btn-primary" onclick="downloadQuote({$product.id_group})">Download Quote</button>
					<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, {$product.id_group}, 'price_details')">Mark as read/unread</button>
				</div>
				</div>
				{/if}
			{else if $group2 == $product['id_group']}
						<tr data-row-value="{$product.status}" data-row-id="{$product.sort_date}">
							<td>
								{if ($product_details_price[$j-2]['name'] == $product_details_price[$j-1]['name']  && $product_details_price[$j-2]['sort_date'] != $product_details_price[$j-1]['sort_date']) || ($product_details_price[$j-2]['name'] != $product_details_price[$j-1]['name'])}
								{assign var=l value=$l+1}
									{$l}
								{else}
								{/if}
							</td>
							<td>
								{if ($product_details_price[$j-2]['name'] == $product_details_price[$j-1]['name']  && $product_details_price[$j-2]['sort_date'] != $product_details_price[$j-1]['sort_date']) || ($product_details_price[$j-2]['name'] != $product_details_price[$j-1]['name'])}
									{$product.name} <br /> Ref: {$product.reference}
									{assign var=hide value=""}
								{else}
									{assign var=hide value="hidden"}
								{/if}
							</td>
							<td class="date">{$product.date_added|date_format:"%b %e, %Y"}</td>
							<td>{if $product.city_name}{$product.city_name}{else}All India{/if}</td>
							<td>{$product.from} -- {$product.to}</td>
							<td>{$currency} {$product.sp|round:2} upto <br />{$product.expires}</td>
							<td class="rate_contract">
							{if ($product_details_price[$j-2]['name'] == $product_details_price[$j-1]['name']  && $product_details_price[$j-2]['sort_date'] != $product_details_price[$j-1]['sort_date']) || ($product_details_price[$j-2]['name'] != $product_details_price[$j-1]['name'])}
								<div>
									<input type="text" placeholder="New Price" class="price">
								</div>
								<div>
									<input type="text" placeholder="Expiry" name="Expiry" class="datepicker">
								</div>
								<input type="hidden" value="{$product.id_product}" name="id_product" class="product_id" />
								<input type="hidden" value="{$product.product_price}" name="product_price" class="product_price" />
								<input type="hidden" value="{$product.name}" name="product_name" class="product_name" />
							{/if}
							</td>
							<td>
								{if $product.status == 0}
									{assign var=read value="fa-exclamation-circle"}
								{else}
									{assign var=read value="fa-check-circle"}
								{/if}
							
								<span id="{$product.id_catalog_change}" onclick="readNotification(this, 'price_details', '{$l}_read', {$product.id_group});" class="read_notification fa {$read} {$hide}"></span>
								<input value="{$product.id_catalog_change}_checkbox" onchange="checkRows('{$product.id_group}_price_details', '{$l}_read', this)" class="read_check {$hide} {$l}_read" type="checkbox" name="" >
								{if $hide == ""}
									<input type="hidden" class="{$l}_read_id_catalog_change hidden_id_catalog_change">
								{/if}
							</td>
						</tr>
				{if $product_details_price[$j-1]['id_group'] != $product_details_price[$j]['id_group']}
						</tbody>
					</table>
					<div class="action-row">
						<button class="btn btn-primary" onclick="downloadQuote({$product.id_group})">Download Quote</button>
						<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, {$product.id_group}, 'price_details')">Mark as read/unread</button>
					</div>
					</div>
					{assign var=l value=1}
				{/if}
			{/if}
			{assign var=j value=$j+1}
		{/if}
		{/foreach}
		</div>
    </div>

<style type="text/css">
	table{
		font-family: roboto;
	}
	table th{
		font-weight: 400;
	}
	table th .sort{
	    display: inline-block;
	    background: #fff;
	    border-radius: 16px;
	    color: #666666;
	    padding: 4px;
	}
	table th .sort .fa{
		display: block;
	}
	.details-control .fa-chevron-down{
	    /*color: #428bca;
    	padding: 8px 56px;*/
    	color: #428bca;
	    /* padding: 8px 56px; */
	    float: right;
	    padding: 6px;
	    /* background: #428bca; */
	    border: 1px solid #428bca;
	}
	.details-control span{
	    text-transform: uppercase;
    	font-size: 14px;
    	font-weight: 500;
	}

	table tbody tr .details-control label{
		border: 1px solid #ececec;
	    width: 24px;
	    height: 24px;
	    background: rgb(66, 139, 202);
	    border-radius: 14px;
	    font-weight: 400;
	    padding: 2px;
	    margin: 0px 20px;
	    color: #fff;
	    text-align: center;
	}
	table tbody tr .details-control{
		border: 1px solid #ccc;
		padding: 4px 8px 4px 16px;
	}
	.action-row{
		text-align: right;
		padding: 4px;
	}
	.product_details	{
		width: 100%;
	}
	.product_details thead tr th{
		padding: 8px;
	}
	.product_details thead{
		background: #428bca;
	    border: 1px solid #428bca;
    	color: #fff;
	}
	.product_details tbody tr td{
	    padding: 8px;
    	border: 1px solid #dddddd;
	}
	.product_details tbody tr{
		/*border: 1px solid #428bca !important;*/
	}
	.btn-container{
		text-align: center;
		padding: 4px;
	}
	.btn-container .active{
		background: #428bca !important;
		color: #fff !important;
		border: 1px solid #428bca !important;
		border-radius: 0px !important;
	}
	.btn-container .btn{
		background: #fff;
		color: #428bca;
		border: 1px solid #428bca;
		border-radius: 0px;
	}
	.rate_contract input{
        padding: 4px;
	    margin: 2px;
	    border: none;
	    border-radius: 0px;
	    border: 1px solid #ccc;
	    text-align: center;
	}
	.fa-exclamation-circle, .fa-check-circle{
		font-size: 24px;
		transition: 300ms ease;
	}
	.fa-check-circle{
		color: green;
	}
	.fa-exclamation-circle{
		color: orange;
	}

	input[type="checkbox"] {
    	margin: 8px;
	    width: 14px;
	    height: 14px;
	}

	input::-webkit-input-placeholder {
	color: #888888 !important;
	}
	 
	input:-moz-placeholder { /* Firefox 18- */
	color: #888888 !important;
	}
	 
	input::-moz-placeholder {  /* Firefox 19+ */
	color: #888888 !important;
	}
	 
	input:-ms-input-placeholder {  
	color: #888888 !important;
	}
	button{
		border-radius: 0px !important;
	}
	.btn-primary{
		background: #428bca;
		border-color: #428bca;
		color: #fff;
	}
	.btn-primary:hover, .btn-primary:active{
		background: #428bca !important;
		border-color: #428bca !important;
		color: #fff !important;
	}
	.btn-info{
		background: #fff !important;
		border-color: #428bca !important;
		color: #428bca !important;
	}
	.btn-info:hover, .btn-info:active{
		background: #fff !important;
		border-color: #428bca !important;
		color: #428bca !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		console.log("alert");
		$('.sidebar-toggle-box .fa-bars').click();
	});
</script>
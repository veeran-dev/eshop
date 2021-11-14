<div class="panel" id="">
    <div class="col-md-12 text-center panel-heading"><b>CHANGE INVOICE TAX</b></div>
    <br><br>
    <div class="panel-body">
    <section class="panel">
    <br>
    <br>
        <div class="col-md-3 col-md-offset-4">
            <input type="text" class="form-control" id="order_id" value="{if isset($id_order)}{$id_order}{/if}">
            {if isset($error)}<label class="finance-error">{$error}</label>{/if}
        </div>
        <button id="searchVatButton" class="btn btn-primary clrbtn">Search</button>
        {if isset($data)}
        <table class="table table-striped table-hover table-bordered" id="change_invoice_vat_table">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Toal Price(tax excl)</th>
					<th>Tax Rate</th>
                    <th>Action</th>
             	</tr>
            </thead>
            <tbody id="finance_invoice_table">
            {assign var=i value=1}
            {foreach $data as $line_item}
            <tr>
                <td>{$i}</td>
                <td>{$line_item.product_name}</td>
                <td>{$line_item.product_quantity}</td>
                <td>{$line_item.total_price_tax_excl}</td>                
                <td class="vat_rate_td">
                    <span id="{$line_item.id_order_detail}_tax" class="item_rate">{$line_item.rate}</span>
                    <span id="{$line_item.id_order_detail}_tax_rate" class="item_rate_select">
                        <select class="item_rate_values">
                        {foreach $tax as $tax_rate}
                            <option value="{$line_item.id_order_detail}-{$tax_rate.id_tax}-{$tax_rate.rate}" {if $tax_rate['rate'] == $line_item['rate']} selected="selected"{/if}>{$tax_rate.rate}</option>
                        {/foreach}
                        </select>
                    </span>
                </td>
                <td>
                    <span class="asd">
                        <input type="checkbox" id="{$line_item.id_order_detail}_select" name="check[]" class="checkbox" ></input>
                    </span>
                </td>
            </tr>
            {assign var=i value=$i+1}
            {/foreach}
            </tbody>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
             </tr>
			  
        </tfoot>
        </table>
        <button class='btn btn-primary' id='vat_save_changes'>Save Changes</button>
        {/if}
     </section>
   </div>
</div>
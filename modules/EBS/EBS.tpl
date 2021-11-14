<!--<p class="payment_module">
	<a href="javascript:$('#EBS_form').submit();" title="{l s='Net Banking/Credit Card/Debit card/Cash Cards' mod='EBS'}">
		<img src="{$module_dir}logo.png" alt="{l s='Net Banking/Credit Card/Debit card/Cash Cards' mod='EBS'}" />
		{l s='Net Banking/Credit Card/Debit Card/Cash Cards' mod='EBS'}
	</a>
</p>-->

<form action="{$EBSUrl}" method="post" id="EBS_form" class="hidden">
	<input type="hidden" name="account_id" value="{$account_id}" />
	<input type="hidden" name="reference_no" value="{$cartID}" />
	<input name="amount" type="hidden" value="{$total}" />
	<input name="description" type="hidden" value="Test Order Description" />
	<input name="name" type="hidden" value="{$address->firstname}" />
    <input name="address" type="hidden" value="{$address->address1}" />
	<input name="city" type="hidden" value="{$address->city}" />
	<input name="state" type="hidden" value="{$state}" />
	<input name="postal_code" type="hidden" value="{$address->postcode}" />
	<input name="country" type="hidden" value="{$country->iso_code}" />
	<input name="email" type="hidden" value="{$customer->email}" />
	<input name="phone" type="hidden" {if $address->phone}value="{$address->phone}" 
										{elseif $address->phone_mobile}value="{$address->phone_mobile}"{/if} />
	<input name="ship_name" type="hidden" value="{$address->firstname}" />
	<input name="ship_address" type="hidden" value="{$address->address1}" />
	<input name="ship_city" type="hidden" value="{$address->city}" />
	<input name="ship_state" type="hidden" value="{$state}" />
	<input name="ship_postal_code" type="hidden" value="{$address->postcode}" />
	<input name="ship_country" type="hidden" value="{$country->iso_code}" />
	<input name="ship_phone" type="hidden" value="{$address->phone}" />
	<input name="return_url" type="hidden" size="60" value="{$return_url}" />
	<input name="mode" type="hidden" size="60" value="{$mode}" />
	<input name="secure_hash" type="hidden" value="{$secure_hash}" />
    <div style="height:30px; border-bottom:1px solid #8f8f8f; padding-left:20px; width:402px;"><h4>Pay By Net Banking</h4><img src="{$module_dir}netbank_logo.png" alt="{l s='Net Banking/Credit Card/Debit card/Cash Cards' mod='EBS'}" style="float:right;margin-top:-18px;"/></div>
    <div id="select_bank">
    	<label id="netbank">Select Your Bank - </label>
   		<select id="sel_Issuingbank"  onchange="document.getElementById('Issuingbank').value=this.value">
         	<option value="">Select Bank</option>
            <option value="1004">AXIS BANK</option>
            <option value="1007">HDFC BANK</option>
            <option value="1016">ICICI BANK</option>
            <option value="1032">STATE BANK OF INDIA</option>
            <option value="1029">FEDERAL BANK</option>
            <option value="1015">J & K BANK</option>
            <option value="1034">STATE BANK OF HYDERABAD</option>
            <option value="1038">STATE BANK OF MYSORE</option>
            <option value="1039">STATE BANK OF TRAVANCORE</option>
            <option value="1035">STATE BANK OF PATIALA</option>
            <option value="1033">STATE BANK OF BIKANER AND JAIPUR</option>
            <option value="1133">KARNATAKA BANK</option>
            <option value="1135">CORPORATION BANK</option> 
            <option value="1143">INDIAN BANK</option>
            <option value="1147">CENTRAL BANK OF INDIA</option>
            <option value="1148">KOTAK MAHINDRA BANK</option>
            <option value="1146">YES BANK</option>
            <option value="1154">ORIENTAL BANK OF COMMERCE</option>
            <option value="1210">ING VYSYA BANK</option>
            <option value="1213">INDIAN OVERSEAS BANK</option>
            <option value="1212">UNITED BANK OF INDIA</option>
            <option value="1216">UNION BANK OF INDIA</option>
            <option value="1214">BANK OF INDIA</option>
            <option value="1215">CITY UNION BANK</option>
            <option value="1224">CANARA BANK</option>
            <option value="1227">DEUTSCHE BANK</option>
		</select>	
	</div>
    <input type="hidden" name="Issuingbank" id="Issuingbank" value="" />
    <input type="button" class="pay_button_small" style="margin-left: 144px;margin-top: 32px; float:none;" onclick="fn_click();" value="Submit" />
    
</form>
<script>
function change_radio()
{	
	var status=$('input:radio[name="card_type"]:checked').val();
	if(status==3)
	{
		$('#select_bank').show();
	}
}

 function fn_netbanking()
{
	var netbank= $('#Issuingbank').val();
 }

function fn_click()
{
	var hidval=$("#hid_Issuingbank").val();
	$('#EBS_form').submit();
}
function fn_click_pay()
{
	$('#EBS_form').submit();
}
</script>

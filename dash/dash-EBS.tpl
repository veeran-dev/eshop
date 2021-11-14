<script type="text/javascript" src="dash/js/EBS.js"></script>

<form  method="post" id="EBS_form" >
  <input id="account_id" name="account_id" type="hidden" value="{$account_id}" />
  <input id="reference_no" name="reference_no" type="hidden" value="{$cartID}" />
  <input id="amount" name="amount" type="hidden" value="{$total}" />
  <input id="description" name="description" type="hidden" value="Test Order Description" />
  <input id="name" name="name" type="hidden" value="{$address->firstname}" />
  <input id="address" name="address" type="hidden" value="{$address->address1}" />
  <input id="city" name="city" type="hidden" value="{$address->city}" />
  <input id="state" name="state" type="hidden" value="{$state}" />
  <input id="postal_code" name="postal_code" type="hidden" value="{$address->postcode}" />
  <input id="country" name="country" type="hidden" value="{$country->iso_code}" />
  <input id="email" name="email" type="hidden" value="{$customer->email}" />
  <input id="phone" name="phone" type="hidden" {if $address->
  phone}value="{$address->phone}" 
  {elseif $address->phone_mobile}value="{$address->phone_mobile}"{/if} />
  <input id="ship_name" name="ship_name" type="hidden" value="{$address->firstname}" />
  <input id="ship_address" name="ship_address" type="hidden" value="{$address->address1}" />
  <input id="ship_city" name="ship_city" type="hidden" value="{$address->city}" />
  <input id="ship_state" name="ship_state" type="hidden" value="{$state}" />
  <input id="ship_postal_code" name="ship_postal_code" type="hidden" value="{$address->postcode}" />
  <input id="ship_country" name="ship_country" type="hidden" value="{$country->iso_code}" />
  <input id="ship_phone" name="ship_phone" type="hidden" value="{$address->phone}" />
  <input id="return_url" name="return_url" type="hidden" size="60" value="{$return_url}" />
  <input id="mode" name="mode" type="hidden" size="60" value="{$mode}" />
  <input id="secure_hash" name="secure_hash" type="hidden" value="{$secure_hash}" />
  <section class="panel" style="height:450px;">
    <header class="panel-heading">Pay By Net Banking</header>
    <div class="panel-body" >
      <div class="">
        <div style="">
          <p><b>Press Submit to redirect  payment gateway</b></p>
      </div>
      <input type="submit" class="btn btn-danger kob_button"  value="Submit" />
    </div>
  </section>
  <!--<div id="select_bank">
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
	</div>--> 
  <!-- <input type="hidden" name="Issuingbank" id="Issuingbank" value="" />-->
  
</form>

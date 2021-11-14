
<!DOCTYPE html>
<html lang="en">
<script type="text/javascript">
	document.getElementById("checkout_confirmation").submit();
 </script>
<body>
	<div id="ebs_block">
		<form name="checkout_confirmation" id="checkout_confirmation" action="{$ebsurl}" method="POST">
			<input type="hidden" name="channel" value="{$channel}" />
			<input type="hidden" name="account_id" value="{$account_id}" />
			<input type="hidden" name="page_id" value="{$page_id}" />
			<input type="hidden" name="currency" value="{$currency}" />
			<input type="hidden" name="reference_no" value="{$reference_no}" />
			<input name="amount" type="hidden" value="{$total}" />
			<input name="description" type="hidden" value="{$description}" />

			<input name="name" type="hidden" value="{$name}" />
			<input name="address" type="hidden" value="{$address}" />
			<input name="city" type="hidden" value="{$city}" />
			<input name="postal_code" type="hidden" value="{$postal_code}" />
			<input name="country" type="hidden" value="{$country}" />
			<input name="email" type="hidden" value="{$email}" />
			<input name="phone" type="hidden" value="{$phone}" />
			<input name="return_url" type="hidden" size="60" value="{$return_url}" />
			<input name="secure_hash" type="hidden" size="100" value="{$secure_hash}" />
			<input name="mode" type="hidden" size="60" value="{$mode}" />				
		</form>
	</div>
</body>
</html>
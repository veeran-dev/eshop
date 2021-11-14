{capture name=path}{l s='Document Verification'}{/capture}
{*{include file="$tpl_dir./breadcrumb.tpl"}*}
<h1>{l s='Upload Document and Get Yourself Verified'}</h1>
<div class="padding5" style="font-size:12px;"> If you are a business buyer, you can submit any one of the below documents to get yourself registered with us. Upon registration you can start purchasing from our website.</div>
{include file="$tpl_dir./errors.tpl"}
{if isset($confirmation) && $confirmation}
<p class="confirmation" style="background-color:#28c779;color:#FFF !important;">
	{$confirmation}
</p>
{/if}
<div class="padding5" style="font-size:12px;">The required documents are:</div>
<div class="paddleft5">
<p>1.Service Tax Registration Certificate</p>
<p>2.GST Registration Certificate</p>
<p>3.CST Registration Certificate</p>
<p>4.Excise Registration Certificate</p>
<p>5.Registration Certificate under Shop & Establishment Act</p>
<p>6.Trade License if any issued by relevant government/municipal authorities</p>
<p>7.Institutions having certificate of incorporation or registration as a society or registration as public trust – for educational institutions etc</p>
<p>8.Registration Certificate under Societies Registration Act, 1860</p>
<p>9.Registration Certificate under the Indian Trusts Act, 1882</p>
<p>10.Professional Tax Certificate</p>
<p>11.Permission Letters/approvals/certificate/registrations from the Central or State Government, as the case may be, or by Statutory accreditation agencies, including the University Grants Commission</p>
<p>12.Registration Certificate issued by the relevant State Health Department for hospitals</p>
<p>13.Registration Certificate issued by the State Medical Council for practicing doctors or nursing</p>
<p>14.License issued by the Reserve Bank of India</p>
<p>15.The Agriculture Produce Market License (APMC)</p>
<p>16.FSSAI License</p>
<p>17.Weights & Measures License</p>
<p>18.Drugs & Cosmetics License (Form 20&21)</p>
</div>
<div class="padding5 paddingtop15">
	<div class="buyer-document-upload">
 		<form action="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}verify-document.php" method="post" class="uploadBuyerDoc" enctype="multipart/form-data">
			<input type="file" name="uploadBuyerDocument" id="uploadBuyerDocument">
			<span class="paddleft5"><input type="submit" style="width:20%;" class="submitDocument" name="submitDocument" id="submitDocument" value="{l s='Upload'}"/></span>
			<div class="padding5">Maximum file size 5 MB</div>
			<div class="padding5">Acceptable formats : (gif, png, jpg, docx, doc, pdf, rtf, zip)</div>
		</form>
	</div>
</div>
 

{capture name=path}{l s='Partner'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<h1>{l s='Partner With Kobster'}</h1>
{if isset($confirmation)}
	<p>{l s='Thank you for contacting us. We will get in touch with you shortly.'}</p>
	<ul class="footer_links">
		<li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.png"/></a><a href="{$base_dir}">{l s='Home'}</a></li>
	</ul>
{elseif isset($alreadySent)}
	<p>{l s='Your message has already been sent.'}</p>
	<ul class="footer_links">
		<li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.png"/></a><a href="{$base_dir}">{l s='Home'}</a></li>
	</ul>
{else}
	<p>
	Are you fascinated by power of internet and the way it has changed the way business is done in India? Do you think that way forward is e-commerce considering the fact that there are thousands of people buying office products online every day, and you can be part of it. If you are manufacturer or distributor of any products and interested to promote your products through our site, please get in touch with us.</p> 
	<p>Just call us on <b>044-64573222</b> or drop a mail at <b>partners@kobster.com</b> and our friendly supply chain team will contact you within 24 hours. Happy Partnering with Us!!
	</p>
	<br />
	<p class="bold">{l s='Please give us the following details and we wll get back to you shortly'}.</p>
	{include file="$tpl_dir./errors.tpl"}
	<form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std" enctype="multipart/form-data">
		<fieldset>
			<p class="text">
				<label for="name">{l s='Your Name'}</label>
				<input type="text" id="name" name="name" />
			</p>
			
			<p class="text">
				<label for="org_name">{l s='Your Organization Name'}</label>
				<input type="text" id="org_name" name="org_name" />
			</p>
			
			<p class="text">
				<label for="email">{l s='E-mail address'}</label>
				<input type="text" id="email" name="from" />
			</p>
			
			<p class="text">
				<label for="phone">{l s='Phone no'}</label>
				<input type="text" id="phone" name="phone" />
			</p>
		<p class="submit">
			<input type="submit" name="submitMessage" id="submitMessage" value="{l s='Send'}" class="button_large" />
		</p>
	</fieldset>
</form>
{/if}
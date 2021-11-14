{if $page_name == 'index'}
<!-- <script type="text/javascript" src="{$this_path}js/nivo.slider.js"></script> -->

<div id="tmn">
	<span id="tmnleft">
		<div id="tmnivoslider">

			<div id="slider">
				{foreach from=$xml->link item=home_link name=links}
					<a href="{$home_link->url}" id="img_{$smarty.foreach.links.iteration}" onclick="showPopup({$smarty.foreach.links.iteration},'{$home_link->img}');"><img src="https://www.kobster.co/modules/tmnivoslider/{$home_link->img}"  alt="slider" title="#htmlcaption{$smarty.foreach.links.iteration}" /></a>
                    <!--<span style="cursor:pointer;" id="img_{$smarty.foreach.links.iteration}" onclick="showPopup({$smarty.foreach.links.iteration},'{$home_link->img}');"><img src="{$link->getPageLink('index.php')}modules/tmnivoslider/{$home_link->img}"  alt="" title="#htmlcaption{$smarty.foreach.links.iteration}" /></span>-->
				{/foreach}
			</div>
			
			{foreach from=$xml->link item=home_link name=links key=k}
				<div id="htmlcaption{$smarty.foreach.links.iteration}" class="nivo-html-caption">
					<h2 class="slide{$smarty.foreach.links.iteration}_title">{$home_link->field1}</h2>
					<h3 class="slide{$smarty.foreach.links.iteration}_descr">{$home_link->field2}</h3>
					<p class="slide_descr1 num-{$smarty.foreach.links.iteration}">{$home_link->field3}</p>
					<p class="slide_descr2 num-{$smarty.foreach.links.iteration}">{$home_link->field4}</p>
					<a href="{$home_link->url}" class="slide_btn">{$home_link->field5}</a>
				</div>
			{/foreach}
		</div>
	</span>
</div>

   
    <div id="popup-analytics" >
		<div class="float_right">
				<img id="cancel_demo" alt="close" src="img/close.png" />
		</div>
    
		<div class="popupPart1">
			<img src="img/popup-img/Analytics-pop-up.jpg" alt="Analytics-pop-up" />
		</div>
		
		<div class="popupPart2">
			<form action="demoqutoes.php" method="post" onsubmit="saveDemo(); return false;" id="demoRegestration"  enctype="multipart/form-data" >
				<fieldset id="demo_fieldset">
					<div class="demo_fields">
						<input type="text" class="account_input" id="demo_name" placeholder="Name" name="demo_name" value=""/>
					</div>
					<div class="demo_fields">
						<input type="text" class="account_input" id="demo_phonenumber" placeholder="Mobile Number" name="demo_phonenumber" value=""/>
					</div>
					 <div class="demo_fields">
						<input type="text" class="account_input" id="demo_email" placeholder="Email" name="demo_email" value=""/>
					</div>
					<div >
						<!--<input type="button" class="reg_button_small" id="cancel_demo" name="cancel_demo" value="Cancel"/>-->
						<input type="submit" id="send_demo_detail" class="reg_button popupreg" name="send_demo_detail"  value="SUBMIT"/>
					</div>
			   </fieldset>
		   </form>
		</div>
    </div>
   
   <div id="restest">
   	{l s =$demo}
   </div>
   
   <div id="popup-qutoes" >
   		<div class="float_right" >
    		<img id="cancel_qutoes" src="img/close.png" alt="close" />
   		</div>
		<div class="popupPart1">
			<img src="img/popup-img/house-keeping-pop-up.jpg" alt="house-keeping-pop-up" />
		</div>
		<div class="popupPart2">
			
			 <form action="demoqutoes.php" method="post" onsubmit="saveQutoes(); return false;" id="quoteRegistration"  enctype="multipart/form-data">
				<fieldset id="qutoes_fieldset">
					<div class="qutoes_fields">
						<input type="text" class="account_input" id="qutoes_name" placeholder="Name" name="qutoes_name" value=""/>
					</div>
					<div class="qutoes_fields">
						<input type="text" class="account_input" id="qutoes_phonenumber" placeholder="Mobile Number" name="qutoes_phonenumber" value=""/>
					</div>
					 <div class="qutoes_fields">
						<input type="text" class="account_input" id="qutoes_email" placeholder="Email" name="qutoes_email" value=""/>
					</div>
					<div >
						<input type="file" name="uploadFile" id="uploadFile"><!--<label id="mbLabel">Max <br/>2Mb</label>-->
						<!--<input type="text" class="account_input" id="qutoes_email" placeholder="Enter your Email Id" name="qutoes_email" value=""/>-->
					</div>
					<div >
						<!--<input type="button" class="reg_button_small" id="cancel_qutoes" name="cancel_qutoes" value="Cancel"/>-->
						<input type="submit" id="send_qutoes_detail" class="reg_button popupreg" name="send_qutoes_detail" value="GET QUOTE"/>
					</div>
			   </fieldset>
			</form>
		</div>
   </div>

<script type="text/javascript">

	$(document).ready(function() {
		//$('#popup-analytics').modalPopLite({ openButton: '#img_4', closeButton: '#cancel_demo' });
		/*$('#popup-qutoes').modalPopLite({ openButton: '#img_2', closeButton: '#cancel_qutoes' });*/
	});
	
	function showPopup(id,slides)
	{
 		if(slides=="slides/analytics.png")
		{
			$('#popup-analytics').show();
			
   		}
		/*if(slides=="slides/house-keeping.png")
		{
			$('#popup-qutoes').show();
		}*/
	}
	 function saveDemo()
	{
 		var name = $('#demo_name').val(); 
		var phonenumber = $('#demo_phonenumber').val();
		var email = $('#demo_email').val();
		var status = 0;
		
		if(name == "")
		{
			status = 1;
			$('#demo_name').attr("placeholder", "Please Enter the Name");
		}
		if(phonenumber == "")
		{
			status = 1;
			$('#demo_phonenumber').attr("placeholder", "Please Enter the phone number");
		}
		if(email == "")
		{
			status = 1;
			$('#demo_email').attr("placeholder", "Please Enter the email");
		}
		if(status == 1)
		{
			return false;
		}
		else
		{
			$("#demoRegestration").submit();
 		}
		
		 
	}
	 function saveQutoes()
	{
  		var name = $('#qutoes_name').val(); 
		var phonenumber = $('#qutoes_phonenumber').val();
		var email = $('#qutoes_email').val();
  		var status = 0;
		
		if(name == "")
		{
			status = 1;
			$('#qutoes_name').attr("placeholder", "Please Enter the Name");
		}
		if(phonenumber == "")
		{
			status = 1;
			$('#qutoes_phonenumber').attr("placeholder", "Please Enter the phone number");
		}
		if(email == "")
		{
			status = 1;
			$('#qutoes_email').attr("placeholder", "Please Enter the email");
		}
		if(status == 1)
		{
			return false;
		}
		else
		{
			$("#quoteRegistration").submit();
			
		}
		
	} 

{literal}
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'fold', //Specify sets like: 'fold,fade,sliceDown'
		slices:10,
		animSpeed:700, //Slide transition speed
		pauseTime:4000,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:true, //Next & Prev
		directionNavHide:false, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
      	controlNavThumbsFromRel:false, //Use image rel for thumbs
		controlNavThumbsSearch: '.jpg', //Replace this with...
		controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
		keyboardNav:true, //Use left & right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:1.0, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});
{/literal}
</script>
{/if}
 
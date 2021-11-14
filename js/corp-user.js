function tohideemptyresult()
{
	$("#empty-result").hide();	
}
$(function()
{
	$("#corporate-user-search-box").val("");
	$("#corporate-user-quantity-value").val(1);
	$("#cart_block_wrapper").css({"position":"static"});
	$("#cart_block").css({"display":"block", "margin-top":"-23px","margin-left":"-171px","position":"static"});
	$("#collapse-icon").css("display","none");
	$("#cart_block h4 span ").css("cursor","default");
});
$(document).ready(function()
{
	setTimeout(function (){
	ajaxCart.expand();
	},700);
	$("#block_cart_collapse").unbind();
	var idProduct,id_product_attribute;
	var auto=2;
	$("#corporate-user-search-box").autocomplete("corp-purchaselist.php?auto="+auto+"&id_customer="+id_customer,{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;
	},
	parse: function(data){
		if(data=="")
		{
		$("#search-load-image").hide();	
		$("#empty-result").show();	
		return data;
		}
		else{
		$("#empty-result").hide();	
		var mytab = new Array();
		for(var i = 0; i < data.length; i++)
				mytab[mytab.length] = { data: data[i].id_product+"," +data[i].name+"," +data[i].id_product_attribute, value:"<div><span style=float:left;>"+"<img src="+data[i][0]+">" +"</span>"+ "<span class='ul-font-size' style='float:right;height:45px;width:180px;overflow:hidden;white-space: nowrap;text-overflow:ellipsis;'>"+data[i].name+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs."+(data[i][1]).toFixed(2)+"</span></div>"};
			return mytab;
		}},
	}).result(
	function(event, data, formatted, value) {
		        var separate=data.split(",");
				$('#corporate-user-search-box').val(separate[1]);
		 idProduct=separate[0];

	id_product_attribute=separate[2];
	changefocus(); 
	$("#empty-result").hide();		
	});
 	$("#corporate-user-add-to-cart").click(function(){
	var quantity=$("#corporate-user-quantity-value").val();
	ajaxCart.add(idProduct, null, false, this, quantity, null);
	$("#corporate-user-search-box").val("");
	$("#corporate-user-quantity-value").val(1);
	$("#corporate-user-search-box").focus();
	});
function changefocus()
	{
		$("#corporate-user-quantity-value").select();
	}
$(document).ajaxStart(function() {
$("#search-load-image").show();
});
$(document).ajaxStop(function() {
$("#search-load-image").hide();
 });
});
	
$(document).keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		$('#corporate-user-add-to-cart').click();   
    }
});


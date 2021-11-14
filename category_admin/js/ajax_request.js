// JavaScript Document
$(document).ready(function() {
				
	$("#slider").change(function(){
		var form = $('form')[0];
		var form_data = new FormData(form);
		form_data.append("action", "add");
		$.ajax({
			url : 'get_sliderResponse.php',
			data : form_data,
			async: false,
			type : 'POST',
			success : function(result) {
				$("#slider_img").html(result);	
				$("#slider").val("");						
			},
			cache: false,
			contentType: false,
			processData: false
		});	
	});
	
	$("#category_image").change(function(){
		var img_id = $('#category_image_id').val();
		if (img_id == ''){
			$("#category_img_error").html("Please select Category to Link with image");
			$("#category_img_error").show();
			$("#category_image").val("");
			setTimeout(function(){
			  $("#category_img_error").hide();        
			}, 3000);
		}
		else{
			var form = $('form')[0];
			var form_data = new FormData(form);
			form_data.append("action", "add");
			$.ajax({
				url : 'get_categoryImgResponse.php',
				data : form_data,
				async: false,
				type : 'POST',
				success : function(result) {
					$("#category_img").html(result);	
					$("#category_image").val("");						
				},
				cache: false,
				contentType: false,
				processData: false
			});	
		}
	});
	
	$("#associated_products").change(function(){
		var prodct_id = $('#associated_products_id').val();
		if (prodct_id == ''){
			$("#associated_products_error").html("Please Enter Product ID to Link with image");
			$("#associated_products_error").show();
			$("#associated_products").val("");
			setTimeout(function(){
			  $("#associated_products_error").hide();        
			}, 3000);
		}
		else{
			var form = $('form')[0];
			var form_data = new FormData(form);
			form_data.append("action", "add");
			$.ajax({
				url : 'get_subCategoryImgResponse.php',
				data : form_data,
				async: false,
				type : 'POST',
				success : function(result) {
					$("#products_list").html(result);	
					$("#associated_products_id").val("");					
				},
				cache: false,
				contentType: false,
				processData: false
			});	
		}
	});
	
});

function slider_remove(id){
	
	var result = confirm("Are you sure Want to delete?");
	if (result) {
		var form_data = new FormData();
		form_data.append("action", "delete");
		form_data.append("id_category", $("#id_category").val() );
		form_data.append("id_delete", id);
	
		$.ajax({
			url : 'get_sliderResponse.php',
			data : form_data,
			async: false,
			type : 'POST',
			success : function(result) {
				$("#slider_img").html(result);							
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}
	
	
}

function category_remove(id){
	
	var result = confirm("Are you sure Want to delete?");
	if (result) {
		var form_data = new FormData();
		form_data.append("action", "delete");
		form_data.append("id_category", $("#id_category").val() );
		form_data.append("id_delete", id);
	
		$.ajax({
			url : 'get_categoryImgResponse.php',
			data : form_data,
			async: false,
			type : 'POST',
			success : function(result) {
				$("#category_img").html(result);							
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}
}

function product_remove(id){
	var result = confirm("Are you sure Want to delete?");
	if (result) {
		var form_data = new FormData();
		form_data.append("action", "delete");
		form_data.append("id_category", $("#id_category").val() );
		form_data.append("id_delete", id);
	
		$.ajax({
			url : 'get_subCategoryImgResponse.php',
			data : form_data,
			async: false,
			type : 'POST',
			success : function(result) {
				$("#products_list").html(result);							
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}
}

function most_searched(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("list_most_searched", $("#list_most_searched").val() );

	$.ajax({
		url : 'get_mspResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#msp_list").html(result);
			$("#list_most_searched").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

function top_selling(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("list_top_selling", $("#list_top_selling").val() );

	$.ajax({
		url : 'get_topSellingResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#ts_list").html(result);
			$("#list_top_selling").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

function top_viewed(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("list_top_viewed", $("#list_top_viewed").val() );

	$.ajax({
		url : 'get_topViewedResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#tv_list").html(result);
			$("#list_top_viewed").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

function top_discounted(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("list_top_discounted", $("#list_top_discounted").val() );

	$.ajax({
		url : 'get_topdiscountedResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#td_list").html(result);
			$("#list_top_discounted").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

function kobster_recommented(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("list_kobster_recommented", $("#list_kobster_recommented").val() );

	$.ajax({
		url : 'get_kobsterRecommentedResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#kr_list").html(result);
			$("#list_kobster_recommented").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}

function brands(id, action){
	
	var form_data = new FormData();
	form_data.append("id", id);
	form_data.append("action", action);
	form_data.append("id_category", $("#id_category").val() );
	form_data.append("associated_brands", $("#associated_brands").val() );

	$.ajax({
		url : 'get_brandResponse.php',
		data : form_data,
		async: false,
		type : 'POST',
		success : function(result) {
			$("#brand_list").html(result);
			$("#associated_brands").val("")							
		},
		cache: false,
		contentType: false,
		processData: false
	});
}
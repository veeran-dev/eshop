<?php
require('../config/config.inc.php');
$id_category = $_GET['id_category'];
$query = "SELECT a.`id_category`, `name`, `description`, `id_parent`, `list_category_slider`, `category_image`, `list_most_searched`, `list_top_selling`, `list_top_viewed`, `list_top_discounted`, `list_kobster_recommented`, `list_ads` FROM `"._DB_PREFIX_."category_listing` cl LEFT JOIN `kob_category_lang` b ON (b.`id_category` = cl.`category_id` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (cl.`category_id` = sa.`id_category` AND sa.id_shop = 1) LEFT JOIN `kob_category` a ON (a.`id_category` = cl.`category_id`)  WHERE `category_id` = ".$id_category;

$category_details = Db::getInstance()->ExecuteS($query);
$total = Db::getInstance()->numRows();


$cat_query = "SELECT a.`id_category`, `name` FROM `kob_category` a LEFT JOIN `kob_category_lang` b ON (b.`id_category` = a.`id_category` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (a.`id_category` = sa.`id_category` AND sa.id_shop = 1) WHERE `id_parent` = ".$id_category." ORDER BY `name` ASC";
$all_category = Db::getInstance()->ExecuteS($cat_query);


$total = Db::getInstance()->numRows();
			
foreach($category_details as $category) 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Add Category</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <!-- editor -->
  <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="css/editor/index.css" rel="stylesheet">
  <!-- select2 -->
  <link href="css/select/select2.min.css" rel="stylesheet">
  <!-- switchery -->
  <link rel="stylesheet" href="css/switchery/switchery.min.css" />

  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md" style="background:none;">

  <div class="container body" style="margin:50px auto; width:90%;">


    <div class="main_container">

      

      <!-- top navigation -->
      
      <!-- /top navigation -->

      <!-- page content -->
      <div class="" role="main">
        <div class="">

          
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Edit <small>Category</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    
                    <li><a class="btn btn-primary" href="index.php" ><i class="fa fa-arrow-left"></i> Back</a></li>
                    <li><a class="btn btn-primary" href="index.php" ><i class="fa fa-th-large"></i> View all Category</a></li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
					
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category ID</label>
                      <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:7px;">
                        <?php echo $category['id_category']; ?>
                        <input type="hidden" name="id_category" id="id_category" value="<?php echo $category['id_category']; ?>" />
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name</label>
                      <div class="col-md-6 col-sm-6 col-xs-12"  style="margin-top:7px;">
                        <?php echo $category['name']; ?> 
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description</label>
                      <div class="col-md-6 col-sm-6 col-xs-12"  style="margin-top:7px;">
                        <?php echo $category['description']; ?>  
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Images</label>
                      
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      	<label class="control-label" for="slider"><span class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add new</span></label>
                        <input type="file" id="slider" name="slider" required="required" class="form-control col-md-7 col-xs-12" style="display:none;">
                        <div id="slider_img">
							<?php
                            $list_category_slider = unserialize($category['list_category_slider']);
                            foreach($list_category_slider as $key => $category_slider) { ?>
                            <div class="col-md-4 col-sm-4 col-xs-6" style="padding-left:0;">
                            <img src="../themes/default-bootstrap/img/all-category/slider/<?php echo $category_slider; ?>" class="img-responsive" >
                            <span class="slider_remove" id="slid<?php echo $key; ?>" onClick="slider_remove(<?php echo $key; ?>);">remove <i class="fa fa-trash-o"></i></span>
                            
                            </div>
                            <?php } ?>  
                        </div>                   
                      </div>

                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sub Category</label>
                      
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="select2_single form-control" id="category_image_id" name="category_image_id">
                          <option></option>
                          
                          <?php				
              						$category_image_array = unserialize($category['category_image']);
              						foreach($all_category as $key => $category_img){
              						?>
                        
                          <option value="<?php echo $category_img['id_category']; ?>" ><?php echo $category_img['name']; ?></option>
                          <?php } ?>
                        </select>
                        <input type="file" id="category_image" name="category_image" required="required" class="form-control col-md-7 col-xs-12" style="display:none;">
                        <label class="control-label" for="category_image"><span class="btn btn-primary btn-sm"> <i class="fa fa-upload"></i> Upload Image</span></label>
                        <span><strong>Image Size : 800x300 px (jpg, png)</strong></span>
                        <span id="category_img_error" class="ajax_report" style="display:none;"></span>	
                        
                        <div id="category_img">
                        
                        
                        <h4>Promoted Sub Categories</h4>
                        <ol>
                        <?php
							$query_sub 	= "SELECT `subCategory_id` FROM `"._DB_PREFIX_."category_sub_listing` WHERE `link_category_id` = ".$id_category;
							$subCategory_details = Db::getInstance()->ExecuteS($query_sub);
							//print_r($subCategory_details);
							foreach($subCategory_details as $subCategory){
							$subCategory_id[] = $subCategory['subCategory_id'];	
							}
							$subCategory_string = implode(',',$subCategory_id);

							$query_sub2 = "SELECT a.`id_category`, `name` FROM `kob_category` a LEFT JOIN `kob_category_lang` b ON (b.`id_category` = a.`id_category` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (a.`id_category` = sa.`id_category` AND sa.id_shop = 1) WHERE a.`id_category` IN (".$subCategory_string.") ORDER BY `name` ASC";
							$subCategory_details2 = Db::getInstance()->ExecuteS($query_sub2);
							foreach($subCategory_details2 as $subCategory2){
						?>
                        	<li><a href="edit_subcategory.php?id=<?php echo $subCategory2['id_category']; ?>"><?php echo $subCategory2['name']; ?> <span class="label label-success">Edit</span></a> &nbsp; &nbsp; <span class="slider_remove" onClick="category_remove(<?php echo $subCategory2['id_category']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span></li>
                      	<?php }?>
                        </ol>
                   
                        </div>                   
                      </div>

                    </div>
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Most Searched products</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                        
                          <input type="text" class="form-control" placeholder="Enter Product Id" name="list_most_searched" id="list_most_searched">
                          <span class="input-group-btn"><button type="button" class="btn btn-primary" onClick="most_searched(0, 'add');">Add</button></span>
                        </div> 
                        
                        <div id="msp_list">
                        <ol>
                        <?php
						$list_most_searched = unserialize($category['list_most_searched']);
						$msp_list = implode(',',$list_most_searched);
						$query_product = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$msp_list.")";
						
						$product_details = Db::getInstance()->ExecuteS($query_product);
						$total_products = Db::getInstance()->numRows();
									
						foreach($product_details as $products)
						{
						?>
                        
                        	<li><?php echo $products['product_name']; ?> <span class="slider_remove" onClick="most_searched(<?php echo $products['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>
                        
                        <?php } ?>
                        </ol>  
                        </div>
                          
                                 
                      </div>

                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Top Selling products</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Enter Product Id" name="list_top_selling" id="list_top_selling">
                          <span class="input-group-btn"><button type="button" class="btn btn-primary" onClick="top_selling(0, 'add');">Add</button></span>
                        </div> 
                        
                        <div id="ts_list">
                        <ol>
                        <?php
						$list_top_selling = unserialize($category['list_top_selling']);
						$ts_list = implode(',',$list_top_selling);
						$query_product_ts = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$ts_list.")";
						
						$product_details_ts = Db::getInstance()->ExecuteS($query_product_ts);
			
						foreach($product_details_ts as $products_ts)
						{
						?>
                        
                        	<li><?php echo $products_ts['product_name']; ?> <span class="slider_remove" onClick="top_selling(<?php echo $products_ts['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>
                        
                        <?php } ?>
                        </ol>  
                        </div>
                          
                                 
                      </div>

                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Top Viewed products</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Enter Product Id" name="list_top_viewed" id="list_top_viewed">
                          <span class="input-group-btn"><button type="button" class="btn btn-primary" onClick="top_viewed(0, 'add');">Add</button></span>
                        </div> 
                        
                        <div id="tv_list">
                        <ol>
                        <?php
						$list_top_viewed = unserialize($category['list_top_viewed']);
						$tv_list = implode(',',$list_top_viewed);
						$query_product_tv = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$tv_list.")";
						
						$product_details_tv = Db::getInstance()->ExecuteS($query_product_tv);
			
						foreach($product_details_tv as $products_tv)
						{
						?>
                        
                        	<li><?php echo $products_tv['product_name']; ?> <span class="slider_remove" onClick="top_viewed(<?php echo $products_tv['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>
                        
                        <?php } ?>
                        </ol>  
                        </div>
                          
                                 
                      </div>

                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Top Discounted products</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Enter Product Id" name="list_top_discounted" id="list_top_discounted">
                          <span class="input-group-btn"><button type="button" class="btn btn-primary" onClick="top_discounted(0, 'add');">Add</button></span>
                        </div> 
                        
                        <div id="td_list">
                        <ol>
                        <?php
						$list_top_discounted = unserialize($category['list_top_discounted']);
						$td_list = implode(',',$list_top_discounted);
						$query_product_td = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$td_list.")";
						
						$product_details_td = Db::getInstance()->ExecuteS($query_product_td);
			
						foreach($product_details_td as $products_td)
						{
						?>
                        
                        	<li><?php echo $products_td['product_name']; ?> <span class="slider_remove" onClick="top_discounted(<?php echo $products_td['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>
                        
                        <?php } ?>
                        </ol>  
                        </div>
                          
                                 
                      </div>

                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kobster Recommended products</label>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Enter Product Id" name="list_kobster_recommented" id="list_kobster_recommented">
                          <span class="input-group-btn"><button type="button" class="btn btn-primary" onClick="kobster_recommented(0, 'add');">Add</button></span>
                        </div> 
                        
                        <div id="kr_list">
                        <ol>
                        <?php
						$list_kobster_recommented = unserialize($category['list_kobster_recommented']);
						$kr_list = implode(',',$list_kobster_recommented);
						$query_product_kr = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$kr_list.")";
						
						$product_details_kr = Db::getInstance()->ExecuteS($query_product_kr);
			
						foreach($product_details_kr as $products_kr)
						{
						?>
                        
                        	<li><?php echo $products_kr['product_name']; ?> <span class="slider_remove" onClick="kobster_recommented(<?php echo $products_kr['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>
                        
                        <?php } ?>
                        </ol>  
                        </div>
                          
                                 
                      </div>

                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="edit" class="btn btn-primary">Save</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>

          <script type="text/javascript">
            $(document).ready(function() {
              $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
            });
			
			
          </script>


          



          


          


          
        </div>
        <!-- /page content -->

        <!-- footer content -->
        
        <!-- /footer content -->
      </div>

    </div>
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- tags -->
  <script src="js/tags/jquery.tagsinput.min.js"></script>
  <!-- switchery -->
  <script src="js/switchery/switchery.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  <!-- richtext editor -->
  <script src="js/editor/bootstrap-wysiwyg.js"></script>
  <script src="js/editor/external/jquery.hotkeys.js"></script>
  <script src="js/editor/external/google-code-prettify/prettify.js"></script>
  <!-- select2 -->
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
  <!-- textarea resize -->
  <script src="js/textarea/autosize.min.js"></script>
  <script>
    autosize($('.resizable_textarea'));
  </script>
  <!-- Autocomplete -->
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      var countriesArray = $.map(countries, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  <script src="js/custom.js"></script>
  
  <script src="js/ajax_request.js"></script>


  <!-- select2 -->
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Select a Category for Linking",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "With Max Selection limit 4",
        allowClear: true
      });
    });
  </script>
  <!-- /select2 -->
  <!-- input tags -->
  <script>
    function onAddTag(tag) {
      alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
      alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
      alert("Changed a tag: " + tag);
    }

    $(function() {
      $('#tags_1').tagsInput({
        width: 'auto'
      });
    });
  </script>
  <!-- /input tags -->
  <!-- form validation -->
  <script type="text/javascript">
    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form .btn').on('click', function() {
        $('#demo-form').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });

    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form2 .btn').on('click', function() {
        $('#demo-form2').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });
    try {
      hljs.initHighlightingOnLoad();
    } catch (err) {}
  </script>
  <!-- /form validation -->
  <!-- editor -->
  <script>
    $(document).ready(function() {
      $('.xcxc').click(function() {
        $('#descr').val($('#editor').html());
      });
    });

    $(function() {
      function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'
          ],
          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
          container: 'body'
        });
        $('.dropdown-menu input').click(function() {
            return false;
          })
          .change(function() {
            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
          })
          .keydown('esc', function() {
            this.value = '';
            $(this).change();
          });

        $('[data-role=magic-overlay]').each(function() {
          var overlay = $(this),
            target = $(overlay.data('target'));
          overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });
        if ("onwebkitspeechchange" in document.createElement("input")) {
          var editorOffset = $('#editor').offset();
          $('#voiceBtn').css('position', 'absolute').offset({
            top: editorOffset.top,
            left: editorOffset.left + $('#editor').innerWidth() - 35
          });
        } else {
          $('#voiceBtn').hide();
        }
      };

      function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
          msg = "Unsupported format " + detail;
        } else {
          console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
          '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
      };
      initToolbarBootstrapBindings();
      $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
      });
      window.prettyPrint && prettyPrint();
    });
  </script>
  <!-- /editor -->
</body>

</html>

<?php
require('../config/config.inc.php');
if (isset($_GET) && $_GET['id_category']){ $id_parent = $_GET['id_category'];}
else {$id_parent = 1;}

$query = "SELECT a.`id_category`, `name`, `description`, `active` FROM `kob_category_listing` cl LEFT JOIN `kob_category_lang` b ON (b.`id_category` = cl.`category_id` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (cl.`category_id` = sa.`id_category` AND sa.id_shop = 1) LEFT JOIN `kob_category` a ON (a.`id_category` = cl.`category_id`)  WHERE `id_parent` = ".$id_parent." ORDER BY sa.`position` ASC ";

$category_details = Db::getInstance()->ExecuteS($query);
$total = Db::getInstance()->numRows();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Category Admin</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


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
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>All Categories</h2>
                  <ul class="nav navbar-right panel_toolbox">
                  	<li><a class="btn btn-primary" href="edit_category.php?id_category=1"><i class="fa fa-pencil"></i> Edit Home</a></li>
                    <li><a class="btn btn-primary" href="add_category.php"><i class="fa fa-plus"></i> Add new</a></li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <!-- start project list -->
                  <table class="table table-striped projects">
                    <thead>
                      <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 20%">Ref ID</th>
                        <th style="width: 20%">Category Name</th>
                        <th>Description</th>
                        <th style="width: 20%">#Edit</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php 
					if ($total != 0){
					$i = 1;
					foreach($category_details as $category){ ?>

					
                      <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td>
                          <?php echo $category['id_category']; ?>
                          
                        </td>
                        <td>
                          <?php echo $category['name']; ?>
                          
                        </td>
                        <td>
                          <?php echo $category['description']; ?>
                        </td>

                        <td>
                          <a href="index.php?id_category=<?php echo $category['id_category']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                          <a href="edit_category.php?id_category=<?php echo $category['id_category']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                          <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                        </td>
                      </tr>
                      <?php } } else {?>
                      <tr>
                        <td colspan="5">No Records found</td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <!-- end project list -->

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        	
        <!-- /footer content -->

      </div>
      <!-- /page content -->
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

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

</body>

</html>

<?php /* Smarty version Smarty-3.1.19, created on 2018-10-30 18:02:22
         compiled from "rm\rm-docs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209585bd84f56767b78-08204204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54db017ec1d9d05bd3de602f79fa4d5631de8ff8' => 
    array (
      0 => 'rm\\rm-docs.tpl',
      1 => 1501672949,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209585bd84f56767b78-08204204',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5bd84f567d31e9_43580493',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5bd84f567d31e9_43580493')) {function content_5bd84f567d31e9_43580493($_smarty_tpl) {?><div class="panel panel-default" id="dwnld-docs">
  <div class="panel-heading">Download DR / Invoice</div>
  <div class="panel-body">    
    <div class="container">
      <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#home">Delivery Receipt</a></li>
        <li><a data-toggle="pill" href="#menu1">Invoice Copy</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" class="form-control" id="dr" placeholder="Enter DR Number" />
            </div>
            <div class="col-md-6">
              <button class="btn btn-primary" onclick="downloadDocs(1)">Search</button>
            </div>
            <div id="dwnldDr" class="col-md-6 float-right">          
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane fade">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" class="form-control" id="invoice" placeholder="Enter Invoice Number" />
            </div>
            <div class="col-md-6">
              <button class="btn btn-primary" onclick="downloadDocs(2)">Search</button>
            </div>
            <div id="dwnldInv" class="col-md-6 float-right">          
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  #dwnld-docs .nav{
    margin: 1% 30%;
  }
</style>
<?php }} ?>

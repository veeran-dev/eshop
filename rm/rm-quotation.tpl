<script type="text/javascript" src="rm/js/rm-index.js"></script>
<script type="text/javascript">
	$('#group_selection, #customer_selection').select2();
 </script>
<div class="row">
	<section class="panel-body">
		<header class="rm_heading">Quotations</header>
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
 			<div class="panel">
				<div class="panel-body">
					<!-- SELECT CUSTOMER GROUP -->
					<div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            		<span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                            		<abbr class="select2-search-choice-close"></abbr>
                            		<span class="select2-arrow" role="presentation">
                            			<b role="presentation"></b>
                            		</span>
                            	</a>
                            	<label for="s2id_autogen3" class="select2-offscreen"></label>
                            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(9)" required>
                            		<option value="0">Select Company</option>
                            		
                            </select>
                    </div>
                    <!-- SELECT CUSTOMER WITH EMAIL ID -->
					 
                    
                   
				</div>
			</div>
		</div>
		
		
	</section>
</div>

<div id="quote-rm" class="hidden">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Quotation History
                </header>
                <div id="quotation-history-hidden-rm" class="display-none">
                    <form id="form_quotation_excel_rm" name="form_invoice" action="scn-quote-excel.php" autocomplete="off" method="post" class="display-none">
                        <div id="quotation-history-hidden-data-rm">
                        </div>
                    </form>
                </div>
                <div class="panel-body" id="quotationHistoryRm">
                    <table class="table" id="id_quotation_history_rm">
                        <thead>
                            <tr>
                                <th>Quotation ID</th>
                                <th>Company Name</th>
                                <th>Quotation Name</th>
                                <th>Version</th>
                                <th>Published By</th>
                                <th>Date generated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="quotation_history_rm">
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewQuoteProductsRm" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Quotation Products</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                            <table class="table table-hover table-bordered" id="quotation-history">
                                <thead>
                                    <tr>
                                        <th class="col-xs-4">
                                            Product Name
                                        </th>
                                        <th class="col-xs-3">
                                            Product Code
                                        </th>
                                        <th class="col-xs-2">
                                            GST %
                                        </th>
                                        <th class="col-xs-3">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="quotation_history_view_rm">
                                <table class="table">
                                    <tbody id="quotation_history_view_rm">
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-foot-download">
                <div id="view-block-download-div-rm">
                    <button type="button" class="btn btn-success" id="view-block-download-rm">
                        Download&nbsp;&nbsp;
                        <i class='fa fa-download '></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publishQuoteConfirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Do you want to continue?</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body">
                            <p>
			                    Once you publish this quote, Rate Contract and Specific Price will be changed.  
			                </p>
			                <span class="rm-quote-publish-loader ajaxLoaderModal" style="display:none;">
				            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer quote-confirm-footer"></div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publishFailed" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-danger modal-text-font"> Publish Failed.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-danger text-center">
                            <p>
			                    Error found in publishing quotation.Please check your product availability in Quotation.  
			                </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            	<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publishFailedGroup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-danger modal-text-font"> Publish Failed.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-danger text-center">
                            <p>
                                You cannot publish this quotation.Because, <strong>USER Company NOT YET CREATED</strong>.Please contact concern person to create Company for this user and then try publish option.  
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publish-quote-success" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-success modal-text-font" style="color:#31881b;">Quotation Published Successfully.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-center">
                           <p class="rate-contract">
                          
		                    </p>
		                    <p class="specific-update">
		                    	
		                    </p>
		                    <p class="specific-add">
		                    	
		                    </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            	<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">

$(document).ready( function() {
 	getGroups(0);
	$('#group_selection, #customer_selection').select2();
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
  });
});
</script>
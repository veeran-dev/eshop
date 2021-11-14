<script type="text/javascript" src="rm/js/rm-cus-verification.js"></script>
<script type="text/javascript">
	$('#group_selection, #customer_selection').select2();
	$(document).ready( function() {
 	getGroups(10);
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
  });
});
 </script>
<div class="row">
	<section class="panel-body">
		 
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
			<header class="panel-heading">Company Verification</header>
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
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(10)" required>
                            		<option value="0">Select Company</option>
                            		
                            </select>
                    </div>
                    <!-- SELECT CUSTOMER WITH EMAIL ID -->
 				</div>
			</div>
		</div>
 	 </section>
</div>
<div class="row">
    <section class="panel-body">
     <div id="no-more-tables"> 
        <table class="table col-md-12 col-sm-12 table-bordered table-striped table-condensed cf panel hidden" id="group-verification-table">
            <thead class="cf panel-title">
                <tr>
                    <th class="col-xs-1">Company Id</th>
                    <th class="col-xs-3">Company Name</th>
                    <th class="col-xs-1">Status</th>
                    <th class="col-xs-1">Document Download</th>
                    <th class="col-xs-3">Upload Document / Verify</th>	
                </tr>
            </thead>
           
			<tbody>
               
                <tr>
                    <td data-title="Cusomer Id" class="col-xs-1" id="id_group"> </td>
                    <td data-title="Customer Name" class="col-xs-3">
                        <p id="customer_firstname"> </p>
                    </td>
                    <td data-title="Status" class="col-xs-1" id = "verification_status">                       
                                              
                    </td>
                    <td data-title="Document Download" id="verification_document" class="col-xs-1">
                        
                    </td>
                    <td data-title="Upload Document / Verify" class="col-xs-2" id="upload_document">
                        
                    </td>
                </tr>
             </tbody>
        </table>
    <!--</div>-->
</section>
</div>
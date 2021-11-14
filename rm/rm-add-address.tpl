<script type="text/javascript" src="rm/js/rm-customer-configure.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-switch.js"></script>
<link rel="stylesheet" type="text/css" href="dash/css/bootstrap-switch.css">
<link rel="stylesheet" type="text/css" href="dash/bs3/bootstrap.css">

<script type="text/javascript">
$(document).ready( function() {
 	getGroups(11);
});
 	$('#group_selection, #customer_selection').select2();
 </script>
<div class="row">
	<section class="panel-body" id="address_section">
		<header class="rm_heading">Addresses</header>
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
 			<div class="">
				<div class="">
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
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_selection" onchange="getCustomer(11);" required>
                            		<option value="0">Select Company</option>
                             </select>
                    </div>
                    <!-- SELECT CUSTOMER WITH EMAIL ID -->
					<div class="form-group col-md-7 col-sm-7 col-xs-7 col-lg-7">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            		<span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                            		<abbr class="select2-search-choice-close"></abbr>
                            		<span class="select2-arrow" role="presentation">
                            			<b role="presentation"></b>
                            		</span>
                            	</a>
                            	<label for="s2id_autogen3" class="select2-offscreen"></label>
                            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(12)" required>
                            		<option value="0">Select User</option>
                             </select>
							 
                    </div>
                    
                   
				</div>
			</div>
		</div>
		
		
	</section>
</div>

<div class="row">
    <section class="panel-body">
        <!--<header class="rm_heading">
            Add / Edit Address
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" id="customerSearch" placeholder="Please search to select customer"/>
                    </div>
                </form>
            </div>
            <div>-->

                <div class="col-xs-12 col-sm-5 col-md-5">
                    <header class="panel-heading">Create New Address</header>
                    <div class="panel">
                        <div class="panel-body position-center">
                            <a href="#myaddress" data-toggle="modal" id="creat_address_button" class="btn btn-primary disabled">
                                <i class="fa fa-plus-circle"> Click here create address</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <header class="panel-heading">User addresses</header>
                    <div class="panel">
                        <div class="panel-body">
                            <table class="table table-bordered table-stripped" id="address-table">
                                <thead>
                                    <th>
                                        S.No
                                    </th>
                                    <th>
                                        Address
                                    </th>
                                    <th>
                                        Contact Person
                                    </th>
                                    <th>
                                        Mobile(POC)
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                    <th>
                                        Delete
                                    </th>
									<th>
                                        STATUS
                                    </th>
                                </thead>
                                <tbody id="group_address">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </section>
    </div>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editAddress" class="modal editAddress fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Edit Address</h3>
                </div>
                <div class="modal-body position-center">
                    <form class="form-horizontal" role="form" onsubmit="saveAddress(1,0,event); return false;" id="addressSubmit1">
                        <div class="form-group">
                            <input type="text" required class="form-control myAddress" id="alias" name="alias" placeholder="Address Name" value="" maxlength="61" />
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control myAddress" id="company" name="company" placeholder="Company Name" value="" />
                        </div> 
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" id="gst" name="gst" disabled="disabled" placeholder="GST" value="" />
                        </div> 
                        
                        <div class="form-group">
                          <input type="checkbox" class="myAddress checkbox" value="1" name="sez" id="sez-edit" disabled="disabled">
                          <label for="sez-edit">SEZ</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" required id="firstname" name="firstname" placeholder="First Name" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" name="lastname" id="lastname" placeholder="Last Name" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" required maxlength="15" value="" id="mobile" name="mobile" placeholder="Mobile(Contact Person)" onkeypress="return isNumber(event)">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control myAddress" required name="address1" id="address1" placeholder="Address" maxlength="255"></textarea>
                            <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=()@#"�{}_$%:</div>    
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" maxlength="15" value="" id="landline" name="landline" placeholder="Land Line Number" onkeypress="return isNumber(event)" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" maxlength="6" value="" name="postcode" id="postcode" placeholder="Pincode" required onkeypress="return isNumber(event)"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control myAddress" value="" required name="city" id="city" placeholder="City">
                        </div>

                        <div class="form-group">
                            <select class="form-control marginTopBottom input-sm m-bot15 state" name="state" required>
                                <option value="0">--Select State--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control marginTopBottom input-sm m-bot15 myAddress" name="country" readonly id="country">
                                <option value="110" selected>India</option>
                            </select>
                        </div>
                        <input type="hidden" name="id_customer" id="id_customer" value="">
                        <input type="hidden" name="request_type" value="6">
                        
                         <input type="hidden" name="id_address" id="id_address">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary form-control" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myaddress" class="modal myaddress fade in">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add Address</h4>
                    </div>
                    <div class="modal-body position-center">
                        <form class="form-horizontal" role="form" onsubmit="saveAddress(0,0,event); return false;" id="addressSubmit">
                            <div class="form-group">
                                <input type="text" required class="form-control myAddress" name="alias" placeholder="Address Name" value="" maxlength="61" />
                            </div>
                             <div class="form-group">
                                <input type="text" required class="form-control myAddress" name="company" placeholder="Company Name" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control myAddress" name="gst" placeholder="GST" value="" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="sez-add" name="sez">
                                <label for="sez-add">SEZ</label>
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control myAddress" name="firstname" placeholder="First Name" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control myAddress" name="lastname" placeholder="Last Name" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control myAddress" maxlength="12" value="" name="mobile" placeholder="Mobile(Contact Person)" onkeypress="return isNumber(event)">
                            </div>
                            <div class="form-group">
                                <textarea maxlength="255" class="form-control myAddress" required name="address1" placeholder="Address"></textarea>
                                <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=+()@#"�{}_$%:'</div>    
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control myAddress" onkeypress="return isNumber(event)" maxlength="15" value="" name="landline" placeholder="Land Line Number" />
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control myAddress" maxlength="6" value="" name="postcode" placeholder="Pincode" onkeypress="return isNumber(event)"/>
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control myAddress" value="" name="city" placeholder="City">
                            </div>

                            <div class="form-group">
                                <select class="form-control marginTopBottom input-sm m-bot15 state" name="state" required>
                                    <option value="0">--Select State--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control marginTopBottom input-sm m-bot15 myAddress" name="country" readonly id="country" required>
                                    <option value="110" selected>India</option>
                                </select>
                            </div>
                            <input type="hidden" name="id_customer" id="customer_id" value="">
                             <input type="hidden" name="request_type" value="5">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary form-control" value="Submit" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
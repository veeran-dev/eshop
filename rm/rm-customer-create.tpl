<script type="text/javascript" src="rm/js/rm-customer-configure.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
   	getGroups(99);
   });
   $('#group_select, #group_select_1, #group_selection2, #group_selection_3, #group_selection_4, #group_select_5, #group_select_6, #group_select_7').select2();	
</script>
<style type="text/css">
   input[type=number]::-webkit-inner-spin-button, 
   input[type=number]::-webkit-outer-spin-button { 
       -webkit-appearance: none;
       -moz-appearance: none;
       appearance: none;
       margin: 0; 
   }
</style>
<div class="row">
   <section class="panel-body">
      <div class="panel">
         <header class="panel-heading">
            Create Company & User
         </header>
         <div class="panel-body min-height400" >
            <div class="col-md-7 col-xs-7 col-sm-7">
               <div class="panel">
                  <div class="panel-body ">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="col-md-7"><strong>Creation</strong></span>
                        </div>
                        <div class="panel-body col-md-7">
                           <a data-toggle="modal" href="#groupCreate">
                           <button class="btn btn-primary"> Create New Company</button>
                           </a>
                        </div>
                        <div class="panel-body  col-md-3">
                           <button type="button" onclick="openCreateCustomerModel()" class="btn btn-primary">Create New User</button>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <span class="col-md-7"><strong>Edit</strong></span>
                        </div>
                        <div class="panel-body col-md-7">
                           <a data-toggle="modal" href="#editGroup">
                           <button class="btn btn-primary"> Edit Company</button>
                           </a>
                        </div>
                        <div class="panel-body  col-md-3">
                           <a data-toggle="modal" href="#editCustomer">
                           <button class="btn btn-primary"> Edit User</button>
                           </a>
                        </div>
                     </div>
                     <div class="row">
                        <div class="panel-body">
                           <div class="col-md-12"><strong>Assign</strong></div>
                        </div>
                        <div class="col-md-4 panel-body">
                           <a data-toggle="modal" href="#assignuser">
                           <button class="btn btn-primary">Assign User to Company</button>
                           </a>
                        </div>
                        <div class="col-md-4 panel-body">
                           <a data-toggle="modal" href="#assignRMtoCompany">
                           <button class="btn btn-primary">Assign RM to Company</button>
                           </a>
                        </div>
                        <div class="col-md-4 panel-body">
                           <a data-toggle="modal" href="#assignKAMtoCompany">
                           <button class="btn btn-primary">Assign KAM to Company</button>
                           </a>
                        </div>
                        <div class="col-md-4 panel-body">
                           <a data-toggle="modal" href="#assignEscalationContacts">
                           <button class="btn btn-primary">Escalation contacts</button>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-5 col-xs-5 col-sm-5">
               <div class="panel">
                  <div class="panel-body ">
                     <div class="col-md-12">
                        <span class="col-md-12"><strong>view</strong></span>
                     </div>
                     <div class="col-md-12">
                        <form role="form">
                           <div class="panel">
                              <div class="panel-body">
                                 <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                                    <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                                    <span class="select2-chosen" id="select2-chosen-3">View Company & User</span>
                                    <abbr class="select2-search-choice-close"></abbr>
                                    <span class="select2-arrow" role="presentation">
                                    <b role="presentation"></b>
                                    </span>
                                    </a>
                                    <label for="s2id_autogen3" class="select2-offscreen"></label>
                                    <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                                 </div>
                                 <select id="group_select" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getGroupDetails(7)" required>
                                    <option value="">View Company & User</option>
                                    {foreach from=$groups item=data}
                                    {if $group_name[0].id_group == $data.id_group}
                                    <option value="{$data.id_group}" selected="">
                                       {$data.name}
                                    </option>
                                    {else}
                                    <option value="{$data.id_group}">
                                       {$data.name}
                                    </option>
                                    {/if}
                                    {/foreach}
                                 </select>
                              </div>
                              {if $group_name[0].id_group}
                              <!-- <div class="panel"> -->
                           </div>
                           {/if}
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            {if $group_name[0].id_group}
            <div class="col-md-12 col-xs-12 col-sm-12 panel-body">
               <header class="panel-heading">
                  Users In Selected Company 
               </header>
               <div class="panel">
                  <div class="panel-body">
                     <table class="table table-bordered" id="group_customers">
                        <thead>
                           <th>
                              S.No
                           </th>
                           <th>
                              Name
                           </th>
                           <th>
                              Email
                           </th>
                           <th>
                              Action
                           </th>
                        </thead>
                        <tbody>
                           {assign var=counter value=1}
                           {foreach from=$group_customers item=data}
                           <tr>
                              <td>
                                 {$counter++}
                              </td>
                              <td>
                                 {$data.firstname}
                              </td>
                              <td>
                                 {$data.email}
                              </td>
                              <td>
                                 <a href="#" title="Remove customer from group" 
                                    onclick="removeCusGroup({$data.id_customer},{$group_name[0].id_group},0)">
                                    <div>
                                       <i class="fa fa-trash-o"></i> Remove
                                    </div>
                                 </a>
                              </td>
                           </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            {/if}
         </div>
         <div class="col-md-12 margintop100">
            <span><button onclick="cusConfigure(1);" class="btn btn-primary floatright black-background"> Go To Address</button></span>
         </div>
      </div>
</div>
</section>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="groupCreate" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Create New Company</h3>
         </div>
         <div class="modal-body position-center">
            <form role="form"  id="group-create-form">
               <div class="form-group ">
                  <input type="text" class="form-control flowGroup" id="" name="group_name" placeholder="Company Name" value="" maxlength="100" required/>
                  <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=+()@#"�{}_$%:'</div>
               </div>
               <div class="form-group">
                  <input type="text" class="form-control flowGroup" name="group_credit" placeholder="Credit days" value="" required/>
               </div>
               <div class="input-group form-group">
                  <span class="input-group-addon btn-white">Price Display Method</span>
                  <select class="form-control " name="price_display_method" required>
                     <option value="1">
                        Tax Excluded
                     </option>
                     <option value="0">
                        Tax Included
                     </option>
                  </select>
               </div>
               <div class="form-group">
                  <input type="checkbox" name="po_mandatory" value="1"> Select if PO upload mandatory for this company 
               </div>
               <div class="form-group">
                  <button onclick="addGroup(1)" type="button" class="btn btn-primary ">Save & Create User </button>
                  <button onclick="addGroup(0)" type="button" class="btn btn-primary ">Save</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default ">Cancel</button>
               </div>
               <input type="hidden" name="request_type" id="request_type" value="4"/>
            </form>
         </div>
      </div>
   </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editGroup" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Edit Company</h3>
         </div>
         <div class="modal-body position-center">
            <form role="form"  id="group-edit-form">
               <div class="form-group ">
                  <div class="form-group">
                     <select id="group_selection_3" class="group_selection3 populate placeholder select2-offscreen form-control flowCustomer" tabindex="-1" title="" onchange="putCompanyName(this);" name="group_selection" required>
                        <option value="0">Select Company</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control flowGroup" id="company_name" name="company_name" placeholder="Company Name" value="" maxlength="100" required/>
                  </div>
                  <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=+()@#"�{}_$%:</div>
                  <div class="form-group">
                     <input type="text" class="form-control flowGroup" name="group_credit" placeholder="Credit days" value="" required/>
                  </div>
                  <div class="form-group">
                     <input type="checkbox" name="po_mandatory" id="po_mandatory_edit" value="1"> Select if PO upload mandatory for this company 
                  </div>
               </div>
               <div class="form-group">
                  <button onclick="editGroup()" type="button" class="btn btn-primary ">Save</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default ">Cancel</button>
               </div>
               <input type="hidden" name="request_type" id="request_type" value="7"/>
            </form>
         </div>
      </div>
   </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editCustomer" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Edit User</h3>
         </div>
         <div class="modal-body">
            <form role="form" id="customer-edit-form"  >
               <div class="input-group col-md-12 col-sm-12 col-xs-12 col-lg-12" id="company_select">
                  <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                     <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                        <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                        <abbr class="select2-search-choice-close"></abbr>
                        <span class="select2-arrow" role="presentation">
                        <b role="presentation"></b>
                        </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                     </div>
                     <select id="group_selection_4" class="group_selection3 populate placeholder select2-offscreen form-control flowCustomer" tabindex="-1" title="" onchange="getCustomer(12)" name="group_selection" required>
                        <option value="0">Select Company</option>
                     </select>
                  </div>
               </div>
               <!-- SELECT CUSTOMER WITH EMAIL ID -->
               <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                  <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                     <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                     <span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                     <abbr class="select2-search-choice-close"></abbr>
                     <span class="select2-arrow" role="presentation">
                     <b role="presentation"></b>
                     </span>
                     </a>
                     <label for="s2id_autogen3" class="select2-offscreen"></label>
                     <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                  </div>
                  <select id="edit_customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="edit_customer_selection" onchange="setCustomerDetails(this)" required>
                     <option value="0">Select User</option>
                  </select>
                  <p id="noUsers" class="col-md-12 text-danger hidden">Users have not been created yet!</p>
               </div>
               <div class="form-group">
                  <div class="form-inline">
                     <div class="form-group col-md-6">
                        <input type="text" required class="form-control flowCustomer" id="firstName" name="firstName" placeholder="First Name">
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control flowCustomer" id="lastName" name="lastName" placeholder="Last Name">
                     </div>
                     <span class="help-block">
                     (First and Last name Should be Individual's Name. For example: Elumalai K)
                     </span>	
                  </div>
               </div>
               <div class="input-group form-group hidden" id="company_text">
                  <span class="input-group-addon btn-white"><i class="fa fa-building-o"></i></span>
                  <input type="text" readonly required class="form-control flowCustomer" id="companyName" name="companyName" placeholder="Company Name" value=" " maxlength="99">
               </div>
               <div class="input-group m-bot15">
                  <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                  <input type="email" required class="form-control flowCustomer" id="emailId" name="emailId" placeholder="Email Address">
               </div>
               <div class="input-group m-bot15">
                  <span class="input-group-addon btn-white"><i class="fa fa-mobile"></i></span>
                  <input type="text" onkeypress="return isNumber(event)" required class="form-control flowCustomer" id="mobileNum" name="mobileNum" placeholder="Mobile Number" maxlength="15">
               </div>
               <input type="hidden" name="type" value="0">						
               <input type="hidden" name="id_employee" id="employee_id" value="{$cookie->id_employee}">
               <input type="hidden" name="id_group" id="id_group" class="id_group" value="">
               <button type="button" class="btn btn-primary" onclick="editCusAccount()">Save</button>
               <button type="button" data-dismiss="modal" class="btn btn-default ">Cancel</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="customerCreate" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Create New User</h3>
         </div>
         <div class="modal-body">
            <form role="form" id="customer-create-form"  >
               <div class="form-group">
                  <div class="form-inline">
                     <div class="form-group col-md-6">
                        <input type="text" required class="form-control flowCustomer" id="firstName" name="firstName" placeholder="First Name">
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control flowCustomer" id="lastName" name="lastName" placeholder="Last Name">
                     </div>
                     <span class="help-block">
                     (First and Last name Should be Individual's Name. For example: Elumalai K)
                     </span>	
                  </div>
               </div>
               <div class="input-group form-group hidden" id="company_text">
                  <span class="input-group-addon btn-white"><i class="fa fa-building-o"></i></span>
                  <input type="text" readonly required class="form-control flowCustomer" id="companyName" name="companyName" placeholder="Company Name" value=" " maxlength="99">
               </div>
               <div class="input-group col-md-12 col-sm-12 col-xs-12 col-lg-12" id="company_select">
                  <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                     <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                        <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                        <abbr class="select2-search-choice-close"></abbr>
                        <span class="select2-arrow" role="presentation">
                        <b role="presentation"></b>
                        </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                     </div>
                     <select id="group_selection2" class="group_selection3 populate placeholder select2-offscreen form-control flowCustomer" tabindex="-1" title="" onchange="" name="group_selection" required>
                        <option value="0">Select Company</option>
                     </select>
                  </div>
               </div>
               <div class="input-group m-bot15">
                  <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                  <input type="email" required class="form-control flowCustomer" id="emailId" name="emailId" placeholder="Email Address">
               </div>
               <div class="input-group m-bot15">
                  <span class="input-group-addon btn-white"><i class="fa fa-mobile"></i></span>
                  <input type="text" onkeypress="return isNumber(event)" required class="form-control flowCustomer" id="mobileNum" name="mobileNum" placeholder="Mobile Number" maxlength="15">
               </div>
               <div class="input-group m-bot15">
                  <span class="input-group-addon btn-white"><i class="fa fa-info"></i></span>
                  <input type="text" class="form-control" id="password" placeholder="Password ( kobster123 )" disabled="true">
               </div>
               <input type="hidden" name="type" value="0">
               <input type="hidden" name="password" id="default_password" value="kobster123">
               <input type="hidden" name="id_employee" id="employee_id" value="{$cookie->id_employee}">
               <input type="hidden" name="id_group" id="id_group" class="id_group" value="">
               <button type="button" class="btn btn-primary" onclick="createCusAccount(0)">Save</button>
               <button type="button" class="btn btn-primary" onclick="createCusAccount(1)">Save & Create New User</button>
               <!-- <button type="button" class="btn btn-primary" onclick="createCusAccount(2)">Save & Add Address</button> -->
            </form>
         </div>
      </div>
   </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="assignuser" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Assign User to Company</h3>
         </div>
         <div class="modal-body position-center">
            <div class="form-group">
               <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                  <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                  <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                  <abbr class="select2-search-choice-close"></abbr>
                  <span class="select2-arrow" role="presentation">
                  <b role="presentation"></b>
                  </span>
                  </a>
                  <label for="s2id_autogen3" class="select2-offscreen"></label>
                  <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
               </div>
               <select id="group_select_1" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="" required>
                  <option value="">Select Company</option>
                  {foreach from=$groups item=data}
                  {if $group_name[0].id_group == $data.id_group}
                  <option value="{$data.id_group}" selected="">
                     {$data.name}
                  </option>
                  {else}
                  <option value="{$data.id_group}">
                     {$data.name}
                  </option>
                  {/if}
                  {/foreach}
               </select>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" id="id_user" name="id_user" placeholder="User Name" value="" maxlength="100" required/>
               <div class="help-block"></div>
            </div>
            <div class="form-group">
               <button class="btn btn-info" onclick="addCustomersToGroup(0,1)">Assign User to Company</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
            <input type="hidden" name="hidden_id_user" id="hidden_id_user" value=""/>
         </div>
      </div>
   </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="assignRMtoCompany" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Assign RM to Company</h3>
         </div>
         <div class="modal-body position-center">
               <div class="form-group">
                  <select id="group_selection2" class="group_selection3 populate placeholder select2-offscreen form-control flowCustomer" tabindex="-1" title="" onchange="findRm(this);" name="group_selection" required>
                     <option value="0">Select Company</option>
                  </select>
               <div class="help-block"></div>
            </div>
            <div class="form-group">
               <select onchange="setRm();" id="group_select_5" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="" required>
                  <option value="">Select RM</option>
                  {foreach from=$kam item=data}
                     <option value="{$data.id_employee}">
                        {$data.firstname}
                     </option>
                  {/foreach}
               </select>
            </div>
            <div class="form-group">
               <input type="hidden" name="id_employee" id="id_employee" value="0">
               <button class="btn btn-info" onclick="addRmToCompany()">Assign RM to Company</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
            <input type="hidden" name="hidden_user_assign_rm" id="hidden_user_assign_rm" value=""/>
         </div>
      </div>
   </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="assignEscalationContacts" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Escalation Contacts</h3>
         </div>
         <div class="modal-body position-center">
               <div class="form-group">
                  <select id="group_selection2" class="group_selection3 populate placeholder select2-offscreen form-control flowCustomer" tabindex="-1" title="" onchange="findEscalations(this);" name="group_selection" required>
                     <option value="0">Select Company</option>
                  </select>
               <div class="help-block"></div>
            </div>
            <div class="form-group">
               <input class="form-control" placeholder="First Name" type="text" name="esc_firstname" id="esc_firstname" value="">
            </div>
            <div class="form-group">
               <input class="form-control" placeholder="Last Name" type="text" name="esc_lastname" id="esc_lastname" value="">
            </div>
            <div class="form-group">
               <input class="form-control" placeholder="Email" type="email" name="esc_email" id="esc_email" value="">
            </div>
            <div class="form-group">
               <input class="form-control" placeholder="Mobile" type="number" name="esc_mobile" id="esc_mobile" value="">
            </div>
            <div class="form-group">
               <button class="btn btn-info" onclick="addEscalations()">Add Escalation</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="assignKAMtoCompany" class="modal fade in">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h3 class="modal-title text-center text-primary modal-text-font">Assign KAM to Company</h3>
         </div>
         <div class="modal-body position-center">
            <div class="form-group">
               <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                  <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                  <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                  <abbr class="select2-search-choice-close"></abbr>
                  <span class="select2-arrow" role="presentation">
                  <b role="presentation"></b>
                  </span>
                  </a>
                  <label for="s2id_autogen3" class="select2-offscreen"></label>
                  <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
               </div>
               <select id="group_select_6" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="findKam(this);" required>
                  <option value="">Select Company</option>
                  {foreach from=$groups item=data}
                  {if $group_name[0].id_group == $data.id_group}
                  <option value="{$data.id_group}" selected="">
                     {$data.name}
                  </option>
                  {else}
                  <option value="{$data.id_group}">
                     {$data.name}
                  </option>
                  {/if}
                  {/foreach}
               </select>
            </div>
            <div class="form-group">
               <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                  <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                  <span class="select2-chosen" id="select2-chosen-3">Select KAM</span>
                  <abbr class="select2-search-choice-close"></abbr>
                  <span class="select2-arrow" role="presentation">
                  <b role="presentation"></b>
                  </span>
                  </a>
                  <label for="s2id_autogen3" class="select2-offscreen"></label>
                  <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
               </div>
               <select id="group_select_7" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="" required>
                  <option value="">Select KAM</option>
                  {foreach from=$kam item=data}
                     <option value="{$data.id_employee}">
                        {$data.firstname}
                     </option>
                  {/foreach}
               </select>
            </div>
            <div class="form-group">
               <button class="btn btn-info" onclick="addKAMToCompany()">Assign KAM to Company</button>
               <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
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
            <form class="form-horizontal" role="form"   id="flowaddressSubmit">
               <div class="form-group">
                  <input type="text" required class="form-control myAddress" id="alias" name="alias" placeholder="Address Name" value="" maxlength="61" />
               </div>
               <div class="form-group">
                  <input type="text" required class="form-control myAddress" id="company" name="company" placeholder="Company Name" value="" />
               </div>
               <div class="form-group">
                  <input type="text" required class="form-control myAddress" id="firstname"  name="firstname" placeholder="Contact Person Name" value="" />
               </div>
               <div class="form-group">
                  <input type="text" required class="form-control myAddress" maxlength="12" value="" name="mobile" id="mobile" placeholder="Mobile(Contact Person)" onkeypress="return isNumber(event)">
               </div>
               <div class="form-group">
                   <input type="text" class="form-control myAddress" id="gst" name="gst" placeholder="GST" value="" />
               </div> 
               <div class="radio">
                     <label><input type="radio" class="myAddress" value="1" name="sez">SEZ</label>
               </div>
               <div class="radio">
                     <label><input type="radio" class="myAddress" value="2" name="sez">IGST</label>
               </div>
               <div class="form-group">
                  <textarea maxlength="255" class="form-control myAddress" id="address1" required name="address1" placeholder="Address"></textarea>
                  <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=+()@#"�{}_$%:'</div>
               </div>
               <div class="form-group">
                  <input type="text" class="form-control myAddress" id="landline" onkeypress="return isNumber(event)" maxlength="15" value="" name="landline" placeholder="Land Line Number" />
               </div>
               <div class="form-group">
                  <input type="text" required class="form-control myAddress"  id="postcode" maxlength="6" value="" name="postcode" placeholder="Pincode" onkeypress="return isNumber(event)"/>
               </div>
               <div class="form-group">
                  <input type="text" required class="form-control myAddress" id="city" value="" name="city" placeholder="City">
               </div>
               <div class="form-group">
                  <select class="form-control marginTopBottom input-sm m-bot15 state" id="state" name="state" required>
                     <option value="0">--Select State--</option>
                  </select>
               </div>
               <div class="form-group">
                  <select class="form-control marginTopBottom input-sm m-bot15 myAddress" name="country" readonly id="country" required>
                     <option value="110" selected>India</option>
                  </select>
               </div>
               <input type="hidden" name="customerid" id="customerid" value="">
               <input type="hidden" name="request_type" id="request_type" value="5"> 
               <div class="form-group">
                  <button type="button" class="btn btn-info" onclick="saveAddress(2,3,event)" >Save Address</button>
                  <button type="button" class="btn btn-info" onclick="saveAddress(2,4,event)">Save & Create New Address</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
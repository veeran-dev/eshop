<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">Rate Contract Report</header>
			<div class="panel-body">
				<div class="col-md-6">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">All Companies</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                        <select id="group_selection_rc" name="group_selection[]" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" multiple="multiple">
                            <option value="0">All Companies</option>
                            {foreach $groups as $data}
                            <option value="{$data.id_group}">{$data.name}</option>
                            {/foreach}
                        </select>
                </div>
                <div class="col-md-6">
                    <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                        <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            <span class="select2-chosen" id="select2-chosen-3">Select status</span>
                            <abbr class="select2-search-choice-close"></abbr>
                            <span class="select2-arrow" role="presentation">
                                <b role="presentation"></b>
                            </span>
                        </a>
                        <label for="s2id_autogen3" class="select2-offscreen"></label>
                        <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3">
                    </div>
                        <select id="group_selection_rc_status" name="group_status" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id">
                        	<option></option>
                            <option value="0">All</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                </div>
				<div class="row marrginTop15">
					<section class="panel">
						<div class="panel-body">
							<div class="col-md-12">
								<button class="btn btn-success btn-block" id="genereteRateContractReport" type="button"><i class="fa fa-cloud-download"></i> Generate Report</button>
							</div>
						</div>					
					</section>
				</div>
			</div>
		</section>
	</div>
</div>
<div class="display-none">
	<form id="rate_contract_report_excel"  action="finance-rc-report.php"  method="post" class="display-none">
		<div id="rate-contract-hidden-data">
		</div>
	</form>
</div>
 
<script>
$(document).ready(function() {
	$('#group_selection_rc').select2({ placeholder: "Select Companies" });
	$('#group_selection_rc_status').select2({ placeholder: "Select Status" });

	$("#sale_from").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#sale_to').datepicker('setStartDate', minDate);
    });

    $("#sale_to").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        endDate: '+0d'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#sale_from').datepicker('setEndDate', minDate);
    });
});	

</script>

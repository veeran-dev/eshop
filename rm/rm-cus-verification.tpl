<script type="text/javascript" src="rm/js/rm-cus-verification.js"></script>

<div id= "company-verification" class="row ">
    <section class="panel">
		<div class="panel-body">
			<header class="panel-heading">User Verification</header>
			<form class="form-horizontal">
				<div class="col-md-12 padding5" id="cusSearchBlock">
					<div class="form-group">
						<label class="col-sm-3 control-label">Search User: </label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="user-list" placeholder="Please search to select User.">
						</div>
					</div>
				</div>
			</form>
			<div id="no-more-tables">
				<table class="table col-md-12 col-sm-12 table-bordered table-striped table-condensed " id="cus-verification-table">
					<thead class="cf panel-title">
						<tr>
							<th class="col-xs-1">User Id</th>
							<th class="col-xs-3">User Name</th>
							<th class="col-xs-1">Mobile</th>
							<th class="col-xs-1">Status</th>
							<th class="col-xs-1">Document Download</th>
							<th class="col-xs-3">Upload Document / Verify</th>
							<th class="col-xs-1">Trigger mail</th>
							<th class="col-xs-1">Last Alert Sent</th>
						</tr>
					</thead>
					 
					 <tbody>
					 
						<tr>
							<td data-title="User Id" class="col-xs-1" id="id_customer"></td>
							<td data-title="User Name" class="col-xs-3" id="customer_firstname"></td>
							<td data-title="Mobile" class="col-xs-1" id="mobile"></td>
							<td data-title="Status" class="col-xs-1" id="doc_status"></td>
							<td data-title="Document Download" class="col-xs-1" id="download_document"></td>
							<td data-title="Upload Document / Verify" class="col-xs-2" id="verification_document"></td>
							 <td data-title="Trigger mail" class="col-xs-1" id= "verification_alert_sent"></td>
							<td data-title="Last Alert Sent" class="col-xs-2" id="last_sent"></td>
						</tr>
					 </tbody>
				</table>
			</div>
		</div>
	</section>
</div>

 
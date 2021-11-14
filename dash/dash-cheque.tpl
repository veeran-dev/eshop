<section class="panel  panelHeight" >
  <header class="panel-heading"> Pay By Cheque </header>
  <div class="panel-body" >
    <div class="">
      <form  id="cheque_deposit">
        <div style="  padding-left:20px;"> <br />
          <span style="margin-top:10px;">Please send us a cheque with</span><br />
          <p><span class="col-sm-3">An amount of:</span><b><span id="codTotal" class="col-sm-9"></span></b></p><br />
          <p><span class="col-sm-3">In favour of:</span><b><span id="chequeName" class="col-sm-9"></span></b></p><br />
          <p><span class="col-sm-3">Payable at:</span><span class="col-sm-9"><b>Chennai</b></span></p><br />
          <br /><br />
          <span class="col-sm-3">Send it to the following address:</span> <b><span  id="chequeAddress" class="col-sm-9"></span></b><br/><br />
          <br/>
          <span class="text-danger col-sm-9">*Order will be processed only on receiving amount from cheque</span>
          <p >
            <input class="btn btn-danger kob_button " type="button"  value="{l s='Confirm Order' mod='cheque'}" onclick="paymentMode(2);" style="margin-left:20%; margin-top:3%;"  />
          </p>
        </div>
      </form>
    </div>
  </div>
</section>

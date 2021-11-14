<section class="panel panelHeight">
  <header class="panel-heading"> Pay By Fund Transfer </header>
  <div class="panel-body" >
    <div class="">
      <form  method="post"  id="cash_deposit">
        <div style="padding-left: 5%;"> <br/>
          Please perform a NEFT/RGTS/Direct Deposit to the following account:<br /><br/>
          <p><span class="col-sm-3">An amount of: </span><span class="col-sm-9" style="font-weight:bold;" id="codTotal"></span></p> <br /><br />
          
          <span class="col-sm-3">Account Name: </span><b><span  class="col-sm-9" id="bankwireOwner"></span></b><br /><br />
          
          <span class="col-sm-3">With these details:</span> <b><span id="bankwireDetails" class="col-sm-9"></span></b><br /><br /><br />
          
          <span class="col-sm-3">Bank :</span><b><span class="col-sm-9" id="bankwireAddress"></span></b><br /><br /><br /><br /><br /><br />
          
          <!--<p class="col-sm-12">Do not forget to insert your order #'  <span class="bold">{$id_order}</span>in the subject of your Online Transfer</p><br /><br />-->
          
          <p>
            <input type="button" name="submit" class="btn btn-danger kob_button" value="Confirm Order" style="margin-left:22%;" onclick="paymentMode(3);"   />
          </p>
        </div>
      </form>
    </div>
  </div>
</section>

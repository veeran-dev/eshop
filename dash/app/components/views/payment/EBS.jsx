import React from 'react'
import axios from 'axios';
import { connect } from 'react-redux'
import cookie from 'react-cookie'
import * as addressApi from '../../../api/address-api'
import * as orderApi from '../../../api/orders-api'
import store from '../../../store/configureStore'

class EBS extends React.Component {
    constructor(props){
        super(props)
    }

    componentDidMount(){
      var formData = new FormData();
      formData.append('type', document.getElementById('cr-o-id').value);
      formData.append('orderid', document.getElementById('ap-o-id').value);
      formData.append('id_address_delivery', cookie.load('id_delivery_address'));
      formData.append('id_address_invoice', cookie.load('id_billing_address'));
      return axios.post('dash-EBSdata.php', formData).then(response => {
								  
        let data = response.data
		
        document.getElementById("EBS_form").setAttribute("action", data.ebsurl);
		    document.getElementById('channel').value = data.channel;
        document.getElementById('account_id').value = data.account_id;
        document.getElementById('page_id').value = data.page_id;
        document.getElementById('currency').value = data.currency;
        document.getElementById('reference_no').value = data.reference_no;
        document.getElementById('amount').value = data.amount;
        document.getElementById('description').value = data.description;
        document.getElementById('name').value = data.name;
        document.getElementById('address').value = data.address;
        document.getElementById('city').value = data.city;
        document.getElementById('country').value = data.country;
        document.getElementById('email').value = data.email;
        document.getElementById('postal_code').value = data.postal_code;
        document.getElementById('country').value = data.country;
        document.getElementById('email').value = data.email;
        document.getElementById('phone').value = data.phone;
        document.getElementById('return_url').value = data.return_url;
        document.getElementById('secure_hash').value = data.hashValue;
        document.getElementById('mode').value = data.mode;
        document.getElementById('EBS_form').submit();
        return response.data
      })
    }

    render() {
        return (
           <div className="payment-mode">
                <div>Redirecting to payment page please wait....</div>
                <form  method="post" id="EBS_form">
					<input type="hidden" name="channel" id="channel" />
					<input type="hidden" name="account_id" id="account_id" />
					<input type="hidden" name="page_id" id="page_id" />
					<input type="hidden" name="currency" id="currency" />
					<input type="hidden" name="reference_no" id="reference_no" />
					<input name="amount" id="amount" type="hidden" />
					<input name="description" id="description" type="hidden" />
					<input name="name" id="name" type="hidden" />
					<input name="address" id="address" type="hidden" />
					<input name="city" id="city" type="hidden" />
					<input name="postal_code" id="postal_code" type="hidden" />
					<input name="country" id="country" type="hidden" />
					<input name="email" id="email" type="hidden" />
					<input name="phone" id="phone" type="hidden" />
					<input name="return_url" id="return_url" type="hidden" size="60" />
					<input name="secure_hash" id="secure_hash" type="hidden" size="100" />
					<input name="mode" id="mode" type="hidden" size="60" />
                  <section className="panel">
                    <div className="panel-body" >
                      <div className="">
                        <input type="submit" style={{display: "none"}} className="btn btn-danger kob_button"  value="Submit" />
                      </div>
                    </div>
                  </section>
                </form>
           </div>
        )
    }
}

EBS.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {}
}

export default connect(mapStateToProps)(EBS)
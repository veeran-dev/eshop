import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import Ripples from 'react-ripples';
import store from '../../../store/configureStore';
import * as G from '../../../api/common-api';
import * as settingsApi from '../../../api/settings-api';
import * as addressApi from '../../../api/address-api';
import { getAddress, deleteAddress } from '../../../api/common-api'
import ConfirmationPop from '../../../components/common/ConfirmationContent'

// Using "Stateless Functional Components"
class SettingsAddress extends React.Component {
  constructor(props){
  	super(props)
  }

  componentDidMount() {
  	addressApi.get()
  }

  showConfirmation(id_address) {
    document.getElementById("confirmationPopContent").innerHTML = "";
    ReactDOM.render(<ConfirmationPop onClick={this.deleteAddress.bind(this, id_address)} message={"Are you sure want to delete your address?"} />, document.getElementById("confirmationPopContent"));
    G.displayModal("confirmationPop");
  }

  deleteAddress(id_address) {
    deleteAddress(id_address)
  }

  render() {
  	return (
		<div className="settings">
			<div className="settings-container">
            <div className="page-sub-header"><h3 className="page-title">Address</h3> <button className="button-blue pull-right" type="button" onClick={G.addAddress.bind(this, "", 1)}>Add Address</button></div>
					{ /* <button type="button" onClick={addressApi.add.bind(this)}>Add Address</button> */ }
						 <div className="address-item-wrapper">
                   {this.props.isFetching ? <div className="fetching fetching-address fetching-address-grid"><div className="fetching-content"><div></div><div></div><div></div><div></div></div></div> : 
                        (this.props.address && this.props.address.length > 0 ? this.props.address.map( (address, index) => {
                          return(
                              <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                  <p className="alias">{address.alias}</p>
                                  <p className="full-name">{address.firstname+" "+address.lastname}</p>
                                  <p className="company">{address.company}</p>
                                  <p className="address">
                                      {address.address1}, <br></br>
                                      {address.city}, <br></br>
                                      {address.postcode}, <br></br>
                                      {address.state}, <br></br>
                                      {address.country}<br></br>
                                  </p>
                                  <p className="phone">{address.phone_mobile}</p>
                                  <p class="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                                        <p className="sez">
                                                            <input type="checkbox" id={"sez-check-"+index} defaultChecked={address.sez == 1 || address.isez == 1 ? true : false} />
                                                            <label className="alias" htmlFor={"sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                                        </p>
                                  <div className="address-item-actions">
                                      {/**<button type="button" onClick={getAddress.bind(this, address.id_address)} className="button-left button-blue outline">Edit</button>
                                      <button type="button" onClick={this.showConfirmation.bind(this, address.id_address)} className="button-right outline">Delete</button> **/}
                                  </div>
                              </div>
                          )
                   }) : <div className="empty-state-container"><div className="empty-state"><div className="empty-state-thumb not-installed"></div><h1>No addresses added yet!</h1><p>Fortunately, it's very easy to add them.</p><a href="javascript:void(0)" onClick={G.addAddress.bind(this, "", 1)}>Add Address</a></div></div>)}
              </div>
					</div>
				</div>
	);
  }
}

const mapStateToProps = function(store) {
  return {
  	address: store.addressState.address,
    isFetching: store.addressState.isFetchingAddress
  };
};

export default connect(mapStateToProps)(SettingsAddress);

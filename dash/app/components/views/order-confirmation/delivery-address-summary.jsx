import React from 'react'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import * as addressApi from '../../../api/address-api'
import cookie from 'react-cookie'
import store from '../../../store/configureStore'

class DeliveryAddressSummary extends React.Component {
    constructor(props){
        super(props)
    }

    componentDidMount(){
      addressApi.getById(cookie.load("id_delivery_address"), 1)
      addressApi.getById(cookie.load("id_billing_address"), 2)
    }

    render() {
        return (
            <div className="address-info">
              <div className="card address-summary">
                 <h3 className="block-header">
                  <span>Delivery address</span>
                  <span className="pull-right">
                      <Link to="address" className="change-address"><i className="icon-edit"></i> <span>Change</span></Link>
                  </span>
                 </h3>
                 {this.props.isFetching ? <div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div> : 
                   (this.props.uniqueAddress && this.props.uniqueAddress.length > 0 ? this.props.uniqueAddress.map( (address, index) => {
                      return(
                          <div className={"address_"+address.id_address+" address-item"} key={index}>
                              <p>{address.alias}</p>
                              <p>{address.firstname}</p>
                              <p>{address.company}</p>

                              <p className="address">{address.address1}<br></br>
                              {address.city}<br></br>
                              {address.postcode}<br></br>
                              {address.state}<br></br>
                              {address.country}</p>

                              <p className="phone">{address.phone_mobile}</p>
                          </div>
                      )
                   }) : <div className="address-empty">No address found.</div>)}
              </div>
              <div className="card address-summary">
                 <h3 className="block-header">
                  <span>Billing address</span>
                  <span className={"pull-right"}>
                      <Link to="address" className="change-address"><i className="icon-edit"></i> <span>Change</span></Link>
                  </span>
                 </h3>
                 {this.props.isFetching ? <div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div> : 
                   (this.props.billingAddress && this.props.billingAddress.length > 0 ? this.props.billingAddress.map( (address, index) => {
                      return(
                          <div className={"address_"+address.id_address+" address-item"} key={index}>
                              <p>{address.alias}</p>
                              <p>{address.firstname}</p>
                              <p>{address.company}</p>

                              <p className="address">{address.address1}<br></br>
                              {address.city}<br></br>
                              {address.postcode}<br></br>
                              {address.state}<br></br>
                              {address.country}</p>
                              
                              
                              <p className="phone">{address.phone_mobile}</p>
                          </div>
                      )
                   }) : <div className="address-empty">No address found.</div>)}
              </div>
            </div>
        )
    }
}

DeliveryAddressSummary.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    uniqueAddress: store.addressState.uniqueAddress,
    billingAddress: store.addressState.billingAddress,
    isFetching: store.addressState.isFetchingUniqueAddress
  }
}

export default connect(mapStateToProps)(DeliveryAddressSummary)
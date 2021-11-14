import React from 'react'
import { connect } from 'react-redux'
import ProductsSummary from './products-summary'
import PaymentSummary from './payment-summary'
import DeliveryAddressSummary from './delivery-address-summary'
import Vouchers from './vouchers.jsx'
import CompaniesAlsoBought from './companies-also-bought'
import PaymentMode from '../payment/Payment'
import store from '../../../store/configureStore'

class OrderConfirmation extends React.Component {
    constructor(props) {
        super(props)
        this.handleLoad = this.handleLoad.bind(this)
        this.stateSelection = document.getElementById('state-selection-topbar');
        this.stateSelectionMobile = document.getElementById('state-selection-topbar-mobile');
    }

    componentDidMount() {
        if(this.isInPage(this.stateSelection || this.stateSelectionMobile) && this.context.router.isActive('confirmation')) {
            this.handleLoad();
        }
    }

    isInPage(node) {
        return (node == document.body) ? false : document.body.contains(node);
    }

    handleLoad() {
        document.getElementById('state-selection-topbar').classList.add('disabled');
        document.getElementById('state-selection-topbar-mobile').classList.add('disabled');  
    }

    componentWillUnmount() {
        document.getElementById('state-selection-topbar').classList.remove('disabled');
        document.getElementById('state-selection-topbar-mobile').classList.remove('disabled');
    }

    render() {
        return (
            <div>
               <div className="order-confirmation">
                    {this.props.isProcessingOrder ? <div className="component-spinner component-spinner-message"><div><div className="spinner"></div><h4>Completing your purchase, please wait...</h4></div></div> : null}
                    <div className="primary-info">
                        <ProductsSummary />
                        <Vouchers />
                    </div>
                    <div className="secondary-info">
                        <DeliveryAddressSummary />
                        { /* <CompaniesAlsoBought /> */ }
                        <PaymentSummary />
                        <PaymentMode />
                    </div>
               </div>
            </div>
        )
    }
}

OrderConfirmation.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    isProcessingOrder: store.orderState.isFetchingOrderComplete
  }
}

export default connect(mapStateToProps)(OrderConfirmation)
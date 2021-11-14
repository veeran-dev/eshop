import React from 'react'
import { connect } from 'react-redux'
import * as procureBuyApi from '../../../../api/procure-buy-api'
import PurchaseListComponent from './purchaseList'
import Cart from '../../../views/cart/Cart'
import store from '../../../../store/configureStore'

class PurchaseList extends React.Component {
    constructor(props){
      super(props)
      this.state = {
        idCategory: 0
      }
    } 

    componentWillMount() {
        if(deliveryRegion == "" || deliveryRegion == 0) {
            document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
            document.body.classList.add('modal-open');
        }
    }   

    componentDidMount() {
    	procureBuyApi.getPurchaseList(this.state.idCategory)
      procureBuyApi.getSupplierProducts()
  	}

    getCategoryProducts(event){
      procureBuyApi.getPurchaseList(event.target.value)
    }

    searchProducts(event){
      let categoryId = document.getElementById("pl-supplier-filter").value;
      procureBuyApi.getPurchaseList(categoryId, event.target.value)
    }

    render() {
        return (
        	<div className="purchase-list-container">
            <PurchaseListComponent myList={this.props.myList} myTotalList={this.props.myTotalList} search={this.searchProducts.bind(this)} suppliers={this.props.suppliers} onChange={this.getCategoryProducts.bind(this)}/>
            <Cart />
		      </div>
    	)
  	}
}

PurchaseList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	myList: store.procureBuyState.purchaseList,
    myTotalList: store.procureBuyState.purchaseListTotal,
    // categories: store.procureBuyState.purchaseCategories
    suppliers: store.procureBuyState.purchaseSuppliers
  }
}

export default connect(mapStateToProps)(PurchaseList) 
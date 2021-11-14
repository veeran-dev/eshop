import React from 'react';
import ReactDOM from 'react-dom'
import { NavLink } from 'react-router-dom';
import { connect } from 'react-redux';
import store from '../../../store/configureStore';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import CurrencyFormat from 'react-currency-format';

import SearchCatalog from './search-catalog'
import AddProduct from './add-product'
import AddPrice from './add-price'


class ProductCreate extends React.Component {
  constructor(props){
    super(props)
    this.state={
      step:1,
      name:null,
      packSize: null,
      mrp: null,
      price: null,
      stock: true,
      enable: true,
    }
  }

  currentSection=(e)=> {
    switch (this.state.step) {
      case 1:
        return <SearchCatalog />
      case 2:
        return <AddProduct />
      case 3:
        return <AddPrice />
      case 4:
        return <Confirmation />
    }
  }

  render(){
    return(
        <div className="create-product-container">
        {this.currentSection()}
        </div>
      )
  }
}

export default ProductCreate;

class Confirmation extends React.Component{
  render(){
    return(
        <div className="">
            Confirmation
        </div>
      )
  } 
}
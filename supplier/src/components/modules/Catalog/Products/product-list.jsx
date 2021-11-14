import React, { memo, useState } from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import ReactPaginate from 'react-paginate';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ReactImageFallback from "react-image-fallback";

import AddProductForm from '../../../common/AddProductForm'
import * as catalogApi from '../../../../api/catalog-api';
import * as G from '../../../../api/common-api';
class ProductList extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      pageNumber: 0,
      offset:0,
      limit: 10,
      query: "",
      idPage: "",
      input: '',
      updatePagination: false,
    }
  }

  componentDidMount() {
    const { limit, offset, idPage, query, updatePagination, pageNumber} = this.state
    catalogApi.getProductList(limit, offset, idPage, query)
  }

  getProductList(limit, offset, idPage, query, pageNumber, updatePagination, object){
    if(object){
      if(object.selected == 0 || object.selected){
        idPage=object.selected    
      }
    }
    if(this.refs.orderPerPage.value){
      limit = this.refs.orderPerPage.value
    }
    catalogApi.getProductList(limit, offset, idPage, query)
    this.setState({idPage, limit, updatePagination})
  }

  addProducts(){
    ReactDOM.render(<AddProductForm />, document.getElementById("addProductFormContent"));
    G.displayModal("addProductForm");
  }
  
  render(){
    const { limit, offset, idPage, query, updatePagination, pageNumber } = this.state
    let pageCount = parseInt(this.props.productCount) / parseInt(limit);
    pageCount = pageCount > parseInt(pageCount) ? parseInt(pageCount)+1 : parseInt(pageCount);
    return (
        <div>
          <div className="contract-list-container">
            <div className="contract-list-wrapper product-list-wrapper">
              <div className="table-filter">
                <div className="contract-list-search">
                  <input ref="searchQuery" type="text" placeholder="Search your Products" 
                    onChange={(e)=>{
                      if (this.state.typingTimeout) {
                        clearTimeout(this.state.typingTimeout);
                      }
                      this.setState({
                        query: e.target.value,
                        typing: false,
                        typingTimeout: setTimeout(function(){
                            this.getProductList(limit, offset, 0, this.state.query, pageNumber, true)
                          }.bind(this), 750)
                      });
                  }}/>
                  <i className="icon-search"></i>
                </div>
                
                <div className="pagination-container">
                  <div>
                    <button className="btn-primary" onClick={this.addProducts.bind(this)}>Add Product</button>
                  </div>
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" defaultValue={10} 
                  onChange={this.getProductList.bind(this, limit, offset, 0, this.state.query, pageNumber, true)}>
                    <option >10</option>
                    <option >25</option>
                    <option >50</option>
                    <option >100</option>
                  </select>
                  <ReactPaginate 
                    nextLabel={<i className="icon-arrow-right"></i>}
                    previousLabel={<i className="icon-arrow-left"></i>}
                    breakLabel={<a href="javascript: void(0)">...</a>}
                    breakClassName={"break-me"}
                    pageCount={parseInt(pageCount)}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    onPageChange={this.getProductList.bind(this, limit, offset, idPage, this.state.query, pageNumber, false)}
                    containerClassName={"pagination"}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"}
                    forcePage={pageNumber} />
                </div>
            </div>

            <table>
              <thead>
                <tr>
                  <th>
                    Image
                  </th>
                  <th className="text-align-left">
                    Product Name
                  </th>
                  <th className="text-align-left">
                    Reference
                  </th>
                  <th className="text-align-center">
                    GST
                  </th>
                  <th className="text-align-center">
                    Stock
                  </th>
                </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? 
                    <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td><td></td></tr> : 
                    (this.props.productList && this.props.productList.length > 0 ? this.props.productList.map(contract => {
                      return (
                        <tr key={contract.id_product}>
                            <td data-title="Image"><ReactImageFallback
                                    src={contract.imageLink}
                                    fallbackImage=".././img/p/en-default-small_default.jpg"
                                    initialImage=".././img/p/en-default-small_default.jpg"
                                    alt={contract.product_name}/>
                            </td>
                            <td data-title="Product Name">{contract.product_name}</td>
                            <td data-title="Reference">{contract.reference}</td>
                            <td data-title="GST" className="text-align-center">{contract.gst}</td>
                            <td data-title="Stock" className="text-align-center">{contract.out_of_stock == 0 ? "IN STOCK" : "OUT OF STOCK"}</td>
                        </tr> 
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Products Found!</h2><p>Please upload your catalog</p></div></td><td></td></tr>)
                  }
              </ReactCSSTransitionGroup>
            </table>
          </div>
        </div> 
      </div>
    )
  }
}

const mapStateToProps = function({catalogState}) {
  return {
    productList: catalogState.productList,
    productCount: catalogState.productCount,
    isFetching: catalogState.isFetching,
  };
};

export default connect(mapStateToProps)(ProductList);
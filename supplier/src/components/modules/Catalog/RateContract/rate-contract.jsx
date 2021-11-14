import React, { memo, useState } from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import ReactPaginate from 'react-paginate';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

import * as catalogApi from '../../../../api/catalog-api';
import * as G from '../../../../api/common-api';
class RateContract extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      pageNumber: 0,
      offset:0,
      limit: 10,
      query: "",
      idPage: "",
      selectedCustomer: 0,
      input: '',
      updatePagination: false,
    }
  }

  componentDidMount() {
    const { limit, offset, idPage, query, updatePagination, pageNumber, selectedCustomer  } = this.state
    catalogApi.getContractList(limit, offset, idPage, query, selectedCustomer)
  }

  getContractList(limit, offset, idPage, query, pageNumber, selectedCustomer, updatePagination, object=false){
    console.log(object)
    if(object){
      if(object.selected == 0 || object.selected){
        idPage=object.selected    
      }
    }
    if(this.refs.orderPerPage.value){
      limit = this.refs.orderPerPage.value
    }
    catalogApi.getContractList(limit, offset, idPage, query, selectedCustomer)
    this.setState({selectedCustomer, idPage, limit, updatePagination})
  }
  
  render(){
    const { limit, offset, idPage, query, updatePagination, pageNumber, selectedCustomer  } = this.state
    let pageCount = parseInt(this.props.contractCount) / parseInt(limit);
    pageCount = pageCount > parseInt(pageCount) ? parseInt(pageCount)+1 : parseInt(pageCount);
    return (
        <div>
          <div className="contract-list-container">
            <div className="contract-filter-container">
              <div className="filter-header">
                <h3>Customers</h3>
              </div>
              <div className="filter-wrapper">
                <div className="actions">
                  {this.props.customers != undefined && this.props.customers.length > 0?
                  <ul className="order_status_filter">
                    <li className={this.state.selectedCustomer == 0 ? "active": ""} onClick={this.getContractList.bind(this, limit, offset, 0, query, pageNumber, 0, true)} key={"0_status"}>All Customers</li>
                    {this.props.customers.length > 0 ? this.props.customers.map(function(customer, i){
                      return(
                      <li id={customer.id_group} className={this.state.selectedCustomer == customer.id_group ? "active": ""} key={customer.id_group} onClick={this.getContractList.bind(this, limit, offset, 0, query, pageNumber, customer.id_group, true)}>
                        <span>{customer.company}</span>
                      </li>
                      )
                    }.bind(this)):
                    <div className="fetching">
                      <div className="fetching-content">
                        <div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item">
                      </div>
                    </div></div>
                    }
                  </ul>:
                  <div className="no-results">
                    <img src="../supplier/src/assets/img/no-data.png" alt="No Results"/>
                    <h2>No Customers Tagged!</h2>
                    <p>Please contact support team</p>
                  </div>}
                </div>
              </div>
            </div>
            <div className="contract-list-wrapper">
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
                            this.getContractList(limit, offset, 0, this.state.query, pageNumber, selectedCustomer, true)
                          }.bind(this), 750)
                      });
                  }}/>
                  <i className="icon-search"></i>
                </div>
                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" defaultValue={10} 
                  onChange={this.getContractList.bind(this, limit, offset, 0, this.state.query, pageNumber, selectedCustomer, true)}>
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
                    onPageChange={this.getContractList.bind(this, limit, offset, idPage, this.state.query, pageNumber, selectedCustomer, false)}
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
                    Reference
                  </th>
                  <th className="text-align-left">
                    Product Name
                  </th>
                  <th className="text-align-left">
                    Customer
                  </th>
                  <th className="text-align-right">
                    Selling Price
                  </th>
                  <th className="text-align-center">
                    GST
                  </th>
                  <th>
                    Expiry On
                  </th>
                </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? 
                    <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td><td></td></tr> : 
                    (this.props.rateContract && this.props.rateContract.length > 0 ? this.props.rateContract.map(contract => {
                      return (
                        <tr key={contract.id_specific_price}>
                            <td data-title="Reference">{contract.reference}</td>
                            <td data-title="Product Name">{contract.product_name}</td>
                            <td data-title="Customer">{contract.company}</td>
                            <td data-title="Selling Price" className="text-align-right">{G.toPrice(contract.price)}</td>
                            <td data-title="GST" className="text-align-center">{contract.gst}</td>
                            <td data-title="Expires On">{G.getDate(contract.to, "lll")}</td>
                        </tr> 
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Product's Found!</h2><p>Please upload your catalog</p></div></td><td></td></tr>)
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
    rateContract: catalogState.rateContract,
    customers: catalogState.allCustomers,
    contractCount: catalogState.contractCount,
    isFetching: catalogState.isFetching,
  };
};

export default connect(mapStateToProps)(RateContract);
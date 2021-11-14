import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import ReactImageFallback from "react-image-fallback";
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ReactPaginate from 'react-paginate';
import DayPickerInput from '../../common/datepickerSingle'
import * as quotationsApi from '../../../api/quotations-api'
import store from '../../../store/configureStore'

class AcceptCustomerDesktop extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            idPage  : 0,
            query: '',
            isMobile: false,
            limit: 10,
            updatePagination: false,
        };
    }

    componentWillMount(){
      quotationsApi.getAcceptedCustomer("", 0, 10, true); 
    }

    getAcceptedCustomerList(q, idPage, limit, updatePagination, dynamicObject){
      if(dynamicObject != null && dynamicObject !== undefined) {
        if(dynamicObject.selected == 0 || dynamicObject.selected){
          idPage = dynamicObject.selected
        }
      }

      if(this.refs.QuotePerPage.value)
        limit = this.refs.QuotePerPage.value

      this.setState({
        limit: limit,
        idPage: idPage,
        q: q,
        updatePagination: updatePagination
      })
      quotationsApi.getAcceptedCustomer(q, idPage, limit, true); 
    }

    acceptBuyer(type, id_quote_request, e){
      console.log(id_quote_request)
      const { limit, idPage, q  } = this.state

      quotationsApi.acceptCustomer(type, id_quote_request).then(response=>{
        if(response.data['success']){
          toastr.success('Success', response.data['success'], { icon: "icon-success"})
            quotationsApi.getAcceptedCustomer(q, idPage, limit, true);
        }
      })
      
    }

    render() {
      const { limit, idPage, q, updatePagination  } = this.state
        return (
            <div className="">
              <div className="table-filter">
                <div className="pagination-container">
                  <select ref="QuotePerPage" className="pagination-select" name="orderPerPage" onChange={this.getAcceptedCustomerList.bind(this, q, idPage, limit, true, null)}>
                    <option defaultValue={10} selected>10</option>
                    <option defaultValue={25}>25</option>
                    <option defaultValue={50}>50</option>
                    <option defaultValue={100}>100</option>
                  </select>
                  <ReactPaginate 
                    nextLabel={<i className="icon-arrow-right"></i>}
                    previousLabel={<i className="icon-arrow-left"></i>}
                    breakLabel={<a href="javascript: void(0)">...</a>}
                    breakClassName={"break-me"}
                    pageNum={this.props.customerCount > 0 ? Math.ceil(this.props.customerCount/this.state.limit) : 0}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    containerClassName={"pagination"}
                    clickCallback={this.getAcceptedCustomerList.bind(this, q, idPage, limit, false)}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
              </div>
              <table>
                <thead>
                  <tr>
                    <th>Reference</th>
                    <th>Product</th>
                    <th>Buyer</th>
                    <th>Location</th>
                    <th>Quantity</th>
                    <th>Quote Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="7"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                      (this.props.acceptedCustomer != undefined && this.props.acceptedCustomer.length > 0 ? this.props.acceptedCustomer.map((quotation, i)=>{
                      return (
                        <tr key={quotation.id_quote_request+"_id"} id={quotation.id_quote_request+"_id"} className={quotation.id_quote_request+"_class qr_wrapper"} >
                            <td><a>{quotation.ref}</a></td>
                            <td className="desc">
                              <div>
                                <ReactImageFallback
                                  src={quotation.imageLink2}
                                  fallbackImage="./img/p/en-default-small.jpg"
                                  initialImage="./img/p/en-default-small.jpg"
                                  alt={quotation.name}/>
                              </div>
                              <div>{quotation.name} | <strong>{quotation.code}</strong></div>
                            </td>
                            <td>{quotation.company}</td>
                            <td>{quotation.location}</td>
                            <td>{quotation.quantity}</td>
                            <td>Rs.{quotation.low_price}</td>
                            <td className="action">
                                <button id={quotation.id_quote_request+"_accept"} className="button-blue" onClick={this.acceptBuyer.bind(this, 1, quotation.id_quote_request)}>Accept</button> 
                                <button id={quotation.id_quote_request+"_cancel"} className="button-blue outline" onClick={this.acceptBuyer.bind(this, 2, quotation.id_quote_request)}>Reject</button> 
                            </td>
                        </tr>
                      );
                    }):
                    <tr className="no-results-wrapper"><td colSpan="7"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No New Buyers !</h2><p>Give competitive price for all Quotation requests</p></div></td></tr>
                  )}
                  </ReactCSSTransitionGroup>
              </table>
            </div>
        )
    }
}

const mapStateToProps = function(store) {
  return {
    acceptedCustomer: store.quotationState.acceptedCustomer,
    isFetching: store.quotationState.isFetching,
    customerCount: store.quotationState.acceptedCustomerCount,
  }
};

export default connect(mapStateToProps)(AcceptCustomerDesktop)
import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import * as quotationsApi from '../../../api/quotations-api';
import * as G from '../../../api/common-api';
import store from '../../../store/configureStore';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import InfiniteScroll from 'react-infinite-scroller';
import Confirmation from './ConfirmQuotationRequests'

// Using "Stateless Functional Components"
class QuotationRequestsList extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      page:0,
      hasMoreItems:true,
      query: "",
      sort: 0,
      acted:0,
      requests: []
    }
  }

  componentWillMount(){
    quotationsApi.getQuotationsRequests("", 0, true);
  }

  _handleKeyDown = (e) => {    
    if (e.key === 'Enter') {
        this.setState({acted:0,hasMoreItems:true, page:0})
        quotationsApi.getQuotationsRequests(this.state.query, 0, true, this.state.sort);
    }
  }

  _handleSendQuote = (id, index, e) => {
    if (e.key === 'Enter') {
      this.sendQuote(id, index);
    }
  }

  rejectQuote(id, index){
    quotationsApi.rejectQuote(id)
    .then(response =>{
        if(response.data['success'] == 1){
          toastr.success("Success", "Quotation rejected successfully.", {icon: "icon-success"})
          let testarray = document.getElementsByClassName(id+"_class");
          for(var i = 0; i < testarray.length; i++)
          {
              testarray[i].className += " remove";
          }
          setTimeout(function(){ 
            let requests = this.state.requests;
            requests.splice(index, 1)
            this.setState({requests: requests}) 
            quotationsApi.getQuotationsRequests(this.state.query, this.state.page, true, this.state.sort);
          }.bind(this), 300);
          this.setState({acted: this.state.acted+1})
        }
        else if(response.data['error'] == 1){
          toastr.error("Error", "Something went wrong, please try again later.", {icon: "icon-error"})
        }
      })
  }

  sendQuote(id, index, lowPrice, expiryDate, el){
    quotationsApi.sendQuoteConfirm(expiryDate, lowPrice, id, this.state.requests[index]['name'], this.state.requests[index]['quantity'], this.state.requests[index]['id_customer'])
    .then(response =>{
        G.closeModal(["confirmQuotation"])
        if(response.data['success'] == 1){
          toastr.success("Success", "Quotation sent to customer successfully.", {icon: "icon-success"})
          let testarray = document.getElementsByClassName(id+"_class");
          for(var i = 0; i < testarray.length; i++)
          {
              testarray[i].className += " remove";
          }
          setTimeout(function(){ 
            let requests = this.state.requests;
            requests.splice(index, 1)
            this.setState({requests: requests}) 
            quotationsApi.getQuotationsRequests(this.state.query, this.state.page, true, this.state.sort);
          }.bind(this), 300);
          this.setState({acted: this.state.acted+1})
        }
        else if(response.data['error'] == 1){
          toastr.error("Error", "Something went wrong, please try again later.", {icon: "icon-error"})
        }
      })
  }

  confirmQuote=(id_quote_request, quantity, i, e)=>{
      ReactDOM.render(<Confirmation 
                          sendQuote={this.sendQuote.bind(this)}
                          item={i}
                          quantity={quantity}
                          idQuoteRequest={id_quote_request} />, document.getElementById("confirmQuotationContent"))
      G.displayModal("confirmQuotation")
  }

  componentWillReceiveProps(nextProps){
    this.setState({requests: this.props.requests})
  }

  render(){
    let d = new Date();
    d.setMonth(d.getMonth() + 3);
    return (
          <>
            <div className="list-search">
              <input ref="searchQuery" type="text" placeholder="Search by products name" 
                onChange={(e)=>{
                  console.log(e.target.value)
                  if (this.state.typingTimeout) {
                    clearTimeout(this.state.typingTimeout);
                  }
                  this.setState({
                    query: e.target.value,
                    typing: false,
                    typingTimeout: setTimeout(function(){
                        this.setState({acted:0,hasMoreItems:true, page:0})
                        quotationsApi.getQuotationsRequests(this.state.query, 0, true, this.state.sort);
                      }.bind(this), 750)
                  });
              }}/>
              <i className="icon-search"></i>
            </div>
            <div className="table-filter">
              <div>
              You have received {this.props.count} quotation requests
              </div>
              <div>
                <select 
                  onChange={(e)=>this.setState({sort: e.target.value},function(){
                    this.setState({page:0, acted:0, hasMoreItems: true})
                    quotationsApi.getQuotationsRequests(this.state.query, 0, true, this.state.sort);
                  })}>
                  <option value="0">Sort By</option>
                  <option value="1">Deadline</option>
                  <option value="2">Newest</option>
                </select>
              </div>
            </div>
            <InfiniteScroll
                    pageStart={0}
                    loadMore={
                        page=>{
                            let i = this.state.page+1;
                            let hasMoreItems = this.state.requests.length == this.props.count ? false : true;
                            this.setState({page: i, hasMoreItems:hasMoreItems},function(){
                                quotationsApi.getQuotationsRequests(this.state.query, i, false, this.state.sort)
                            }.bind(this))
                            
                        }
                    }
                    className="qr_container_mobile"
                    initialLoad={false}
                    hasMore={this.state.hasMoreItems}
                    loader={<div className="q-loader" key={0}>    </div>}
                >
                {this.state.requests && this.state.requests.length > 0 ? this.state.requests.map((request, i) => {
                      return (
                              <div key={request.id_quote_request+"_id"} id={request.id_quote_request+"_id"} className={request.id_quote_request+"_class qr_wrapper"}>
                                <div className="qr_image_block">
                                    <img src={request.imageLink2} />
                                </div>
                                <div className="qr_product_details">
                                    <div className="qr_product_name_wrapper">
                                        <p className="qr_product_name">
                                            {request.name} - <span>{request.reference}</span>
                                        </p>
                                    </div>
                                    <div className="qr_block_top">
                                        <div className="qr_detail">
                                            <p>Standard Price</p>
                                            <p>Rs.{parseFloat(request.price).toFixed(2)}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p>Quantity</p>
                                            <p>{request.quantity}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p>Deadline</p>
                                            <p>{request.deadline}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p>Payment</p>
                                            <p>{request.payment}</p>
                                        </div>
                                    </div>
                                    <div className="qr_block_top">
                                        <div className="qr_price_block">
                                            <p><i className="icon-arrow-up"></i> {request.sellHigh ? request.sellHigh : "NA"}</p>
                                            <p><i className="icon-arrow-down"></i> {request.sellLow ? request.sellLow : "NA"}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p className="label">Purchase For</p>
                                            <p className="detail">{request.buying_interval}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p className="label">Purchase</p>
                                            <p className="detail">{request.purchase}</p>
                                        </div>
                                        <div className="qr_detail">
                                            <p className="label">Delivery</p>
                                            <p className="detail">{request.location}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="qr_action_block_wrapper">
                                  <button className="button-blue" onClick={this.confirmQuote.bind(this,request.id_quote_request, request.quantity, i)}>
                                    <span>Quote</span>
                                  </button>
                                  <button className="button-black outline" onClick={this.rejectQuote.bind(this,request.id_quote_request, i)}>
                                    <span>Reject</span>
                                  </button>
                              </div>
                            </div>
                      );
                    }):
                    <div className="no-results">
                        <img src="../supplier/src/assets/img/no-data.png" alt="No Results"/>
                        <h2>No Quotations Found!</h2>
                        <p>There is no products in your quotations.<br/> please contact your Relationship Manager for any issues</p>
                    </div>
                  }
              </InfiniteScroll>
        </> 
    )
  }
}

const mapStateToProps = function({quotationState}) {
  return {
    requests: quotationState.quotationRequestsList,
    isFetching: quotationState.isFetching,
    count: quotationState.quotationRequestsListCount,
  };
};

export default connect(mapStateToProps)(QuotationRequestsList);

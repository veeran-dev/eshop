import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import ReactImageFallback from "react-image-fallback";
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import DayPickerInput from '../../common/datepickerSingle'
import * as quotationsApi from '../../../api/quotations-api'
import store from '../../../store/configureStore'

class QuotationLists extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            hasMoreItems: true,
            page: 0,
            quotations: [],
            query: '',
            isMobile: false,
        };
    }

  _handleKeyDown = (e) => {    
    if (e.key === 'Enter') {
        this.setState({acted:0, page:0})
        quotationsApi.getQuotationsRequests(this.state.query, 0, true);
    }
  }
  
  toQuotation =(id) =>{
        let old_url = window.location.href;
        var new_url = old_url.substring(0, old_url.indexOf("list"));
        var win = window.open(new_url+'details/'+id, '_blank');
        win.focus();
  }

  componentWillReceiveProps(nextProps){
    this.setState({
      quotations: this.props.quotations,
      hasMoreItems: this.props.quotations.length == this.props.count ? false : true,
    },function(){console.log(this.state.quotations)})

  }
    render() {
        return (
            <div className="page-container">
              <div className="table-filter">
                <input type="text" placeholder="Search products name" 
                    onChange={(e)=>this.setState({query: e.target.value})} 
                    onKeyDown={this._handleKeyDown.bind(this)} />
              </div>
                <InfiniteScroll
                        pageStart={0}
                        loadMore={
                            page=>{
                                let i = this.state.page+1;
                                this.setState({page: i, hasMoreItems:false},function(){
                                    quotationsApi.getQuotationsRequests(this.state.query, this.state.page, false)
                                }.bind(this))
                                
                            }
                        }
                        initialLoad={false}
                        hasMore={this.state.hasMoreItems}
                        loader={<div className="loader" key={0}>    </div>}
                      >
                    {this.state.quotations && this.state.quotations.length > 0 ? this.state.quotations.map((quotation, i) => {
                      return (
                              <div key={quotation.id_quote_request+"_id"} id={quotation.id_quote_request+"_id"} className={quotation.id_quote_request+"_class quote_response_mobile"}>
                                <div className="image_block">
                                    <ReactImageFallback
                                      src={quotation.imageLink2}
                                      fallbackImage="./img/p/en-default-large.jpg"
                                      initialImage="./img/p/en-default-large.jpg"
                                      alt={quotation.name}/>
                                </div>
                                <div className="detail_section">
                                  <div className="product_name">
                                    <p>
                                    {quotation.name} - <span>{quotation.reference}</span>
                                    </p>
                                  </div>
                                  <div className="quote_ref">
                                    <p>Quote Reference</p>
                                    <p>{quotation.id_quote_request.padStart(6, '0')}</p>
                                  </div>
                                  <div className="quote_details">
                                    <div className="product_qty">
                                      <p>Quantity</p>
                                      <p>{quotation.quantity}</p>
                                    </div>
                                    <div className="product_deadline">
                                      <p>Deadline</p>
                                      <p>{quotation.deadline}</p>
                                    </div>
                                    <div className="product_payment">
                                      <p>Payment</p>
                                      <p>{quotation.payment}</p>
                                    </div>
                                  </div>
                                  <div className="product_action">
                                    {quotation.ready == 1 ? 
                                      <button className="button-blue button-large" onClick={this.toQuotation.bind(this, quotation.id_quote_request)} >
                                      {quotation.cnt >0 || quotation.cnt !=null ? quotation.cnt+" Quotations Received" : "No quotations"}
                                      </button>:
                                      <button className="button-black button-large outline" onClick={this.toQuotation.bind(this, quotation.id_quote_request)} >{quotation.cnt ==0 || quotation.cnt ==null ? "Awaiting quotation":quotation.cnt +" quotations processed"}</button>}
                                  </div>
                                </div>
                              </div>
                      );
                    }):
                    <div className="no-results">
                        <img src="dash/img/no-data.png" alt="No Results"/>
                        <h2>No Quotations Found!</h2>
                        <p>Search products and find supplier to get quote</p>
                    </div>
                  }      
                </InfiniteScroll>
            </div>
        )
    }
}

const mapStateToProps = function(store) {
  return {
    quotations: store.quotationState.quotationRequestsList,
    isFetching: store.quotationState.isFetching,
    count: store.quotationState.quotationRequestsListCount,
  }
};

export default connect(mapStateToProps)(QuotationLists)
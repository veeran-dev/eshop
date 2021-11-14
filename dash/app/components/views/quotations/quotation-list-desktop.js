import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import ReactImageFallback from "react-image-fallback";
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ReactPaginate from 'react-paginate';
import DayPickerInput from '../../common/datepickerSingle'
import * as quotationsApi from '../../../api/quotations-api'
import store from '../../../store/configureStore'

class QuotationLists extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            idPage  : 0,
            quotations: [],
            query: '',
            isMobile: false,
            limit: 10,
        };
    }

    componentWillMount(){
      quotationsApi.getQuotationsRequests("", 0, 10, true); 
    }
    toQuotation =(id) =>{
          let old_url = window.location.href;
          var new_url = old_url.substring(0, old_url.indexOf("list"));
          var win = window.open(new_url+'details/'+id, '_blank');
          win.focus();
    }

    getQuotations(q, idPage, limit, updatePagination, dynamicObject){
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
      quotationsApi.getQuotationsRequests(q, idPage, limit, true); 
    }

    cancelQuotationsRequests(id){
      console.log(id);
      quotationsApi.cancelQuotationsRequests(id);
    }

    handleDownload(file){
      console.log(file)
      window.open(file);
    }
    render() {
      const { limit, idPage, q, updatePagination  } = this.state
        return (
            <div >
              <div className="table-filter">
                <div className="pagination-container">
                  <select ref="QuotePerPage" className="pagination-select" name="orderPerPage" onChange={this.getQuotations.bind(this, q, 0, limit, true, null)}>
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
                    pageNum={Math.ceil(this.props.count/this.state.limit)}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    containerClassName={"pagination"}
                    clickCallback={this.getQuotations.bind(this, q, idPage, limit, false)}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
            </div>
              <table>
                <thead>
                  <tr>
                    <th>Reference</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                      (this.props.quotations != undefined && this.props.quotations.length > 0 ? this.props.quotations.map((quotation, i)=>{
                      return (
                        <tr key={quotation.id_quote_request+"_id"} id={quotation.id_quote_request+"_id"} className={quotation.id_quote_request+"_class qr_wrapper"} >
                            <td><a>{quotation.ref}</a></td>
                            <td className="desc">
                              {quotation.type == 1 ? 
                                <MarkOne data={quotation} /> 
                                : <MarkThree download={this.handleDownload} data={quotation}/>}
                            </td>
                            <td>{quotation.created}</td>
                            <td>{quotation.deadline}</td>
                            <td id={quotation.id_quote_request+"_status"}>{quotation.status}</td>
                            <td className="action">
                              {quotation.status === "In Process" ?
                              <button id={quotation.id_quote_request+"_cancel"} className="button-black outline" onClick={this.cancelQuotationsRequests.bind(this, quotation.id_quote_request)}>Cancel</button> 
                              :null}
                              {quotation.status == "Response Received" ? 
                              <button id={quotation.id_quote_request+"_rr"} className="button-blue outline" onClick={this.toQuotation.bind(this, quotation.id_quote_request)}>View</button> 
                              :null}
                            </td>
                        </tr>
                      );
                    }):
                    <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Quotations Found!</h2><p>Search products and find supplier to get quote</p></div></td></tr>
                  )}
                  </ReactCSSTransitionGroup>
              </table>
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


const MarkThree=({data, download})=>{
  let length = data.categories.split(",").length-3;
  return (
        <div className="desc-wrapper markone">
          <div className="section">
            <div className="details">
              {data.product_name != "" ?
              <p>Product : {data.product_name}</p>
              :null}
              <div className="categories" id={data.id_quote_request+"_iqr"}>
                {data.categories.split(",").map((cat, i)=>{
                  if(i<3){
                    return(<div>{cat}</div>);
                  }
                  else if(i == 3){
                    return(<div>{length} more..</div>);
                  }
                })}
              </div>
            </div>
          </div>
          <div className="bottom-section">
            <p>{data.description}</p>
            <div>
              {data.quotation_file != undefined ?
                <a onClick={()=>download(data.quotation_file)}><span><i className="icon-download"></i></span> {data.ref}</a>
              :null}
              {data.quotation_image != undefined?
                <a onClick={()=>download(data.quotation_image)}><span><i className="icon-download"></i></span> Images</a>
              :null}
              {data.quotation_attachment != undefined ?
                <a onClick={()=>download(data.quotation_attachment)}><span><i className="icon-download"></i></span> Attachment</a>
              :null}
            </div>
          </div>
        </div>
    )
}

const MarkOne=({data})=>{
  return (
        <div className="desc-wrapper markone">
          <div className="section">
            <div className="details">
              <p>{data.pname} | <strong>{data.code}</strong></p>
            </div>
            <div className="image-cell">
              <ReactImageFallback
                src={data.imageLink2}
                fallbackImage="./img/p/en-default-medium.jpg"
                initialImage="./img/p/en-default-medium.jpg"
                alt={data.pname != "" ? data.pname : "default_image"}/>
            </div>
          </div>
        </div>
    )
}
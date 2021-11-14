import React from 'react';
import ReactDOM from 'react-dom';
import Product from '../../../common/ProductBox';
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore'
import {search} from '../../../../api/search-api';
import * as G from '../../../../api/common-api';
import QuotationForm from '../../../views/quotations/quotation-form'

class SearchResults extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            hasMoreItems: true,
            page: 1,
        };
    }

    componentWillReceiveProps(nextProps){
        if(nextProps.products.length > this.props.products.length){
            this.setState({hasMoreItems: true})
        }
        // whenever search results are reset or count of result is zero then state.page reset to 1
        // console.log(nextProps.products.length)
        if(nextProps.products.length == 0){
            this.setState({page: 1})
        }
    }

    showQuoteForm(){
        console.log("showQuoteForm");
        ReactDOM.render(<QuotationForm getQuantity={true} getProduct={true} minimalQuote={false} store={store}/>, document.getElementById("quotationFormContent"))
        G.displayModal("quotationFormID")
    }

    render() {
        let query = this.props.searchFilters.query, zone = this.props.searchFilters.zone 
        let category_filter = this.props.searchFilters.category_filter, brand_filter = this.props.searchFilters.brand_filter
        let price = this.props.searchFilters.price, sort = this.props.searchFilters.sort, update_filter = this.props.searchFilters.update_filter
        return (
            <div className="sp-search-results">
                <InfiniteScroll
                    pageStart={0}
                    loadMore={
                        page=>{
                            let i = this.state.page+1;
                            this.setState({page: i, hasMoreItems:false},function(){
                                search(i, query, zone, category_filter, brand_filter, price, sort, true )
                            }.bind(this))
                            
                        }
                    }
                    initialLoad={false}
                    hasMore={this.state.hasMoreItems}
                    loader={<div className="loader" key={0}>    </div>}
                >
                <div className="sp-search-results-container">
                {this.props.products != undefined && this.props.products.length > 0 ? this.props.products.map((product)=>{
                    return(
                        <Product product={product} />
                        )
                }):
                <div className="no-results">
                    <img src="dash/img/no-data.png" alt="No Results"/>
                    <button className="button-blue" onClick={this.showQuoteForm.bind(this)}>Get Quote</button>
                    <h2>No Results Found!</h2>
                    <p>Please try again with more keywords.</p>
                </div>
                }
                </div>
                </InfiniteScroll>
            </div>
        )
    }
}

const mapStateToProps = function(store) {
  return {
    products: store.searchState.result,
    searchFilters: store.searchState.search_data,
  }
};

export default connect(mapStateToProps)(SearchResults)  


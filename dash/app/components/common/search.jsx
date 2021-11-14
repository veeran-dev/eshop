import React from 'react'
import ReactDOM from 'react-dom'
import cookie from 'react-cookie'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group'
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import * as G from '../../api/common-api'
import * as cartApi from '../../api/cart-api'
import * as action from '../../actions/common-actions';
import Input from '../../components/common/Input'
import Ripples from 'react-ripples';
import ReactPaginate from 'react-paginate';
import * as procureBuyApi from '../../api/procure-buy-api'
import InputRange from 'react-input-range';
import { Scrollbars } from 'react-custom-scrollbars';
class Search extends React.Component {
    constructor(props){
      super(props)
      this.state = {
        limit: 20,
        idPage: 0,
        updatePagination: false,
        search_type: cookie.load("search_type"),
		pageType:3,
      values: {
        min: 0,
        max: 0,
      }
      }
    }

	handleValuesChange(component, values) {
		this.setState({
		  values: values,
		});
	}
	
	handleValuesChangeDone() {
		/*G.searchProducts(this.props.params.searchTerm, this.state.limit, this.state.idPage, this.state.search_type,document.getElementById('priceMin').value,document.getElementById('priceMax').value,1);*/
		procureBuyApi.getFilterValues(this.state.limit,this.state.idPage,this.state.search_type,this.state.pageType,this.props.params.searchTerm, this.state.values);
	}
    componentDidMount(){
      G.searchProducts(this.props.params.searchTerm, this.state.limit, this.state.idPage, this.state.search_type)
    }
	
	filterProducts(type, limit,idPage, updatePagination,freshclick,page) {
 	   let id_Page ;
 	   if(freshclick==1)
	   {
 		   let id_Page=0;
	   }
	   else
	   {
 		   let id_Page=idPage;
	   }
  	   let page_id = (page && page.selected) ? page.selected : id_Page;  
       G.searchProducts(this.props.params.searchTerm, this.state.limit, page_id, type)
      this.setState({
        limit: limit,
        idPage: page_id,
        search_type: type,
        updatePagination: updatePagination
      })
     }
	
 	checkFilter(elemId,limit,idPage,search_type,pagenation, dynamicObject) {
		if(!pagenation)
		{
			var filterChoosen=document.getElementById(elemId).checked;
			if(filterChoosen == true)
			{
				document.getElementById(elemId).checked=false;
			}
			else if(filterChoosen == false)
			{
				document.getElementById(elemId).checked=true;
			}
		}
		
		if(dynamicObject != undefined) {
  			idPage = dynamicObject.selected
		}
 		procureBuyApi.getFilterValues(limit,idPage,search_type,this.state.pageType,this.props.params.searchTerm, this.state.values);
		this.setState({
			limit: limit,
			idPage: idPage,
			search_type: search_type,
 			updatePagination:false
		})
	
	}
    
    render() {
  		var categoryFilter = this.props.productFilters[0], manufactureFilter = this.props.productFilters[1], priceFilter = this.props.productFilters[2];
		var priceFilterResult = new Array();
		if(priceFilter != undefined) {
		   var priceMin,priceMax;
 
 				priceFilterResult.push(<div>
											<Input id={"priceMin"} onKeyUp={this.checkFilter.bind(this, this.state.limit,this.state.idPage,this.state.search_type,false,undefined)} type="hidden" name={"priceMin"} inputValue="" placeholder="Min Value"/>
 											 
										
 											<Input id={"priceMax"} onKeyUp={this.checkFilter.bind(this, this.state.limit,this.state.idPage,this.state.search_type,false,undefined)} type="hidden" name={"priceMax"} inputValue="" placeholder="Max Value"/>
											 
										</div>)
				priceMin=priceFilter.min
				priceMax = priceFilter.max
			
	    }
       return (
        <div className="search-container">
          <div className="page-header">
            <h3 className="page-title">Showing results for <span className="red-color-text"> "{this.props.params.searchTerm.split("+").join(" ")}"</span></h3>
              <div className="page-filter">
				<Ripples className="button-group-item blue">
					<button type="button" className={this.state.search_type == 2 ? "active" : ""} onClick={this.filterProducts.bind(this,2, this.state.limit, this.state.idPage, true,1,undefined)}>My Products</button>
				</Ripples>
				<Ripples className="button-group-item blue">
					<button type="button" className={this.state.search_type == 1 ? "active" : ""} onClick={this.filterProducts.bind(this,1,  this.state.limit, this.state.idPage, true,1,undefined)}>All Products</button>
				</Ripples>
              </div>
            <div className="pagination-container">
                <ReactPaginate 
                    nextLabel={<i className="icon-arrow-right"></i>}
                    previousLabel={<i className="icon-arrow-left"></i>}
                    breakLabel={<a href="javascript: void(0)">...</a>}
                    breakClassName={"break-me"}
                    pageNum={this.props.productsList && this.props.productsList.length > 0 ? this.props.totalCount : 0}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={this.state.updatePagination}
                    clickCallback={this.filterProducts.bind(this,this.state.search_type,  this.state.limit, this.state.idPage,0, false)}
                    containerClassName={"pagination"}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
            </div>
          </div>
		  
		  <div className="filter-products-container">
		  <div className="filter-container">	
				<div class="filter-category">
					<h4>Category</h4>
					<Scrollbars autoHeight autoHeightMin={20} autoHeightMax={126}>
					<form id="categoryFilterForm">
						{categoryFilter != undefined && categoryFilter ? 
							categoryFilter.map((data, i) => {
								return (
									<div key={i}>
										<Input id={"cat_"+data.id_category} type="checkbox" name={"cat_"+data.id_category} defaultChecked={false} />
										<label for={"cat_"+data.id_category} onClick={this.checkFilter.bind(this, "cat_"+data.id_category,this.state.limit,this.state.idPage,this.state.search_type,false)}>{data.name}</label>
								    </div>
								)
							}) :
							null}
					</form>
					</Scrollbars>
				</div>
				<div class="filter-manufacture">
					<h4>Manufacturer</h4>
					<Scrollbars autoHeight autoHeightMin={20} autoHeightMax={126}>
					<form id="manufacturerFilterForm">
						{manufactureFilter != undefined && manufactureFilter ? 
							manufactureFilter.map((data, i) => {
								return (
									<div key={i}>
										<Input id={"brand_"+data.id_manufacturer} type="checkbox" name={"brand_"+data.id_manufacturer} defaultChecked={false} />
										<label for={"brand_"+data.id_manufacturer} onClick={this.checkFilter.bind(this, "brand_"+data.id_manufacturer,this.state.limit,this.state.idPage,this.state.search_type,false)}>{data.name}</label>
								    </div>
								)
							}) :
							null}
					</form>
					</Scrollbars>
				</div>
				<div class="filter-price">
					<h4>Price</h4>
					<form id="priceFilterForm">
						<div className="price-slider">
							{priceFilterResult != undefined && priceFilterResult ? priceFilterResult : null}
						  <div className="input-range-slider">
							<InputRange
                draggableTrack
							  maxValue={priceMax}
							  minValue={priceMin}
							  value={this.state.values}
                formatLabel={values => '₹ '+values}
							  onChange={this.handleValuesChange.bind(this)}
							  onChangeComplete={this.handleValuesChangeDone.bind(this)}
							/>
						  </div>
						</div>
					</form>
				</div>
			</div>
			
          
          <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={true} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="div" className="product-container">
            {this.props.productsList && this.props.productsList.length > 0 ? this.props.productsList.map((products, index) => {
              let ratingsElem = [], disabledBtn = 0, budgetTooltip = 0, regionTooltip = 0
              let ratingsGrade = Math.ceil(products.ratings.grade)
              for(var j = 0; j < 5; j++){
                if(ratingsGrade > j)
                  ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
                else
                  ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
              }

              if(products.available_in_selected_region == 0) {
                disabledBtn = 1
                regionTooltip = 1
              }
              else if(budgetConfigured == 1 && budgetOption == 1 && !products.budget_product) {
                disabledBtn = 1
                budgetTooltip = 1
              }

              return (
                  /* Product Grid Starts */
                  <div key={index} className="product">                    
                    {/* Product Image */}
                    <a href="javascript:void(0)" onClick={G.quickView.bind(this, products.id_product)}>
                      <div className="product-visual">
                        {regionTooltip == 1 && <div className="product-error">
                          <div className="wrapper">
                            <h3>Sorry!</h3>
                            <p>The product is not available in {products.selected_region_name} region.</p>
                          </div>
                        </div>}
                        <img src={products.imageLink} alt={products.name} />
                        <button className="quick-view" >Quick view</button>
                      </div>
                    </a>

                    {/* Product Name */}
                    <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, products.id_product)}>
                      <div className="product-name"><h3>{products.name}</h3></div>
                    </a>

                    {/* Product Details Wrapper */}
                    <div className="product-details">
                      {/* Product Reviews and Ratings */}
                      <div className="product-standard">
                        <div className="product-ratings">
                          <span>
                           {ratingsElem}
                          </span>
                        </div>

                        <div className="product-reviews">{products.nbComments} Reviews</div>
                      </div>

                      {/* Product Price */}
                      <div className="product-value">
                        <div className="product-price">
                          <span>{(products.price && products.price_without_reduction != 0) ? G.formatPrice(products.price) : "Contact for price"}</span>
                        </div>
                        <div className="market-price">
                          { /* <span className="retail-price">Rs. 12000</span>
                          <span className="offer-percentage">25%</span> */ }
                        </div>
                      </div>
                    </div>

                    {/* Product Actions Wrapper */}
                    <div className="product-actions">

                      {/* Product Quantity Stepper Input */}
                      <div className="product-quantity">
                        <div className="minimum-order-quantity">MOQ: <span>{products.minimal_quantity}</span></div>
                        <div className="item-quantity">
                          <span className="quantity-decrement" onClick={G.updateQuantity.bind(this, products.id_product, products.minimal_quantity, products.price_tax_exc, 2, "search_results_quantity", false)}><i className="icon-remove"></i></span>
                          <Input className="quantity-value" type="number" id={"search_results_quantity_"+products.id_product} inputValue={products.minimal_quantity} />
                          <span className="quantity-increment" onClick={G.updateQuantity.bind(this, products.id_product, products.minimal_quantity, products.price_tax_exc, 1, "search_results_quantity", false)}><i className="icon-add"></i></span>
                        </div>
                      </div>

                      {/* Product Grid Call to Action */}
                      <div className="product-cta tooltip-container">
                      	<button className={"button-black has-tooltip"+ (disabledBtn == 1 ? " disabled-light" : "")} type="button" onClick={G.addToCart.bind(this, products.id_product, "search_results_quantity", 0, products.minimal_quantity)}>
                      		Add to Cart
                      		{budgetTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">This product is not available in your Purchase Order.</span></span>}
                          {regionTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">Sorry this product is not available in {products.selected_region_name} region.</span></span>}
                        </button>
                      </div>
                    </div>
				          	{budgetConfigured == 1 && budgetOption == 1 && products.budget_product ? <div className="product-po-balance">PO Balance: <span>{products.available_budget_quantity}</span></div> : null}

                  </div>
                  /* Product Grid Ends */
              )
            }) : <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with more keywords.</p></div> }
        </ReactCSSTransitionGroup>
      </div>
	  </div>
    )
  }
}

Search.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
    return {
	 
	productFilters: store.commonState.productFilters,
	productsList: store.commonState.productList,
	totalCount: store.commonState.total
  }
}

export default connect(mapStateToProps)(Search)
import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import Ripples from 'react-ripples';
import * as addressApi from '../../api/address-api';
import * as cartApi from '../../api/cart-api';
import * as G from '../../api/common-api'
import Input from '../../components/common/Input';
import store from '../../store/configureStore';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class Deals extends React.Component {
  constructor(props){
  	super(props)
  	this.state = {
  		type: 1,
  		disabledPrevious: true,
  		disabledNext: false
  	}
  }

  componentDidMount(){
  	G.checkWidget(6, true)
  	addressApi.getDeals(0)
  }

  showDeal(dealsHash, type){
  	this.setState({type: type})
  }

  getDeals(pageID){
  	if(pageID == 0) {
  		this.setState({
  			disabledPrevious: true,
  			disabledNext: false
  		})
  	}
  	else {
  		this.setState({
  			disabledPrevious: false,
  			disabledNext: true
  		})
  	}

  	addressApi.getDeals(pageID)
  }

  render() {
  	const { disabledPrevious, disabledNext } = this.state
    return (
    	<div>
    	{ (this.props.widgetStatus) == 1 ?
			(this.props.isFetching ? <div className="deal-container fetching"><div className="fetching-content graph"><div></div></div></div> : 
				<div className="deal-container">
					<div className="page-header">
						<h3 className="page-title">Deals</h3>
						<div className="action-block">
							{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
						</div>
					</div>
					<div className="deal-banner">
						<img src={"themes/default-bootstrap/img/deals/"+this.props.dealsBanner.hero_banner} alt="latest-deal-banner"/>
					</div>

					{/* Four Links Start*/}
					<div className="deal-nav">
						<div className="deal-nav-item">
						  <a href="javascript:void(0);" onClick={this.showDeal.bind(this, this.props.dealsHash, 1)}>
							<img src={"themes/default-bootstrap/img/deals/"+this.props.dealsBanner.small_banner1} className="deal-nav-thumb" alt="deal-nav-thumb-item"/>
						  </a>
						</div>
						<div className="deal-nav-item">
							<a href="javascript:void(0);" onClick={this.showDeal.bind(this, this.props.dealsHash, 2)}>
								<img src={"themes/default-bootstrap/img/deals/"+this.props.dealsBanner.small_banner2} className="deal-nav-thumb" alt="deal-nav-thumb-item"/>
							</a>
						</div>
						<div className="deal-nav-item">
							<a href="javascript:void(0);" onClick={this.showDeal.bind(this, this.props.dealsHash, 3)}>
								<img src={"themes/default-bootstrap/img/deals/"+this.props.dealsBanner.small_banner3} className="deal-nav-thumb" alt="deal-nav-thumb-item"/>
							</a>
						</div>
						<div className="deal-nav-item">
							<a href="javascript:void(0);" onClick={this.showDeal.bind(this, this.props.dealsHash, 4)}>
								<img src={"themes/default-bootstrap/img/deals/"+this.props.dealsBanner.small_banner4} className="deal-nav-thumb" alt="deal-nav-thumb-item"/>
							</a>
						</div>
					</div>
					{/* Four Links End*/}

					<div className={"deal-group "+(this.state.type == 1 ? "" : "hidden")} id={this.props.dealsHash[1]}>
						<h3 className="deal-group-title">{this.props.dealsTitle[1]}</h3>
						<div className="deal-group-list">
							<div className="product-container">
								{this.props.deals1.map((data, i) => {
									
									let ratingsGrade = Math.ceil(data.ratings.grade)
									var ratingsElem = [], reductionPercent = 0, portalPrice = 0
									
									for(var j = 0; j < 5; j++){
										if(ratingsGrade > j)
											ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
										else
											ratingsElem.push(<i className="icon-star-empty" key={j}></i>)	
									}

									if(data.specific_prices){
										if(data.specific_prices.reduction_type == "percentage"){
											reductionPercent = (data.specific_prices.reduction * 100)
										}
										else{
											reductionPercent = ((data.specific_prices.reduction * 100) / data.price_without_reduction)
										}
									}

									portalPrice = (!priceDisplayMethod ? (data.price_without_reduction == data.price ? parseFloat(data.orderprice).toFixed(2) : data.price.toFixed(2)) : data.price_tax_exc.toFixed(2))

									if(data.eliteDealProduct){
										return(
											<div className="product" key={i}>
						                  		{/* Product Image */}
							                    <a href="javascript:void(0)" onClick={G.quickView.bind(this, data.id_product)}>
							                      <div className="product-visual">
							                        <img src={data.imageLink} alt={data.name} />
							                        <button className="quick-view" >Quick view</button>
							                      </div>
							                    </a>

							                    {/* Product Name */}
							                    <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, data.id_product)}>
							                      <div className="product-name"><h3>{data.name}</h3></div>
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

														<div className="product-reviews">{data.nbComments ? data.nbComments : "No"} Reviews</div>
													</div>

													{/* Product Price */}
													<div className="product-value">
														<div className="product-price">
															<span>{portalPrice ? "₹ "+portalPrice : 0}</span>
														</div>
														<div className="market-price">
															<span className="retail-price">
																{data.price_without_reduction.toFixed(2) != portalPrice ? "₹ "+data.price_without_reduction.toFixed(2) : ""}
															</span>
															<span className="offer-percentage">
																{reductionPercent ? reductionPercent+"%" : ""}
															</span>
														</div>
													</div>
												</div>

												{/* Product Actions Wrapper */}
												<div className="product-actions">
													{/* Product Quantity Stepper Input */}
													<div className="product-quantity">
														<div className="minimum-order-quantity">MOQ: <span>{data.minimal_quantity}</span></div>
														<div className="item-quantity">
															<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "deal1", false)}><i className="icon-remove"></i></span>
															<Input className="quantity-value" type="number" id={"deal1_"+data.id_product} inputValue={data.minimal_quantity} />
															<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "deal1", false)}><i className="icon-add"></i></span>
														</div>  
													</div>

													{/* Product Grid Call to Action */}
													<div className="product-cta"><button className="button-black" type="button" onClick={G.addToCart.bind(this, data.id_product, "deal1", 0, data.minimal_quantity)}>Add to Cart</button>
													</div>
												</div>
											</div>
										)
									}
								})}
							</div>
						</div>
					</div>
					<div className={"deal-group "+(this.state.type == 2 ? "" : "hidden")} id={this.props.dealsHash[2]}>
						<h3 className="deal-group-title">{this.props.dealsTitle[2]}</h3>
						<div className="deal-group-list">
							<div className="product-container">
			                	{this.props.deals2.map((data, i) => {

			                		let ratingsGrade = Math.ceil(data.ratings.grade)
									var ratingsElem = [], reductionPercent = 0, portalPrice = 0
									
									for(var j = 0; j < 5; j++){
										if(ratingsGrade > j)
											ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
										else
											ratingsElem.push(<i className="icon-star-empty" key={j}></i>)	
									}

									if(data.specific_prices){
										if(data.specific_prices.reduction_type == "percentage"){
											reductionPercent = (data.specific_prices.reduction * 100)
										}
										else{
											reductionPercent = ((data.specific_prices.reduction * 100) / data.price_without_reduction)
										}
									}

									portalPrice = (!priceDisplayMethod ? (data.price_without_reduction == data.price ? parseFloat(data.orderprice).toFixed(2) : data.price.toFixed(2)) : data.price_tax_exc.toFixed(2))

									if(data.eliteDealProduct){
										return(
											<div className="product" key={i}>
						                  		{/* Product Image */}
							                    <a href="javascript:void(0)" onClick={G.quickView.bind(this, data.id_product)}>
							                      <div className="product-visual">
							                        <img src={data.imageLink} alt={data.name} />
							                        <button className="quick-view" >Quick view</button>
							                      </div>
							                    </a>

							                    {/* Product Name */}
							                    <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, data.id_product)}>
							                      <div className="product-name"><h3>{data.name}</h3></div>
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

														<div className="product-reviews">{data.nbComments ? data.nbComments : "No"} Reviews</div>
													</div>

													{/* Product Price */}
													<div className="product-value">
														<div className="product-price">
															<span>{portalPrice ? "₹ "+portalPrice : 0}</span>
														</div>
														<div className="market-price">
															<span className="retail-price">
																{data.price_without_reduction.toFixed(2) != portalPrice ? "₹ "+data.price_without_reduction.toFixed(2) : ""}
															</span>
															<span className="offer-percentage">
																{reductionPercent ? reductionPercent+"%" : ""}
															</span>
														</div>
													</div>
												</div>

												{/* Product Actions Wrapper */}
												<div className="product-actions">
													{/* Product Quantity Stepper Input */}
													<div className="product-quantity">
														<div className="minimum-order-quantity">MOQ: <span>{data.minimal_quantity}</span></div>
														<div className="item-quantity">
															<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "deal2", false)}><i className="icon-remove"></i></span>
															<Input className="quantity-value" type="number" id={"deal2_"+data.id_product} inputValue={data.minimal_quantity} />
															<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "deal2", false)}><i className="icon-add"></i></span>
														</div>  
													</div>

													{/* Product Grid Call to Action */}
													<div className="product-cta"><button className="button-black" type="button" onClick={G.addToCart.bind(this, data.id_product, "deal2", 0, data.minimal_quantity)}>Add to Cart</button>
													</div>
												</div>
											</div>
										)
									}
								})}
							</div>
						</div>
					</div>
					<div className={"deal-group "+(this.state.type == 3 ? "" : "hidden")} id={this.props.dealsHash[3]}>
						<h3 className="deal-group-title">{this.props.dealsTitle[3]}</h3>
						<div className="deal-group-list">
							<div className="product-container">
			                	{this.props.deals3.map((data, i) => {
			                		
			                		let ratingsGrade = Math.ceil(data.ratings.grade)
									var ratingsElem = [], reductionPercent = 0, portalPrice = 0
									
									for(var j = 0; j < 5; j++){
										if(ratingsGrade > j)
											ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
										else
											ratingsElem.push(<i className="icon-star-empty" key={j}></i>)	
									}

									if(data.specific_prices){
										if(data.specific_prices.reduction_type == "percentage"){
											reductionPercent = (data.specific_prices.reduction * 100)
										}
										else{
											reductionPercent = ((data.specific_prices.reduction * 100) / data.price_without_reduction)
										}
									}

									portalPrice = (!priceDisplayMethod ? (data.price_without_reduction == data.price ? parseFloat(data.orderprice).toFixed(2) : data.price.toFixed(2)) : data.price_tax_exc.toFixed(2))

									if(data.eliteDealProduct){
										return(
											<div className="product" key={i}>
						                  		{/* Product Image */}
							                    <a href="javascript:void(0)" onClick={G.quickView.bind(this, data.id_product)}>
							                      <div className="product-visual">
							                        <img src={data.imageLink} alt={data.name} />
							                        <button className="quick-view" >Quick view</button>
							                      </div>
							                    </a>

							                    {/* Product Name */}
							                    <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, data.id_product)}>
							                      <div className="product-name"><h3>{data.name}</h3></div>
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

														<div className="product-reviews">{data.nbComments ? data.nbComments : "No"} Reviews</div>
													</div>

													{/* Product Price */}
													<div className="product-value">
														<div className="product-price">
															<span>{portalPrice ? "₹ "+portalPrice : 0}</span>
														</div>
														<div className="market-price">
															<span className="retail-price">
																{data.price_without_reduction.toFixed(2) != portalPrice ? "₹ "+data.price_without_reduction.toFixed(2) : ""}
															</span>
															<span className="offer-percentage">
																{reductionPercent ? reductionPercent+"%" : ""}
															</span>
														</div>
													</div>
												</div>

												{/* Product Actions Wrapper */}
												<div className="product-actions">
													{/* Product Quantity Stepper Input */}
													<div className="product-quantity">
														<div className="minimum-order-quantity">MOQ: <span>{data.minimal_quantity}</span></div>
														<div className="item-quantity">
															<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "deal3", false)}><i className="icon-remove"></i></span>
															<Input className="quantity-value" type="number" id={"deal3_"+data.id_product} inputValue={data.minimal_quantity} />
															<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "deal3", false)}><i className="icon-add"></i></span>
														</div>  
													</div>

													{/* Product Grid Call to Action */}
													<div className="product-cta"><button className="button-black" type="button" onClick={G.addToCart.bind(this, data.id_product, "deal3", 0, data.minimal_quantity)}>Add to Cart</button>
													</div>
												</div>
											</div>
										)
									}
								})}
							</div>
						</div>
					</div>
					<div className={"deal-group "+(this.state.type == 4 ? "" : "hidden")} id={this.props.dealsHash[4]}>
						<h3 className="deal-group-title">{this.props.dealsTitle[4]}</h3>
						<div className="deal-group-list">
							<div className="product-container">
			                	{this.props.deals4.map((data, i) => {
			                		
			                		let ratingsGrade = Math.ceil(data.ratings.grade)
									var ratingsElem = [], reductionPercent = 0, portalPrice = 0
									
									for(var j = 0; j < 5; j++){
										if(ratingsGrade > j)
											ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
										else
											ratingsElem.push(<i className="icon-star-empty" key={j}></i>)	
									}

									if(data.specific_prices){
										if(data.specific_prices.reduction_type == "percentage"){
											reductionPercent = (data.specific_prices.reduction * 100)
										}
										else{
											reductionPercent = ((data.specific_prices.reduction * 100) / data.price_without_reduction)
										}
									}

									portalPrice = (!priceDisplayMethod ? (data.price_without_reduction == data.price ? parseFloat(data.orderprice).toFixed(2) : data.price.toFixed(2)) : data.price_tax_exc.toFixed(2))

									if(data.eliteDealProduct){
										return(
											<div className="product" key={i}>
						                  		{/* Product Image */}
							                    <a href="javascript:void(0)" onClick={G.quickView.bind(this, data.id_product)}>
							                      <div className="product-visual">
							                        <img src={data.imageLink} alt={data.name} />
							                        <button className="quick-view" >Quick view</button>
							                      </div>
							                    </a>

							                    {/* Product Name */}
							                    <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, data.id_product)}>
							                      <div className="product-name"><h3>{data.name}</h3></div>
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

														<div className="product-reviews">{data.nbComments ? data.nbComments : "No"} Reviews</div>
													</div>

													{/* Product Price */}
													<div className="product-value">
														<div className="product-price">
															<span>{portalPrice ? "₹ "+portalPrice : 0}</span>
														</div>
														<div className="market-price">
															<span className="retail-price">
																{data.price_without_reduction.toFixed(2) != portalPrice ? "₹ "+data.price_without_reduction.toFixed(2) : ""}
															</span>
															<span className="offer-percentage">
																{reductionPercent ? reductionPercent+"%" : ""}
															</span>
														</div>
													</div>
												</div>

												{/* Product Actions Wrapper */}
												<div className="product-actions">
													{/* Product Quantity Stepper Input */}
													<div className="product-quantity">
														<div className="minimum-order-quantity">MOQ: <span>{data.minimal_quantity}</span></div>
														<div className="item-quantity">
															<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "deal4", false)}><i className="icon-remove"></i></span>
															<Input className="quantity-value" type="number" id={"deal4_"+data.id_product} inputValue={data.minimal_quantity} />
															<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "deal4", false)}><i className="icon-add"></i></span>
														</div>  
													</div>

													{/* Product Grid Call to Action */}
													<div className="product-cta"><button className="button-black" type="button" onClick={G.addToCart.bind(this, data.id_product, "deal4", 0, data.minimal_quantity)}>Add to Cart</button>
													</div>
												</div>
											</div>
										)
									}
								})}
							</div>
						</div>
					</div>

					<div className="deal-pagination">
						<a className={"button-blue outline"+(disabledPrevious ? " previous disabled" : "")} href="javascript:void(0)" onClick={this.getDeals.bind(this, 0)}>Previous</a>&nbsp;&nbsp;
						<a className={"button-blue outline"+(disabledNext ? " next disabled" : "")} href="javascript:void(0)" onClick={this.getDeals.bind(this, 1)}>Next</a>
					</div>
				</div>):
			(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={6} /> : 
	        (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
		</div>
	);
  }
}

Deals.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus,
  	dealsBanner: store.addressState.dealsBanner,
  	dealsTitle: store.addressState.dealsTitle,
  	dealsHash: store.addressState.dealsHash,
  	deals1: store.addressState.deals1,
  	deals2: store.addressState.deals2,
  	deals3: store.addressState.deals3,
  	deals4: store.addressState.deals4,
  	isFetching: store.addressState.isFetchingDeals
  };
};

export default connect(mapStateToProps)(Deals);
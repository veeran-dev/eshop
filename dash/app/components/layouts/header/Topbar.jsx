import React from 'react'
import {findDOMNode} from 'react-dom'
import moment from 'moment'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import * as settingsApi from '../../../api/settings-api'
import * as addressApi from '../../../api/address-api'
import * as G from '../../../api/common-api'
import Input from '../../../components/common/Input'
import cookie from 'react-cookie'
import store from '../../../store/configureStore'
import MobileMoreMenu from './mobile-more-menu'
import {toastr} from 'react-redux-toastr'
import {Scrollbars} from 'react-custom-scrollbars'
import * as actions from '../../../actions/common-actions'
import * as addressActions from '../../../actions/address-actions'
import * as procureBuyApi from '../../../api/procure-buy-api'
import Search from '../../../components/views/widgets/search'
import SearchProduct from '../../../components/views/widgets/searchProduct'
import CONTROLLED_MEGAMENU from '../../../constants/action-types';
import OutsideClickHandler from 'react-outside-click-handler';

class Topbar extends React.Component {
	constructor(props, context) {
		super(props)
		this._handleOutsideClick = this._handleOutsideClick.bind(this);
		this.state = {
			mobileMenu: 'is-hidden',
			choosingState: false,
			megaMenu: false,
			value: '',
			suggestions: [],
			searchLoading:false,
			id_address: '',
			addressName: '',
			id_state: '',
			selectValuePO: '',
			selectValueAddress: ''
		};
		this.flash = " ";
		cookie.save("search_type", 2)
	}

	componentDidMount(){
		document.addEventListener('click', this.handleClickOutside.bind(this), true);
		window.addEventListener('scroll', this._handleScroll)
		cartApi.cartSummary()
		cartApi.get()
		cartApi.getLoyaltyPoints()
		addressApi.getStates()
		G.getNotifications(1)
		settingsApi.getCustomerLogo()
		addressApi.getAllStates()
		if(cookieAddressBudget != '') {
			addressApi.getPurchaseOrdersByAddress(cookieAddressBudget).then(data => { 
       			store.dispatch(addressActions.purchaseOrders(data));
				this.setState({ 
					id_address: cookieAddressBudget, 
					id_state, 
					selectValueAddress: `${id_state}-${cookieAddressBudget}`,
					selectValuePO: cookiePO
				}) 
			});
		}
	}

	handleClickOutside(event) {
        const megaMenuNode = findDOMNode(this.refs.megaMenu);
        const cityMenuNode = findDOMNode(this.refs.cityMenu);
        if(cityMenuNode && cityMenuNode.classList.contains('active')){
            if (!cityMenuNode || !megaMenuNode.contains(event.target)){
                this.props.handleMegaMenu();
                event.stopPropagation();
            }
        } 
    }

	_handleClick(e){
    	e.preventDefault();
        if (this.state.mobileMenu === 'is-hidden'){
            this.setState({mobileMenu: 'is-active'})
        }else {
            this.setState({mobileMenu: 'is-hidden'})
        }
    }

	_handleOutsideClick(event){
		if (this.refs.mobileMenuButton.contains(event.target)) {
			return
        } else {
            this.setState({mobileMenu: 'is-hidden'});
        }
	}

	// IE10+ Hover Menu Fix
	_selectFocus(e){
		e.preventDefault();
		this.setState({choosingState: true})
	}

	_selectLeave(e){
		e.preventDefault();
		this.setState({ choosingState: false })
	}

	stateSet = (e) => {
		addressApi.stateSetWithAddress(this.state.id_state, this.state.addressName, this.state.id_address, e.target.value).then(data => {
			if(data) {
				if(data.type == 2) { this.setState({ selectValuePO: cookiePO }); }
				else if(data.type == 3) { this.setState({ selectValuePO: cookiePO }); }
			}
		});
	}

	getPurchaseOrders = (e) => {
	    if(e.target.value != "" && e.target.value != undefined){
	      let addressName  = this.refs.stateSelection.options[this.refs.stateSelection.options['selectedIndex']].innerHTML;
	      var selectedValue = e.target.value;
	      let value_split = e.target.value.split("-");
	      if(budgetOption == 2) {
	      	addressApi.getPurchaseOrdersByAddress(value_split[1]).then(data => {
	          if(data && data.length > 0) {
        		store.dispatch(addressActions.purchaseOrders(data));
	            this.setState({ 
	              addressName,
	              id_address: value_split[1],
	              id_state: value_split[0],
	              selectValueAddress: selectedValue,
	              megaMenu: true
	            });
	          }
	          else {
	            this.setState({ megaMenu: true, selectValueAddress: `${id_state}-${cookieAddressBudget}` }, () => {
	            	addressApi.getPurchaseOrdersByAddress(cookieAddressBudget).then(data => {
	            		if(data && data.length > 0) {
        					store.dispatch(addressActions.purchaseOrders(data));
	            		}
	            	});
	            	toastr.error("Error", "PO is not available for the selected address", { icon: "icon-error"});
	            });
	          }
	        });
	      }
	      else {
	      	this.setState({
	          addressName,
	          id_address: value_split[1],
	          id_state: value_split[0],
	          megaMenu: false
	        }, () => addressApi.stateSetWithAddress(this.state.id_state, this.state.addressName, this.state.id_address, 0));
	      }
	    }
	}

	componentWillMount() {
		document.addEventListener('click', this._closeMegaMenu, false);
		document.addEventListener('click', this._handleOutsideClick, false);
	}

	componentWillUnmount(){
		//window.removeEventListener('scroll', this._handleScroll);
		document.removeEventListener('click', this._closeMegaMenu, false);
		document.addEventListener('click', this._handleOutsideClick, false);
		document.removeEventListener('click', this.handleClickOutside.bind(this), true);
	}

	removeProduct(idProduct, idCombination, idCustomization, event){
		cartApi.deleteProduct(idProduct, idCombination, idCustomization)
	}

	updateQuantity = (idProduct, minimalQuantity, price, budgetQuantity, type) => {
    	var oldQuantity, newQuantity, quantityArray = new Array()
    	var oldQuantity = document.getElementById("cartTopQty_"+idProduct).value
    	if(type == 1)
    		newQuantity = (parseInt(oldQuantity)+1)
    	else if(type == 2)
    		newQuantity = (parseInt(oldQuantity)-1)
    	else
    		newQuantity = parseInt(oldQuantity)

    	if(newQuantity < minimalQuantity){
    		toastr.error('Error', 'Please provide '+minimalQuantity+' or more units.', {icon: 'icon-error'})
    	}
    	else if(budgetConfigured == 1 && newQuantity > budgetQuantity) {
	      toastr.error('Error', "You can't add more than PO Balance. Balance is "+budgetQuantity, {icon: 'icon-error'});
    	  quantityArray.push(idProduct+"-"+budgetQuantity)
	      cartApi.update(quantityArray, price, oldQuantity, 'cartTopQty_');
	    }
    	else {
    		quantityArray.push(idProduct+"-"+newQuantity)
			cartApi.update(quantityArray, price, oldQuantity, 'cartTopQty_');
    	}
    }

	viewLoyaltyPoints(){
		cartApi.viewLoyaltyPoints()
	}

	componentWillReceiveProps(nextProps) {
		var newValue = nextProps.cartTopSummary.totalProducts;
		if (this.props.cartTopSummary.totalProducts !== newValue) {
			this.flash = this.flash === "flash1" ? "flash2" : "flash1";
		}
	}

	viewVouchers(){
		cartApi.loadDicounts()
	}

	notificationUrl(url){
		this.context.router.push(url)
	}

	goToNotificationsPage(){
		this.context.router.push("notifications")
	}

	goToCartPage() {
		this.context.router.push("cart")
	}

	goToLoyaltyPointsPage() {
		this.context.router.push("loyalty-points")
	}

	changeDeliveryRegion = (e) => {
		this.props.handleMegaMenu();
		if(e.target.value != "" && e.target != undefined && e.target.value != deliveryRegion) {
			let cityName = this.refs.stateSelection.options[this.refs.stateSelection.options['selectedIndex']].innerHTML;
			addressApi.setDeliveryRegion(e.target.value, cityName, 1);
		}
	}

	proceedCheckout = (e) => {
		if(deliveryRegion == "" || deliveryRegion == 0) {
            document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
            document.body.classList.add('modal-open');
        }
        
		this.context.router.push('address');
	}

	resetRegion = () => {
		if(this.refs.stateSelection.value != "") {
			this.refs.stateSelection.value = id_state;
		}
	}

	_handleMegaMenu = () => {
		this.setState({ megaMenu: true });
	}

	handleOutSideClickBudget = () => {
		if(cookieAddressBudget != '' && this.state.megaMenu) {
			addressApi.getPurchaseOrdersByAddress(cookieAddressBudget).then(data => {
				let addressName  = this.refs.stateSelection.options[this.refs.stateSelection.options['selectedIndex']].innerHTML;
				if(data && data.length > 0) {
        			store.dispatch(addressActions.purchaseOrders(data));
		            this.setState({ 
		              addressName,
		              id_address: cookieAddressBudget,
		              id_state: id_state,
		              selectValueAddress: `${id_state}-${cookieAddressBudget}`,
		              megaMenu: false,
		              selectValuePO: cookiePO
		            });
		        }
			});
		}
	}

	handleStateLoad = () => {
		if(this.context.router.isActive('confirmation')) {
			document.getElementById('state-selection-topbar').classList.add('disabled');
        	document.getElementById('state-selection-topbar-mobile').classList.add('disabled');  
		}
	}
	
    render() {
    	const { purchase_orders } = this.props
	    return (
			<div className="topbar" id={this.state.mobileMenu}>
				<div className="topbar-wrapper" id="sticky">
					<div className="topbar-item-mobile">
						<a href="#" ref="mobileMenuButton" className={this.state.mobileMenu} onClick={this._handleClick.bind(this)}><i className="icon-menu"></i></a>
					</div>

					<div className="logo-section">
						<Link to="/"><span className="logo" title="Kobzo Elite"></span></Link>
					</div>
					<div className={this.props.megaMenu ? "topbar-right-section idle" : "topbar-right-section"}>
						{/*<div className="topbar-item-mobile">
							<Link to="notifications" activeClassName="active">
								<i className="icon-notifications"></i>
								<span className="menu-counter">{this.props.notificationsCount > 0 ? this.props.notificationsCount : ""}</span>
							</Link>
						</div>*/}
						<div className="topbar-item-mobile">
							<Link to="cart" activeClassName="active">
								<i className="icon-cart"></i>
								<span className={"menu-counter "+this.flash}>{this.props.cartTopSummary.totalProducts ? this.props.cartTopSummary.totalProducts : ""}</span>
							</Link>
						</div>
						<Search isMobile={true} />
						<Search isMobile={false} />
						<SearchProduct />
						{/*<div className="topbar-item loyalty-points">
							<a href="javascript:void(0)" className="topbar-menu-item">
								<div className="menu-icon-block">
									<i className="menu-icon menu-icon-red icon-loyalty-points"></i>
									<span className="menu-counter" id="loyaltyMenuCounter">{this.props.loyaltyCount[0] ? (this.props.loyaltyCount[0] < 9999 ? (this.props.loyaltyCount[0] > 0 ? this.props.loyaltyCount[0] : "") : "9999+") : ""}</span>
								</div>
								<span className="menu-label">Points</span>
							</a>
							<div className="mega-menu" ref="currentMegaMenu">
								{/* <div className="mega-menu-content tooltip-arrow"> */}
								{/*<div className="mega-menu-content tooltip-arrow">
									<div className="loyalty-points-wrapper">
										<div className="count-cards">
											<div className="card">
												<span className="count-label">Loyalty Points</span>
												<span className="count" id="loyaltyCount">{this.props.loyaltyCount[0]}</span>
											</div>
											<div className="card">
												<span className="count-label">Claim Amount</span>
												<span className="count" id="loyaltyAmount">{G.formatPrice(this.props.loyaltyCount[1])}</span>
											</div>
										</div>	
										<div className="footer-action">
											<button className="button-red" onClick={this.viewLoyaltyPoints.bind(this)}>Create Voucher</button>
											<button className="button-red outline" onClick={this.viewVouchers.bind(this)}>View Vouchers</button>
										</div>
									</div>
								</div>
							</div>
						</div>*/}

						{/*<div className="topbar-item notification">
							<a href="javascript:void(0)" className="topbar-menu-item">
								<div className="menu-icon-block">
									<i className="menu-icon menu-icon-red icon-notifications"></i>
									<span className="menu-counter">{this.props.notificationsCount > 0 ? this.props.notificationsCount : ""}</span>
								</div>
								<span className="menu-label">Notifications</span>
							</a>
							<div className="mega-menu">
								
								<div className="mega-menu-content fixed-scroll tooltip-arrow">
									<div className={this.props.notificationsCount > 0 ? "is-empty hidden" : "is-empty"}>
										<img src="dash/img/empty-notification.png" alt="No Notifications" />
										<h2>No unread notifications!</h2>
										<p>When your order status changes, invoices and delivery receipts get generated you will see it here.</p>
									</div>
									<Scrollbars style={{ width: 376, height: 345 }} className="list">
										{this.props.notifications.map((notification, i) => {
											return (
												<div className="list-item unread" key={i}>
													{ /* <div className="list-item-icon">
														<span className="orange-color-text text-size-large"><i className="icon-warning"></i></span>
													</div> */ }
													{/*<div className="list-item-info" onClick={this.notificationUrl.bind(this, notification.url)}>
														<div className="list-item-title">{notification.content}</div>
														<div className="list-item-timestamp">{moment(notification.date_add).format('LL')}</div>
													</div>
													<div className="list-item-action" onClick={G.readNotification.bind(this, notification.id_notification)}>
														<span><i className="icon-check"></i></span>
													</div>
												</div>
											)
										})}
									</Scrollbars>

									<div className="footer-action">
									{this.props.notificationsCount.length ? <a href="javascript:void(0)" className="button button-blue" onClick={this.goToNotificationsPage.bind(this)}>View All Notifications</a> : null}							
									</div>
								</div>
							</div>
						</div>*/}

						<div className="topbar-item cart">
							<a href="javascript:void(0)" className="topbar-menu-item">
								<div className="menu-icon-block">
									<i className="menu-icon menu-icon-red icon-cart"></i>
									<span className={"menu-counter "+this.flash}>{this.props.cartTopSummary.totalProducts ? this.props.cartTopSummary.totalProducts : ""}</span>
								</div>
								<span className="menu-label">Cart</span>
							</a>
							<div className="mega-menu">
								<div className="mega-menu-content fixed-scroll tooltip-arrow">
									<div className={this.props.cartTopSummary.totalProducts ? 'is-empty hidden' : 'is-empty'}>
										<img src="dash/img/empty-cart.png" alt="Cart Empty" />
										<h2>You dont have any products in your cart!</h2>
										<p>When you add products to your cart, you can view them quickly from here.</p>
									</div>
									<Scrollbars style={{ width: 376, height: 345 }} className="list">
									{ (this.props.cartTopProducts && this.props.cartTopProducts.length > 0) ?
										(this.props.cartTopProducts.map((data, i) => {
											return(
												<div className="list-item" key={i}>
													<div className="list-item-thumb">
														<img src={data[0]} alt={data.name} width="48" height="48"/>
													</div>
													<div className="list-item-info">
														<div className="list-item-title">{data.name}</div>
														<div className="list-item-price">{G.formatPrice(data.price)}</div>
													</div>
													<div className="list-item-quantity">
														<div id={"quantityParent_"+data.id_supplier+"_"+data.id_product} className="tooltip">
															<Input type="number" 
																   min={data.minimal_quantity} 
																   id={"cartTopQty_"+data.id_supplier+"_"+data.id_product} 
																   className="quantity-value" 
																   inputValue={data.cart_quantity}
																   onBlur={this.updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price, data.available_budget_quantity, 0)}/>
															<span className="tooltiptext tooltip-left gray-color-text">Please enter {data.minimal_quantity} or more units.</span>
														</div>
														<div>
															<span className="quantity-increment" onClick={this.updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price, data.available_budget_quantity, 2)}><i className="icon-remove"></i></span>
															<span className="quantity-decrement" onClick={this.updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price, data.available_budget_quantity, 1)}><i className="icon-add"></i></span>
														</div>
													</div>
													<div className="list-item-action">
														<span onClick={this.removeProduct.bind(this, data.id_supplier+"_"+data.id_product, data.id_product_attribute, data.id_customization)}><i className="icon-close"></i></span>
													</div>
												</div>
											)
										})) : (this.props.cartTopProducts.saleStatus == 1 ? <div className="is-empty"><p className="sale-alert">Due to GST implementations there won't be any sales from 28th June to 5th July!</p></div> : null)
									}
									</Scrollbars>							
									<div className="footer-action">
										{this.props.cartTopProducts.saleStatus == 1 ? 
											null
											: (this.props.cartTopProducts.length) ? 
												<a className="button button-blue" href="javascript:void(0)" onClick={this.proceedCheckout.bind(this)}>Proceed to Checkout</a> : null}
									</div>
								</div>
							</div>
						</div>

						{budgetConfigured == 1 ?
							<OutsideClickHandler onOutsideClick={this.handleOutSideClickBudget}>
								<div className={"topbar-item-click budget-address-selection " + (this.state.megaMenu ? "active " : "") + this.state.choosingState} 
									onClick={this._handleMegaMenu} 
									id="state-selection-topbar"
									ref="stateSelectionTopbar"
									onLoad={this.handleStateLoad}
								>
									<a href="javascript:void(0)" title="Click here to select address" className="topbar-menu-item" aria-haspopup="true">
										<div className="menu-icon-block">
											<i className="menu-icon menu-icon-red icon-place-pin"></i>
										</div>
										<span className="menu-label">Address<i className="icon-arrow-dropdown"></i></span>
									</a>
									<div className="mega-menu">
										<div className="mega-menu-content tooltip-arrow state-selection">
											<div className="state-selection-info text-align-center">
												<h2>Please choose your delivery address!</h2>
												<img src="dash/img/delivery-region.png" alt="Delivery Region" />
											</div>
											<div className="state-selection-form">
												<select id="selectState" ref="stateSelection" value={this.state.selectValueAddress} onChange={this.getPurchaseOrders.bind(this)} onClick={this._selectFocus.bind(this)}>
													<option value="">Select Address</option>
													{this.props.states.map((address, i) => {
														return(
															<optgroup label={address.alias ? address.alias : address.company} key={i} id={"id_address_"+address.id_address}>
																<option className="address-highlight" value={address.id_state+"-"+address.id_address} title="Select this address" selected={cookieAddressBudget == address.id_address ? true : false}>{address.address1.length > 20 ? address.address1.substring(0, 20)+"..." : address.address1}</option>
																<option disabled>{address.city +", "+ address.state}</option>
															</optgroup>
														)
													})}
												</select>
												{ /**<button className="button-red" onClick={this.stateSetWithAddress.bind(this)}>Update</button> **/}
											</div>
											{purchase_orders && budgetOption == 2 && purchase_orders.length > 0 &&
									          <div className="state-selection-form">
									              <select name={"poSelect"} ref={"poSelection"} value={this.state.selectValuePO} id={"poSelect"} onChange={this.stateSet.bind(this)} >
									                <option value="">Select PO</option>
									                {purchase_orders.map((po, i) => {
														if(po.value_available > 0) {
															return(
																<optgroup label={po.po_number} key={i} id={"id_po_"+po.id_purchase_order}>
																  <option className="address-highlight" value={po.id_purchase_order} title="Select this purchase order" selected={cookiePO == po.id_purchase_order ? true : false}>
																    {budgetOption == 1 ? `Products available: ${po.product_available}` : `Available Budget: ${G.formatPrice(po.value_available)}`}
																  </option>
																  <option disabled>
																    {budgetOption == 1 ? `Total Products: ${po.product_available_total}` : `Total Budget: ${G.formatPrice(po.value_available_total)}`}
																  </option>
																</optgroup>
															)
														}
									                })}
									            </select>
									          </div>
									        }
									        <div className="state-selection-info text-align-center">
									        	<span>Selected PO: </span>
									        	<span><strong>{cookiePONumber}</strong></span>
									        </div>
											<div className="state-selection-info text-align-center">
						                    	<p>Select your address. System will work based on budget configuration for selected address.</p>
						                    </div>
										</div>
									</div>
								</div> 
							</OutsideClickHandler>
						: 

							(this.props.states && this.props.states.length > 1 ?
								<OutsideClickHandler onOutsideClick={() => this.setState({ megaMenu: false })}>
									<div ref="cityMenu" 
										className={"topbar-item-click city-selection " + (this.state.megaMenu ? "active " : "") + this.state.choosingState} 
										id="state-selection-topbar" 
										onClick={this._handleMegaMenu} 
										onMouseEnter={this.resetRegion.bind(this)}
										ref="stateSelectionTopbar"
										onLoad={this.handleStateLoad}
									>
										<a href="javascript:void(0)" title="Click here to select region" className="topbar-menu-item" aria-haspopup="true">
											<div className="menu-icon-block">
												<i className="menu-icon menu-icon-red icon-place-pin"></i>
											</div>
											<span className="menu-label">
											Region <i className="icon-arrow-dropdown"></i>
											</span>
										</a>
										<div ref="megaMenu" className="mega-menu">
											<div className="mega-menu-content tooltip-arrow state-selection">
												<div className="state-selection-info text-align-center">
													<h2>Please choose your delivery region!</h2>
													<img src="dash/img/delivery-region.png" alt="Delivery Region" />
												</div>
												<div className="state-selection-form">
													<select id="selectState" ref="stateSelection" onChange={this.changeDeliveryRegion.bind(this)} onClick={this._selectFocus.bind(this)} onBlur={this._selectLeave.bind(this)}>
														<option value="">Select delivery region</option>
														{this.props.states.map((state, i) => {
															if(state.id_state != null) {
																return (
																	<option key={i} value={state.id_state} selected={(deliveryRegion == state.id_fulfillment_centre) && (id_state == state.id_state) ? true : false}>{state.name}</option>
																)
															}
														})}
													</select>
													{ /** <button className="button-blue" onClick={this.changeDeliveryRegion.bind(this)}>UPDATE</button> **/ }
												</div>
												<div className="state-selection-info text-align-center">
													<p className="attention">Attention! </p>
													<p>By changing the region, the products which are not available in your newly selected region, will be removed from your cart.</p>
												</div>  
											</div>
										</div>
									</div>
								</OutsideClickHandler> 
							: null)
						}

						<div className="topbar-item account">
							<a href="javascript:void(0)" className="topbar-menu-item">
								<div className="menu-icon-block">
									<i className="menu-icon menu-icon-red icon-account"></i>
								</div>
								<span className="menu-label">Account<i className="icon-arrow-dropdown"></i></span>
							</a>
							<div className="mega-menu">
								<div className="mega-menu-content account tooltip-arrow">
									<div className="profile-cover">
										<img src={this.props.logo != "" ? baseDir+this.props.logo : baseDir+'dash/img/logo/default-customer-logo.jpg'} alt="Customer Logo" />
										<p className="username">{username}</p>
										<p className="company-name">{companyName}</p>
									</div>
									<ul>
										<li>
											<Link to="/settings">Settings</Link>
											<Link to="/help-faqs">Help/FAQs</Link>
											<Link to="/feedback">Give Us Feedback</Link>
											<a id="logoutLink" href={logoutLink}>Logout</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<MobileMoreMenu/>
				</div>
			</div>
		)
	}
}

Topbar.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    cartTopSummary: store.cartState.summary,
    cartTopProducts: store.cartState.cart,
    states: store.addressState.states,
    loyaltyCount: store.cartState.loyaltyCount,
    notifications: store.commonState.notifications,
    notificationsCount: store.commonState.notificationsCount,
    logo: store.settingsState.customerLogo,
	megaMenu: store.commonState.megaMenu,
	purchase_orders: store.addressState.purchaseOrders
  }
}


function mapDispatchToProps(dispatch) {
    return({
        handleMegaMenu: () => {
        	dispatch({
	    		type: "CONTROLLED_MEGAMENU",
	    		megaMenu: false
	  		})
        }
    })
}

export default connect(mapStateToProps, mapDispatchToProps)(Topbar)
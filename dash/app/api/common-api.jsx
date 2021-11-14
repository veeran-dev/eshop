import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import moment from 'moment';
import cookie from 'react-cookie'
import {toastr} from 'react-redux-toastr'
import serialize from 'form-serialize'
import store from '../store/configureStore'
import * as orderApi from './orders-api'
import * as cartApi from './cart-api'
import * as addressApi from './address-api'
import * as approvalsApi from './approvals-api'
import * as action from '../actions/common-actions'
import ClearAddCart from '../components/common/clearAddCart'
import QuickView from '../components/common/QuickView'
import ReviseOrderContent from '../components/common/reviseOrder'
import RejectOrderContent from '../components/common/rejectOrder'
import ApprovalPaymentOptions from '../components/common/approvalPaymentOption'
import OrderView from '../components/common/view-order'
import AddressView from '../components/common/view-address'
import RequestQuote from '../components/common/requestQuote';
import RequestQuoteProductSuggesstion from '../components/common/RequestQuoteProductSuggesstion'
import ViewWidget from '../components/views/widgets/store/ViewWidget'
import * as procureBuyActions from '../actions/procure-buy-actions';
import NewMessage from '../components/common/Message'
import PoDetail from '../components/common/poDetail'
import AddAddressView from '../components/views/address/AddAddress'
import accounting from '../../common/js/accounting'

// Padding 0 to single digits
export function padDigits(number, digits){
	return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
}

// Update quantity in cart
export function updateQuantity(idProduct, minimalQuantity, price, type, elementID, purchaseList){
	let oldQuantity, newQuantity
  
	oldQuantity = document.getElementById(elementID+"_"+idProduct).value
	
  if(type == 1)
	  newQuantity = (parseInt(oldQuantity)+1)
	else
	  newQuantity = (parseInt(oldQuantity)-1)

	if(newQuantity < minimalQuantity) {
	  toastr.error('Error', 'Requires minimal quantity of '+minimalQuantity, {icon: 'icon-error'})
	  if(purchaseList) {
	  	document.getElementById("listProduct_"+idProduct).value = 0
		  document.getElementById("finalPrice_" + idProduct).innerHTML = formatPrice(0)
    	document.getElementById("hiddenCartQuantity_" + idProduct).value = ""
	  }
	}
	else {
	  document.getElementById(elementID+"_"+idProduct).value = newQuantity
	  if(purchaseList) {
	  	document.getElementById("listProduct_"+idProduct).value = newQuantity
		  document.getElementById("finalPrice_" + idProduct).innerHTML = formatPrice(newQuantity * price)
    	document.getElementById("hiddenCartQuantity_" + idProduct).value = (idProduct + "-" + newQuantity)
	  }
	}
}

// Add to Cart
export function addToCart(idProduct, elementID, type, minimalQuantity, router){
	let products = new Array()
    let quantity = document.getElementById(elementID+"_"+idProduct).value
   
    if(router) {
    	router = router
    }
    else {
    	router = this.context.router
    }

    if(quantity > 0 && quantity != ""){
      closeModal(['viewProduct'])
      products.push(idProduct + "-" + quantity)
      cartApi.add(products, elementID, router, type, minimalQuantity)
    }
    else{
      toastr.error("Error", 'Please check the quantity you entered', {icon: 'icon-error'})
    }
}

// Date formatting for filters
export function getDate(dateString, format){
  let fromDateObj = new Date(dateString)
  if(format == "dd-mm-yyyy")
    return padDigits(fromDateObj.getDate(), 2)+"-"+padDigits((fromDateObj.getMonth()+1), 2)+"-"+fromDateObj.getFullYear();
  else if(format == "yyyy-mm-dd")
    return fromDateObj.getFullYear()+"-"+padDigits((fromDateObj.getMonth()+1), 2)+"-"+padDigits(fromDateObj.getDate(), 2);
  else if(format == "mm/dd/yyyy")
    return padDigits((fromDateObj.getMonth()+1), 2)+"/"+padDigits(fromDateObj.getDate(), 2)+"/"+fromDateObj.getFullYear();
  else if(format === "LL")
    return moment(dateString).format('LL');
  else if(format === "LLL")
    return moment(dateString).format('LLL');
  else if(format === "lll")
    return moment(dateString).format('lll');
  else if(format === "ll")
    return moment(dateString).format('ll');
}

// Reset date
export function resetDate(datePicker){
	datePicker.setState({from: null, to: null})
    datePicker.refs.from.value = ""
    datePicker.refs.to.value = ""
}

// Display modal
export function displayModal(elementID){
    document.body.classList.add("modal-open");
    document.getElementById(elementID).setAttribute("style", "display: flex; display: -webkit-flex;");
}

// Close modal - Parameter -> array of elements
export function closeModal(elementID){
	for(var i = 0; i < elementID.length; i++){
		if(elementID[i] != null && elementID[i] != undefined){
	    	document.body.classList.remove("modal-open");
	    	document.getElementById(elementID[i]).style.display = "none";
	    }
	}
}

// Orders global view
export function viewOrderDetail(idOrder, deliveryAddress, invoiceAddress){
	return axios.get('dash-history.php?type=2&ajax=true&id_order='+idOrder+'&delivery_add='+deliveryAddress+'&invoice_add='+invoiceAddress).then(response => {
        ReactDOM.render(<OrderView data={response.data} routers={this.context.router} reOrder={reOrderView.bind(this)} />, document.getElementById("orderContent"))
        displayModal("viewOrder")
        return response
    });
}

// Reorder products
export function reOrderView(idOrder, cartObj, router){
  reorder = 0;
  if(deliveryRegion == "" || deliveryRegion == 0) {
      document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
      document.body.classList.add('modal-open');
      reorder = idOrder;
      return false;
  }
  
	if(cartObj.length > 0){
	  ReactDOM.render(<ClearAddCart idOrder={idOrder} clearAndAdd={clearCartAddProducts.bind(this, idOrder, router)} addToExist={addProductsToExistCart.bind(this, idOrder, router)} />, document.getElementById("cartClearContent"))
	  displayModal("addToExistingCart")
	}
	else
	  cartApi.reOrderCart(router, idOrder)

  closeModal(["viewOrder"])
}

// Cart - Add products along with cart
export function addProductsToExistCart(idOrder, router){
  closeModal(["addToExistingCart"])
	cartApi.reOrderCart(router, idOrder)
}

// Cart - clear cart and add products
export function clearCartAddProducts(idOrder, router){
  closeModal(["addToExistingCart"])
	cartApi.remove(router, idOrder)
}

// GET - payemnt options
export function getPaymentOption(idOrder, dashboard, router, epaylaterEligibility, epayLaterId){
	return axios.get('dashpaymentoption.php?type=1&id_customer='+id_customer).then(response => {
	    ReactDOM.render(<ApprovalPaymentOptions 
          dashboard={dashboard} 
          router={router} 
          epaylaterEligibility={epaylaterEligibility}
          epayLaterId={epayLaterId}
          orderID={idOrder} 
          data={response.data} 
          onClick={approveOrder} />, document.getElementById("paymemtContent"))
	    displayModal("approvalPaymentOptions")
	    return response
	})
}

// Approve orders
export function approveOrder(idPayment, idOrder, type, router, epayLaterId){
	if(idPayment != 4){
		approvalsApi.approveOrder(idOrder, idPayment, "approvalPaymentOptions", type, epayLaterId)
  }
	else{
    document.getElementById('cr-o-id').value = 1
    document.getElementById('ap-o-id').value = idOrder
    router.push("payment")
  }

  closeModal(["approvalPaymentOptions"])
}

// Revise order
export function reviseOrder(idOrder, type, router){
	if(type == 0){
        ReactDOM.render(<ReviseOrderContent onClick={reviseOrder.bind(this, idOrder, 1, router)} />, document.getElementById("reviseContent"))
        displayModal("reviseOrder")
    }
    else{
        approvalsApi.reviseOrder(idOrder, router, "reviseOrder")
    }
}

// Reject order
export function rejectOrder(idOrder, dashboard) {
  let cancelReason = document.getElementById("cancel_reason").value
  cancelReason = cancelReason.replace(/^\s+|\s+$/gm,'');
  if(cancelReason != "") {
    return approvalsApi.rejectOrder(idOrder, cancelReason, "rejectOrder", dashboard);
  }
  else {
    toastr.error("Error", "Please provide cancel reason", {icon: 'icon-error'})
    return false;
  }
}

export function selectAllCheckBox(checked, elements){
	for(var i = 0; i < elements.length; i++){
		let allElems = document.getElementsByClassName(elements[i]);
		for(var j = 0; j < allElems.length; j++){
			allElems[j].checked = checked
		}
	}
}

export function drawHeaderLogo(){
	let eliteCanvasLogo = document.getElementById("eliteCanvasLogo").getContext("2d");
	let eliteLogo = document.getElementById("eliteLogo");
	eliteCanvasLogo.drawImage(eliteLogo, 10, 10, 263, 60);

	let customerCanvasLogo = document.getElementById("customerCanvasLogo").getContext("2d");
	let customerLogo = document.getElementById("customerLogo");
	customerCanvasLogo.drawImage(customerLogo, 10, 10);
}

// Style for autocomplete selected block
export let styles = {
  item: {
    //padding: '2px 6px',
    //cursor: 'default'
  },

  highlightedItem: {
    //color: 'white',
    background: '#eeeeee',
    //padding: '2px 6px',
    //cursor: 'default'
  },

  menu: {
    border: 'solid 1px #ee0000'
  }
}

export function matchStateToTerm (state, value) {
  return (
    state.name.toLowerCase().indexOf(value.toLowerCase()) !== -1 ||
    (state.abbr && state.abbr.toLowerCase().indexOf(value.toLowerCase()) !== -1) ||
    (state.code && state.code.toLowerCase().indexOf(value.toLowerCase()) !== -1)
  )
}

export function sortStates (a, b, value) {
  return (
    a.name.toLowerCase().indexOf(value.toLowerCase()) >
    b.name.toLowerCase().indexOf(value.toLowerCase()) ? 1 : -1
  );
}

export function sortGroups(a, b) {
  return a > b ? -1 : 1;
}

export function searchProducts(query, limit, pageID, searchType,priceMin=0,priceMax=0,priceFilter=0){
    if(searchType == 2)
    var customerID = id_customer;
  else
    var customerID = 0;

  return axios.get('dash-searchproductdata.php?search_query='+query+'&mode=1&type=0&id_customer='+customerID+'&pagenum='+pageID+'&limit='+limit+'&priceMin='+priceMin+'&priceMax='+priceMax+'&priceFilter='+priceFilter).then(response => {
        store.dispatch(action.searchResults(response.data))
      return response.data
  })
}

export function goToSearch(query, router,searchType){
 	let searchQuery = query.split(" ").join("+")
	router.push("search/"+searchQuery)
	this.searchProducts(searchQuery, 20, 0,searchType)
}

export function getProductById(idProduct, idSupplier){
	if(cookie.load("search_type") == 1)
		var customerID = 0;
	else
		var customerID = id_customer;
	return axios.get('dash-searchproductdata.php?id_product='+idProduct+'&type=1&id_customer='+customerID+'&id_supplier='+idSupplier).then(response => {
      store.dispatch(action.productPage(response.data))
      return response
	})
}
export function getListCategoryProductsWithFilters(idCategory, limit, idPage, searchType){
	if(idPage=="undefined")
 		var idPage = 0;
 	if(searchType == 1)
		var customerID = 0;
	else 
		var customerID = id_customer;
	
	return axios.get('dash-category.php?id_category='+idCategory+'&type=1&id_customer='+customerID+'&pagenum='+idPage+'&limit='+limit).then(response => {
	   store.dispatch(procureBuyActions.purchaseCategoryProductsWithFilters(response.data))
       return response
	})
}


export function quickView(idProduct, idSupplier){
	return axios.get('dash-searchproductdata.php?id_product='+idProduct+'&type=1&id_customer='+id_customer+'&id_supplier='+idSupplier).then(response => {
      ReactDOM.render(<QuickView products={response.data} routers={this.context.router} />, document.getElementById("viewProductContent"))  
      displayModal("viewProduct")
      return response
	})
}


export function formatPrice(price){
	//var formatMoney = lib.formatMoney = function(number, symbol, precision, thousand, decimal, format)
  var formattedPrice = 0;

  var space = currencyBlank != undefined && currencyBlank ? " " : "";

  switch(currencyFormat) {
    /* X 0,000.00 */
    case '1':
      formattedPrice = currencyChar + space + accounting.formatMoney(price, "", currencyDecimals, ",", ".", "%s%v");
      break;
     /* 0 000,00 X*/
    case '2':
      formattedPrice = accounting.formatMoney(price, "", currencyDecimals, " ", ",", "%v%s") + space + currencyChar;
      break;
    /* X 0.000,00 */
    case '3':
      formattedPrice = currencyChar + space + accounting.formatMoney(price, "", currencyDecimals, ".", ",", "%s%v");
      break;
    /* 0,000.00 X */
    case '4':
      formattedPrice = accounting.formatMoney(price, "", currencyDecimals, ",", ".", "%v%s") + space + currencyChar;
      break;
    /* X 0'000.00  Added for the switzerland currency */
    case '5':
      formattedPrice = accounting.formatMoney(price, "", currencyDecimals, "'", ".", "%s%v") + space + currencyChar;
      break;
  }

  return formattedPrice;
}

export function getPageID(idPage, totalPage, type){
	if(type == 1){
      if(parseInt(idPage) > 0)
        return parseInt(idPage)-1
    }
    else{
      if(parseInt(idPage) < (parseInt(totalPage)-1))
        return parseInt(idPage)+1
    }

    return idPage
}

export function goToProduct(idProduct, idSupplier){
	getProductById(idProduct, idSupplier)
	this.context.router.push("product/"+idProduct+'/'+idSupplier)
}

export function quoteSubmit(formID, State){
  let quoteForm = document.querySelector('#'+formID)
  let data = serialize(quoteForm, { hash: false })

  closeModal(["requestQuote"])

  return axios.post('bqProcessRequest.php', data).then(response => {
    if(response.data == 1){
      toastr.success("Success", "Request sent successfully.", { icon: "icon-succes"})
      quoteForm.reset()
      document.getElementById("productResult").innerHTML = ""
      State.setState({ value: ""})
    }
    else
      toastr.error("Error", "There is an error while sending request", { icon: "icon-error"})
    return response
  })                                                                      
}

export function getAddress(idAddress){
  return axios.get('dash-address.php?type=13&id_address='+idAddress).then(response => {
    var arr = response.data;
    if(arr[0] == 200){
      document.getElementById("messagePopContent").innerHTML = "";
      ReactDOM.render(<NewMessage message={"Address was created by "+arr[1]+" so you cannot edit it.Please contact your Relationship Manager"} />, document.getElementById("messagePopContent"));
      displayModal("messagePop");
    }
    else if(response.data[0].length > 0) {
      document.getElementById("addressContent").innerHTML = ""
      ReactDOM.render(<AddressView data={response.data[0]} states={response.data[1]} />, document.getElementById("addressContent"))
      displayModal("viewAddress")
      return response
    }
  })
}

export function deleteAddress(idAddress) {
  return axios.get('dash-address.php?type=12&action=1&id_address='+idAddress+"&id_customer="+id_customer).then(response => {
    var customer_name = response.data;
      if(response.data == 1) {
        toastr.success("Success", "Address deleted successfully.", {icon: "icon-error"})
        closeModal(["confirmationPop"])
      }
      else if(response.data != "" ){
        closeModal(["confirmationPop"])
        document.getElementById("messagePopContent").innerHTML = "";
        ReactDOM.render(<NewMessage message={"Address was created by "+customer_name+" so you cannot delete it.Please contact your Relationship Manager"} />, document.getElementById("messagePopContent"));
        displayModal("messagePop");
      }
      else {
        toastr.error("Error", "Error while deleting your address.", {icon: "icon-error"})
      }
      addressApi.get()
      return response
  })
}

export function editAddress(formId){
  let addressForm = document.querySelector('#'+formId);
  let data = serialize(addressForm, { hash: false });

  closeModal(["viewAddress"])

  return axios.post('dash-address.php', data).then(response => {
    if(response.data == 1){
      toastr.success("Success", "Address updated successfully.", { icon: "icon-succes"})
      addressForm.reset()
      // Update address in page
      addressApi.get()
    }
    else
      toastr.error("Error", "There is an error while updating address.", { icon: "icon-error"})
    return response
  })      
}

export function addAddress(formId, type){
  if(type == 1) {
      document.getElementById("addAddressContent").innerHTML = ""
      ReactDOM.render(<AddAddressView />, document.getElementById("addAddressContent"))
      displayModal("addAddress")
  }
  else {
    let addressForm = document.querySelector('#'+formId);
    let data = serialize(addressForm, { hash: false });

    closeModal(["addAddress"])

    return axios.post('dash-address.php', data).then(response => {
      if(response.data == 1){
        toastr.success("Success", "Address Created Successfully.", { icon: "icon-succes"})
        addressForm.reset()
        // Update address in page
        addressApi.get()
      }
      else
        toastr.error("Error", "There is an error while creating address.", { icon: "icon-error"})
      return response
    })      
  }
}

export function getAllWidgets(){
  return axios.get('widget.php?type=2').then(response => {
      store.dispatch(action.widgetsStore(response.data))
      return response
  })
}

export function installWidget(idWidget, isPaid, active, position, id_option, router){
  return axios.post('widget.php?type=1&id_user='+id_customer+'&id_widget='+idWidget+'&is_paid='+isPaid+'&active='+active+'&position='+position+'&id_option='+id_option).then(response => {
      if(response.data == 1){
        toastr.success("Success", "Widget added successfully!", {icon: 'icon-succes'});
        closeModal(["viewWidget"])
        getAllWidgets()
        checkWidget(idWidget, true)
        if(idWidget == 17) {
          router.push('budget-configuration');
          location.reload(true);
        }
      }
      else if(response.data == 0){
        toastr.error("Error", "There was an error while adding your widget.", {icon: 'icon-error'});
      }
      else{
        toastr.error("Error", response.data, {icon: 'icon-error'});
      }

      if(idWidget == 18) {
        checkSearchWidget(18, true)
      }

      return response
  })
}

export function uninstallWidget(idWidget){
  return axios.post('widget.php?type=5&id_widget='+idWidget+'&id_user='+id_customer).then(response => {
      if(response.data == 1){
          toastr.success("Success", "Widget removed successfully.", {icon: 'icon-succes'});
          closeModal(["viewWidget"])
          getAllWidgets()
          getDashboardWidgets()
          if(idWidget == 17) {
            location.reload();
          }
      }
      else {
          toastr.error("Error", response.data, {icon: 'icon-error'});
      }

      if(idWidget == 18)
        checkSearchWidget(18, true)

      return response
  })
}

export function checkWidget(idWidget, isWidget){
  return axios.get('widget.php?type=3&widget='+isWidget+'&id_widget='+idWidget).then(response => {
      store.dispatch(action.widgetStatus(response.data))
      return response
  })
}

export function checkSearchWidget(idWidget, isWidget) {
  return axios.get('widget.php?type=3&widget='+isWidget+'&id_widget='+idWidget).then(response => {
      store.dispatch(action.searchWidgetStatus(response.data))
      return response
  })
}

export function getDashboardWidgets(){
  store.dispatch(action.requestDashboardWidgets())
  return axios.get('widget.php?type=4&id_user='+id_customer).then(response => {
      store.dispatch(action.dashboardWidgets(response.data))
      return response
  })
}

export function getWidgetById(idWidget) {
  return axios.get('widget.php?type=6&id_widget='+idWidget).then(response => {
      store.dispatch(action.uniqueWidget(response.data))
      return response
  })
}

export function setProductDetails(product, contexts){
  return axios.get('dash-searchproductdata.php?id_product='+product.id_product+'&type=1&id_customer='+id_customer).then(response => {
      ReactDOM.render(<RequestQuoteProductSuggesstion data={response.data} />, document.getElementById("productResult"))  
      return response
  })
}

export function openRequestQuote(productName, productId){
  document.getElementById("requestQuoteContent").innerHTML = ""
  ReactDOM.render(<RequestQuote productName={productName} productCode={productId} />, document.getElementById("requestQuoteContent"))
  displayModal("requestQuote")
}

export function viewWidget(widgetData){
  ReactDOM.render(<ViewWidget data={widgetData} />, document.getElementById("viewWidgetContent"));
  displayModal("viewWidget")
}

export function getHotels(searchQuery, checkInDate, checkOutDate, router){
  return axios.get('http://terminal2.expedia.com/x/mhotels/search', {
      params: { 
          city: decodeURI(searchQuery), 
          checkInDate: checkInDate, 
          checkOutDate: checkOutDate, 
          room1: 2, 
          apikey: "LL2D04YN1TlILmHqNkRqiREGxYusxYRT", 
          resultsPerPage: -1, 
          sortOrder: true,
          filterUnavailable: true,
          filterHotelName: decodeURI(searchQuery)
      }}).then(response => { 
            store.dispatch(action.hotelSearchResults(response.data))
            if(response.data)
              router.push("expedia/search")
            return response
  })
}

export function getNotifications(type){
  return axios.get('notification.php?type='+type, {transformRequest: [function (data) { 
                        document.getElementById('loader').style.visibility = 'hidden';
                        return data;
                      }]}).then(response => { 
        if(type == 1)
          store.dispatch(action.topbarNotifications(response.data))
        else if(type == 2)
          store.dispatch(action.notificationsPage(response.data))
        return response
  })
}

export function readNotification(idNotification) {
  return axios.get('notification.php', {
      params: { type: 3, id_notification: idNotification }}).then(response => { 
        if(response.data == 1)
          getNotifications(1)
        return response
  })
}

export function getDayWithTime(date) {
  return moment(date).format('MMMM Do YYYY, h:mm:ss a');
}


export function checkPastDate(date) {
  var dateLimit = moment(date)
  var now = moment()
  if (now < dateLimit) {
    return true;
  }
  else{
    return false
  }
}

export function isPastDate(date, includeCurrentDay = false) {
  var dateLimit = moment(date).format('YYYY-MM-DD')
  var now = moment().format('YYYY-MM-DD')
  console.log(dateLimit)
  console.log(now)
  if(includeCurrentDay === true){
    return now <= dateLimit
  }
  else{
    return now < dateLimit
  }
}

export function getCategoryNameById(categoryId) {
  return axios.get('dash-category.php?id_category='+categoryId+'&type=2').then(response => {
      document.getElementById("categorySearchKeyword").innerHTML = '"'+response.data+'"';
      return response
  })
}

export function getFAQs() {
  return axios.get('dash/app/api/help-faqs.json').then(response => {
      store.dispatch(action.helpFAQS(response.data.Faqs))
      return response
  })
}

export function submitFeedback(stateObject, type) {

  let feedbackContent = "", action = 1
  
  if(type == 1) { // Success Feedback
    feedbackContent = stateObject.state.successText
    action = 1
  }
  else if(type == 2) { // Unsuccess Feedback
    feedbackContent = stateObject.state.unsuccessText
    action = 2
  }
  
  if(feedbackContent.length >= 4) 
  {
    return axios.post('feedback.php?type=1&message='+feedbackContent+'&reaction='+action).then(response => {
        if(response.data == 1) {
          stateObject.setState({
            response: action,
            successFeedback: false,
            initialContent: false,
            unsuccessFeedback: false
          })
        }
        else {
          toastr.error("Error", "Error while getting feedback. Please try again.", {icon: "icon-error"})
        }
        return response
    })
  }
  else {
    toastr.error("Error", "Please enter atleast 4 characters.", {icon: "icon-error"})
  }
}

export function getGroupInfo(){
  return axios.get('dash-get-group-info.php?id_customer='+id_customer+'&type=12').then(response => {
        store.dispatch(action.companyInfo(response.data))
      return response.data
  })
}

export function checkBudgetInstalled() {
  return axios.get('purchase-order.php?id_customer='+id_customer+'&type=3').then(response => {
        store.dispatch(action.budgetInstalled(response.data))
      return response.data
  })
}

export function viewPoDetail(id_purchase_order) {
  return axios.get('purchase-order.php?id_purchase_order='+id_purchase_order+'&type=6').then(response => {
      ReactDOM.render(<PoDetail data={response.data} />, document.getElementById("poDetailedView"));
      displayModal("poDetail");
      return response.data
  })
}

export function inviteSupplier(emails) {
  var data = new FormData()
  data.append('SupplierInvite', true);
  data.append('supplier_emails', emails);
  return axios.post('invite-supplier.php', data).then(response => {
    return response.data;
  });
}

export function openMegaMenu(){
    document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
    document.body.classList.add('modal-open');
}

export function toPrice(price){
  if(price == null || price == undefined){
      return "₹ "+"0.00".toLocaleString('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 2,
    });  
  }
  else{
    return "₹ "+price.toLocaleString('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 2,
    });
  }
}

export function downloadAll(urls) {
  var link = document.createElement('a');

  link.setAttribute('download', null);
  link.style.display = 'none';

  document.body.appendChild(link);

  for (var i = 0; i < urls.length; i++) {
    link.setAttribute('download', urls[i]);
    link.setAttribute('href', urls[i]);
    link.click();
  }
  document.body.removeChild(link);
}

export function getSelectedCity() {
  return axios.get('elite-common-data.php?type=1').then(response => {
        store.dispatch(action.setSelectedCities(response.data['selectedCities']))
      return response
  })
}

export function getSelectedCategory() {
  return axios.get('elite-common-data.php?type=2').then(response => {
        store.dispatch(action.setSelectedCategories(response.data['selectedCategories']))
      return response
  })
}

export function addSupplier(contact_person, entp_name, mobile, entp_email, city, cat){

  return axios.get('invite-supplier.php?type=1&entp_name='+entp_name+'&entp_email='+entp_email+'&contact_person='+contact_person+'&mobile='+mobile+'&city='+city+'&category='+cat).then(response => {
          return response.data;
        });
}
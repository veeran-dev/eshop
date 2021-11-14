import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import moment from 'moment';
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import ResetPassword from '../components/common/ResetPassword'
import * as commonAction from '../actions/common-actions'

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

export function padDigits(number, digits){
	return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
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
  console.log(datePicker)
	datePicker.setState({from: null, to: null})
    // datePicker.state.from = ""
    // datePicker.state.to = ""
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


export function selectAllCheckBox(checked, elements){
	for(var i = 0; i < elements.length; i++){
		let allElems = document.getElementsByClassName(elements[i]);
		for(var j = 0; j < allElems.length; j++){
			allElems[j].checked = checked
		}
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

export function getDayWithTime(date) {
  return moment(date).format('MMMM Do YYYY h:mm:ss a');
}

export function getDateFormat(date){
  return moment(date).format('YYYY-MM-DD hh:mm:ss');
}
export function compareDates($date1, $date2){
  const a = new Date($date1);
  const b = new Date($date2);
  return a == b || a > b ? false : true;
}

export function recoverPassword(){
      ReactDOM.render(<ResetPassword />, document.getElementById("resetPasswordContent"))  
      displayModal("resetPassword")
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
    return axios.post('../feedback.php?type=1&message='+feedbackContent+'&reaction='+action).then(response => {
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

export function checkPastDate(date, includeCurrentDay = false) {
  var dateLimit = moment(date).format('YYYY-MM-DD')
  var now = moment().format('YYYY-MM-DD')
  if(includeCurrentDay === true){
    return now <= dateLimit
  }
  else{
    return now < dateLimit
  }
}

export function toPrice(price){
  if(price == null){
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

export function timeDiff(target_date){
  var now = moment(new Date()); //todays date
  var end = moment(target_date); // another date
  var diff = now.diff(end);
  var days = now.diff(end, 'days')
  var hours = now.diff(end, 'hours')
  var min = now.diff(end, 'minutes')
  return {0:days, 1:hours, 2:min}
}

export function downloadAll(urls) {
  var link = document.createElement('a');

  link.setAttribute('download', null);
  link.style.display = 'none';

  document.body.appendChild(link);

  for (var i = 0; i < urls.length; i++) {
    link.setAttribute('download', urls[i]);
    link.setAttribute('href', "../"+urls[i]);
    link.click();
  }
  document.body.removeChild(link);
}

export function getSelectedCity() {
  return axios.get('../elite-supplier-address.php?type=3').then(response => {
        store.dispatch(commonAction.selectedCity(response.data['selectedCities']))
      return response
  })
}

export function getSelectedCategory() {
  return axios.get('../elite-supplier-address.php?type=4').then(response => {
        store.dispatch(commonAction.selectedCategory(response.data['selectedCategories']))
      return response
  })
}

export function getAllStates() {
  return axios.get('../elite-supplier-address.php?type=1').then(response => {
        store.dispatch(commonAction.allState(response.data['states']))
      return response
  })
}

export function getMyBuyers(){
  return axios.get('../elite-supplier-order.php?type=11').then(response => {
          store.dispatch(commonAction.allState(response.data['companies']))
        return response
    })
}
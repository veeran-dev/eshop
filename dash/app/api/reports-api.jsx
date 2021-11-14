import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/report-actions'
import * as G from '../api/common-api'
import {toastr} from 'react-redux-toastr'

/**
 * Get user reports
 */
export function getPurchaseHistory(fromDate, toDate, duration, locationID, addressId) {
  store.dispatch(action.requestHistoryReport())
  return axios.get('dash-reports.php',{ params: { 
                                          type: 1, 
                                          customerid:id_customer, 
                                          addressId: addressId, 
                                          from_date: fromDate, 
                                          to_date: toDate, 
                                          duration: duration,
                                          location: locationID
                                        }
                                      })
    .then(response => {
      store.dispatch( action.getPurchaseHistoryReport(response.data) )
      return response
  })
}

export function getCategoriesReport(fromDate, toDate, duration, locationID, addressId, orderId){
  store.dispatch(action.requestCategoryReport())
  return axios.get('dash-reports.php', { params: { 
                                            type: 2, 
                                            customerid: id_customer, 
                                            orderid: orderId, 
                                            duration: duration,
                                            addressId: addressId,
                                            from_date: fromDate,
                                            to_date: toDate,
                                            location: locationID
                                          }
                                        })
    .then(response => {
      store.dispatch(action.categoryReport(response.data))
      return response
  })
}

export function getLocations(fromDate, toDate, duration, locationID, addressId, orderId){
  store.dispatch(action.requestLocationsReport())
  return axios.get('dash-reports.php', {  params: {
                                            type: 6,
                                            customerid: id_customer,
                                            orderid: orderId,
                                            duration: duration,
                                            addressId: addressId,
                                            from_date: fromDate,
                                            to_date: toDate,
                                            location: locationID
                                          }
                                        })
    .then(response => { 
      store.dispatch(action.locationReport(response.data[0], response.data[1]))
      return response
  })
}

export function mailReportAsExcel(duration, fromDate, toDate, locationID, sendMail, type) {
  let url = "";
  if(type == 1) {
    url = "generate-purchase-history.php";
  }
  else if(type == 2) {
    url = "generate-category-report.php";
  }
  else if(type == 3) {
    url = "generate-location-report.php";
  }

  let mailTo = document.getElementById("mailTo").value;
  let mailMessage = document.getElementById("mailMessage").value;
  
  return axios.get(url, { params: {
                              customerid: id_customer,
                              duration: duration,
                              from_date: fromDate,
                              to_date: toDate,
                              location: locationID,
                              sendMail: sendMail,
                              mailTo: (mailTo != "" ? mailTo : ""),
                              message: mailMessage
                            }
                          })
    .then(response => {
      document.getElementById("mailShare").reset();
      if(response.data == 1) {
        toastr.success("Mail Sent Successfully", "Report has been sent to given E-mail as Excel", {icon: "icon-succes"})
        document.getElementById("mailShare").reset();
        G.closeModal(["emailShare"]);
      } 
      else {
        toastr.error("Error", "Error while sending an email. Please try agin later.", {icon: "icon-error"})
      }

      return response
  })

}
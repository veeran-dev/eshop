import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/services-actions'
import * as G from '../api/common-api'
import {toastr} from 'react-redux-toastr';
import serialize from 'form-serialize'

// Get locations suggestions - city, country and airport for skyscanner flights API
export function getFlightsSuggestions(context, value) {
    return axios.get('skyscanner-ajax.php', {params: {
                                            type: 2,
                                            q: value
                                          }, transformRequest: [function (data) { 
                        document.getElementById('loader').style.visibility = 'hidden';
                        return data;
                      }]}).then(response => {
              context.setState({ suggestions: response.data.Places })
              return response.data
    })
}

export function searchFlights(formId) {
    var skyscannerForm = document.querySelector('#'+formId)
    var params = serialize(skyscannerForm, { hash: true })
    let onwardDate, returnDate
    onwardDate = document.getElementById("from-date-hidden").value
    returnDate = document.getElementById("to-date-hidden").value

    return axios.get('skyscanner-ajax.php', {
        params: {
            type: 1,
            originplace: (params.originplace != "" ? params.originplace : ""),
            destinationplace: (params.destinationplace != "" ? params.destinationplace : ""),
            outbounddate: (onwardDate != "" ? G.getDate(onwardDate, "yyyy-mm-dd") : ""),
            inbounddate: (returnDate != "" ? G.getDate(returnDate, "yyyy-mm-dd") : ""),
            cabinclass: (params.cabinclass != "" ? params.cabinclass : ""),
            adults: (params.adults != "" ? params.adults : ""),
            children: (params.children != "" ? params.children : ""),
            infants: (params.infants != "" ? params.infants : "")
        }
    }).then(response => {
        store.dispatch(action.getFlightsSuccess(response.data))
    })
}

export function loadMoreFlights(pageSize, pageIndex, session_key) {
    return axios.get('skyscanner-ajax.php', {
        params: {
            type: 3,
            pagesize: pageSize,
            pageindex: parseInt(pageIndex),
            session_key: session_key
        }
    }).then(response => {
        store.dispatch(action.getFlightsSuccess(response.data))
    })
}


import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/search-actions'

export function search(idPage, query, zone, category_filter, brand_filter, price, sort="", update_filter, clear_results){
  store.dispatch(action.searching())

  if(clear_results == true){
    store.dispatch(action.clearResults([]))
  }
  if(idPage ==1 && zone.length == 0 && category_filter.length == 0 && brand_filter.length == 0 && price == "" && sort == ""){
    store.dispatch(action.clearFilters([]))
  }
  store.dispatch(action.searchDetails({idPage: idPage, query:query, zone:zone, category_filter:category_filter, brand_filter:brand_filter, price:price, sort:sort, update_filter:update_filter}))
  return axios.post('elite-search-api.php?price='+price+'&brand_filter='+brand_filter+'&category_filter='+category_filter+'&sort='+sort+'&zone='+JSON.stringify(zone)+'&idPage='+idPage+'&query='+query+'').then(response => {
      store.dispatch(action.zones(response.data['zone']))
      store.dispatch(action.getAllAvailableResults(response.data['result']['result']))      
      if(update_filter){
          store.dispatch(action.updateCategoryResults(response.data['result']['category']))
          store.dispatch(action.updateManufacturerResults(response.data['result']['manufacturer']))
      }
      else{
        store.dispatch(action.allCategoryResults(response.data['result']['category']))
        store.dispatch(action.allManufacturerResults(response.data['result']['manufacturer']))
      }
      store.dispatch(action.maxPriceResults(response.data['result']['price']))
      store.dispatch(action.gotIt())
      return response  
  })
}

export function setZone(zone){
  store.dispatch(action.zones(zone))
}
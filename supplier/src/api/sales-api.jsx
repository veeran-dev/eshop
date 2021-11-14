import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/sales-actions'

export function getTopCustomers(){
    store.dispatch(action.topCustomersLoading(true))
    return axios.get('../elite-supplier-sales.php?type=1')
        .then(response => {
            store.dispatch(action.setTopCustomers(response.data['topCustomer']))
            store.dispatch(action.topCustomersLoading(false))
            return response
          })
}

export function getMonthlySales(){
    store.dispatch(action.monthlySalesLoading(true))
    return axios.get('../elite-supplier-sales.php?type=2')
        .then(response => {
            store.dispatch(action.setMonthlySales(response.data['monthlySales']))
            store.dispatch(action.monthlySalesLoading(false))
            return response
          })
}

export function getTopProducts(){
    store.dispatch(action.topProductsLoading(true))
    return axios.get('../elite-supplier-sales.php?type=3')
        .then(response => {
            store.dispatch(action.setTopSoldProducts(response.data['topSoldProducts']))
            store.dispatch(action.topProductsLoading(false))
            return response
          })
}

export function getDashboardKpi(){
    store.dispatch(action.loading(true))
    return axios.get('../elite-supplier-sales.php?type=4')
    .then(response => {
        store.dispatch(action.dashboardKpi(response.data))
        store.dispatch(action.loading(true))
        return response
      })
}
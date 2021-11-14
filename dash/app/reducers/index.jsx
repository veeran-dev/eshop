import { combineReducers } from 'redux'
import {reducer as toastrReducer} from 'react-redux-toastr'

// Reducers
import dashboardReducer from './dashboard-reducer'
import pendingPaymentReducer from './pending-payment-reducer'
import invoiceReducer from './invoice-reducer'
import approvalReducer from './approval-reducer'
import orderReducer from './order-reducer'
import reportReducer from './report-reducer'
import procureBuyReducer from './procure-buy-reducer'
import cartReducer from './cart-reducer'
import addressReducer from './address-reducer'
import commonReducer from './common-reducer'
import servicesReducer from './services-reducer'
import settingsReducer from './settings-reducer'
import searchReducer from './search-reducer'
import productReducer from './product-reducer'
import quotationReducer from './quotation-reducer'

// Combine Reducers
const reducers = combineReducers({
	dashboardState: dashboardReducer,
	approvalState: approvalReducer,
    pendingPaymentState: pendingPaymentReducer,
    invoiceState: invoiceReducer,
    orderState: orderReducer,
    reportState: reportReducer,
    procureBuyState: procureBuyReducer,
    toastr: toastrReducer,
    cartState: cartReducer,
    addressState: addressReducer,
    commonState: commonReducer,
    servicesState: servicesReducer,
    settingsState: settingsReducer,
    searchState: searchReducer,
    productState: productReducer,
    quotationState: quotationReducer,
})

export default reducers

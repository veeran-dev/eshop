import { combineReducers } from 'redux'
import {reducer as toastrReducer} from 'react-redux-toastr'
// Reducers
import dashboardReducer from './dashboard-reducer'
import addressReducer from './address-reducer'
import authReducer from './auth-reducer'
import orderReducer from './order-reducer'
import quotationReducer from './quotation-reducer'
import settingReducer from './settings-reducer'
import salesReducer from './sales-reducer'
import catalogReducer from './catalog-reducer'
import commonReducer from './common-reducer'
import inventoryReducer from './inventory-reducer'

// Combine Reducers
const reducers = combineReducers({
	toastr: toastrReducer,
	dashboardState: dashboardReducer,
	authState: authReducer,
	orderState: orderReducer,
	quotationState: quotationReducer,
	addressState: addressReducer,
	settingState: settingReducer,
	salesState: salesReducer,
	catalogState: catalogReducer,
	commonState: commonReducer,
	inventoryState: inventoryReducer,
})

export default reducers

import * as types from '../constants/action-types';

const initialState = {
  fc: [],
  productDetails: [],
  widgets: [],
  widgetStatus: 0,
  searchResults: [],
  dashboardWidgets: [],
  hotelsList: [],
  notifications: [],
  notificationsCount: [],
  pageNotifications: [],
  pageNotificationsCount: [],
  isFetchingDashboardWidgets: false,
  helpFAQs: [],
  uniqueWidget: [],
  productFilters:[],
  productList: [],
  total:0,
  companyInfo: [],
  searchWidgetStatus: 0,
  budgetInstalled: 0,
  megaMenu: false,
  selectedCities: [],
  selectedCategories: [],
};

const commonReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_DASHBOARD_WIDGETS:
        return { ...state, isFetchingDashboardWidgets: action.loading }
    case types.GET_FC_SUCCESS:
        return { ...state, fc: action.fc }
    case types.SEARCH_RESULTS:
        return { ...state, productFilters: action.searchResults[0], productList: action.searchResults[1], total: action.searchResults[2] } 
	case types.SEARCH_FILTER_RESULTS:
        return { ...state, productList: action.searchFilterResults[0], total: action.searchFilterResults[1] }
  	case types.PRODUCT_DATA:
  		  return { ...state, productDetails: action.productData }
    case types.GET_WIDGETS_SUCCESS:
        return { ...state, widgets: action.widgets }
    case types.GET_WIDGET_STATUS:
        return { ...state, widgetStatus: action.widgetStatus }
    case types.GET_DASHBOARD_WIDGET_SUCCESS:
        return { ...state, dashboardWidgets: action.dashboardWidgets, isFetchingDashboardWidgets: false }
    case types.GET_HOTELS_SUCCESS:
        return { ...state, hotelsList: action.hotels }
    case types.GET_TOPBAR_NOTIFICATIONS_SUCCESS:
        return { ...state, notifications: action.notifications.results, notificationsCount: action.notifications.total }
    case types.GET_NOTIFICATIONS_SUCCESS:
        return { ...state, pageNotifications: action.pageNotifications.results, pageNotificationsCount: action.pageNotifications.total }
    case types.HELP_FAQS_RESPONSE:
        return { ...state, helpFAQs: action.helpFAQS }
    case types.UNIQUE_WIDGET_RESPONSE:
        return { ...state, uniqueWidget: action.uniqueWidget }
    case types.COMPANY_INFO:
        return { ...state, companyInfo: action.companyInfo }
    case types.SEARCH_WIDGET_STATUS:
        return { ...state, searchWidgetStatus: action.searchWidgetStatus }
    case types.BUDGET_INSTALLED:
        return { ...state, budgetInstalled: action.budgetInstalled }
    case types.CONTROLLED_MEGAMENU:
        return { ...state, megaMenu: action.megaMenu }
    case types. SELECTED_CATEGORY:
        return { ...state, selectedCategories: action.payload }
    case types. SELECTED_CITIES:
        return { ...state, selectedCities: action.payload }
    default:
      return state
  }
}

export default commonReducer;

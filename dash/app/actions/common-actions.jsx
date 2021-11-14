import * as types from '../constants/action-types';

export function searchResults(searchResults,total=0) {
 	return { 
			type: types.SEARCH_RESULTS,
			searchResults,
			total: total	
		   }
}
export function searchFilterResults(searchFilterResults) {
 	return { 
			type: types.SEARCH_FILTER_RESULTS,
			searchFilterResults
		   }
}

export function productPage(data){
	return { type: types.PRODUCT_DATA, productData: data }
}

export function widgetsStore(widgets){
	return { type: types.GET_WIDGETS_SUCCESS, widgets: widgets}
}

export function widgetStatus(status){
	return { type: types.GET_WIDGET_STATUS, widgetStatus: status}
}

export function dashboardWidgets(widgets){
	return { type: types.GET_DASHBOARD_WIDGET_SUCCESS, dashboardWidgets: widgets}
}

export function hotelSearchResults(hotelResults){
	return { type: types.GET_HOTELS_SUCCESS, hotels: hotelResults }
}

export function topbarNotifications(notifications) {
	return { type: types.GET_TOPBAR_NOTIFICATIONS_SUCCESS, notifications: notifications }
}

export function notificationsPage(notifications){
	return { type: types.GET_NOTIFICATIONS_SUCCESS, pageNotifications: notifications}
}

export function requestDashboardWidgets() {
	return { type: types.REQUEST_DASHBOARD_WIDGETS, loading: true }
}

export function helpFAQS(helpFAQS) {
	return { type: types.HELP_FAQS_RESPONSE, helpFAQS: helpFAQS }
}

export function uniqueWidget(widgetData) {
	return { type: types.UNIQUE_WIDGET_RESPONSE, uniqueWidget: widgetData }
}

export function companyInfo(companyInfo) {
	return { type: types.COMPANY_INFO, companyInfo: companyInfo}
}

export function searchWidgetStatus(widgetStatus) {
	return { type: types.SEARCH_WIDGET_STATUS, searchWidgetStatus: widgetStatus}
}

export function budgetInstalled(budgetInstalled) {
	return { type: types.BUDGET_INSTALLED, budgetInstalled: budgetInstalled}
}

export function controlledMegaMenu(budgetInstalled) {
	return { type: types.CONTROLLED_MEGAMENU, megaMenu: megaMenu}
}

export function setSelectedCities(data){
	return { type: types.SELECTED_CITIES, payload: data }
}

export function setSelectedCategories(data){
	return { type: types.SELECTED_CATEGORY, payload: data }
}
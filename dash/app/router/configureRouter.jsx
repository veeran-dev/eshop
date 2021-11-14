import React from 'react'
import { Router, Route, IndexRoute, useRouterHistory, IndexRedirect } from 'react-router'
import { createHashHistory } from 'history'

// Layouts
import MainLayout from '../components/layouts/main-layout'

// Pages
import Dashboard from '../components/containers/Dashboard'
import Procure from '../components/containers/Procure'
      import CategoryList from '../components/views/procure/category-list'
        import CategoryProducts from '../components/views/procure/category-products'
      import PurchaseList from '../components/views/procure/purchase-list'
      import ReorderList from '../components/views/procure/reorder-list'
      import UploadPo from '../components/views/procure/upload-po'
        import PurchaseOrderFetchedProducts from '../components/views/procure/PurchaseOrderFetchedProducts'
import Orders from '../components/containers/Orders'
  import OrdersList from '../components/views/orders/orders-list-index'
import Suppliers from '../components/containers/Suppliers'
  import SupplierIndex from '../components/views/supplier/supplier-index'
  import SupplierDetails from '../components/views/supplier/supplier-details'
  import SupplierInvite from '../components/views/supplier/InviteSupplier'
import Quotations from '../components/containers/Quotations'
  import QuotationLists from '../components/views/quotations/quotation-index'
  import QuotationHome from '../components/views/quotations/quotation-home'
  import QuotationDetails from '../components/views/quotations/quotation-details'
import Reports from '../components/containers/Reports'
      import PurchaseHistoryReport from '../components/views/reports/purchase-history-report'
      import CategoriesReport from '../components/views/reports/categories-report'
      import LocationBasedReport from '../components/views/reports/location-based-report'
import Invoices from '../components/containers/Invoices'
      import InvoiceList from '../components/views/invoice-list'
      import DeliveryReceipt from '../components/views/delivery-receipts'
import Payments from '../components/containers/Payments'
      import PendingPayments from '../components/views/pending-payments-list'
import Approvals from '../components/containers/Approvals'
  import ApprovalList from '../components/views/approval-list';
import Deals from '../components/containers/Deals'
import Services from '../components/containers/Services'
      import SkyScanner from '../components/views/services/skyscanner'
      { /* import Expedia from '../components/views/services/expedia'
        import ExpediaSearch from '../components/views/services/expedia/search-results'
        import HotelInfo from '../components/views/services/expedia/hotel-info'
      import Zomato from '../components/views/services/zomato'
      import Goibbo from '../components/views/services/goibbo' */}
import Settings from '../components/containers/Settings'
  import SettingsProfile from '../components/views/settings/SettingsProfile'
  import SettingsAddress from '../components/views/settings/SettingsAddress'
  import SettingsBudget from '../components/views/settings/SettingsBudget'
    import BudgetConfigs from '../components/views/settings/BudgetConfigs'
    import BudgetLists from '../components/views/settings/BudgetLists'
import Address from '../components/common/Address'
      import AddressList from '../components/views/address/address-list'
import OrderConfirmation from '../components/views/order-confirmation/OrderConfirmation'
import SearchProducts from '../components/containers/Search'
import SearchResults from '../components/views/widgets/searchProduct/search-results'
import ProductDetails from '../components/common/ProductDetails'
import ThankyouPage from '../components/common/thankyou'
import Search from '../components/common/search'
import DisplayModal from '../components/common/Modal'
import StateSelection from '../components/views/state-selection'
import ProductPage from '../components/common/Product'
import Store from '../components/views/widgets/store/Store'
import EBS from '../components/views/payment/EBS'
import Notifications from '../components/common/Notifications'
import ListCategoryProducts from '../components/views/category-products'
import ListBrandProducts from '../components/views/brand-products'
import OrderPage from '../components/common/Order'
import OrderDetail from '../components/views/orders/orders-details'
import CartPage from '../components/views/cart/CartPage'
import LoyaltyPointsPage from '../components/views/topbar/loyalty-points'
import HelpFAQs from '../components/containers/HelpFAQs'
  import FaqsList from '../components/views/help-faqs'
  import FaqCategoryDetails from '../components/views/help-faqs/CategoryDetails'
  import FaqAnswer from '../components/views/help-faqs/FaqAnswer'
import Feedback from '../components/views/feedback/Feedback'
{ /*import Inventory from '../components/containers/Inventory'
  import MyStore from '../components/views/inventory/my-store'
  import SetupMyStore from '../components/views/inventory/setup-my-store' */ }
import BudgetControl from '../components/views/widgets/budget'
import InviteSupplier from '../components/views/supplier/addSupplier'
import ShopSaleStatus from '../components/views/shop-sale-status'

import ReduxToastr from 'react-redux-toastr'

const appHistory = useRouterHistory(createHashHistory)({ queryKey: false })

export default (
  <div>
    <Router history={appHistory}>
      <Route path="/" component={MainLayout}>
        <IndexRedirect to="dashboard" />
        <Route path="dashboard" component={Dashboard} />
        <Route path="procure" component={Procure}>
              <IndexRedirect to="purchase-list" />
              <Route path="purchase-list-categories">
                <IndexRoute component={CategoryList} />
                <Route path=":categoryId" component={CategoryProducts} />
              </Route>
              <Route path="purchase-list" component={PurchaseList}/>
              <Route path="reorder-list" component={ReorderList} />
              <Route path="upload-po">
                <IndexRoute component={UploadPo} />
                <Route path="fetched-products" component={PurchaseOrderFetchedProducts}/>
              </Route>
        </Route>
        <Route path="orders" component={Orders} >
          <IndexRoute component={OrdersList} />
          <Route path=":id" component={OrderDetail} />
        </Route>
        <Route path="suppliers" component={Suppliers} >
          <IndexRedirect to="list" />
          <Route path="list" component={SupplierIndex} />
          {/*<Route path="details/:idQuotations" component={QuotationDetails} />*/}
        </Route>
        <Route path="quotations" component={Quotations} >
          <IndexRedirect to="home" />
          <Route path="list" component={QuotationLists} />
          <Route path="details/:idQuotations" component={QuotationDetails} />
          <Route path="home" component={QuotationHome} />
        </Route>
        <Route path="reports" component={Reports}>
              <IndexRedirect to="purchase-history-report" />
              <Route path="purchase-history-report" component={PurchaseHistoryReport} />
              <Route path="categories-report" component={CategoriesReport} />
              <Route path="location-based-report" component={LocationBasedReport} />
        </Route>
        <Route path="invoices-drs" component={Invoices}>
              <IndexRedirect to="invoices" />
              <Route path="invoices" component={InvoiceList} />
              <Route path="delivery-receipts" component={DeliveryReceipt} />
        </Route>
        <Route path="pending-payments" component={Payments}>
          <IndexRoute component={PendingPayments}/>
        </Route>
        <Route path="approvals" component={Approvals} >
          <IndexRoute component={ApprovalList} />
        </Route>
        <Route path="deals" component={Deals} />
        <Route path="services" component={Services} />
        <Route path="settings" component={Settings}>
              <IndexRedirect to="profile" />
              <Route path="profile" component={SettingsProfile} />
              <Route path="address" component={SettingsAddress} />
              <Route path="budget" component={SettingsBudget}>
                <IndexRedirect to="purchase-orders" />
                <Route path="purchase-orders" component={BudgetLists} />
                <Route path="configs" component={BudgetConfigs} />
              </Route>
        </Route>
        <Route path="address" component={Address}>
          <IndexRoute component={AddressList} />
        </Route>
        <Route path="searchProducts/" component={SearchProducts} >
            <IndexRedirect to="results/:query" />
            <Route path="results/:query" component={SearchResults} />
        </Route>
        <Route path="productdetails/:idProduct" component={ProductDetails} />
        <Route path="confirmation" component={OrderConfirmation} />
        <Route path="order/:id/:status/thankyou" component={ThankyouPage} />
        <Route path="search/:searchTerm" component={Search} />
        <Route path="product/:idProduct/:idSupplier" component={ProductPage} />
        <Route path="store" component={Store} />
        <Route path="skyscanner" component={SkyScanner} />
        { /*<Route path="expedia" component={Expedia} >
          <Route path="search" component={ExpediaSearch} />
          <Route path="hotel-info/:id" component={HotelInfo} />
        </Route>
        <Route path="zomato" component={Zomato} />
        <Route path="goibbo" component={Goibbo} /> */ }
        <Route path="payment" component={EBS} />
        <Route path="notifications" component={Notifications} />
        <Route path="category/:categoryId" component={ListCategoryProducts} />
        <Route path="cart" component={CartPage} />
        <Route path="loyalty-points" component={LoyaltyPointsPage} />
        <Route path="help-faqs" component={HelpFAQs} >
          <IndexRoute component={FaqsList} />
          <Route path="category/:faqCategoryDetail" component={FaqCategoryDetails} />
          <Route path="answer/:questionId" component={FaqAnswer} />
        </Route>
		    <Route path="brand/:idBrand" component={ListBrandProducts} />
        <Route path="feedback" component={Feedback} />
        {/*<Route path="inventory" component={Inventory}>
          <IndexRedirect to="my-store" />
          <Route path="my-store" component={MyStore} />
          <Route path="setup-my-store" component={SetupMyStore} />
        </Route>*/}
        <Route path="budget-configuration" component={BudgetControl} />
        <Route path="invite-supplier" component={InviteSupplier} />
      </Route>
    </Router>
    <ReduxToastr timeOut={2000} newestOnTop={false} position="bottom-center"/>
    <DisplayModal id={"cResponse"} contentID={"cResponseContent"} scrollHeight={150} modalSize="modal-small" closeBtnId="modal-close" title={"Cart Response"} />
    <DisplayModal id="viewOrder" contentID={"orderContent"} scrollHeight={250} title={"Order Details"}/>
    <DisplayModal id="viewProduct" contentID={"viewProductContent"} title={"Product Details"} />
    <DisplayModal id="addToExistingCart" contentID={"cartClearContent"} scrollHeight={100} title={"Cart is not Empty"}/>
    <DisplayModal id="approvalPaymentOptions" contentID={"paymemtContent"} scrollHeight={100} title={"Choose your payment mode"}/>
    <DisplayModal id="rejectOrder" contentID={"rejectContent"} scrollHeight={150} modalSize="modal-small" title={"Reject Order"}/>
    <DisplayModal id="reviseOrder" contentID={"reviseContent"} scrollHeight={100} modalSize="modal-small" title={"Revise Order"}/>
    <DisplayModal id={"loyaltyResponse"} contentID={"loyaltyResponseContent"} title={"Create Voucher"} />
    <DisplayModal id={"viewAddress"} contentID={"addressContent"} title={"Edit Address"} />
    <DisplayModal id={"addAddress"} contentID={"addAddressContent"} title={"Add Address"} />
    {/*<DisplayModal id={"requestQuote"} contentID={"requestQuoteContent"} title={"Request Quote"} />*/}
    <DisplayModal id={"viewWidget"} contentID={"viewWidgetContent"} title={"Widget Details"} />
    <DisplayModal id="vouchers" contentID={"voucherContent"} title={"Available Vouchers"} />
    <DisplayModal id="emailShare" contentID={"emailShareContent"} title={"Send Report as E-mail"} />
    <DisplayModal id="confirmationPop" contentID={"confirmationPopContent"} title={"Confirmation"} />
    <DisplayModal id="messagePop" contentID={"messagePopContent"} title={"Message"} />
    <DisplayModal id="otpPop" contentID={"otpPopContent"} title={"OTP"} />
    <DisplayModal id="poDetail" contentID={"poDetailedView"} title={"Purchase Order Details"} />
    <DisplayModal id="setPoOption" contentID={"setPoOptionContent"} title={"Choose PO Option"} />
    <DisplayModal id="confirmRegionChange" contentID={"confirmRegionChangeContent"} title={"Confirm Region Change"} />
    <DisplayModal id="spArea" contentID={"spLocaationContent"} title={"Select your area"} />
    <DisplayModal id="quotationConfirmation" contentID={"quotationConfirmationContent"} title={"Buy Now"} />
    <DisplayModal id="quotationMiniConfirmation" contentID={"quotationMiniConfirmationContent"} title={"Confirm Quotation"} />
    <DisplayModal id="quotationFormID" contentID={"quotationFormContent"} title={"Get Quotation"} />
    <ShopSaleStatus />
    <div>
      <input type="hidden" id="cr-o-id" value="" />
      <input type="hidden" id="ap-o-id" value="" />
    </div>
    <StateSelection />
  </div>
)
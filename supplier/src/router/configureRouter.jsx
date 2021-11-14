import React, { Suspense, lazy } from 'react'
import ReactDOM from 'react-dom'
import { HashRouter as Router, Route, Switch } from 'react-router-dom'
import { connect } from 'react-redux'
import ReduxToastr from 'react-redux-toastr'
import DisplayModal from '../components/common/Modal'
// import MainLayout from '../components/layouts/main-layout'
import { withAuthentication, checkLogged } from '../components/hoc/Authenticate'

const Loading = () => <div>Loading...</div>; 

const MainLayout   = lazy(() => import(/* webpackChunkName: "order" */ '../components/layouts/main-layout'));
const Dashboard   = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Dashboard'));
const Home        = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/home'));
const Quotations  = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Quotations'));
const Orders      = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Orders'));
const Catalog     = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Catalog'));
const Inventory   = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Inventory'));
const Setting     = lazy(() => import(/* webpackChunkName: "order" */ '../components/containers/Settings'));
const Feedback    = lazy(() => import(/* webpackChunkName: "order" */ '../components/modules/Feedback/Feedback'));


export default (
  <Router>
    <div>
        <Suspense fallback={<div id="preloader"><img src="./src/assets/img/preloader.gif" alt="loading" /> <span>Your shop is loading, please wait...</span></div>}>
          <Switch>
            <Route exact path="/" component={checkLogged(Home)} />            
            <Route exact path={"/signup/:id_group?/:id_customer?"} component={Home} />
            <MainLayout>
              <Route exact path="/dashboard" component={withAuthentication(Dashboard)}/>
              <Route path="/orders" component={withAuthentication(Orders)}/>
              <Route path="/quotations" component={withAuthentication(Quotations)}/>
              <Route path="/catalog" component={withAuthentication(Catalog)}/>
              <Route path="/inventory" component={withAuthentication(Inventory)}/>
              <Route exact path="/settings" component={withAuthentication(Setting)}/>
              <Route exact path="/feedback" component={withAuthentication(Feedback)}/>
            </MainLayout>
          </Switch>
          <ReduxToastr timeOut={4000} newestOnTop={false} position="bottom-center"/>
          <DisplayModal id={"orderHistory"} contentID={"orderHistoryContent"} closeBtnId="modal-close" title={"Order History"} />
          <DisplayModal id={"splitOrder"} contentID={"splitOrderContent"} closeBtnId="modal-close" title={"Split Order Details"} />
          <DisplayModal id={"confirmationPop"} contentID={"confirmationPopContent"} closeBtnId="modal-close" title={"Confirmation"} />
          <DisplayModal id={"supplierAddress"} contentID={"supplierAddressContent"} closeBtnId="modal-close" title={"Address"} />
          <DisplayModal id={"resetPassword"} contentID={"resetPasswordContent"} closeBtnId="modal-close" title={"Reset Password"} />
          <DisplayModal id={"confirmQuotation"} contentID={"confirmQuotationContent"} closeBtnId="modal-close" title={"Confirm Quotation"} />
          <DisplayModal id={"confirm"} contentID={"confirmContent"} closeBtnId="modal-close" title={"Confirm"} />
          <DisplayModal id={"CalendarPop"} contentID={"calendarPopContent"} closeBtnId="modal-close" title={"Schedule Delivery"} />
          <DisplayModal id={"uploadFiles"} contentID={"UploadFilesContent"} closeBtnId="modal-close" title={"Delivered"} />
          <DisplayModal id={"getDate"} contentID={"getDateContent"} closeBtnId="modal-close" title={"Date"} />
          <DisplayModal id={"inform"} contentID={"informContent"} closeBtnId="modal-close" title={"Information"} />
          <DisplayModal id={"report"} contentID={"reportContent"} closeBtnId="modal-close" title={"Download Reports"} />
          <DisplayModal id={"createInventory"} contentID={"createInventoryContent"} closeBtnId="modal-close" title={"Create Inventory"} />
          <DisplayModal id={"uploadInventory"} contentID={"uploadInventoryContent"} closeBtnId="modal-close" title={"Upload Inventory"} />
          <DisplayModal id={"addProductForm"} contentID={"addProductFormContent"} closeBtnId="modal-close" title={"Upload Products"} />
        </Suspense>
    </div>
  </Router>
)
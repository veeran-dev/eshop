import React, { Component,Suspense, lazy } from 'react';
import { Route} from "react-router-dom";

const Loading = () => <div>Loading...</div>; 
const Lists = lazy(() => import(/* webpackChunkName: "order" */ '.././modules/Orders/orders-list-index'));
const Details = lazy(() => import(/* webpackChunkName: "order" */ '.././modules/Orders/orders-details'));

const Orders = ({ match }) => (
  <div className="order-container">
  	<Suspense fallback={<div>Loading...</div>}>
	    <Route exact path={match.url} component={Lists} />
	    <Route path={`${match.url}/view/:id_order`} component={Details} />
    </Suspense>
  </div>
)

export default Orders;
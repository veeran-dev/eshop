import React, { Component,Suspense, lazy } from 'react';
import { Route} from "react-router-dom";
import { NavLink } from 'react-router-dom'
import Ripples from 'react-ripples';

const Loading = () => <div>Loading...</div>; 
const Lists = lazy(() => import(/* webpackChunkName: "order" */ '../modules/Quotations/quotation-requests-list'));
const Customers = lazy(() => import(/* webpackChunkName: "order" */ '../modules/Quotations/accept-customer'));

const Quotations = ({ match }) => (
  <div className="quotation-container">
  	<div className="page-header">
	    <div className="page-filter">                    
	        <div className="default-duration-filter procure-nav">
	            <Ripples className="button-group-item">
	                <NavLink className="button" activeClassName="active" to={`${match.url}/home`}>Quotations</NavLink>
	            </Ripples>
	            <Ripples className="button-group-item">
	                <NavLink className="button" activeClassName="active" to={`${match.url}/buyers`}>Accept Buyers</NavLink>
	            </Ripples>
	        </div>
	    </div>
	</div>
  	<Suspense fallback={<div>Loading...</div>}>
	    <Route exact path={`${match.url}/home`} component={Lists} />
	    <Route exact path={`${match.url}/buyers`} component={Customers} />
    </Suspense>
  </div>
)

export default Quotations;
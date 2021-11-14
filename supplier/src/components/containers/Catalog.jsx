import React, { Component,Suspense, lazy } from 'react';
import { HashRouter as Router, Route, Switch} from "react-router-dom";
// import Index from '.././modules/Catalog/catalog-index'
// import Upload from '.././modules/Catalog/product-upload'
// import RateContract from '.././modules/Catalog/RateContract/rate-contract'
// import Products from '.././modules/Catalog/Products/product-list'

import { NavLink } from 'react-router-dom'
import Ripples from 'react-ripples';

const Upload = lazy(() => import('.././modules/Catalog/product-upload'));
const RateContract = lazy(() => import('.././modules/Catalog/RateContract/rate-contract'));
const Products = lazy(() => import('.././modules/Catalog/Products/product-list'));

const Catalog = ({ match }) => {
	return (
            <div className="catalog-container">
                <div className="page-header">
                    <div className="page-filter">                    
                        <div className="default-duration-filter procure-nav">
                            <Ripples className="button-group-item">
                                <NavLink className="button" activeClassName="active" to={`${match.url}/home`}>Upload</NavLink>
                            </Ripples>
                            <Ripples className="button-group-item">
                                <NavLink className="button" activeClassName="active" to={`${match.url}/rate-contract`}>Rate Contracts</NavLink>
                            </Ripples>
                            <Ripples className="button-group-item">
                                <NavLink className="button" activeClassName="active" to={`${match.url}/product-list`}>Product List</NavLink>
                            </Ripples>
                        </div>
                    </div>
                </div>
                <Suspense fallback={<div>Loading...</div>}>
                 <Switch>
	                <Route path={`${match.url}/home`} component={Upload} />
			    	<Route path={`${match.url}/rate-contract`}  component={RateContract} />
			    	<Route path={`${match.url}/product-list`}  component={Products} />
		    	 </Switch>
		    	</Suspense>
            </div>
        )
}

export default Catalog;


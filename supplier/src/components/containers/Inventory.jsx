import React, { Component,Suspense, lazy } from 'react';
import { HashRouter as Router, Route, Switch} from "react-router-dom";
import { NavLink } from 'react-router-dom'
import Ripples from 'react-ripples';

const InventoryList = lazy(() => import('.././modules/Inventory/inventory-list-index'));

const Inventory = ({ match }) => {
	return (
            <div className="catalog-container">
                <Suspense fallback={<div>Loading...</div>}>
                 <Switch>
	                <Route path={`${match.url}`} component={InventoryList} />
		    	 </Switch>
		    	</Suspense>
            </div>
        )
}

export default Inventory;


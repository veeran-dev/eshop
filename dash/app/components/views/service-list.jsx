import React from 'react';
import Ripples from 'react-ripples';
import { openRequestQuote } from '../../api/common-api' 

// Using "Stateless Functional Components"
export default function(props) {
  return (
    <div className="services">
		<div className="page-header">
			<h3 className="page-title">Services</h3>
    		<div className="action-block">
    			{/*<Ripples><button className="button-red outline" onClick={openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
    		</div>
		</div>
		<div className="services-container">
			<h1 className="gray-color-tex">Coming Soon..!</h1>
		</div>
	</div>
  );
}

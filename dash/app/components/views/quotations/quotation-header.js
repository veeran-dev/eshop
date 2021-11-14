import React from 'react'
import { Link } from 'react-router'
import Ripples from 'react-ripples';

class QuotationHeader extends React.Component {
    render() {
        return (
            <div className="page-header">
		    	<h3 className="page-title">Quotations</h3>
		    	<div className="page-filter">
			    	<div className="sub-page-filter">
				    	<Ripples className="button-group-item">
							<Link className="button" to="quotations/home" activeClassName="active">Quotations</Link>
						</Ripples>
						<Ripples className="button-group-item">
							<Link className="button" to="quotations/list" activeClassName="active">Quotation Lists</Link>
						</Ripples>
					</div>
		    	</div>
          		<div className="action-block">
          			{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
          		</div>				    	
		    </div>
        )
    }
}

export default QuotationHeader


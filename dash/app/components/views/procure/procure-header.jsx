import React from 'react'
import { Link } from 'react-router'
import Ripples from 'react-ripples'
import { openRequestQuote } from '../../../api/common-api' 


class ProcureHeader extends React.Component {
    render() {
        return (
            <div className="page-header">
                <h3 className="page-title">Procure/Buy</h3>
                <div className="page-filter">                    
                    <div className="sub-page-filter procure-nav">
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/purchase-list">Purchase List</Link>
                        </Ripples>
                        <Ripples className="button-group-item">
                             <Link className="button" activeClassName="active" to="procure/upload-po">Order by Excel</Link>
                        </Ripples>
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/reorder-list">Reorder List</Link>
                        </Ripples>
                        
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/purchase-list-categories">Category</Link>
                        </Ripples>
                        
                    </div>
                </div>
                <div className="action-block">
                    {/*<Ripples><button className="button-red outline" onClick={openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
                </div>
            </div>
        )
    }
}

export default ProcureHeader


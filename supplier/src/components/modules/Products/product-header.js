import React from 'react'
import { Link } from 'react-router-dom'
import Ripples from 'react-ripples'


class ProductHeader extends React.Component {
    render() {
        return (
            <div className="page-header">
                <h3 className="page-title">My Catalog</h3>
                <div className="page-filter">                    
                    <div className="default-duration-filter procure-nav">
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/purchase-list">Product List</Link>
                        </Ripples>
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/purchase-list">Upload by Excel</Link>
                        </Ripples>
                        <Ripples className="button-group-item">
                            <Link className="button" activeClassName="active" to="procure/reorder-list">Price List</Link>
                        </Ripples>
                    </div>
                </div>
            </div>
        )
    }
}

export default ProductHeader


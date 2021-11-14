import React from 'react'
import { Link } from 'react-router-dom'
import Ripples from 'react-ripples'


const CatalogHeader = ({children}) => {
    console.log(children)
        return (
            <div className="catalog-container">
                <div className="page-header">
                    <h3 className="page-title">My Catalog</h3>
                    <div className="page-filter">                    
                        <div className="default-duration-filter procure-nav">
                            <Ripples className="button-group-item">
                                <Link className="button" activeClassName="active" to="catalog">Upload Products</Link>
                            </Ripples>
                            <Ripples className="button-group-item">
                                <Link className="button" activeClassName="active" to="catalog/product-list">Product List</Link>
                            </Ripples>
                        </div>
                    </div>
                </div>
                {children}
            </div>
        )
}

export default CatalogHeader


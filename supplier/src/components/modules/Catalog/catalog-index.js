import React from 'react'
import { Link } from 'react-router-dom'
import Ripples from 'react-ripples'


const CatalogIndex = ({children}) => {
    console.log(children)
        return (
            <div className="catalog-container">
                <div className="page-header">
                    <div className="page-filter">                    
                        <div className="default-duration-filter procure-nav">
                            <Ripples className="button-group-item">
                                <Link className="button" activeclassname="active" to="catalog/">Upload Catalog</Link>
                            </Ripples>
                            <Ripples className="button-group-item">
                                <Link className="button" activeclassname="active" to="catalog/rate-contract">Rate Contracts</Link>
                            </Ripples>
                            <Ripples className="button-group-item">
                                <Link className="button" activeclassname="active" to="catalog/catalog-list">Product List</Link>
                            </Ripples>
                        </div>
                    </div>
                </div>
                {children}
            </div>
        )
}

export default CatalogIndex


import React from 'react'
import ReactDOM from 'react-dom';
import ReactImageFallback from "react-image-fallback";
import QuotationForm from '../views/quotations/quotation-form'
import store from '../../store/configureStore'
import * as G from '../../api/common-api';
class ProductBox extends React.Component {
    
    toProduct =(id) =>{
        // let old_url = window.location.href;
        // var new_url = old_url.substring(0, old_url.indexOf("searchProducts"));
        // var win = window.open(new_url+'productdetails/'+id, '_blank');
        // win.focus();
        console.log("showQuoteForm");
        ReactDOM.render(<QuotationForm getQuantity={true} minimalQuote={true} store={store} idProduct={id}/>, document.getElementById("quotationFormContent"))
        G.displayModal("quotationFormID")
    }
    
    render() {
        let ratingsElem = [];
        for(var j = 0; j < 5; j++){
            if(this.props.product.ratings.grade > j)
                ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
            else
                ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
        }
        return (
            <div className="sp-product-container">
                <div className="sp-image-wrapper">
                    <div className="sp-supplier-count">
                        <span>{this.props.product.supplier_count > 0 ? this.props.product.supplier_count: "NA"}</span>
                        <span>Supplier</span>
                    </div>
                    <div className="image-container">
                        <ReactImageFallback
                            src={this.props.product.imageLink2}
                            fallbackImage="./img/p/en-default-large.jpg"
                            initialImage="./img/p/en-default-large.jpg"
                            alt={this.props.product.name}/>
                    </div>
                </div>
                <div className="sp-name">
                    {this.props.product.name}
                </div>
                <div className="sp-reference">{this.props.product.reference}</div>
                <div className="sp-details">
                    <div className="sp-price">
                        <div>Standard Price</div>
                        <div>₹ {parseFloat(this.props.product.price).toFixed(2)}</div>
                    </div>
                    <div className="sp-ratings">
                        <div>
                            {ratingsElem}
                        </div>
                        <div>{this.props.product.ratings.grade > 0 ? this.props.product.ratings.grade+" Ratings": "No Ratings"}</div>
                    </div>
                </div>
                <div className="sp-cta">
                    <button className="button-large button-blue" onClick={this.toProduct.bind(this, this.props.product.id_product)}>Get Quotations</button>
                </div>
            </div>
        )
    }
}
ProductBox.contextTypes = {
  router: React.PropTypes.object.isRequired
};
export default ProductBox


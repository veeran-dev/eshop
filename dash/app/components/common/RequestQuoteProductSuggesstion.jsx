import React from 'react'
import Input from './Input'
import * as G from '../../api/common-api'

class RequestQuoteProductSuggesstion extends React.Component{
	constructor(props){
		super(props)
	}

	render(){
		return(
			<div className="product-result zoomIn animated">
				<div className="product-visual">
					<img src={this.props.data[0].imageLink} alt={this.props.data[0].name} />
				</div>
		        <div className="product-info">
					<h3>{this.props.data[0].name ? this.props.data[0].name : "--"}</h3>
					<p><span>Reference: {this.props.data[0].reference}</span> <span>{this.props.data[0].manufacturer != null ? "Brand: " + this.props.data[0].manufacturer : null}</span></p>
					<p></p>
					<p className="product-price"><span className="red-color-text">{G.formatPrice(this.props.data[0].price)}</span><span className="product-tax-label"> (Incl. of Tax)</span></p>
				{/*
					{this.props.data[0].features.length ? <div className="features"><p>{this.props.data[0].features[1]['name'] ? (this.props.data[0].features[1]['name']+": "+this.props.data[0].features[1]['value']) : "--"}</p>
		        <p>{this.props.data[0].features[2]['name'] ? (this.props.data[0].features[2]['name']+": "+this.props.data[0].features[2]['value']) : "--"}</p>
		        <p>{this.props.data[0].features[3]['name'] ? (this.props.data[0].features[3]['name']+": "+this.props.data[0].features[3]['value']) : "--"}</p></div> : null}
				*/}
				</div>
				<Input type="hidden" inputValue={this.props.data[0].id_product} name="id_product" id={"productCode"}/>
				<Input type="hidden" inputValue={this.props.data[0].name} name="product_name" id={"productName"}/>
		    </div>
		)
	}
}

export default RequestQuoteProductSuggesstion
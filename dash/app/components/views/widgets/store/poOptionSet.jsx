import React from 'react'
import ReactDOM from 'react-dom'
import { Link } from 'react-router'
import * as G from '../../../../api/common-api'
import Ripples from 'react-ripples'

class poOptionSet extends React.Component {
	constructor(props){
		super(props)
	}

	installWidget(idWidget, isPaid, active, position, id_option){
		G.installWidget(idWidget, isPaid, active, position, id_option, this.props.route);
	}

	render(){
		return (
		    <div className="set-po-option">
				<h2>Choose a type to configure PO</h2>
				<div className="button-container">
					<div className="button-item disabled">
						<button onClick={this.installWidget.bind(this, this.props.idWidget, 0, 1, 0, 1)}>
							<img src="dash/img/product-based.png" />
							<h3>Product Limit</h3>
							<p>Set limit on the number of products.</p>
						</button>
					</div>
					<div className="button-item">
						<button onClick={this.installWidget.bind(this, this.props.idWidget, 0, 1, 0, 2)}>
							<img src="dash/img/value-based.png" />
							<h3>Value Limit</h3>
							<p>Set limit on the total expense value.</p>
						</button>
					</div>
				</div>
		    </div>
	    )
	}
}

export default poOptionSet;
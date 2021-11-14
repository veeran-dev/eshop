import React, { Component } from 'react'

class ConfirmCityChange extends Component {
	render() {
		return (
			<div className="modal-wrapper">
				<div className="modal-message">
					<p>You have changed the region from <strong>{this.props.oldCity}</strong> to <strong>{this.props.newCity}</strong>, so the products which are not available in <strong>{this.props.newCity}</strong> will be removed from your cart.</p>
				</div>
				<div className="modal-footer">
					<button className="button-red outline" type="button" onClick={this.props.dismissCityChange}>Dismiss Changing Region</button>
					<button className="button-red" type="button" onClick={this.props.setDeliveryRegion.bind(this, this.props.regionId, this.props.newCity, 0)}>Change Region and Update Cart</button>
				</div>
			</div>
		)
	}
}

export default ConfirmCityChange
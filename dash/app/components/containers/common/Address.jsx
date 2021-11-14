import React from 'react'

class Address extends React.Component {
    render() {
        return (
        	<div className="address-container">
        		{this.props.children}
			</div>
    	)
    }
}

export default Address
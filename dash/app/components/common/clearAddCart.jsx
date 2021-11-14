import React from 'react'

class ClearAddCart extends React.Component{
	constructor(props){
		super(props)
	}

  	render(){
      return(
        <div className="modal-wrapper">
          <div className="modal-message">
            <p>Your cart contains the products that you have already added. Do you want us to add the current re-ordered products to the existing cart or do you want to empty and add the re-ordered products?</p>
          </div>
          <div className="modal-footer">
            <button className="button-red outline" onClick={this.props.addToExist}>Update Cart</button>
            <button className="button-red" onClick={this.props.clearAndAdd}>Clear Cart & Add products</button>
          </div>
        </div>
      )
    }
}

export default ClearAddCart
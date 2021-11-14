import React from 'react'

class CartResponse extends React.Component{
	constructor(props){
		super(props)
	}

	render(){
		return(
			<div>
		        <table>
		          <thead>
		            <tr>
		              <th>Product Name</th>
		              <th>Reasons</th>
		            </tr>
		          </thead>
		          <tbody>
		            {this.props.data.map((data, i) => {
		              return(
		                <tr key={i}>
		                  <td>{data.name}</td>
		                  <td>{data.message}</td>
		                </tr>
		              )
		            })}
		          </tbody>
		        </table>
		    </div>
		)
	}
}

export default CartResponse
import React from 'react'

class CartResponse extends React.Component{
	constructor(props){
		super(props)
	}

	reload() {
		location.reload();
	}

	render(){
		const {data, reload} = this.props
		if(reload) {
			document.getElementById('modal-close').classList.add('disabled');
		}
		return(
			<div className="modal-wrapper">
				<div className="modal-message">
			        <table>
			          <thead>
			            <tr>
			              <th>Product Name</th>
			              <th>Reasons</th>
			            </tr>
			          </thead>
			          <tbody>
			            {data.map((data, i) => {
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
			    {reload ? <div className="modal-footer"><button className="button-red outline" type="button" onClick={this.reload}>OK</button></div> : null} 
		    </div>
		)
	}
}

export default CartResponse
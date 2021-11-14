import React from 'react'
import * as G from '../../api/common-api'
import * as cartApi from '../../api/cart-api'
import serialize from 'form-serialize'
import { Scrollbars } from 'react-custom-scrollbars'
import Input from '../../components/common/Input'

class VouchersList extends React.Component{
	constructor(props){
		super(props)
	}

	handleVoucher(type, idDiscount, discountName){
		if(type == 0)
			cartApi.applyDiscount(idDiscount, discountName)
		else
			cartApi.deleteDiscount(idDiscount, discountName)
	}

	render(){
		let usedVouchers = this.props.used
		let usedVouchersArray = new Array(), btnToggleApply = "", btnToggleCancel = ""
		if(usedVouchers.length > 0){
			for(var i = 0; i < usedVouchers.length; i++)
				usedVouchersArray.push(usedVouchers[i].id_cart_rule)
		}
		
		return(
			<div className="modal-message">
				<Scrollbars autoHide autoHideTimeout={1000} autoHideDuration={200} style={{ height: '300px'}}>
		            <table>
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Code</th>
		                  <th>Value</th>
		                  <th>Tax</th>
		                  <th>Description</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		                {this.props.data.map((data, i) => {
		                  if(usedVouchersArray.length > 0) {
								if(usedVouchersArray.indexOf(data.id_cart_rule) != -1){
									btnToggleApply = "hidden"
									btnToggleCancel = ""
								}
								else{
									btnToggleCancel = "hidden"
									btnToggleApply = ""		
								}
						  }
						  else {
						  	btnToggleCancel = "hidden"
							btnToggleApply = ""		
						  }
		                  return(
		                    <tr key={i}>
		                      <td>{data.name}</td>
		                      <td>{data.code}</td>
		                      <td>{data.value}</td>
		                      <td>{data.reduction_tax == 0 ? "Tax Excl." : "Tax Incl."}</td>
		                      <td>{data.description}</td>
		                      <td>
		                      	<button id={"apply-discount-"+data.id_cart_rule} className={"button-blue outline " + btnToggleApply} onClick={this.handleVoucher.bind(this, 0, data.id_cart_rule, data.code)}>Apply</button>
		                      	<button id={"delete-discount-"+data.id_cart_rule} className={"button-red outline " + btnToggleCancel} onClick={this.handleVoucher.bind(this, 1, data.id_cart_rule, data.code)}>Cancel</button>
		                      </td>
		                    </tr>
		                  )
		                })}
			          </tbody>
		            </table>
		        </Scrollbars>
            </div>
		)
	}
}

export default VouchersList
import React from 'react'
import * as G from '../../api/common-api'
import * as cartApi from '../../api/cart-api'
import serialize from 'form-serialize'
import { Scrollbars } from 'react-custom-scrollbars'
import {toastr} from 'react-redux-toastr'
import Input from '../../components/common/Input'

class LoyaltyPoints extends React.Component{
	constructor(props){
		super(props)
		this.state = {
			totalLoyaltyPoints: 0,
			totalLoyaltyValue: 0
		}
	}

	selectAllPoints(event){
		G.selectAllCheckBox(event.target.checked, ["loyaltyPointsCheck"])
		this.calculateLoyalty()
	}

	calculateLoyalty(){
		let loyaltyPointElems = document.getElementsByClassName("loyaltyPointsCheck")
		let totalPoints = 0
		for(var i = 0; i < loyaltyPointElems.length; i++){
			if(loyaltyPointElems[i].checked == true)
				totalPoints += parseInt(loyaltyPointElems[i].value.split("-")[1])
		}

		this.setState({totalLoyaltyPoints: totalPoints, totalLoyaltyValue: (parseInt(totalPoints) * this.props.pointValue)})
	}

	generateVoucher(){
		let loyaltyPointsForm, loyaltyPointsObj, checkedPoints = false
		let loyaltyPointElems = document.getElementsByClassName("loyaltyPointsCheck")
		
		for(var i = 0; i < loyaltyPointElems.length; i++){
			if(loyaltyPointElems[i].checked == true)
				checkedPoints = true
		}

		if(checkedPoints) {
			loyaltyPointsForm = document.querySelector('#loyaltyPointsForm')
	    	loyaltyPointsObj = serialize(loyaltyPointsForm, { hash: true })
	    	cartApi.generateVoucher(loyaltyPointsObj.loyaltyPoints, this.state)
		}
		else {
			toastr.error("Error", "Please select atleast one loyalty point.", {icon: 'icon-error'})
		}
	}

	render(){
		return(
			<div className="modal-wrapper">
				<div className="modal-message create-voucher">
					<Scrollbars autoHide autoHideTimeout={1000} autoHideDuration={200} style={{ height: '200px'}}>
									<form id={"loyaltyPointsForm"}>
										<table className="widget-compressed-table">
											<thead>
												<tr>
													<th>
														<div title="Select All">
															<Input type="checkbox" id="selectAllLoyalty" onChange={this.selectAllPoints.bind(this)} />
															<label htmlFor="selectAllLoyalty"></label>
														</div>
													</th>
													<th>Order ID</th>
													<th>Date</th>
													<th>Points</th>
													<th>Amount</th>
												</tr>
											</thead>
											<tbody>
												{this.props.data.map((data, i) => {
													return(
														<tr key={i}>
															<td>
																<div>
																		<Input type="checkbox" name={"loyaltyPoints[]"} inputValue={data.id+"-"+data.points+"-"+data.id_loyalty} onChange={this.calculateLoyalty.bind(this, data.id_loyalty)} className="loyaltyPointsCheck" id={"selectLoyalty_"+data.id_loyalty} />
																		<label htmlFor={"selectLoyalty_"+data.id_loyalty}></label>
																</div>
															</td>
															<td>{data.id}</td>
															<td>{data.date_add}</td>
															<td>{parseInt(data.points) > 0 ? parseInt(data.points) : 0}</td>
															<td>{parseInt(data.points) > 0 ? ("₹"+(parseInt(data.points)) * this.props.pointValue) : "₹ 0"}</td>
														</tr>
													)
												})}
										</tbody>
										</table>
								</form>
							</Scrollbars>
							<div className="create-voucher-total">
		        		<p>Total Points to be used: <span>{this.state.totalLoyaltyPoints}</span></p>
		        		<p>Voucher value to be generated: <span>{"₹ " + this.state.totalLoyaltyValue}</span></p>
		        	</div>
						</div>
						<div className="modal-footer">
							<button className="button-red" onClick={this.generateVoucher.bind(this)}>Generate Voucher</button>
						</div>
            </div>
		)
	}
}

export default LoyaltyPoints
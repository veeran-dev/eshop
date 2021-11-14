import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import store from '../../../store/configureStore';
import * as G from '../../../api/common-api';
import Ripples from 'react-ripples';
import Input from '../../../components/common/Input';
//import storeInventory from '../../../api/inventory';

class Inventory extends React.Component {
  constructor(props){
    super(props)
  }

  saveMyStore() { 
	storeInventory.saveMyCostCenter(this.ref.cost_center_name,this.ref.cost_center_description) 
  }

  render() {
    return(
      <div>{/*whole page */}
		
		<div>{/*Step panel*/}
			<div>
			  <div className="page-header">
				<h3 className="page-title">Inventory</h3>
				<div className="page-filter" >
					<Ripples className="button-group-item blue">
						<button type="button">My Store</button>
					</Ripples>
					<Ripples className="button-group-item blue">
						<button type="button">Setup My Store</button>
					</Ripples>
				</div>
			  </div> 
			  <div className="column-content-container">
				  <div className="page-container ">
					<div className="col-md-3">
						<input className="form-control" type="text" name="cost_center_name"   ref="cost_center_name" />
						<input className="form-control" type="text" name="cost_center_description"   ref="cost_center_description" />
					</div>
					<div className="col-md-3">
						<input className="form-control button-blue" type="button" onClick={this.saveMyStore.bind(this)} value="Add Cost Center" />
					</div>
				  </div>
			  </div>
			</div>
			
		</div>
      </div>
    )
  }
}

Inventory.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(Inventory);
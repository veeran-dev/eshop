import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import store from '../../../../store/configureStore';
import Input from '../../../../components/common/Input';

class ValueBasedBudget extends React.Component {
  constructor(props){
    super(props)
  }

  render() {
    return(
      <div>
        <div className={"active"}>
          <h4 className="block-title">Set expense limit for your PO</h4>
          <div className="po-set-value">
            <div className="control-group">
              <label for="poNumber">Amount </label>
              <div className="input-with-symbol">
                <span className="symbol">₹</span>
                <Input type="number" name="poValue" id="poValue" onChange={this.props.handleInputChange} inputValue={this.props.state.poValue} placeholder="Enter Purchase Order Value in ₹" />
              </div>
            </div>
          </div>
          <h4 className="block-title">Upload PO</h4>
          <div className="po-upload">
            <div className="control-group">
              <label>Click choose PO to attach the soft copy</label>
              <form id="upload-purchase-order" method="post" encType="multipart/form-data">
                <input 
                  type="file" 
                  name="excel-file" 
                  id="upload-purchase-order-budget-input" 
                  className="file-input" onChange={this.props.fileInputHandler}
                  placeholder="Choose PO" />
                <label htmlFor="upload-purchase-order-budget-input">{this.props.state.selectedExcel}</label>
              </form>
            </div>
          </div>
        </div>
      </div>
    )
  }
}

ValueBasedBudget.contextTypes = {
  router: React.PropTypes.object.isRequired
};

export default ValueBasedBudget;
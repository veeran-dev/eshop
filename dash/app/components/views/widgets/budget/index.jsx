import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';
import * as procureApi from '../../../../api/procure-buy-api'
import * as addressApi from '../../../../api/address-api'
import Ripples from 'react-ripples';
import Input from '../../../../components/common/Input';
import WidgetNotInstalled from '../../../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../../../common/empty-states/widget-no-access';
import DayPick from '../../../common/datepickerSingle';
import serialize from 'form-serialize';
import Select from 'react-select';
import ProductBased from './product-based';
import ValueBased from './value-based';
import moment from 'moment'

class BudgetControl extends React.Component {
  constructor(props){
    super(props)
    this.state = {
    	poNumber: "",
    	poDate: null,
    	poFromDate: null,
    	poToDate: null,
    	isUploadingPo: false,
    	selectedExcel: "Choose PO",
    	disabled_step: true,
    	errors: false,
    	productsBlock: "active",
    	addressBlock: "hidden",
    	activeProducts: [],
      value: [],
      poValue: 0
    }
  }

  componentWillMount() {
  	G.checkWidget(17, true)
  }

  componentDidMount() {
  	addressApi.get();
  }

  handleInputChange(event) {
  	this.setState({
  		[event.target.id] : event.target.value
  	})
  }

  fileInputHandler(e){
    if(e.target.files[0].size < 5242880) {
      const fileName = e.target.files[0].name;
      this.setState({selectedExcel: fileName})
    }
    else {
      toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
    }
  }

  upload(e) {
    procureApi.uploadBudgetPO(this.context.router, this.state.poNumber);
    e.preventDefault();
  }

  download() {
  	const { poNumber, poDate, poFromDate, poToDate } = this.state;
    procureApi.downloadBudgetPurchaseOrder(poNumber, poDate, poFromDate, poToDate);
  }

  isNumeric = (n) => {
    return !isNaN(parseInt(n)) && isFinite(n);
  }

  complete() {
  	const { id_address: poAddress } = this.state.value;
    var poNumber = this.state.poNumber;
    var details = "";
    if(budgetOption == 1) {
  	   details = serialize(document.getElementById("purchaseOrderProducts"), { hash: true }).activeProducts;
    }
    else {
       details = this.state.poValue;
    }

    var poDateHidden = document.getElementById("poDateHidden").value;
    var poValidFromHidden = document.getElementById("poValidFromHidden").value;
    var poValidThroughHidden = document.getElementById("poValidThroughHidden").value;
    var poDate = (poDateHidden ? G.getDate(poDateHidden, "dd-mm-yyyy") : "");
    var poFromDate = (poValidFromHidden ? G.getDate(poValidFromHidden, "dd-mm-yyyy") : "");
    var poToDate = (poValidThroughHidden ? G.getDate(poValidThroughHidden, "dd-mm-yyyy") : "");

    if(poValidFromHidden == '') {
      poValidFromHidden = moment();
    }

    var poValidThrough = moment(poValidThroughHidden).format('LL');
    var poValidFrom = moment(poValidFromHidden).format('LL');

    if(poNumber.replace(/^\s+|\s+$/gm,'') == "") {
      toastr.error("Error", "PO Number Cannot be empty.", {icon: "icon-error"});
    }
    else if(poDate == "") {
      toastr.error("Error", "PO Date Cannot be empty.", {icon: "icon-error"});
    }
    else if(poToDate == "") {
      toastr.error("Error", "PO valid through date cannot be empty.", {icon: "icon-error"});
    }
    else if(!moment(poValidThrough).isSameOrAfter(poValidFrom)) {
      toastr.error("Error", "PO valid through date cannot be lesser than valid from date.", { icon: 'icon-error' });
    }
  	else if(poAddress == "" || poAddress == undefined || !this.isNumeric(poAddress)) {
  		toastr.error("Error", "Please select atleast one address.", {icon: "icon-error"});
  	}
  	else if(details == "" || details == undefined || details == 0) {
  		toastr.error("Error", (budgetOption == 1 ? "Please upload atleast one product." : "Please give purchase value to proceed."), {icon: "icon-error"});
  	}
    else if(!isNaN(details) && details < 0) {
      toastr.error("Error", "Negative numbers not allowed.", { icon: "icon-error" });
    }
  	else {
		  procureApi.configureBudget(poNumber, poDate, poFromDate, poToDate, details, poAddress, this);
  	}
  }

  handleSelectChange = (value) => {
    this.setState({value});
  }

  render() {
    const { addresses, purchaseOrderProducts } = this.props;
    if(addresses != "") {
      for(var k = 0; k < addresses.length; k++) {
        addresses[k].value = addresses[k].id_address;
        addresses[k].label = addresses[k].alias+"-"+addresses[k].company;
      }
    }

    return(
      <div>
      	{(this.props.widgetStatus == 1) ? 
      			<div className="add-po-container">
	      			<div className="page-header">
	      				<h3 className="page-title">PO Configuration Panel</h3>
	      			</div>
	      			<div className="page-container">
                <h4 className="block-title">Enter PO Information</h4>
                <div className="po-information-header">
  	      				<div className="po-information">
                    <div className="po-information-left">
                      <div className="control-group">
                        <label for="poNumber">PO Number</label>
                        <Input 
                          type="text" 
                          name="poNumber" 
                          id="poNumber" 
                          onChange={this.handleInputChange.bind(this)} 
                          inputValue={this.state.poNumber} 
                          placeholder="Ex: 1000, AB1000, 100XYZ00 etc.," />
                      </div>

                      <div className="control-group">
                        <label for="poValidFrom">Valid from</label>
                        <DayPick 
                          hiddenId="poValidFromHidden" 
                          primaryId="poValidFrom" 
                          name="poValidFrom"
                          placeholder="Select valid from date"
                          fileldFill={false}
                          datePickerClass=""
                          onChange={(value) => this.setState({ poFromDate: value })}
                        />
                      </div>
                    </div>

                    <div className="po-information-right">
                      <div className="control-group">
                        <label for="poDate">PO Date</label>
                        <DayPick 
                          hiddenId="poDateHidden" 
                          primaryId="poDate" 
                          name="poDate"
                          placeholder="Select PO Date"
                          fileldFill={false}
                          datePickerClass=""
                          onChange={(value) => this.setState({ poDate: value })}
                        />
                      </div>

                      <div className="control-group">	
                        <label for="poValidThrough">Valid through</label>
                        <DayPick 
                          hiddenId="poValidThroughHidden" 
                          primaryId="poValidThrough" 
                          name="poValidThrough"
                          placeholder="Select expiry date"
                          fileldFill={false}
                          datePickerClass=""
                          onChange={(value) => this.setState({ poToDate: value })}
                        />
                      </div>
                    </div>
  	      				</div>
                  <div className="po-address po-information">
                    <div className="control-group">
                      <label for="selectAddress">Select Address</label>
                      <Select 
                        isMulti={false}
                        id="selectCabinCrews"  
                        className='react-select-container'
                        classNamePrefix='react-select'
                        placeholder="Select your preferred delivery location." 
                        options={addresses} 
                        value={this.state.value}
                        onChange={(value) => this.setState({ value })} 
                        ref={component => { this.addresses = component }} 
                      />
                    </div>
                  </div>
                </div>
                {budgetOption == 1 ? 
                  <ProductBased 
                    purchaseOrderProducts={purchaseOrderProducts} 
                    complete={this.complete.bind(this)} 
                    fileInputHandler={this.fileInputHandler.bind(this)}
                    upload={this.upload.bind(this)}
                    state={this.state}
                    isUploadingPo={this.props.isUploadingPo} 
                    download={this.download.bind(this)}
                  /> 
                : 
                  <ValueBased 
                    handleInputChange={this.handleInputChange.bind(this)}
                    state={this.state}
                    fileInputHandler={this.fileInputHandler.bind(this)}
                  />
                }
                <div className="action-block">
                    <button type="button" className="button-blue" onClick={this.complete.bind(this)}><i className="icon-check"></i> Submit and Proceed</button>
                </div>
	      			</div>
	      		</div> : 
    	(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={17} /> : 
     	(this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
      </div>
    )
  }
}

BudgetControl.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus,
  	isUploadingPo: store.procureBuyState.isUploadingPo,
  	purchaseOrderProducts: store.procureBuyState.purchaseOrderProductsBudget,
  	addresses: store.addressState.address
  };
};

export default connect(mapStateToProps)(BudgetControl);
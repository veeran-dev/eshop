import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../../store/configureStore'
import * as cartApi from '../../../api/cart-api'
import { getGroupInfo } from '../../../api/common-api'
import Input from '../../../components/common/Input'
import DisplayModal from '../../../components/common/Modal'

class Vouchers extends React.Component {
    constructor(props){
        super(props)
        this.state = {
          inputPO: "Upload PO"
        }
    }

    componentDidMount() {
      getGroupInfo();
    }

    viewVouchers(){
      cartApi.loadDicounts()
    }

    applyDiscount(e){
      e.preventDefault();
      let voucherInput = document.getElementById("voucherCode");
      if(voucherInput.value == ""){
        toastr.error("Error", "Please enter voucher code", {icon: "icon-error"})
      }
      else{
        cartApi.applyDiscount(0, voucherInput.value)
      }
    }

    viewLoyaltyPoints(){
      cartApi.viewLoyaltyPoints()
    }

    _fileInputHandler(e){
      let fileName = e.target.files[0].name.split('.');
      let file_ext = fileName[fileName.length-1];
      let extentions = ['PNG','png','jpg','JPEG','xls','xlsx','pdf'];
      if(!extentions.includes(file_ext)){
        toastr.error("Error", "Please upload valid files", {icon: "icon-error"})
        document.getElementById("po-file").value = ""
        return false;
      }

      if(e.target.files[0].size < 5242880) {
        const fileName = e.target.files[0].name;
        this.setState({inputPO: fileName})
      }
      else {
        toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
        document.getElementById("po-file").value = ""
      }
    }

    render() {
        return (
          <div className="sidebar-info">

            <div className="card apply-voucher">
              <h3 className="block-header">Apply Voucher Code</h3>
              <form className="vouchers-inline">
                <Input type="text" placeholder="Enter Code" id={"voucherCode"}/>
                <button className="button-blue" onClick={this.applyDiscount.bind(this)}>Apply</button>
              </form>
              <div className="view-vouchers">
                <a href="javascript:void(0)" onClick={this.viewLoyaltyPoints.bind(this)}>Create Voucher</a>
                <a href="javascript:void(0)" onClick={this.viewVouchers.bind(this)}>View Vouchers</a>
              </div>
            </div>

            
            {budgetConfigured == 1 && budgetOption == 2 ?
                <div className="card po-details">
                  <h3 className="block-header">Purchase Order Details</h3>
                  <div className="inline-form">
                    <p>PO Number: <strong>{cookiePONumber}</strong></p>
                  </div>
                  <div className="po-info">This P.O. Number will be shown in your Invoice.</div>
                </div>
              :
              <div className="card po-details">
                <h3 className="block-header">Purchase Order Details <span>({this.props.companyInfo.po_mandatory == 1 ? "Mandatory" : "optional"})</span></h3>
                <div className="inline-form">
                  <Input className="po-number" type="text" placeholder="Enter PO Number" id="po-number" />
                  <form className="po-upload" id="upload-po" method="post" encType="multipart/form-data">
                    <input type="file" id="po-file" name="po-file" className="file-input" onChange={this._fileInputHandler.bind(this)}/>
                    <label htmlFor="po-file">{`${this.state.inputPO.slice(0, 19)}`}</label>
                  </form>
                </div>
                <div className="po-info">Allowed file types: JPEG, PNG, PDF and EXCEL.</div>
                <div className="po-info">The entered P.O. Number will be shown in your Invoice.</div>
              </div>
            }

          </div>
        )
    }
}

Vouchers.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    loyaltyCount: store.cartState.loyaltyCount,
    companyInfo: store.commonState.companyInfo
  }
}

export default connect(mapStateToProps)(Vouchers)
import React from 'react'
import { connect } from 'react-redux'
import serialize from 'form-serialize'
import * as procureApi from '../../../api/procure-buy-api'
import DisplayModal from '../../../components/common/Modal'

class UploadPO extends React.Component{
  constructor(props){
    super(props)
    this.state = {
      selectedExcel: "Choose file"
    }
  }
  fileInputHandler(e){
    if(e.target.files[0].size < 5242880) {
      const fileName = e.target.files[0].name;
      this.setState({selectedExcel: fileName})
    }
    else {
      toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
      document.getElementById("po-file").value = ""
    }
  }
  upload(e){
    procureApi.uploadPO(this.context.router);
    e.preventDefault();
  }

  download(){
    procureApi.downloadPurchaseOrder()
  }

  render(){
    return (
      <div className="upload-po-container">
        <ul className="upload-excel">
          <li className="step">
            <div className="step-count">Step-1</div>
            <div className="step-message">
              <p>Download your excel template.</p>
              <button className="button-blue outline" onClick={this.download.bind(this)}><span><i className="icon-cloud-download"></i></span>Download Excel Template</button>
              <p className="help-text"><strong>Note:</strong> You can only add products which are available in your currently selected region.</p>
            </div>
          </li>
          <li className="step">
            <div className="step-count">Step-2</div>
            <div className="step-message">
              <p>Fill quantities in the downloaded excel sheet.</p>
            </div>
          </li>
          <li className="step">
            <div className="step-count">Step-3</div>
            <div className="step-message">
              <p>Upload your excel template.</p>
              <form id="upload-purchase-order" method="post" encType="multipart/form-data">
                <input type="file" name="excel-file" id="upload-purchase-order-input" className="file-input" onChange={this.fileInputHandler.bind(this)}/>
                <label htmlFor="upload-purchase-order-input">{this.state.selectedExcel}</label>
                <button className="button-blue" onClick={this.upload.bind(this)}><span><i className="icon-cloud-upload"></i></span> {this.props.isUploadingPo ? "Uploading..." : "Upload Excel"} </button>
              </form>
            </div>
          </li>
        </ul>
        <DisplayModal id={"uploadResponse"} contentID={"uploadResponseContent"} scrollHeight={150} title={"Upload Response"} />
      </div>
    )
  }
}

UploadPO.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    isUploadingPo: store.procureBuyState.isUploadingPo
  };
};

export default connect(mapStateToProps)(UploadPO);


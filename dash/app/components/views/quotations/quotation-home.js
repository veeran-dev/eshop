import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../../store/configureStore'
import SearchWeb from '../widgets/searchProduct/search-web'
import Input from '../../common/Input'
import QuotationForm from './quotation-form'

class QuotationHome extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
       showForm: false,
       quotationName: "",
    };
    this.baseState = this.state 
  }

  reset(){
    this.setState(this.baseState);
  }

  fileInputHandler(e){
    console.log("fileInputHandler");
    console.log(e.target.files);
    console.log(e.target.files.length);
    
    if(e.target.files.length == 0){
      this.setState({quotationName: "", showForm: false})
      document.getElementById("upload-quotation-excel-input").value = ""; 
      return false;
    }

    let fileName = e.target.files[0].name;
    let fileSize = e.target.files[0].size;
    if(fileSize > 5242880){
      this.setState({quotationName: "", showForm: false})
      document.getElementById("upload-quotation-excel-input").value = ""; 
      toastr.error('Error', 'File size should not be more than 5MB', {icon: 'icon-error'}) 
      return false;
    }
    else if(['xls', 'xlsx', 'pdf', 'csv' ].includes(fileName.split(".")[1])){
      this.setState({quotationName: fileName, showForm: true})
    }
    else{
      this.setState({quotationName: "", showForm: false})
      document.getElementById("upload-quotation-excel-input").value = ""; 
      toastr.error('Error', 'File format not supported', {icon: 'icon-error'}) 
      return false;
    }
    
  }
  render() {
      return (
        <div className="quotation-container-home">
          <div className="layer">
            <div className="wrapper">
              <h3>Option 1: Search products and get quotations</h3>
              <div className="sp_search ">
                <SearchWeb />
              </div>
              <div className="ex">
                <p>Example: A4 paper, Tissue, Printer. </p>
              </div>
            </div>
          </div>
          <div className="layer">
            <div className="wrapper">
              <h3>Option 2: Get custom quotations</h3>
              <div className="upload">
                <form id="upload-quotation-excel" method="post" encType="multipart/form-data" className="file-select">
                  <input type="file" name="excel-file" id="upload-quotation-excel-input" className="file-input" onChange={this.fileInputHandler.bind(this)}/>
                  <label htmlFor="upload-quotation-excel-input"><span><i className="icon-cloud-upload"></i></span> {"Select File"}</label>
                  <button type="button">{this.state.quotationName != "" ? this.state.quotationName: "No file choosen"}</button>
                </form>
              </div>
              <div className="ex">
                <p>Allowed file types: PDF, CSV and EXCEL.</p>
              </div>
              <div className="info"><p><strong>Note: </strong>It is mandatory to have Product Name and Quantity in the uploading  file</p></div>
              <div className={this.state.showForm ? "quotation-details-wrapper animate" :"quotation-details-wrapper"}>
                <QuotationForm id="quotation-home-details-form" reset={this.reset.bind(this)} getProduct={false} minimalQuote={false} QuotationFileId={"upload-quotation-excel-input"} />
              </div>
            </div>
          </div>

        </div>
      )
  }
}

QuotationHome.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    isFetching: false,
  }
};

export default connect(mapStateToProps)(QuotationHome)
import React, { memo, useState, useEffect } from 'react';
import ReactDOM from 'react-dom'
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import * as catalogApi from '../../../api/catalog-api';
// import posed from 'react-pose';

// Using "Stateless Functional Components"
const Upload = () => {

  const [filename, setFilename] = useState('Choose File');
  const [uploading, setUploading] = useState(false);

  useEffect(() => {
    document.getElementById('loader').style.visibility = 'hidden';
  });

  const fileInputHandler = (e) =>{
    let type = e.target.files[0].type;
    console.log(e.target.files[0]);
    let validExts = new Array("xlsx", "xls", "csv");
    let fileExt = e.target.files[0].name.split(".")
    console.log(fileExt)
    if(e.target.files[0].size > 2097152){
        toastr.error("Error", "Maximum file upload size is 2MB.", {icon: "icon-error"})
        document.getElementById("upload-product-details-input").value = null
    }
    else if (validExts.indexOf(fileExt[fileExt.length-1]) < 0) {
        toastr.error("Error", "File format such as .xls, .xlsx, .csv are only accepted", {icon: "icon-error"})
        document.getElementById("upload-product-details-input").value = null
    }
    else{
      const fileName = e.target.files[0].name;
      setFilename(fileName);
    }
    
  }

  const upload = (e) => {

    console.log("upload");
    e.preventDefault();
    if(uploading == true){
      return false;
    }
    setUploading(true)
    var fileInput = document.getElementById("upload-product-details-input");
    if(fileInput.value == ""){
      toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
      setFilename('Choose File'); 
      setUploading(false);
      return false;
    }
    else{
      catalogApi.uploadCatalog().then(response =>{        
        setFilename('Choose File'); 
        setUploading(false);
        let data = response.data
        document.getElementById("upload-product-details-input").value = ""

      })
    }
  }
  return (
    <div className="page-container">
      {uploading == true ? <div className="loader"><div className="spinner"></div></div> : null}
      <div className="upload-po-container">
        <ul className="upload-excel">
            <li className="step">
              <div className="step-count">Step-1</div>
              <div className="step-message">
                <p>Download your excel template.</p>
                <button className="button-blue outline" onClick={(e)=>{window.open('./sample.xlsx')}}><span><i className="icon-cloud-download"></i></span>Download Excel Template</button>
                <p className="help-text"><strong>Note:</strong> For any issues or clarification please contact us.</p>
              </div>
            </li>
            <li className="step">
              <div className="step-count">Step-2</div>
              <div className="step-message">
                <p>Fill all the product details in the downloaded excel sheet.</p>
              </div>
            </li>
            <li className="step">
              <div className="step-count">Step-3</div>
              <div className="step-message">
                <p>Upload your excel template.</p>
                <form id="upload-purchase-order" method="post" encType="multipart/form-data">
                  <input type="file" name="excel-file" id="upload-product-details-input" className="file-input" onChange={(e)=>fileInputHandler(e)}/>
                  <label htmlFor="upload-product-details-input">{filename}</label>
                  <button className="button-blue" onClick={upload}><span><i className="icon-cloud-upload"></i></span>{uploading == true ? "Loading..": "Upload Excel"} </button>
                </form>
              </div>
            </li>
            </ul>
      </div>
    </div>
  )
}

// Wrap component using `React.memo()`
export default memo(Upload);
import React from 'react';
import { useState, useEffect } from 'react';
import { getStates } from '../../api/address-api'
import { UploadInventoryProducts } from '../../api/inventory-api'
import axios from 'axios'
import Input from './Input'
import 'babel-polyfill';
import {toastr} from 'react-redux-toastr'

function UploadInventory(props) {

    const [errors, setErrors] = useState("Please upload valid file");
    const [filename, setFilename] = useState('Choose File');
    const [uploading, setUploading] = useState(false);

  useEffect(() => {
    document.getElementById('loader').style.visibility = 'hidden';
  });

    const isValid = (e) =>{
      let type = e.target.files[0].type;
      let validExts = new Array("xlsx", "xls", "csv");
      let fileExt = e.target.files[0].name.split(".")
      if(e.target.files[0].size > 5242880){
          toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
          document.getElementById("uploadFile").value = null
      }
      else if (validExts.indexOf(fileExt[fileExt.length-1]) < 0) {
          toastr.error("Error", "File format such as .xls, .xlsx, .csv are only accepted", {icon: "icon-error"})
          document.getElementById("uploadFile").value = null
      }
      else{
        const fileName = e.target.files[0].name;
        setFilename(fileName);
      }
    }


  const upload = (e) => {
    console.log(props)
    console.log("upload");
    e.preventDefault();
    setUploading(true)
    var fileInput = document.getElementById("uploadFile");
    console.log(fileInput);
    console.log(fileInput.value);
    if(fileInput.value == ""){
      toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
      setFilename('Choose File'); 
      setUploading(false);
      return false;
    }
    else{
      UploadInventoryProducts(props.inventory.value).then(response =>{        
        setFilename('Choose File'); 
        setUploading(false);
        let data = response.data
        document.getElementById("uploadFile").value = ""

      })
    }
  }

  const downloadFile =() =>{
    let url ="./sample_documents/Inventory_Upload_Sample.xlsx";
    window.open(url);
  }

    return (
      <form id="UploadInventoryProducts" className="register-form">
        {uploading == true ? <div className="loader"><div className="spinner"></div></div> : null}
        <div className="form-wrapper">
          <p><strong>Inventory: </strong> {props.inventory.label}</p>
        </div>
        <div className="info-msg form-wrapper">
          <p>Kobzo’s mission is to transform organizations by creating novel end to end digital solutions to enhance their procurement activities, employee welfare and workplace goals.</p>
          <button className="btn-outline" onClick={downloadFile} ><span><i className="icon-cloud-download"></i></span> Download Sample</button>
        </div>
        <div className="form-wrapper">
          <form id="upload-inventory-product" className="upload-file-details" method="post" encType="multipart/form-data" >
            <input type="file" name="uploadFile" id="uploadFile" className="file-input" onChange={isValid}/>
            <label htmlFor="uploadFile">{filename}</label>
            <button className="button-blue" onClick={upload}><span><i className="icon-cloud-upload"></i></span>{uploading == true ? "Loading..": "Upload Excel"} </button>
          </form>
        </div>
      </form>
    );

}

export default UploadInventory;
import React from 'react';
import { useState, useEffect } from 'react';
import { getStates } from '../../api/address-api'
import { createInventory } from '../../api/inventory-api'
import Select from 'react-select';
import axios from 'axios'
import Input from './Input'
import validateQuoteForm from './helpers/Validation';
import 'babel-polyfill';
import {toastr} from 'react-redux-toastr'


import CheckboxTree from 'react-checkbox-tree';
import 'react-checkbox-tree/lib/react-checkbox-tree.css';

import { TabProvider, Tab, TabPanel, TabList } from 'react-web-tabs';
import 'react-web-tabs/dist/react-web-tabs.css';

const initialState = {
    nodes: [],
    manufacturer: [],
    category: [],
    gst: [],
    errors: [],
    filename: "No File Chosen",
    csvFilename: "Choose File",
    uploadingCSV: false,
    updated: 0,
    checked: [],
    expanded: [],
    selectedGst: '',
    selectedCategory: '',
    selectedManufacturer: '',
};

const nodes = [{
    value: 'mars',
    label: 'Mars',
    children: [
        { value: 'phobos', label: 'Phobos',
          children: [
            { value: 'phobos', label: 'Phobos' },
            { value: 'deimos', label: 'Deimos' },
          ], 
        },
        { value: 'deimos', label: 'Deimos' },
    ],
}];

class AddProduct extends React.Component {

  constructor(props){
    super(props)
    this.state = initialState;
  }

  componentDidMount() {
    axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 5,
                  }}).then(response => {
                    console.log(response)
                    console.log(response.data)
                    this.setState({category: response.data})
                  })
    axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 6,
                  }}).then(response => {
                    console.log(response)
                    console.log(response.data)
                    this.setState({manufacturer: response.data})
                  })
    axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 7,
                  }}).then(response => {
                    console.log(response)
                    console.log(response.data)
                    this.setState({gst: response.data})
                  })
    axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 4,
                  }}).then(response => {
                    console.log(response)
                    console.log(response.data)
                    this.setState({nodes: response.data})
                  })
  }
  handleSubmit(e){
    e.preventDefault();
    console.log(this.state.errors)
    console.log(this.state.errors.length)

    let name = document.getElementById("name").value;
    let hsn_code = document.getElementById("hsn_code").value;
    let price = document.getElementById("price").value;
    let moq = document.getElementById("minimal_quantity").value;
    let desc = document.getElementById("description").value;

    let id_category = this.state.selectedCategory['id_category'];
    let id_manufacturer = this.state.selectedManufacturer['id_manufacturer'];
    let id_tax_rules_group = this.state.selectedGst['id_tax_rules_group'];

    if(name == '' || hsn_code == '' || price == '' || moq =='' || desc == '' || id_category == '' || id_category == undefined || id_manufacturer == '' || id_manufacturer == undefined || id_tax_rules_group == '' || id_tax_rules_group == undefined){
        toastr.error("Error", "Please check all the fields", {icon: "icon-error"})
        return false;
    }
    for(let key in this.state.errors){
      if(this.state.errors[key] != undefined && this.state.errors[key] != ''){
        toastr.error("Error", "Please check all the fields", {icon: "icon-error"})
        return false;
      }
    }

    var fileInput = document.getElementById("uploadFile");
    var files = fileInput.files;
    console.log(files)  
    
    var data = new FormData();
    for(let i=0; i<files.length; i++){
      data.append('file['+i+']', files[i])
      console.log(files[i])
    }
    console.log(data)

    data.append("type", 8)
    data.append("name", name)
    data.append("hsn_code", hsn_code)
    data.append("price", price)
    data.append("moq", moq)
    data.append("desc", desc)
    data.append("id_category", id_category)
    data.append("id_manufacturer", id_manufacturer)
    data.append("id_tax_rules_group", id_tax_rules_group)

    console.log(data)
    // return false;
    axios.post('../elite-supplier-catalog.php', data).then(response => {
                    console.log(response)
                    console.log(response.data)
                    toastr.success("Success", "Your Product is added successfully")
                    document.getElementById("createProductForm").reset();
                    document.getElementById("uploadFile").value = '';
                    this.setState({filename: 'No File Chosen'})
                    this.setState({selectedGst: '', selectedCategory: '', selectedManufacturer: ''})

                  })
  }

  upload(e){
    console.log(e.target.files.length);
    if(e.target.files.length == undefined || e.target.files.length <= 0){
      this.setState({filename: 'Choose File'})
      return false;
    }
    let files = e.target.files.length;
    let validExts = new Array("png", "jpeg", "jpg" ,"PNG", "JPEG");
    
    if(e.target.files.length > 0){
      for(let i=0; i<files; i++){

        let fileExt = e.target.files[i].name.split(".")
        console.log(fileExt)
        if (validExts.indexOf(fileExt[fileExt.length-1]) < 0) {
          toastr.error("Error", "File format such as .PNG, .JPG, .JPEG are only accepted", {icon: "icon-error"})
          this.setState({filename: 'Choose File'})
          return false;
        }

        if(e.target.files[i].size > 5242880) {
          toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
          this.setState({filename: 'Choose File'})
          return false;
        }   
      }
      let filename = e.target.files.length > 1 ?e.target.files.length +" files selected" : e.target.files[0].name;
      this.setState({filename: filename})
    }
  }

  isValid(e){
    console.log(e.target)
    let name = e.target.name;
    let value = e.target.value;
    let errors = this.state.errors;
    let id = e.target.id ? e.target.id: null;

    if(name === 'name'){
      if(value.trim() === ''){
        errors['name'] = 'Please enter product name';  
      }
      else if(value.length > 255){
        errors['name'] = 'Product name should be less than 255 characters';  
      }
      else{
        errors['name'] = '';   
      }
    }

    if(name === 'hsn_code'){
      if(value === ''){
        errors['hsn_code'] = 'Please enter HSN CODE';  
      }
      else if(value.length > 8){
        errors['hsn_code'] = 'HSN Code should be less than 8 characters';  
      }
      else if(!value.match(/^\w*$/)){
        errors['hsn_code'] = 'Please enter valid HSN CODE';  
      }
      else{
        errors['hsn_code'] = '';   
      }
    }
    
    if(name === 'price'){
      if(value.trim() === ''){
        errors['price'] = 'Please enter price';  
      }
      else if(!value.match(/^-?\d*(\.\d+)?$/) || value.trim() <= 0 || value.length > 8){
        errors['price'] = 'Please enter valid price';  
      }
      else{
        errors['price'] = '';   
      } 
    }
    
    if(name === 'minimal_quantity'){
      if(value === ''){
        errors['minimal_quantity'] = 'Please enter Minimal Quantity';  
      }
      else if(!value.match(/^[0-9]+$/)){
        errors['minimal_quantity'] = 'Please enter valid Minimal Quantity'
      }
      else if(value == '0'){
        errors['minimal_quantity'] = 'Please enter valid Minimal Quantity' 
      }
      else{
        errors['minimal_quantity'] = '';   
      }
    }
    
    if(name === 'description'){
      if(value.trim() === ''){
        errors['description'] = 'Please enter description';  
      }
      else{
        errors['description'] = '';   
      }
    }
    if(id === 'react-select-2-input'){
      console.log(this.state.selectedGst)
      if(this.state.selectedGst == ''){
        errors['gst'] = 'Please select GST';  
      }
      else{
        errors['gst'] = '';   
      }
    }

    if(id === 'react-select-3-input'){
      if(this.state.selectedCategory == ''){
        errors['category'] = 'Please select Category';  
      }
      else{
        errors['category'] = '';   
      }
    }

    if(id === 'react-select-4-input'){
      if(this.state.selectedManufacturer == ''){
        errors['manufacturer'] = 'Please select Manufacturer';  
      }
      else{
        errors['manufacturer'] = '';   
      }
    }
    console.log(errors)
    this.setState({ errors: errors, updated: 1 })

  }

  downloadSample(e){
    console.log(e)
    let url ="./Upload_Catalog.xlsx";
    window.open(url);
  }

  fileHandler(e){
    if(e.target.files.length == undefined || e.target.files.length == 0){
      this.setState({csvFilename: 'Choose File'})
      return false;
    }
    let files = e.target.files.length;
    let validExts = new Array("xlsx", "xls", "csv");
    
    if(e.target.files.length > 0){
      for(let i=0; i<files; i++){

        let fileExt = e.target.files[i].name.split(".")
        console.log(fileExt)
        if (validExts.indexOf(fileExt[fileExt.length-1]) < 0) {
          toastr.error("Error", "File format such as .xlsx, .xls are only accepted", {icon: "icon-error"})
          this.setState({csvFilename: 'Choose File'})
          return false;
        }

        if(e.target.files[i].size > 5242880) {
          toastr.error("Error", "Maximum file upload size is 5MB.", {icon: "icon-error"})
          this.setState({csvFilename: 'Choose File'})
          return false;
        }   
      }
      console.log(e.target.files)
      let filename = e.target.files.length > 1 ?e.target.files.length +" files selected" : e.target.files[0].name;
      this.setState({csvFilename: filename})
    }
  }

  uploadCSV(e){
    e.preventDefault();
    console.log(e)
    var fileInput = document.getElementById("uploadcsvFile");

    var files = fileInput.files[0];
    console.log(files)
    if(files == undefined){
      this.setState({csvFilename: 'Choose File'})
      return false;
    }
    if(files == undefined){
      return false;
    }
    var data = new FormData();
    data.append('type', 9)
    data.append('file', files)
    console.log(data)
    // return false;
    axios.post('../elite-supplier-catalog.php', data).then(response => {
                    if(response.data['success']){
                      toastr.success("Success", "Your Product is added successfully", {icon: "icon-success"})
                    }
                    if(response.data['error']){
                      toastr.error("Error", response.data['error'], {icon: "icon-error"})
                    }
                    document.getElementById("upload-bulk-product").reset();
                    document.getElementById("uploadcsvFile").value = "";
                    this.setState({initialState})
                    this.setState({csvFilename: 'Choose File'})

                  })

  }

  render() {
    const InputProps = props => <components.Input {...props} maxLength={5} />;
    return (
      <TabProvider defaultTab="one">
        <section className="my-tabs">
          <TabList className="my-tablist">
            <Tab tabFor="one" >Single Product</Tab>
            <Tab tabFor="two">Multiple Products</Tab>
            <Tab tabFor="three">Create Category</Tab>
          </TabList>
          <div className="wrapper">
            <TabPanel tabId="one">
              <form id="createProductForm" onSubmit={this.handleSubmit.bind(this)} className="register-form">
              <div className="form-group">
                <h3>Add New Product</h3>
              </div>
              <div className="form-wrapper">
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="name" id="name" maxLength={124} inputValue={""} type="text" placeholder="Product Name" onBlur={this.isValid.bind(this)} autoFocus={true}/>
                    </div>
                    {this.state.errors && <p className="error">{this.state.errors.name}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="hsn_code" maxlength={64} id="hsn_code" inputValue={""} type="text" placeholder="HSN CODE" onBlur={this.isValid.bind(this)} />
                    </div>
                    {this.state.errors && <p className="error">{this.state.errors.hsn_code}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="price" id="price" maxLength={61} inputValue={""} type="text" placeholder="Unit Price Tax Excl" onBlur={this.isValid.bind(this)} />
                    </div>
                    {this.state.errors && <p className="error">{this.state.errors.price}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="minimal_quantity" maxlength={64} id="minimal_quantity" inputValue={""} type="text" placeholder="Minimal Quantity" onBlur={this.isValid.bind(this)} />
                    </div>
                    {this.state.errors && <p className="error">{this.state.errors.minimal_quantity}</p>}
                  </div>
                </div>
              </div>
              <div className="form-wrapper">
                <div className="step double-column">
                  <div className="form-group">
                    <div>
                      <div className="form-control" >
                        <Select 
                        isMulti={false}
                        id="selectedGst"  
                        className='react-select-container'
                        classNamePrefix='react-select'
                        placeholder="Select GST" 
                        options={this.state.gst} 
                        value={this.state.selectedGst}
                        onChange={(value) =>this.setState({selectedGst: value})} 
                        onBlur={this.isValid.bind(this)}
                        ref={component => { this.gst = component }} 
                        components={{ InputProps }}
                      />
                      </div>
                      {this.state.errors && <p className="error">{this.state.errors.gst}</p>}
                    </div>
                  </div>
                  <div className="form-group">
                    <div>
                      <div className="form-control">
                          <Select 
                            isMulti={false}
                            id="selectedCategory"  
                            className='react-select-container'
                            classNamePrefix='react-select'
                            placeholder="Select Category" 
                            options={this.state.category} 
                            value={this.state.selectedCategory}
                            onChange={(value) =>this.setState({selectedCategory: value})} 
                            onBlur={this.isValid.bind(this)}
                            ref={component => { this.category = component }} 
                            components={{ InputProps }}
                          />
                      </div>
                      {this.state.errors && <p className="error">{this.state.errors.category}</p>}
                    </div>
                  </div>
                </div>
              </div>
              <div className="form-wrapper">
                <div className="step">
                  <div className="form-group">
                    <div>
                      <div className="form-control">
                        <Select 
                        isMulti={false}
                        id="selectedGst"  
                        className='react-select-container'
                        classNamePrefix='react-select'
                        placeholder="Select Manufacturer" 
                        options={this.state.manufacturer} 
                        value={this.state.selectedManufacturer}
                        onChange={(value) =>this.setState({selectedManufacturer: value})} 
                        onBlur={this.isValid.bind(this)}
                        ref={component => { this.manufacturer = component }}
                        components={{ InputProps }} 
                      />
                      </div>
                      {this.state.errors && <p className="error">{this.state.errors.manufacturer}</p>}
                    </div>
                  </div>
                </div>
              </div>
              <div className="form-wrapper">
                <div className="step">
                  <div className="form-group">
                    <div className="form-control">
                      <textarea name="description" id="description" cols="30" rows="10" placeholder="Description" onBlur={this.isValid.bind(this)}>{""}</textarea>
                    </div>
                    {this.state.errors && <p className="error">{this.state.errors.description}</p>}
                  </div>
                </div>
              </div>
              <div className="">
                <div className="">
                  <div className="form-control">
                    <form id="upload-product-image" className="upload-file-details" method="post" encType="multipart/form-data" >
                      <input type="file" name="uploadFile" id="uploadFile" className="file-input" onChange={this.upload.bind(this)} multiple/>
                      <label htmlFor="uploadFile">{"Select Image"}</label>
                      <button type="button" className="button-blue" >{this.state.filename}</button>
                    </form>
                  </div>
                </div>
              </div>
              <div className="form-footer">
                <button type="submit" className="button-blue">Create Product</button>
              </div>
            </form>
            </TabPanel>
            <TabPanel tabId="two">
              <div className="register-form">
                <div className="info-msg form-wrapper">
                  <p>Kobzo’s mission is to transform organizations by creating novel end to end digital solutions to enhance their procurement activities, employee welfare and workplace goals.</p>
                  <button className="btn-outline" onClick={this.downloadSample.bind(this)} ><span><i className="icon-cloud-download"></i></span> Download Sample</button>
                </div>
                <div className="form-wrapper">
                  <form id="upload-bulk-product" className="upload-file-details" method="post" encType="multipart/form-data" >
                    <input type="file" name="uploadcsvFile" id="uploadcsvFile" className="file-input" onChange={this.fileHandler.bind(this)}/>
                    <label htmlFor="uploadcsvFile">{this.state.csvFilename}</label>
                    <button className="button-blue" onClick={this.uploadCSV.bind(this)}><span><i className="icon-cloud-upload"></i></span>{this.state.uploadingCSV == true ? "Loading..": "Upload Excel"} </button>
                  </form>
                </div>
              </div>
            </TabPanel>
            <TabPanel tabId="three">
              <div className="register-fo" style={{padding: 24}}>
                <CheckboxTree
                  nodes={this.state.nodes}
                  checked={this.state.checked}
                  expanded={this.state.expanded}
                  onCheck={checked => this.setState({ checked })}
                  onExpand={expanded => this.setState({ expanded })}
                  icons={{
                      check: <span className="rct-icon rct-icon-check" />,
                      uncheck: <span className="rct-icon rct-icon-uncheck" />,
                      halfCheck: <span className="rct-icon rct-icon-half-check" />,
                      expandClose: <span className="rct-icon rct-icon-expand-close" />,
                      expandOpen: <span className="rct-icon rct-icon-expand-open" />,
                      expandAll: <span className="rct-icon rct-icon-expand-all" />,
                      collapseAll: <span className="rct-icon rct-icon-collapse-all" />,
                      parentClose: <span className="rct-icon rct-icon-parent-close" />,
                      parentOpen: <span className="rct-icon rct-icon-parent-open" />,
                      leaf: <span className="rct-icon rct-icon-leaf" />,
                  }}
                />
              </div>
            </TabPanel>
          </div>
        </section>
      </TabProvider>
    );
  }
}

export default AddProduct;
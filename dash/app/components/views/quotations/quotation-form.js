import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'

import store from '../../../store/configureStore'
import Input from '../../common/Input'
import * as G from '../../../api/common-api'
import Select from 'react-select';
import Datepicker from '../../common/datepickerSingle'
import NewMessage from '../../common/Message'

class QuotationForm extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
       chosenCategory: [],
       selectedCategories: [],
       chosenCategory: [],
       images: [],
       selectedImage: "",
       attachments: [],
       selectedAttachment: "",
       deadline: "",
       regular: 1,
       immediately: 1,
       buyingPeriod: "",
       payment: 1,
       quotation_quantity: 0,
       description:"",
       quotation_pname: "",
    };
    this.baseState = this.state 
  }

  fileInputHandler(e){
    console.log(e);
  }

  imageInputHandler(e){
    let files = e.target.files;
    let length = e.target.files.length;
    console.log(files);
    if(length == 0){
      document.getElementById("upload-quotation-details-images").value="";
      this.setState({images: "", selectedImage: ""})
      return false;  
    }
    for(let i =0;i<length;i++){
      console.log(files[i]);
      let fileSize = files[i].size;
      let fileName = files[i].name;
      if(fileSize > 5242880){
          document.getElementById("upload-quotation-details-images").value="";
          toastr.error('Error', 'Each file should be less than 5MB', {icon: 'icon-error'}) 
          this.setState({images: "", selectedImage: ""})
          return false;  
      }
      else if(!['png', 'jpg', 'jpeg' ].includes(fileName.split(".")[1])){
          document.getElementById("upload-quotation-details-images").value="";
          toastr.error('Error', 'JPG, JPEG, PNG are only supported', {icon: 'icon-error'}) 
          this.setState({images: "", selectedImage: ""})
          return false;  
      }
    }
    if(e.target.files.length > 1){
      this.setState({images: e.target.files, selectedImage: e.target.files.length+" files selected"})
    }
    else{
      this.setState({images: e.target.files, selectedImage: e.target.files[0].name})
    }
  }

  attachmentInputHandler(e){ 
    console.log(e.target.files);
    if(e.target.files[0] === undefined){
          this.setState({selectedAttachment: ""})
          document.getElementById("upload-quotation-details-attachments").value = ""; 
          return false;
    }
    let fileName = e.target.files[0].name;
    let fileSize = e.target.files[0].size;
    console.log(e.target);
    console.log(fileSize);
    if(fileSize > 5242880){
          this.setState({selectedAttachment: ""})
          document.getElementById("upload-quotation-details-attachments").value = ""; 
          toastr.error('Error', 'File should be less than 5MB', {icon: 'icon-error'}) 
          return false;  
    }
    else if(['xls', 'xlsx', 'pdf', 'csv' ].includes(fileName.split(".")[1])){
      this.setState({attachments: e.target.files, selectedAttachment: e.target.files[0].name})
    }
    else{
      this.setState({selectedAttachment: ""})
      document.getElementById("upload-quotation-details-attachments").value = ""; 
      toastr.error('Error', 'File format not supported', {icon: 'icon-error'}) 
      return false;
    }
  }

  submitQuotationForm=(e)=>{
    e.preventDefault();
    if(this.isValid(0, null, true)){
      //Quote file
      var data = new FormData();
      if(this.props.minimalQuote == false){
        if(this.props.QuotationFileId != undefined){
          var fileInput = document.getElementById(this.props.QuotationFileId);
          var file = fileInput.files[0];
          data.append("file_i", file)
        }

        var imageFile = document.getElementById("upload-quotation-details-images");
        console.log(imageFile.files);
        if(imageFile.files.length > 0){
          for(let i=0; i<imageFile.files.length; i++){
            data.append("image_"+i, imageFile.files[i])  
          }
        }
        

        var attachmentFile = document.getElementById("upload-quotation-details-attachments");
        if(attachmentFile.files[0] != undefined){
          var file_attachment = attachmentFile.files[0];
          data.append("file_k", file_attachment)
        }
      }
      console.log(data);
      // return false;
      let category = this.state.chosenCategory
      let description = this.state.description
      let date =  this.state.deadline
      let qty = this.state.quotation_quantity
      let period = this.state.buyingPeriod
      let credit = this.state.credit;
      let payment = this.state.payment
      let regular = this.state.regular
      let immediately = this.state.immediately

      data.append('type', 6);
      if(this.props.minimalQuote == false){
        data.append('id_category', [...new Set(category.map(item => item.value))]);
        data.append('name_category', [...new Set(category.map(item => item.label))]);
        data.append('description', description);
      }
      data.append('date', date);
      if(this.props.getQuantity === true){
        data.append('qty', qty);
      }
      data.append('period', period);
      data.append('credit', credit);
      data.append('payment', payment);
      data.append('regular', regular);
      data.append('immediately', immediately);
      if(this.props.getProduct === true){
        data.append('product_name', this.state.quotation_pname);
      }
      if(this.props.minimalQuote == true){
        return axios.get('elite-quotation-api.php?type=7&id_product='+this.props.idProduct+'&intervalOption='+regular+'&quoteQuantity='+qty+'&buyingPeriod='+period+'&immediately='+immediately+'&deadline='+date+'&payment='+payment+'&credit='+credit)
        .then(response => {
          if(response.data['success'] == 1){
            toastr.success("Success", "Quotation created successfully", {icon: "icon-succes"})
            document.getElementById("messagePopContent").innerHTML = "";
            ReactDOM.render(<NewMessage message={"Your request for Quotation #"+response.data['reference']+" is forwarded to all suppliers"} />, document.getElementById("messagePopContent"));
            G.displayModal("messagePop");
            this.setState(this.baseState);
            this.refs.datePicker.handleReset();
            document.getElementById('quotation_quantity').value = "";
            if(this.state.regular == 2){
                document.getElementById('buyingPeriod').value = "";
            }
            G.closeModal(["quotationFormID"])
            return true  
          }
        })
        return false;
      }
      else{
        return axios.post('./elite-quotation-api.php?type=6', data).then(response => {
          console.log(response)
          if(response.data['success'] == true){
            toastr.success("Success", "Quotation created succesfully", {icon: "icon-succes"})
            document.getElementById("messagePopContent").innerHTML = "";
            ReactDOM.render(<NewMessage message={"Your request for Quotation #"+response.data['reference']+" received"} />, document.getElementById("messagePopContent"));
            G.displayModal("messagePop");

            this.setState(this.baseState);
            this.refs.datePicker.handleReset();
            
            if(this.props.getProduct == true){
              document.getElementById('quotation_pname').value = "";  
            }
            if(this.props.getQuantity == true){
              document.getElementById('quotation_quantity').value = "";
            }
            if(this.state.regular == 2){
                document.getElementById('buyingPeriod').value = "";
            }
            G.closeModal(["quotationFormID"])
            
            G.getSelectedCity().then(response=>{
              console.log(response.data)
              this.setState({selectedCities: response.data['selectedCities']})
              return response
            });
            
            G.getSelectedCategory().then(response=>{
              this.setState({selectedCategories: response.data['selectedCategories']})
              return response
            });
            
            if(this.props.QuotationFileId){
              document.getElementById(this.props.QuotationFileId).value = "";
              this.props.reset();
            }
            
            imageFile = document.getElementById("upload-quotation-details-images").value="";
            attachmentFile = document.getElementById("upload-quotation-details-attachments").value="";

          }
        })
      }
    }
  }

  componentWillMount(){
    G.getSelectedCity().then(response=>{
      console.log(response.data)
      this.setState({selectedCities: response.data['selectedCities']})
      return response
    });
    G.getSelectedCategory().then(response=>{
      this.setState({selectedCategories: response.data['selectedCategories']})
      return response
    });
  }

  isValid(type, e, override=false){
    let error = false;
    if(this.props.minimalQuote == false){
      if((type === 6 || override === true) && this.props.getProduct == true){
        if(this.state.quotation_pname == ""){
          error = true;
          toastr.error('Error', 'Please enter product name', {icon: 'icon-error'})  
          return false;
        }
        else if(this.state.quotation_pname.length > 64){
          error = true;
          toastr.error('Error', 'Product name should be less than 64 characters', {icon: 'icon-error'})  
          return false;
        }
      }
      if(type === 1 || override === true){
        console.log(this.state.chosenCategory)
        if(this.state.chosenCategory.length <= 0){
          error = true;
          toastr.error('Error', 'Please select atleast one category', {icon: 'icon-error'})
          return false;
        }

        if(this.state.chosenCategory.length > 5){
          error = true;
          toastr.error('Error', 'Please select less than 5 category', {icon: 'icon-error'})
          return false;
        }
      }
    }
    if(type === 2 || override === true){
      let date =  this.state.deadline
      let pastDate = G.isPastDate(date);
      if(date == "" || pastDate === false){
        error = true;
        toastr.error('Error', 'Please enter valid date', {icon: 'icon-error'}) 
        return false;
      }
    }
    if((type === 3 || override === true) && this.props.getQuantity == true){
      let qty = this.state.quotation_quantity
      if(qty <= 0 || qty === "" || !qty.match(/^[0-9]+$/) || qty.length > 6){
        error = true;
        toastr.error('Error', 'Please enter valid quantity', {icon: 'icon-error'}) 
        return false;
      }
    }
    if(this.state.regular == 2 && (type === 4 || override === true)){
      let period = this.state.buyingPeriod
      if(period === ""){
        error = true;
        toastr.error('Error', 'Please select the buying frequency', {icon: 'icon-error'}) 
        return false;
      }

    }
    if(type === 5 || override === true){
      if(this.state.credit == 0 && this.state.payment == 0){
        error = true;
        toastr.error('Error', 'Please select valid payment', {icon: 'icon-error'})  
        return false;
      }
    }
    if(type === 7 || override === true){
      if(this.state.description != "" && this.state.description.length > 180){
        toastr.error('Error', 'Description should be less than 120 characters', {icon: 'icon-error'})  
        return false; 
      }
    }
    return true

  }
    render() {
        return (
          <form id={this.props.id} onSubmit={this.submitQuotationForm.bind(this)} className="quotationForm">
            <div className="form-group">
              <h3>Please fill below details</h3>
            </div>
            <div className="form-wrapper">
            {this.props.getProduct == true ?
              <div className="step">
                <div className="form-control">
                  <Input id={"quotation_pname"} ref="quotation_pname" type="text" placeholder="Please enter the product name" onChange={(e)=>this.setState({quotation_pname: e.target.value.trim()})} onBlur={this.isValid.bind(this, 6)} />
                </div>
              </div>:null}
              {this.props.minimalQuote == false ?
              <div className="step">
                <div className="form-control">
                    <input type="hidden" name="category" value={this.state.chosenCategory} />
                    <Select 
                      isMulti={true}
                      id="selectedCategories"  
                      className='react-select-container'
                      classNamePrefix='react-select'
                      placeholder="Supplier Category" 
                      options={this.state.selectedCategories} 
                      value={this.state.chosenCategory}
                      onChange={(value) =>this.setState({chosenCategory: value})} 
                      ref={component => { this.addresses = component }} 
                      onBlur={this.isValid.bind(this, 1)}
                    />
                    </div>
               </div>:null}
               {this.props.minimalQuote == false ?
               <div className="step">
                <div className="form-group">
                  <div>
                    <p className="mute-text">Optional</p>
                  </div>
                  <div className="upload">
                       <form id="upload-quotation-images-form" method="post" encType="multipart/form-data" className="file-select">
                      <input type="file" 
                              name="upload-quotation-details-images" 
                              id="upload-quotation-details-images" 
                              className="file-input" 
                              onChange={this.imageInputHandler.bind(this)} 
                              multiple accept='image/*'/>
                      <label htmlFor="upload-quotation-details-images"><span><i className="icon-cloud-upload"></i></span>{"Select Images"}</label>
                      <button type="button">{this.state.selectedImage != "" ? this.state.selectedImage : "No file choosen"} </button>
                    </form>
                  </div>
                </div>
               </div>:null}
               {this.props.minimalQuote == false ?
              <div className="step">
                <div>
                  <p className="mute-text">Optional</p>
                </div>
                <div className="form-control">
                  <textarea name="description" id="description" type="textarea" placeholder="Description" value={this.state.description} onChange={(e)=>this.setState({description:e.target.value})} onBlur={this.isValid.bind(this,7)}/>
                </div>
              </div>:null}
              <div className="step">
                <div className="form-control">
                    <p className="title">Please enter deadline date</p>
                    <Datepicker 
                        className="datePicker" ref="datePicker" 
                        onChange={(date)=>{
                          let x = G.isPastDate(date);
                          if(x === false){
                            toastr.error('Error', 'Please enter valid date', {icon: 'icon-error'}) 
                          }
                          this.setState({deadline: date})
                        }}
                        disablePast={true} placeholder={"Quotation's Deadline Date"}
                        onBlur={this.isValid.bind(this,2)}
                        />
                </div>
              </div>
              <div className="step">
                <div className="form-control">
                  <p className="title">Is it one time requirement or regular?</p>
                  <div className="form-control form-group-inline">
                    <div className="form-group">
                        <input type="radio" value="Immediately" checked={this.state.regular === 1 ? true:false}/>
                        <label onClick={()=>this.setState({regular: 1})}>One Time</label>
                    </div>
                    <div className="form-group">
                        <input type="radio" checked={this.state.regular === 2 ? true:false}/>
                        <label onClick={()=>this.setState({regular: 2})}>Regular</label>
                    </div>
                  </div>
                </div>
              </div>
              {this.state.regular === 2 ?
              <div className="step">
                <div className="form-group">
                  <p className="title">How frequently will you buying?</p>
                  <div className="form-control">
                    <select 
                      ref="buying_period" 
                      onChange={(e)=>this.setState({buyingPeriod: e.target.value})} 
                      onBlur={this.isValid.bind(this, 4)}
                      selected={this.state.buyingPeriod}
                      id={"buyingPeriod"}
                      >
                        <option value="">Select Frequency</option>
                        <option value="1">Weekly</option>
                        <option value="2">Monthly</option>
                        <option value="3">Quaterly</option>
                    </select> 
                  </div>
                </div>
              </div>:null}
              {this.props.getQuantity == true ?
              <div className="step">
                <div className="form-control">
                  <p className="title">Please enter the quantity</p>
                  <Input id={"quotation_quantity"} ref="quotation_quantity" type="number" placeholder="Please enter the quantity" onChange={(e)=>this.setState({quotation_quantity: e.target.value})} onBlur={this.isValid.bind(this, 3)} />
                </div>
              </div>:null}
              <div className="step">
                <div className="form-group">
                  <p className="title">When do you need it?</p>
                  <div className="form-control form-group-inline">
                    <div className="form-group">
                        <input type="radio" value="Immediately" checked={this.state.immediately === 1 ? true:false}/>
                        <label onClick={()=>this.setState({immediately: 1})}>Immediately</label>
                    </div>
                    <div className="form-group">
                        <input type="radio" checked={this.state.immediately === 2 ? true:false}/>
                        <label onClick={()=>this.setState({immediately: 2})}>1 Month</label>
                    </div>
                  </div>
                </div>
              </div>
              <div className="step">
                <div className="form-group">
                  <p className="title">Choose your payment term.</p>   
                  <div className="form-group-inline form-control">
                      <button type="button" onClick={()=>this.setState({payment: 1})} className={this.state.payment === 1 ? "button-blue":""}>Advance </button>
                      <button type="button" onClick={()=>this.setState({payment: 2})} className={this.state.payment === 2 ? "button-blue":""}>On Delivery </button>
                      <select onChange={(e)=>{this.setState({payment: 0, credit: e.target.value})}} onBlur={this.isValid.bind(this, 5)}>
                          <option value="0" selected={this.state.payment !=0}>Credit</option>
                          <option value="1">7 Days</option>
                          <option value="2">30 days</option>
                          <option value="3">45 days</option>
                      </select>
                  </div>
                </div>
              </div>
              {this.props.minimalQuote == false ?
              <div className="step">
                <div className="form-control">
                  <div >
                    <p className="mute-text">Optional</p>
                  </div>
                  <div className="upload">
                    <form id="upload-quotation-attachments-form" method="post" encType="multipart/form-data" className="file-select">
                      <input type="file" name="upload-quotation-details-attachments" id="upload-quotation-details-attachments" className="file-input" onChange={this.attachmentInputHandler.bind(this)}/>
                      <label htmlFor="upload-quotation-details-attachments">{"Select Attachments"}</label>
                      <button type="button">{this.state.selectedAttachment != "" ? this.state.selectedAttachment : "No file choosen"} </button>
                    </form>
                  </div>
                  <div><p className="mute-text">Allowed file types: PDF, CSV and EXCEL.</p></div>
                </div>
               </div>:null}
            </div>
            <div className="form-footer">
              <Input type="hidden" name="type" inputValue={6} />
              <button type="submit" className="button-black">Get Quotations</button>
            </div>
          </form>
        )
    }
}

QuotationForm.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    isFetching: false,
  }
};

export default connect(mapStateToProps)(QuotationForm)
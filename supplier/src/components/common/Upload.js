import React from 'react';
import * as moment from 'moment';
import { FilePond, registerPlugin } from 'react-filepond';
import Datetime  from'react-datetime'
import DayPickerInput  from'./datepickerSingle'
import {toastr} from 'react-redux-toastr'
import Time from './Time'
import 'filepond/dist/filepond.min.css';
import 'react-datetime/css/react-datetime.css';

import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

registerPlugin(FilePondPluginFileValidateSize);
registerPlugin(FilePondPluginFileValidateType);

class uploadFile extends React.Component {
  constructor(props) {
      super(props);

      this.state = {
          // skip: true,
          drFiles: [],
          invFiles: [],
          hasProof: true
      };
  }
  
  handleInit() {
      this.setState({files:[]})
  }
  submit(){
    let date = this.refs.expiryDate.state.value;
    let time = this.refs.deliveryTime.state.time24;
    let dr_files = this.dr_pond.props.files;
    let inv_files = this.inv_pond.props.files;

    if(date == ""){
      toastr.warning('Warning', 'Please select date', { icon: "icon-warning"})
      return false;
    }

    if(time == ""){
      toastr.warning('Warning', 'Please select time', { icon: "icon-warning"})
      return false;
    }

    if(this.state.hasProof){
      if(dr_files.length == 0 && inv_files.length == 0){
        toastr.warning('Warning', 'Please upload delivery proof', { icon: "icon-warning"})
        return false;
      }
      let error = false
      dr_files.map(x=>{
        if(x.size > 2097152){
          toastr.error('Error', "Sorry, File Size should be less than 2MB", { icon: "icon-error"})
          error = true;
        }
        if(x.type != "application/pdf" && x.type != "image/png" && x.type != "image/jpeg"){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
          error = true;
        }

      })  
      inv_files.map(y=>{
        if(y.size > 2097152){
            toastr.error('Error', "Sorry, File Size should be less than 2MB", { icon: "icon-error"})
            error = true;
        }
        if(y.type != "application/pdf" && y.type != "image/png" && y.type != "image/jpeg"){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
          error = true;
        }
      })
      if(error === false){
        this.props.submit(date+" "+time, dr_files, inv_files)
      }
    }
    else{
      this.props.submit(date+" "+time, null, null) 
    }
    
  }

  onLoaded = response => {
    console.log("onLoaded", response); // it print the id returned by the server
  };

  valid =(current)=>{
      return current.isSameOrBefore(moment(), 'date') && current.isSameOrAfter(moment(this.props.minDate), 'date')
  };

  render(){
    let d = new Date();
    return(
      <div className="upload-file" key={this.props.key}>
        <div className="delivery-date">
          <div className="select-sect">
            <h3>Delivered Date and Time</h3>
          </div>
          <div className="delivery-cal">
            <DayPickerInput 
              ref="expiryDate" 
              overrideOverlay={false} 
              selected={d} 
              className={"date-input"}  
              format={'YYYY-MM-DD'} 
              minDate={this.props.minDate}
              component={props => <input {...props} onBlur={(e)=>{console.log(e)}}/>} 
              onChange={(e)=>{this.refs.deliveryTime.refs.inputFocus.focus()}}
              />
          </div>
          <div>
            <Time ref="deliveryTime" placeholder={"Delivery Time"} primaryId={"delivery_time_id"} name={"delivery_time_id"} />
          </div>
        </div>
        <div className="upload-file-section">
          <div className="select-sect">
            <h3>Delivery Proof</h3>
          </div>
          <div className="select-sect">
              <input type="radio" name={"uproof"} id={"uploadProof"} onClick={(e)=>console.log(e)} checked={this.state.hasProof}/>
              <label htmlFor={"uploadProof"} onClick={(e)=>this.setState({hasProof: !this.state.hasProof})}>I Have Delivery Proof</label>
          </div>
          <div className={this.state.hasProof == true ?"upload-section show":"upload-section"}>
              <FilePond id={"dr_pond"} ref={ref => this.dr_pond = ref}
                      files={this.state.drFiles}
                      allowMultiple={true}
                      labelIdle={"Click here to upload delivery receipt files"}
                      allowFileTypeValidation={true}
                      acceptedFileTypes={['image/png', 'image/jpeg', 'application/pdf']}
                      allowFileSizeValidation ={true}
                      maxFileSize={'2MB'}
                      chunkUploads={false}
                      oninit={() => this.handleInit() }
                      onupdatefiles={(fileItems) => {
                          // Set current file objects to this.state
                          console.log(fileItems)
                          this.setState({
                              // skip: false,
                              drFiles: fileItems.map(fileItem => fileItem.file)
                          });
                      }}>
              </FilePond>
              <FilePond id={"inv_pond"} ref={ref => this.inv_pond = ref}
                      files={this.state.invFiles}
                      allowMultiple={true}
                      labelIdle={"Click here to upload invoice acknowledgement files"}
                      allowFileTypeValidation={true}
                      acceptedFileTypes={['image/png', 'image/jpeg', 'application/pdf']}
                      allowFileSizeValidation ={true}
                      maxFileSize={'2MB'}
                      chunkUploads={false}
                      oninit={() => this.handleInit() }
                      onupdatefiles={(fileItems) => {
                          // Set current file objects to this.state
                          console.log(fileItems)
                          this.setState({
                              // skip: false,
                              invFiles: fileItems.map(fileItem => fileItem.file)
                          });
                      }}>
              </FilePond>
              {this.props.warning}
          </div>
          <div className="select-sect">
            <input type="radio" name={"uproof"} id={"uploadNoProof"} onClick={(e)=>console.log(e)} checked={!this.state.hasProof}/>
            <label htmlFor={"uploadNoProof"} onClick={(e)=>this.setState({hasProof: !this.state.hasProof})}>I Donot Have Delivery Proof</label>
          </div>
          <button className="button-blue" onClick={this.submit.bind(this)}>Submit</button>
        </div>      
      {this.props.skip === true?
        <div className="warning">
          <button onClick={this.props.skipped.bind(this)}>Skip</button>
        </div>
      :null}
      </div>
      )}
}
export default uploadFile
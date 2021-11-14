import React from 'react';
import * as moment from 'moment';
import DayPickerInput  from'./datepickerSingle'
import {toastr} from 'react-redux-toastr'
import * as G from '../../api/common-api';

class uploadFile extends React.Component {
  constructor(props) {
      super(props);
      this.state = {
      };
  }
  
  handleInit() {
      this.setState({files:[]})
  }
  submit(){
    console.log("submit");
    let d = this.refs.expiryDate.state.value;
    let x = G.checkPastDate(d, false);
    if(x){
      toastr.warning('Warning', 'Please select past or present date', { icon: "icon-warning"})
      return false;
    }
    else{
      this.props.submit(d)
    }
  }

  render(){
    let d = new Date();
    return(
      <div className="date-box" key={this.props.key}>
        <div className="title">
          <h3>{this.props.title}</h3>
        </div>
        <div className="date-section">
          <DayPickerInput ref="expiryDate" overrideOverlay={false} selected={d} className={"date-input"}  format={'YYYY-MM-DD'} component={props => <input {...props} />} />
          <button className="button-blue" onClick={this.submit.bind(this)}>Submit</button>
        </div>
      </div>
      )}
}
export default uploadFile
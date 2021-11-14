import React, {useState, useCallback, useEffect} from 'react'
import {toastr} from 'react-redux-toastr'
import axios from 'axios'
import MydateFilter from './datepicker';
import * as G from '../../api/common-api';

class ReportContent extends React.Component {
    constructor(props){
    super(props)
    this.state = {
      fromDate: null,
      toDate: null,
      error: null,
      type: null,
      id_group: null,
    }
    this.baseState = this.state;
  }

  componentDidMount() {
    window.addEventListener("click", this.outerControl.bind(this));
    G.getMyBuyers().then(response =>{
      this.setState({company: response.data['companies']});
    })
  }

  componentWillReceiveProps(nextProps){
    G.getMyBuyers().then(response =>{
      this.setState({company: response.data['companies']});
    }) 
  }

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
  }


	_splitButton(e) {
		console.log(e)
	  let allElem = document.getElementsByClassName('split-button-dropdown')
	  if(e.target.nextSibling.classList.contains("hidden")){
	    for(var i = 0; i < allElem.length; i++){
	        allElem[i].classList.add("hidden")
	        e.target.nextSibling.classList.remove("hidden")
	    }
	  }
	  else{
	    e.target.nextSibling.classList.add("hidden")
	    for(var i = 0; i < allElem.length; i++)
	        allElem[i].classList.add("hidden")
	  }
	}

  outerControl(event){
    var allElem = document.getElementsByClassName('split-button-dropdown');
    for(var i=0; i < allElem.length; i++){
        let box = allElem[i]
        if(event.target != box && event.target.parentNode != box){
          if(box && box.style.display != undefined)
            if(!box.classList.contains("hidden") && !event.target.classList.contains("split-button-arrow"))
              box.className += " hidden"
        }
    }
  }


	downloadReports(type, fromDate, toDate) {
	  const [list, setData] = React.useState(null);
	  const [error, setError] = React.useState(null);
	  React.useEffect(() => {
	    axios
	      .get('./eupplier-reports.php/type='+type+'&fromDate='+fromDate+'&toDate='+toDate)
	      .then(function(response) {
	      	console.log(response)
	        // setData(response.data);
	      })
	      .catch(function(error) {
	      	console.log(error)
	        setError(error);
	      });
	  });
	  return { suc, error };
	}

	selectOption(type){
    document.getElementById('downloadReportsBtn').innerHTML = "Download Report";
    if(type == 1){
        document.getElementById('downloadReportsBtn').innerHTML = "Download Procurement Plan";
    }
    else if(type == 2){
        document.getElementById('downloadReportsBtn').innerHTML = "Download Sales Report";
    }
    else if(type == 3){
        document.getElementById('downloadReportsBtn').innerHTML = "Download Delivery Report";
    }
    else if(type == 4){
        document.getElementById('downloadReportsBtn').innerHTML = "Download RateContract Report";
    }
		this.setState({type});
	}

  setDate(date){
    console.log(date.to);
    console.log(date.from);
    this.setState({
      fromDate: G.getDate(date.from, 'yyyy-mm-dd'),
      toDate: G.getDate(date.to, 'yyyy-mm-dd')
    });
  }

	submit(){
		console.log("submit")
    console.log(this.state);
    let id_group = "";
    if(document.getElementById('company_rc')){
      id_group = document.getElementById('company_rc').value;  
    }
    
    if(!this.state.type){
      toastr.error("Error", "Please select the report to download.", {icon: "icon-error"})
    }
    else if (this.state.type !=1 && this.state.type != 4 && (!this.state.fromDate || !this.state.toDate)){
      toastr.error("Error", "Please select date.", {icon: "icon-error"})
    }
    else if(this.state.type !=1 && this.state.type != 4 && G.checkPastDate(this.state.fromDate)){
      toastr.error("Error", "Please select valid from date.", {icon: "icon-error"}) 
    }
    else if(this.state.type !=1 && this.state.type != 4 && G.checkPastDate(this.state.toDate)){
      toastr.error("Error", "Please select valid to date.", {icon: "icon-error"}) 
    }
    else if(this.state.type == 4 && id_group == ""){
      toastr.error("Error", "Please select the customer.", {icon: "icon-error"}) 
    }
    else{
      const { fromDate, toDate, type  } = this.state
      let file_path ="../supplier-reports.php?type="+type+"&from_date="+fromDate+"&to_date="+toDate+"&id_group="+id_group;
      // window.open(file_path);
      
      var a = document.createElement('A');
      a.href = file_path;
      a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      
    }

	}
  reset(){
    console.log("reset");
    this.setState(this.baseState)
    document.getElementById('downloadReportsBtn').innerHTML = "Select Report To Download";
    G.resetDate(this.datePicker)
  }

    downloadFiles(num, type){
    let url = "";
    if(type == 0){
      url ="/index.php?controller=pdf-invoice&id_par_delivery="+num
      window.open(url);
    }
    else if(type == 1){
      G.downloadAll(num[0]['files'])
    }
    else if(type == 2){
      G.downloadAll(num)
    }
    else if(type == 3){
      url ="/index.php?controller=pdf-invoice&id_order="+num
      window.open(url);
    }
    else if(type == 4){
      this.props.orderDetails[0]['po_file'].map(file =>{
        window.open("../"+file);
      })
    }
  }
  render(){
    return (
    			<div className="modal-wrapper report-wrapper" id={this.props.ids}>
            <div>
              <h3>Please select the report to download</h3>
            </div>
    				<div>
    					<div className="split-button">
                <div className={"split-button-default-action"}>
                  <button id="downloadReportsBtn">Select Report To Download</button>
                  <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                  <ul className={"split-button-dropdown hidden"}>
                    <li className={"active"} onClick={this.selectOption.bind(this, 1)}>
                      <a className="button button-blue outline padding-0404" href='javascript:void(0)'>
                        <i className="icon-download"></i><span>Procurement Plan</span>
                      </a>                                      
                    </li>
                    <li className={"active"} onClick={this.selectOption.bind(this, 2)}>
                      <a className="button button-blue outline padding-0404" href='javascript:void(0)'>
                        <i className="icon-download"></i><span>Sales Report</span>
                      </a>                                      
                    </li>
                    <li className={"active"} onClick={this.selectOption.bind(this, 3)}>
                      <a className="button button-blue outline padding-0404" href='javascript:void(0)'>
                        <i className="icon-download"></i><span>Delivery Report</span>
                      </a>                                      
                    </li>
                    <li className={"active"} onClick={this.selectOption.bind(this, 4)}>
                      <a className="button button-blue outline padding-0404" href='javascript:void(0)'>
                        <i className="icon-download"></i><span>RateContract Report</span>
                      </a>                                      
                    </li>
                  </ul>
                </div>
              </div>
    				</div>
            {this.state.type == 4 ?
            <div>
              <select id="company_rc">
                <option value="">Select Company</option>
                {this.state.company.map( x =>{
                  return(
                    <option value={x.id_group}>{x.company}</option>
                    )
                })}
              </select>
            </div>:null}
    				{this.state.type != 1 && this.state.type != 4 ?
    				<div>
    					<MydateFilter ref={el => (this.datePicker = el)} changeRequested={true} onChange={this.setDate.bind(this)}/>
    				</div>:null}
    				<div>
    					<button className="button-blue" onClick={this.submit.bind(this)}>Submit</button>
              <button className="button-black outline" onClick={this.reset.bind(this)}>Reset</button>
    				</div>
  		    </div>
    	)
  }
}

export default ReportContent;
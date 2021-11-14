import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router'
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import * as reportApi from '../../../api/reports-api';
import * as G from '../../../api/common-api';
import Column from './chart-types/Column'
import store from '../../../store/configureStore';
import Ripples from 'react-ripples';
import DayPicker from 'react-day-picker';
import MydateFilter from '../../common/datepicker';
import EmailShare from '../../common/EmailShare'

class CategoriesReport extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      duration: 5,
      fromDate: "",
      toDate: "",
      locationID: ""
    }
  }

  componentDidMount() {
    reportApi.getCategoriesReport()
    G.drawHeaderLogo()
  }

  handleClick(){}

  handleInputChange(date){
    let fromDate = G.getDate(date.from, "dd-mm-yyyy")
    let toDate = G.getDate(date.to, "dd-mm-yyyy")
    this.setState({fromDate: fromDate, toDate: toDate, duration: ""})
    reportApi.getCategoriesReport(fromDate, toDate, "", this.state.locationID)
  }

  refreshPage(){
    reportApi.getCategoriesReport("", "", 5, "")
    this.setState({duration: 5, fromDate: "", toDate: "", locationID: ""})
    G.resetDate(this.refs.datePicker)
    this.refs.searchFilter.value = ""
  }

  getCategoriesByDuration(duration){
    reportApi.getCategoriesReport("", "", duration, this.state.locationID)
    this.setState({ duration: duration, fromDate: "", toDate: "", locationID: this.state.locationID })
    G.resetDate(this.refs.datePicker)
  }

  locationChange(e){
    reportApi.getCategoriesReport("", "", 5, e.target.value)
    this.setState({locationID: e.target.value, fromDate: "", toDate: "", duration: 5})
    G.resetDate(this.refs.datePicker)
  }

  downloadExcel(){
    if(this.props.categories && this.props.categories.length > 0) {
     window.open("generate-category-report.php?customerid="+ id_customer+"&duration="+this.state.duration+"&from_date="+this.state.fromDate+"&to_date="+this.state.toDate+"&location="+this.state.locationID);
    }
    else {
      toastr.error("Error", "No data found.", {icon: "icon-error"})
    }
  }

  downloadPDF(){
    if(this.props.categories && this.props.categories.length > 0) {
      let duration = this.state.duration == 1 ? "Now" : (this.state.duration == 2 ? "Day" : (this.state.duration == 3 ? "Week" : (this.state.duration == 4 ? "Month" : "All Time")))
      let sourceTable = document.getElementById("categoryTable");
      let eliteLogo = document.getElementById("eliteCanvasLogo").toDataURL("image/png")
      let customerLogo = document.getElementById("customerCanvasLogo").toDataURL("image/png")
      let canvas = document.getElementsByClassName("canvasjs-chart-canvas")[0]
      let dataURL = canvas.toDataURL()
      let pdf = new jsPDF('p', 'pt', 'a4')
      pdf.addImage(eliteLogo,'PNG',6, 2,155,80);
      pdf.setFontSize(10);
      pdf.text(400, 30, companyName);
      pdf.setTextColor('#CCC');
      pdf.setDrawColor(176,176,176);
      pdf.line(5, 50, 590, 50);
      pdf.setLineWidth(1);
      pdf.setFontSize(12);
      pdf.text(20, 70, 'Duration: ' + ((this.state.fromDate != "" || this.state.toDate != "") ? "Nil" : duration));
      pdf.text(20, 85, 'From Date: ' + (this.state.fromDate ? this.state.fromDate : 'Nil'));
      pdf.text(20, 100, 'To Date: ' + (this.state.toDate ? this.state.toDate : 'Nil'));
      pdf.text(20, 115, 'Location: ' + this.refs.searchFilter.options[this.refs.searchFilter.options['selectedIndex']].innerHTML);
      pdf.text(210, 135, 'Categories Report');
      pdf.addImage(dataURL, 'PNG', 20, 125, 550, 250)
      pdf.setTextColor('#CCC');
      pdf.setDrawColor(176,176,176);
      pdf.line(5, 800, 590, 800);
      pdf.setLineWidth(5);
      /*Footer*/
      pdf.setFontSize(12);
      pdf.text(250, 820, 'KobZo.com');
      let tableJson = pdf.autoTableHtmlToJson(sourceTable);
      pdf.autoTable(tableJson.columns, tableJson.data, {  margin: {top: 430}, avoidPageSplit: false });
      pdf.save(id_customer+"-categories-report.pdf");
    }
    else {
      toastr.error("Error", "No data found.", {icon: "icon-error"})
    }
  }

  mailTo(e){
    const { duration, fromDate, toDate, locationID } = this.state
    reportApi.mailReportAsExcel(duration, fromDate, toDate, locationID, true, 2)
  }

  renderEmailShare() {
    if(this.props.categories && this.props.categories.length > 0) {
      ReactDOM.render(<EmailShare mailTo={this.mailTo.bind(this)} />, document.getElementById("emailShareContent"));
      G.displayModal("emailShare");
    }
    else {
      toastr.error("Error", "No data found.", {icon: "icon-error"})
    }
  }

  printChart(){
    if(this.props.categories && this.props.categories.length > 0) {
      let dataUrl = document.getElementsByClassName("canvasjs-chart-canvas")[0].toDataURL(); //attempt to save base64 string to server using this var  
      let tabContents = ""
      let data = this.props.categories
      let j = 1

      for(var i = 0; i < data.length; i++){
        tabContents += "<tr><td>"+(j++)+"</td><td>"+data[i]['category']+"</td><td>"+data[i]['y']+"</td></tr>";
      }

      let windowContent = '<!DOCTYPE html>';
      windowContent += '<html>';
      windowContent += '<head><title>Category Report</title>';
      windowContent += '<link rel="stylesheet" type="text/css" href="dash/print-style.css"></head>';
      windowContent += '<body onload="window.print()"><div class="print-page"><header><img class="print-logo" src="dash/img/kobster-elite-logo.svg" alt="KobZo Elite Logo"></header>'
      windowContent += '<div><img src="' + dataUrl + '" alt="Canvas Logo"></div>';
      windowContent += '<div id="printTable">\
                          <table class="print-border">\
                            <thead>\
                              <tr>\
                                <th>S.No</th>\
                                <th>Category</th>\
                                <th>Purchase Value</th>\
                              </tr>\
                            </thead>\
                            <tbody>\
                              '+tabContents+'\
                            </tbody>\
                          </table>\
                        </div></div></body>';
      windowContent += '</html>';
      let printWin = window.open('','','');
      printWin.document.open();
      printWin.document.write(windowContent);
      printWin.document.close();
    }
    else {
      toastr.error("Error", "No data found.", {icon: "icon-error"})
    }
  }

  render() {
    const { duration } = this.state
    return (
            <div>
              <div className="reports-filter">
                <div className="duration-filter">
                  <MydateFilter changeRequested={true} ref="datePicker" onChange={this.handleInputChange.bind(this)}/>
                </div>

                <div className="reset-button">
                  <Ripples><button onClick={this.refreshPage.bind(this)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                </div>

                <div className="default-duration-filter">
                  <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getCategoriesByDuration.bind(this, 1)}>Now</button></Ripples>
                  <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getCategoriesByDuration.bind(this, 2)}>Day</button></Ripples>
                  <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getCategoriesByDuration.bind(this, 3)}>Week</button></Ripples>
                  <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getCategoriesByDuration.bind(this, 4)}>Month</button></Ripples>
                  <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getCategoriesByDuration.bind(this, 5)}>All Time</button></Ripples>
                </div>

                <div className="location-filter">
                  <select name="search-filter" ref="searchFilter" onChange={this.locationChange.bind(this)}>
                    <option value="">Across All Locations</option>
                    {this.props.states.map((data, i) => {
                      return(
                        <option key={i} value={data.id_state}>{data.name}</option>
                      )
                    })}
                  </select>
                </div>

                <div className="action-block">
                  <div className="tooltip">
                    <Ripples>
                        <button className="button" onClick={this.downloadExcel.bind(this)}><span><i className="icon-cloud-download"></i></span></button> 
                    </Ripples>
                    <span className="tooltiptext tooltip-bottom gray-color-text">Export as Excel</span>
                  </div>
                  <div className="tooltip">
                    <Ripples>
                      <button className="button" onClick={this.downloadPDF.bind(this)}><span><i className="icon-pdf"></i></span></button>
                    </Ripples>
                    <span className="tooltiptext tooltip-bottom gray-color-text">Export as PDF</span>
                  </div>
                  <div className="tooltip">
                    <Ripples>
                      <button className="button" onClick={this.renderEmailShare.bind(this)}><span><i className="icon-mail"></i></span></button>
                    </Ripples>
                    <span className="tooltiptext tooltip-bottom gray-color-text">Share through E-mail</span>
                  </div>
                  <div className="tooltip">
                    <Ripples>
                      <button className="button" onClick={this.printChart.bind(this)}><span><i className="icon-print"></i></span></button>
                    </Ripples>
                    <span className="tooltiptext tooltip-bottom gray-color-text">Print Report</span>
                  </div>
              </div>

              </div>

              <div className="reports-graph">
                <div className="chart-container">
                  {this.props.isFetching ? <div className="component-spinner"><div className="spinner"></div></div> :
                   (this.props.categories && this.props.categories.length > 0 ? 
                    <Column data={this.props.categories} onClick={this.handleClick.bind(this)} id={"categories-chart"} title={"Categories Report"}/>
                    : <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Data Found!</h2><p>Try broadening your filters.</p></div>)
                  }
                </div>
                <div style={{display: "none"}}>
                  <table id="categoryTable">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Category</th>
                        <th>Purchase Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      {this.props.categories.map((data, i) => {
                        return(
                          <tr key={i}>
                            <td>{++i}</td>
                            <td>{data.category}</td>
                            <td>{data.y+" Rs"}</td>
                          </tr>
                        )
                      })}
                    </tbody>
                  </table>
                </div>
              </div>
        	  </div>
          )
  }
}

const mapStateToProps = function(store) {
  return {
  	categories: store.reportState.categories,
    states: store.addressState.customerStates,
    isFetching: store.reportState.isFetchingCategory
  };
};

export default connect(mapStateToProps)(CategoriesReport);
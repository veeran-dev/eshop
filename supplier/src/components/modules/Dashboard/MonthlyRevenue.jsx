import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import ReactTooltip from 'react-tooltip'
import * as G from '../../../api/common-api'

class MonthlyRevenue extends React.Component {
  render() {
    let x =Object.keys(this.props.data).length > 0 ? this.props.data['currentMonthRevenue']['0'].sm: 0;
    let y =Object.keys(this.props.data).length > 0 ? this.props.data['previousMonthRevenue']['0'].sm: 0;
    let trend = "icon-trending_down";
    if(x == null && y == null){
      let trend = "icon-trending_down";
    }
    else if(x && y){
      x = x.replace(",","");
      y = y.replace(",","");
      console.log(x);
      console.log(y);
      console.log(parseFloat(x));
      console.log(parseFloat(y));

      if(parseFloat(x) < parseFloat(y)){
        trend = "icon-trending_down";
      }
      else{
        trend = "icon-trending_down invert";        
      }
      
    }
    else if(x != null){
        trend = "icon-trending_down invert";
    }
    else if(y != null){
        trend = "icon-trending_down";
    }
    return  (
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-credit green"></i>
            </div>
            <div className="widget-box">
              <div>
                <h3>Monthly Revenue</h3>
                <p>{Object.keys(this.props.data).length > 0 ? G.toPrice(this.props.data['currentMonthRevenue']['0'].sm) : 0}</p>
              </div>
            </div>
            <div className="widget-box" >
                <i
                  data-tip={Object.keys(this.props.data).length > 0 ? "Last Month Revenue: "+G.toPrice(this.props.data['previousMonthRevenue']['0'].sm):""} 
                  className={trend}></i>
            </div>
          </div>
        </div>
    )
  }
}
const mapStateToProps = function({orderState}) {
  return {
    isFetching: orderState.isFetchingHistory
  }
}

export default connect(mapStateToProps)(MonthlyRevenue)
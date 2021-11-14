import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import ReactTooltip from 'react-tooltip'

class SellingProducts extends React.Component {
  render() {
    let cm = Object.keys(this.props.data).length > 0 ? this.props.data.currentMonthSellingProducts[0]['sm']:0;
    let lm = Object.keys(this.props.data).length > 0 ? this.props.data.lastMonthSellingProducts[0]['sm']:0;
    console.log(lm);
    console.log(cm);
    console.log(lm == cm);
    console.log(cm < lm);
    let trend = "icon-trending_down";
    if(lm == 0 && cm != 0){
      trend = "icon-trending_down invert";
    }
    else if(lm == cm){
        trend = "icon-info";
    }
    else if(parseInt(cm) < parseInt(lm) || cm == 0){
      trend = "icon-trending_down";
    }
    else{
      trend = "icon-trending_down invert";
    }
    return  (
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-cart orange"></i>
            </div>
            <div className="widget-box">
                <div>
                  <h3>Selling Products</h3>
                  <p>{Object.keys(this.props.data).length > 0 ? this.props.data.currentMonthSellingProducts[0]['sm'] : 0}</p>
                </div>
            </div>
            <div className="widget-box" >
                <i
                  data-tip={Object.keys(this.props.data).length > 0 ? "Last Month Selling Products: "+this.props.data.lastMonthSellingProducts[0]['sm']:""} 
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

export default connect(mapStateToProps)(SellingProducts)
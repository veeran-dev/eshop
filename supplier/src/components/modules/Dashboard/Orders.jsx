import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'

class Quotation extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      status: [],
    }
  }

  componentWillReceiveProps(nextProps){
    if(nextProps.data.orderStateCount != undefined){
      let arr = nextProps.data.orderStateCount.filter(map=>{ if(map['id_order_state']==19 || map['id_order_state']==22){return(map)}})
      this.setState({status:arr},(e)=>console.log(status))
    }
  }

  toRedirect(){
    this.props.redirect("/orders");
  }

  render() {
    return  (
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-orders blue"></i>
              <h3>Orders</h3>            
            </div>
            <div className="widget-box">
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{this.state.status.length > 0 ? this.state.status[1]['cn']: ""}</h3></div>
                <div>{this.state.status.length > 0 ? this.state.status[1]['name']: ""}</div>
              </div>
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{this.state.status.length > 0 ? this.state.status[0]['cn']: ""}</h3></div>
                <div>{this.state.status.length > 0 ? this.state.status[0]['name']: ""}</div>
              </div>
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

export default connect(mapStateToProps)(Quotation)
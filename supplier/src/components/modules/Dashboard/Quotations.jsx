import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'

class Quotation extends React.Component {
  constructor(props){
    super(props)
    this.state = {
    }
  }

  toRedirect(){
    this.props.redirect("/quotations");
  }

  render() {
    return 	(
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-credit orange"></i>
              <h3>Quotations</h3>            </div>
            <div className="widget-box">
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{this.props.data.newCount != undefined ? this.props.data.newCount['0']['count']:0}</h3></div>
                <div>New Quotations</div>
              </div>
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{this.props.data.Submitted != undefined ? this.props.data.Submitted['0']['count']:0}</h3></div>
                <div>Submitted</div>
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
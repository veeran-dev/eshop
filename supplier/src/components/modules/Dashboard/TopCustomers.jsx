import React from 'react'
import { connect } from 'react-redux'
import Column from '../reports/chart-types/TopCustomers'
import * as salesApi from '../../../api/sales-api'
import store from '../../../store/configureStore'

class TopCustomers extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      fromDate: "",
      toDate: "",
      duration: 5,
      width: 0,
    }
  }
  
  componentDidMount() {
  	salesApi.getTopCustomers()
    console.log(document.getElementById('top-customer-dashboard'))
    console.log()
    this.setState({width: document.getElementById('top-customer-dashboard').offsetWidth})
  }
  
  handleClick(){

  }

  render() {
  	 return <div className="widget" id="top-customer-dashboard">
        <div className="widget-header">
          <h3>Top Customers</h3>
        </div>
        {this.props.isFetching ? <div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
          (this.props.topCustomers && this.props.topCustomers.length > 0 ?
            <Column width={this.state.width} data={this.props.topCustomers} onClick={this.handleClick.bind(this)} id={"top-customers-chart"} title={""}/>
          : <div className="no-results small"><h2>No Data Found!</h2><p>Try broadening your filters.</p></div>)
        }
			</div>
  }
}

const mapStateToProps = function({salesState}) {
  return {
  	topCustomers: salesState.top_customer,
    isFetching:  salesState.isFetchingTopCustomers
  }
}

export default connect(mapStateToProps)(TopCustomers)


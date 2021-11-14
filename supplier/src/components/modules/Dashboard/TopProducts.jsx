import React from 'react'
import { connect } from 'react-redux'
import Column from '../reports/chart-types/TopProducts'
import * as salesApi from '../../../api/sales-api'
import store from '../../../store/configureStore'

class TopCustomers extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      fromDate: "",
      toDate: "",
      duration: 5
    }
  }
  
  componentDidMount() {
    salesApi.getTopProducts()
    this.setState({width: document.getElementById('top-products-dashboard').offsetWidth})
  }

  handleClick(){}

  render() {
  	 return <div className="widget" id="top-products-dashboard">
        <div className="widget-header">
          <h3>Top Products</h3>
        </div>
        {this.props.isFetching ? <div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
          (this.props.topSoldProducts && this.props.topSoldProducts.length > 0 ?
            <Column width={this.state.width} data={this.props.topSoldProducts} onClick={this.handleClick.bind(this)} id={"top-products-dashboard-chart"} title={""}/>
          : <div className="no-results small"><h2>No Data Found!</h2><p>Try broadening your filters.</p></div>)
        }
			</div>
  }
}

const mapStateToProps = function({salesState}) {
  return {
  	topSoldProducts: salesState.top_sold_products,
    isFetching:  salesState.isFetchingTopCustomers
  }
}

export default connect(mapStateToProps)(TopCustomers)


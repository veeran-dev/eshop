import React from 'react'
import { connect } from 'react-redux'
import Column from '../reports/chart-types/MonthlySales'
import * as salesApi from '../../../api/sales-api'
import store from '../../../store/configureStore'

class MonthlySales extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      fromDate: "",
      toDate: "",
      duration: 5
    }
  }
  
  componentDidMount() {
  	salesApi.getMonthlySales()
  }

  handleClick(){}

  render() {
  	 return <div className="widget">
        <div className="widget-header">
          <h3>Monthly Sales</h3>
        </div>
        {this.props.isFetching ? <div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
          (this.props.monthlySales && this.props.monthlySales.length > 0 ?
            <Column data={this.props.monthlySales} onClick={this.handleClick.bind(this)} id={"monthly-sales-chart"} title={""}/>
          : <div className="no-results small"><h2>No Data Found!</h2><p>Try broadening your filters.</p></div>)
        }
			</div>
  }
}

const mapStateToProps = function({salesState}) {
  return {
  	monthlySales: salesState.monthly_sales,
    isFetching:  salesState.isFetching
  }
}

export default connect(mapStateToProps)(MonthlySales)


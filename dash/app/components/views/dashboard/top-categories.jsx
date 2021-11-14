import React from 'react'
import { connect } from 'react-redux'
import Column from '../reports/chart-types/TopCategories'
import * as G from '../../../api/common-api'
import * as dashboardApi from '../../../api/dashboard-api'
import store from '../../../store/configureStore'

class TopCategories extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      fromDate: "",
      toDate: "",
      duration: 5
    }
  }
  
  componentDidMount() {
  	dashboardApi.topCategories(this.state.fromDate, this.state.toDate, this.state.duration)
  }

  handleClick(){}

  render() {
  	 return <div className="widget">
        <div className="widget-header">
          <h3>Top Categories</h3>
          <button className="close" onClick={G.uninstallWidget.bind(this, this.props.widgetId)}><i className="icon-close"></i></button>
        </div>
        {this.props.isFetching ? <div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
    		  (this.props.topCategory && this.props.topCategory.length > 0 ?
            <Column data={this.props.topCategory} onClick={this.handleClick.bind(this)} id={"top-categories-chart"} title={""}/>
          : <div className="no-results small"><h2>No Data Found!</h2><p>Try broadening your filters.</p></div>)
        }
			</div>
  }
}

const mapStateToProps = function(store) {
  return {
  	topCategory: store.dashboardState.topCategory,
    isFetching:  store.dashboardState.isFetchingCategories
  }
}

export default connect(mapStateToProps)(TopCategories)


import React from 'react'
import { connect } from 'react-redux'
import * as dashboardApi from '../../../api/dashboard-api'

class PromotionalBanner extends React.Component {
  sendMailToRM = () => {
  	dashboardApi.sendPromotionalMailToRM()
  }

  componentWillMount(){
    dashboardApi.getEliteDealsDetails();
  }

  render = () => {
    return( <div className="widget promotion-widget">
              <a href={this.props.eliteDeals.link} target="_blank">
                <img src={this.props.eliteDeals.img} alt="Promotion Banner"/>
              </a>
           </div>
          )
  }
}

const mapStateToProps = function(store) {
  return {
    eliteDeals: store.dashboardState.eliteDeals,
  }
}

export default connect(mapStateToProps)(PromotionalBanner)
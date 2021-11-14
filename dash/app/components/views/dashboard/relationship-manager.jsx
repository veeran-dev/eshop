import React from 'react'
import { connect } from 'react-redux'
import * as dashboardApi from '../../../api/dashboard-api'
import store from '../../../store/configureStore'

class RelationshipManager extends React.Component {
  componentDidMount() {
  	dashboardApi.getRM()
  }

  render() {
    return <div className="widget relationship-manager">
					<h3>Relationship Manager (RM)</h3>
    			{this.props.isFetching ? <div className="fetching small" colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div>  : 
            (this.props.relationshipManager && this.props.relationshipManager.length > 0 ? this.props.relationshipManager.map((data, i) => {
      				return(
      					<div key={i}>
                  <img className="avatar" src="dash/img/rm/avatar.png" width="64" height="64" alt="RM Profile Picture" />
  		    				<p><i className="icon-account"></i> {data.firstname+" "+data.lastname}</p>
  		    				{/*<p><a href={`tel:${data.phone}`}><i className="icon-phone"></i>{data.phone}</a></p>*/}
									<p><a href="tel:+91 93611 33463"><i className="icon-phone"></i>+91 93611 33463 (10am - 6pm)</a></p>
  		    				<p><a href={`mailto:hello@kobzo.com`}><i className="icon-mail"></i>hello@kobzo.com</a></p>
  		    			</div>
  	    			)
      			}) : <div>No Relationship Manager info found.</div>)}
    	   </div>
  }
}

const mapStateToProps = function(store) {
  return {
  	relationshipManager: store.dashboardState.relationshipManager,
    isFetching: store.dashboardState.isFetchingRm
  };
};

export default connect(mapStateToProps)(RelationshipManager)
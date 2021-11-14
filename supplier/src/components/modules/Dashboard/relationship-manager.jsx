import React from 'react'
import { connect } from 'react-redux'
import store from '../../../store/configureStore'

const RelationshipManager = () => {
    return(
         <div className="widget relationship-manager">
			<h3>Contact Support</h3>
			<div className="wrapper"> 
				<div className="profile-icon">
	      			<i className="icon-round-account"></i>
	  			</div>
	  			<div className="contact">
					<p><a href="tel:8939816163"><i className="icon-phone"></i>8939816163 (10AM - 6PM)</a></p>
					<p><a href={`mailto:support@kobster.com`}><i className="icon-mail"></i>support@kobster.com</a></p>
				</div>
			</div>
	   </div>
   )
}

export default RelationshipManager
import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';

class HotelInfo extends React.Component {
	constructor(props){
		super(props)
	}

	componentDidMount(){}

	render(){
		return (
		    <div>
		    	<div>Hotel Information</div>
			</div>
	    )
	}
}

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(HotelInfo);
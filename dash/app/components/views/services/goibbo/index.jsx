import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';

class Goibbo extends React.Component {
  constructor(props){
  	super(props)
  }

  render() {
    return (
    	<div>
    	 <div>Goibbo</div>
    	</div>
    );
  }
}

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(Goibbo);
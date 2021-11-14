import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';

class Zomato extends React.Component {
  constructor(props){
  	super(props)
  }

  render() {
    return (
    	<div>
    	 <div>Zomato</div>
    	</div>
    );
  }
}

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(Zomato);
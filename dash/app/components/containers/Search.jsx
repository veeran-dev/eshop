import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import SearchHeader from '../common/SearchHeader'
import SearchResults from '../views/widgets/SearchProduct/Search-results'
import * as G from '../../api/common-api'
import {search} from '../../api/search-api'
import store from '../../store/configureStore'
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class SearchProduct extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount(){
  	G.checkWidget(21, true)
    search(1, this.props.params.query, [], [], [], "","", true)

  }

  render() {
    return (
    	<div>
    	{(this.props.widgetStatus == 1) ?
	    	<div>
		      <SearchHeader query={this.props.params.query} />
		      <div className="search-product-container">{this.props.children}</div>
		    </div> :
				(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={21} /> : 
	      (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
		  </div>
	 )
  }
}

SearchProduct.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus
  }
};

export default connect(mapStateToProps)(SearchProduct)  
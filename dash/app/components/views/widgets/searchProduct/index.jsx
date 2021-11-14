import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';

import SearchWeb from './search-web'
import SearchMobile from './search-mobile'
class SearchProduct extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isMobile: false,
    }
  }

  componentWillMount(){
    console.log(this.context);
    G.checkWidget(21, true)
    if(window.innerWidth <= 992) {
       this.setState({isMobile: true})
     } else {
       this.setState({isMobile: false})
     }
  }

  render() {
    let query = this.props.searchFilters.query;
    return(
      <div className="sp_search">
        {(this.props.widgetStatus == 1) ? (this.state.isMobile ? <SearchMobile /> : <SearchWeb query={query}/>): <div></div>}
      </div>
    )
  }
}

SearchProduct.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    widgetStatus: store.commonState.widgetStatus,
    searchFilters: store.searchState.search_data,
  };
};

export default connect(mapStateToProps)(SearchProduct);
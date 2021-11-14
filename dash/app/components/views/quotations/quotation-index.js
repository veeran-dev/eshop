import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Desktop from './quotation-list-desktop'
import Mobile from './quotation-list-mobile'
import DayPickerInput from '../../common/datepickerSingle'
import * as quotationsApi from '../../../api/quotations-api'
import store from '../../../store/configureStore'

class QuotationLists extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
    };
  }

  componentWillMount(){
    if(window.innerWidth <= 992) {
       this.setState({isMobile: true})
     } else {
       this.setState({isMobile: false})
     }
    // quotationsApi.getQuotationsRequests("", 0, true);
  }
    render() {
        return (
          <div>
            {this.state.isMobile != true ? <Desktop /> : <Desktop />}
          </div>
        )
    }
}

QuotationLists.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    quotations: store.quotationState.quotationRequestsList,
    isFetching: store.quotationState.isFetching,
    count: store.quotationState.quotationRequestsListCount,
  }
};

export default connect(mapStateToProps)(QuotationLists)
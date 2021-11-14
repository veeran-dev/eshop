import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import Desktop from './quotation-details-desktop'
import Mobile from './quotation-details-mobile'
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
    let id_quotation = this.props.params.idQuotations;
    quotationsApi.getQuotationsDetails(id_quotation);
  }
    render() {
        return (
          <div>
            {this.state.isMobile != true ? <Desktop /> : <Mobile suppliers={this.props.suppliers} />}
          </div>
        )
    }
}

QuotationLists.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    quotations: store.quotationState.quotationDetails,
    suppliers: store.quotationState.suppliers,
    isFetching: store.quotationState.isFetching,
  }
};

export default connect(mapStateToProps)(QuotationLists)
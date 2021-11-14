import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import ProcureHeader from '../procure/procure-header'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import WidgetNotInstalled from '../../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../../common/empty-states/widget-no-access';

class FaqsCategoryDetails extends React.Component {
  constructor(props){
  	super(props)
  }
  
  render() {
      let faqId = this.props.params.faqCategoryDetail.split("-")[0]
      return (
        <div className="">
            {this.props.helpFAQs.map((data, i) => {
                return (
                  <div key={i}>
                    {(data.id == faqId) ?
                      <div className="faq-category">
                        <h4 className="faq-category-title">{data.category}</h4>
                        <div className="faq-questions">
                          {data.faqs && data.faqs.length > 0 ? data.faqs.map((faqs, i) => {
                            return (
                              <div key={i}>
                                <p className="faq-question"><Link to={"help-faqs/answer/"+faqs.id}>{faqs.Question}</Link></p>
                              </div>
                            )
                          }) : <div>No questions found in this category.</div>}
                        </div>
                      </div>
                    : null}
                  </div>
                )
            })}
      </div>
    )
  }
}

FaqsCategoryDetails.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	helpFAQs: store.commonState.helpFAQs
  }
};

export default connect(mapStateToProps)(FaqsCategoryDetails)
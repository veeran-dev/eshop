import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import ProcureHeader from '../procure/procure-header'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import WidgetNotInstalled from '../../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../../common/empty-states/widget-no-access';

class Faqs extends React.Component {
  constructor(props){
  	super(props)
  }

  render() {
      return (

          <div className="faq-index">
            {this.props.helpFAQs.map((data, i) => {
                return (
                  <div className="faq-category" key={i}>
                    <Link className="faq-category-title" to={"help-faqs/category/"+(data.id+"-"+data.category.split(" ").join("-")).toLowerCase()}>{data.category}</Link>
                    <div className="faq-questions">
                      {data.faqs && data.faqs.length > 0 ? data.faqs.map((data, i) => {
                        return (
                          <div>{i < 5 ? <p key={i} className="faq-question"><Link to={"help-faqs/answer/"+data.id}>{data.Question}</Link></p> : null}</div>
                        )
                      }) : <div className="">No questions found!</div>}
                    </div>
                    {data.faqs.length > 5 ? <Link className="view-all-question" to={"help-faqs/category/"+(data.id+"-"+data.category.split(" ").join("-")).toLowerCase()}>View all questions in {data.category}</Link> : null}
                  </div>
                )
            })}
          </div>
    )
  }
}

const mapStateToProps = function(store) {
  return {
  	helpFAQs: store.commonState.helpFAQs
  }
};

export default connect(mapStateToProps)(Faqs)
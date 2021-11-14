import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import ProcureHeader from '../procure/procure-header'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import WidgetNotInstalled from '../../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../../common/empty-states/widget-no-access';

class FaqAnswer extends React.Component {
  constructor(props){
  	super(props)
  }

  goBack() {
    document.getElementById("searchFaqs").value = ""
    this.context.router.goBack()
  }
  
  render() {
      let questionId = this.props.params.questionId

      var answer = new Array(), questionLine = ""
      for(var i = 0; i < this.props.helpFAQs.length; i++) {
          questionLine = this.props.helpFAQs[i].faqs.filter(function(l){
              return l.id == questionId;
          });

          if(questionLine && questionLine.length > 0) {
            for(var j = 0; j < questionLine.length; j++) {
              questionLine[j]['category'] = this.props.helpFAQs[i].category
              answer.push(questionLine[j]);
            }
          }
      }

      return (
        <div className="faq-item">
            {answer.map((data, i) => {
                return (
                  <div key={i}>
                    <h3 className="faq-question">{data.Question}</h3>
                    <p className="faq-answer">{data.Answer}</p>
                  </div>
                )
            })}
      </div>
    )
  }
}

FaqAnswer.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	helpFAQs: store.commonState.helpFAQs
  }
};

export default connect(mapStateToProps)(FaqAnswer)
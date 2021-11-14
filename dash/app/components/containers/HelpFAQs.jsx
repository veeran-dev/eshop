import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import ProcureHeader from '../views/procure/procure-header'
import * as G from '../../api/common-api'
import store from '../../store/configureStore'
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class HelpFAQs extends React.Component {
  constructor(props){
  	super(props)
    this.state = {
      showSearchResults: false,
      searchResults: [],
      isLoading: false
    }
  }

  componentDidMount(){
    G.getFAQs()
  }

  filterFaqs(e) {
    if(e.target.value != "") {
      this.setState({
        showSearchResults: true,
        isLoading: true
      })

      var questions = new Array(), questionLine = ""
      for(var i = 0; i < this.props.helpFAQs.length; i++) {
          questionLine = this.props.helpFAQs[i].faqs.filter(function(l){
              return l.Question.toLowerCase().match( e.target.value );
          });

          if(questionLine && questionLine.length > 0) {
            for(var j = 0; j < questionLine.length; j++) {
              questionLine[j]['category'] = this.props.helpFAQs[i].category
              questions.push(questionLine[j]);
            }
          }
      }

      this.setState({
        searchResults: questions,
        isLoading: false
      })
    }
    else {
      this.setState({
        showSearchResults: false
      })
    }
  }

  goToAnswer(answerId) {

    this.setState({
      showSearchResults: false,
      searchResults: []
    })

    this.context.router.push("help-faqs/answer/"+answerId);
  }

  render() {
      const { showSearchResults, searchResults, isLoading } = this.state
      return (
        <div className="">
          <div className="page-header">
            <button className="back" onClick={this.context.router.goBack.bind(this)}>
              <i className="icon-back-arrow"></i>
            </button>
            <h3 className="page-title">Help/FAQs</h3>
            <div className="faq-search">
              <input
                id="searchFaqs" 
                type="text" 
                placeholder="Have a question? Search for answers"
                onChange={this.filterFaqs.bind(this)}  />
            </div>
          </div>
          {!showSearchResults ? 
            <div className="page-container">
              {this.props.children}
            </div> : 
            <div className="page-container">
              {isLoading ? <div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
                <div className="faq-category">
                  <h4 className="faq-category-title">Search Results</h4>
                  {searchResults && searchResults.length > 0 ? searchResults.map((data, i) => {
                    return (
                      <div key={i}>
                        <p className="faq-question"><a href="javascript:void(0)" onClick={this.goToAnswer.bind(this, data.id)}>{data.Question}</a><span className="faq-question-category">{data.category}</span></p>
                      </div>
                    )
                  }) : <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No questions found!</h2><p>Enter more keywords and try.</p></div>}
                </div> }
            </div>}
      </div>
    )
  }
}

HelpFAQs.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    helpFAQs: store.commonState.helpFAQs
  }
};

export default connect(mapStateToProps)(HelpFAQs)
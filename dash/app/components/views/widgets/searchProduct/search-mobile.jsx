import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';

class Search extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isMobile: false,
      showSearch: false,
    }
  }

  componentWillMount = () => {
    G.checkWidget(21, true)
    if(window.innerWidth <= 992) {
       this.setState({isMobile: true})
     } else {
       this.setState({isMobile: false})
     }
  }

  onsearch=()=>{
    // console.log(this)
    // let query = this.refs.search_query.value
    this.setState({showSearch: false})
    // this.context.router.push("searchProducts/results/"+query)
    let url_ref = window.location.href.includes("elite2#/") ? "elite2#/": window.location.href.includes("dash-index#/")?"dash-index#/":"dash-index.php#/";
    let url = window.location.href.split(url_ref);
    let query = this.refs.search_query.value
    if(query.trim() !== ""){
      window.location.href = url['0']+''+url_ref+'searchProducts/results/'+query;
      window.location.reload()
    }
  }
  

  render() {
    return(
      <div className="topbar-item-mobile">
          <i className="icon-search" onClick={(e)=>this.setState({showSearch: true})}></i>
          <div className={this.state.showSearch == true ?"sp-mobile-search show-search":"sp-mobile-search"}>
              <div className="sp-mobile-search-wrapper">
                  <div className="close-search">
                    <i className="icon-back-arrow" onClick={(e)=>this.setState({showSearch: false})}></i>
                  </div>
                  <div className="sp-mobile-search-input">
                    <input type="text" 
                    placeholder="Search product name or code and find supplier" 
                    ref="search_query"
                    onKeyPress={event => {
                      if (event.key === 'Enter') {
                        this.onsearch() 
                      }
                    }}/>
                    <button className="button-blue" onClick={this.onsearch.bind(this)}><i className="icon-search"></i></button>
                  </div>
              </div>
          </div>
      </div>
    )
  }
}

Search.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    widgetStatus: store.commonState.widgetStatus
  };
};

export default connect(mapStateToProps)(Search);
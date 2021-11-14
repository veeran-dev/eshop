import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import {search} from '../../../../api/search-api'
class SearchWeb extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      input: "",
    }
  }
  componentWillMount(){
    console.log(this.context);
    this.setState({input: this.props.query})
  }

  _onsearch=()=>{
    // console.log(this)
    // console.log(this.router)
    // this.context.router.push('/searchProducts/results/mano');
    if(window.location.href.includes("searchProducts/results/")){
      let url = window.location.href.split('searchProducts/results/');
      let query = this.refs.search_query.value
      if(query.trim() !== ""){

        this.context.router.push('/searchProducts/results/'+query);
        // window.location.href = url['0']+'searchProducts/results/'+query
        // window.location.reload()
      }
    }
    else{
      let url_ref = window.location.href.includes("elite2#/") ? "elite2#/": window.location.href.includes("dash-index#/")?"dash-index#/":"dash-index.php#/";
      let url = window.location.href.split(url_ref);
      let query = this.refs.search_query.value
      if(query.trim() !== ""){
        this.context.router.push('/searchProducts/results/'+query);
      //   window.location.href = url['0']+''+url_ref+'searchProducts/results/'+query;
      //   window.location.reload()
      }
    }
  }

  updateInput(e){
    this.setState({
       input: e.target.value,
    });
  }

  _handleKeyDown = (e) => {
    console.log(this.context);
    if (e.key === 'Enter') {
      if(window.location.href.includes("searchProducts/results/")){
        let url = window.location.href.split('searchProducts/results/');
        let query = this.refs.search_query.value
        if(query.trim() !== ""){
          window.location.href = url['0']+'searchProducts/results/'+query
          window.location.reload()
        }
      }
      else{
        let url_ref = window.location.href.includes("elite2#/") ? "elite2#/": window.location.href.includes("dash-index#/")?"dash-index#/":"dash-index.php#/";
        let url = window.location.href.split(url_ref);
        let query = this.refs.search_query.value
        
        if(query.trim() !== ""){
          window.location.href = url['0']+''+url_ref+'searchProducts/results/'+query;
          window.location.reload()
        }
      }
    }
  }

  render() {
    return(
      <div className="sp-container">
        <input type="text" placeholder="Search product name or code and find supplier" 
              ref="search_query"
              onKeyDown={this._handleKeyDown.bind(this)}
              onChange={this.updateInput.bind(this)}
              value={this.state.input}
              />
        <div onClick={this._onsearch.bind(this)}><i className="icon-search" /></div>
      </div>
    )
  }
}

SearchWeb.contextTypes = {
  router: React.PropTypes.object.isRequired
};
export default SearchWeb;
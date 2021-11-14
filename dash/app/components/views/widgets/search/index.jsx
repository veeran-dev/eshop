import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import axios from 'axios';
import store from '../../../../store/configureStore';
import Autosuggest from '../../../../components/common/autocomplete/AutosuggestContainer';
import * as G from '../../../../api/common-api';
import WidgetNotInstalled from '../../../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../../../common/empty-states/widget-no-access';
import cookie from 'react-cookie';

class Search extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      value: '',
      mobileSearch: 'is-hidden-mobile',
      suggestions: [],
      searchLoading:false,
      searchWidgetStatus: ""
    }

    cookie.save("search_type", 2)
  }

  componentDidMount = () => {
    G.checkSearchWidget(18, true)
  }

  componentWillReceiveProps = (nextProps) => {
    if(this.props.searchWidgetStatus != nextProps.searchWidgetStatus) 
      this.state.searchWidgetStatus = nextProps.searchWidgetStatus
  }

  _handleMobileSearch = (e) => {
      e.preventDefault();
        if (this.state.mobileSearch === 'is-hidden-mobile'){
            this.setState({mobileSearch: 'is-active-mobile'});
            document.body.classList.add('modal-open');
        }else {
            this.setState({mobileSearch: 'is-hidden-mobile'});
            document.body.classList.remove('modal-open');
        }
    this.setState({isMobileSearch: true});
    }

  changeSearchType = (e) => {
    if(cookie.load("search_type"))
      cookie.remove("search_type")
    cookie.save("search_type", e.target.value)
  }

  searchProduct = (e) => {
    let keyCode = (window.Event) ? e.which : e.keyCode
    if(keyCode == 13){
      if(e.target.value.length > 2){
        this.setState({mobileSearch: 'is-hidden-mobile'});         
            document.body.classList.remove('modal-open');
        G.goToSearch(e.target.value, this.context.router,cookie.load("search_type"))//g - common api folder -> api/common-api.jsx
      }
      else
        toastr.error("Error", "Atleast 3 characters required to perform search")
    }
  }

  onChangeHandle = (event, { newValue }) => {
    this.setState({ value: newValue })
  }

  getSuggestionValue = (suggestion) => {
    return suggestion.name;   
  }

  getSectionSuggestions = (section) => {
    return section.suggestions;
  }

  // Use your imagination to render suggestions.
  renderSuggestion = (suggestion) => {
    if(suggestion.type != 0) {
      return(
        <div>
          <a href="javascript:void(0)" onClick={this.goToProduct.bind(this, suggestion.id, suggestion.name, suggestion.type)}>
            {/*<span>{suggestion.type == 2 ? <img src={suggestion.image_link} alt={suggestion.name} /> : null}</span> */}
            <span className={"search-result"}>
              {suggestion.name}
            </span>
          </a>
        </div>
      )
    }
  }

  onSuggestionsFetchRequested = ({ value }) => {
      setTimeout(() => {
        if (value === this.state.value) {
          if(value.length > 2) {
            this.getMatchedProducts(value)
          }
        }
      }, 200);
  }

  onSuggestionsClearRequested = () => {
      this.setState({
        suggestions: []
      });
  }

  renderSectionTitle = (section) => {
    return (
        <strong>{section.title}</strong>
    );
  }

  getMatchedProducts = (query) => {
    let searchType = cookie.load("search_type"), idCustomer

    if(searchType == 2)
        idCustomer = '&id_customer='+id_customer
    else
        idCustomer = "";
    this.setState({searchLoading:true})
  
    return axios.get('search.php?q='+query+'&ajaxSearch=true&ajax=true&suggest=3&id_lang=1'+idCustomer, 
            {transformRequest: [function (data) { 
                        document.getElementById('loader').style.visibility = 'hidden';
                        return data;
                      }]}).then(response => {
      document.getElementById('loader').style.visibility = 'hidden';

      if(typeof response.data == 'object') {
        var suggest_results = [];
        for(var key in response.data) {
          if (response.data.hasOwnProperty(key)) {
            suggest_results.push({
                title: key,
                suggestions: response.data[key]
              }
            )
          }
        }
      }
      
      this.setState({suggestions: suggest_results, searchLoading:false})

      return response.data
    })
  }

  goToProduct = (id,name,type) => {
    this.setState({mobileSearch: 'is-hidden-mobile'});
      document.body.classList.remove('modal-open');
      if(type==1) {
      //procureBuyApi.getListCategoryProductsWithFilters(id)
      this.context.router.push("category/"+id)
    }
    else if(type ==2) {
      G.getProductById(id)
      this.context.router.push("product/"+id)
    }
    else if(type == 3){
      //procureBuyApi.getBrandById(id)
      this.context.router.push("brand/"+id)
    }
  }


  render() {
    let searchTypeSelected = cookie.load("search_type")
    this.state.searchWidgetStatus = this.props.searchWidgetStatus
  const { value, suggestions, searchWidgetStatus } = this.state;
    // Autosuggest will pass through all these props to the input field.
    const inputProps = { placeholder: 'Type Product name or Product Code or Manufacturer code', value, onKeyPress: this.searchProduct.bind(this), onChange: this.onChangeHandle.bind(this)};
    return(
      <div className={!this.props.isMobile ? "search-widget" : "search-widget mobile"}>
        {searchWidgetStatus == 1 ? 
          <div>
          {!this.props.isMobile ?
          <div className="searchbox">
                <select name="search-filter" id="search-filter" onChange={this.changeSearchType.bind(this)}>
                    <option value="1" selected={searchTypeSelected ? (searchTypeSelected == 1 ? true: false) : false}>All Products</option>
                    <option value="2" selected={searchTypeSelected ? (searchTypeSelected == 2 ? true : false) : true}>My Products</option>
                </select>
            <Autosuggest
              multiSection={true}
              suggestions={suggestions}
              onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
              onSuggestionsClearRequested={this.onSuggestionsClearRequested}
              getSuggestionValue={this.getSuggestionValue}
              renderSuggestion={this.renderSuggestion.bind(this)}
              renderSectionTitle={this.renderSectionTitle}
              getSectionSuggestions={this.getSectionSuggestions}
              inputProps={inputProps} 
              id="globalSearch"
              onKeyPress={this.searchProduct.bind(this)}
              className="search-box" 
            />
            <div className="loading-indicator">{this.state.searchLoading ? <div className="spinner inline"></div> :null}</div>
          </div>
          :
          <div className="topbar-item-mobile">
            <a href="#" className="mobile-search-button" id={this.state.mobileSearch} onClick={this._handleMobileSearch.bind(this)}>
              <i className="icon-search"></i>
            </a>
            <div className="mobile-search">
              <div className="mobile-search-header">
                <a className="mobile-search-button" onClick={this._handleMobileSearch.bind(this)}>
                  <i className="icon-back-arrow"></i>
                </a>
                <h3>Search</h3>
              </div>
              <div className="mobile-search-container">
                <div className="searchbox">
                      <select name="search-filter-mobile" id="search-filter-mobile" onChange={this.changeSearchType.bind(this)}>
                        <option value="1" selected={searchTypeSelected ? (searchTypeSelected == 1 ? true: false) : false}>All Products</option>
                        <option value="2" selected={searchTypeSelected ? (searchTypeSelected == 2 ? true : false) : true}>My Products</option>
                      </select>
                 
                  <Autosuggest
                    multiSection={true}
                    suggestions={suggestions}
                    onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
                    onSuggestionsClearRequested={this.onSuggestionsClearRequested}
                    getSuggestionValue={this.getSuggestionValue}
                    renderSuggestion={this.renderSuggestion.bind(this)}
                    renderSectionTitle={this.renderSectionTitle}
                    getSectionSuggestions={this.getSectionSuggestions}
                    id="mobileSearch"
                    inputProps={inputProps} 
                    onKeyPress={this.searchProduct.bind(this)}
                    className="search-box" 
                  />
                  <div>{this.state.searchLoading ? <div className="spinner inline"></div> :null}</div>
                </div>                  
              </div>
            </div>
          </div>
        }
      </div>
    : null}
    </div>
    )
  }
}

Search.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    searchWidgetStatus: store.commonState.searchWidgetStatus,
  };
};

export default connect(mapStateToProps)(Search);
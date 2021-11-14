import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';
import Input from '../../../common/Input'
import Ripples from 'react-ripples'
import Autosuggest from '../../../common/autocomplete/AutosuggestContainer';
import MydateFilter from '../../../common/datepicker';
import axios from 'axios';

class Expedia extends React.Component {
  constructor(props){
  	super(props)
    this.state = {
      value: '',
      suggestions: [],
      hotelAvailability: ""
    }
  }

  onChangeHandle(event, { newValue }){
      this.setState({ value: newValue })
  }

  onSuggestionsFetchRequested = ({ value }) => {
      setTimeout(() => {
        if (value === this.state.value) {
          this.getHotelsSuggestions(value)
          this.setState({ hotelID: ""})
        }
      }, 200);
  };

  onSuggestionsClearRequested = () => {
      this.setState({
        suggestions: []
      });
  };

  getHotelsSuggestions(value) {
    return axios.get('http://terminal2.expedia.com/x/suggestions/hotels?query='+value+'&apikey=LL2D04YN1TlILmHqNkRqiREGxYusxYRT', 
          {transformRequest: [function (data) { document.getElementById('loader').style.visibility = 'hidden'; return data; }]}).then(response => {
              
              if(response.data.sr)
                this.setState({suggestions: response.data.sr})
              else
                this.setState({suggestions: []})

              return response.data
    })
  }

  getSuggestionValue(suggestion) {
    return suggestion.f;
  }

  // Use your imagination to render suggestions.
  renderSuggestion(suggestion) {
    return (
      <div>
        <a href="javascript:void(0)">
        <p className="search-result">
          <span dangerouslySetInnerHTML={{__html: suggestion.d}}></span>
        </p>
      </a>
      </div>
    );
  }

  searchHotels(){
    let fromDate = "", toDate = "", searchQuery
    searchQuery = document.getElementById("hotelSearch").value
    fromDate = document.getElementById("from-date-hidden").value
    toDate = document.getElementById("to-date-hidden").value
    
    if(searchQuery != "" && fromDate != "" && toDate != ""){
         G.getHotels(searchQuery, G.getDate(fromDate, "yyyy-mm-dd"), G.getDate(toDate, "yyyy-mm-dd"), this.context.router)
    }
    else
      alert("Please fill all required field to proceed.");
  }

  render() {
    const { value, suggestions } = this.state;
    // Autosuggest will pass through all these props to the input field.
    const inputProps = { id: "hotelSearch", placeholder: 'Destination, hotel name, landmark or address', value, onChange: this.onChangeHandle.bind(this)};
    
    return (
    	<div className="services">
          <div className="page-header">
            <h3 className="page-title">Expedia</h3>
              <div className="action-block">
                {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
              </div>
          </div>
          <div className="page-container">
              <div className="step">
                <div className="form-group">
                  <div className="form-control">
                    <div>Search for hotels</div>
                      <Autosuggest
                          suggestions={suggestions}
                          getSuggestionValue={this.getSuggestionValue}
                          renderSuggestion={this.renderSuggestion.bind(this)}
                          onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
                          onSuggestionsClearRequested={this.onSuggestionsClearRequested}
                          inputProps={inputProps} 
                          className="search-box"
                          id="hotelSearch"/>
                  </div>
                </div>
              </div>
              <div className="step">
                  <div className="form-control">
                    <div>Check in and out Date</div>
                      <MydateFilter ref="datePicker" fromPlaceholder={"dd/mm/yyyy"} toPlaceholder={"dd/mm/yyyy"} changeRequested={false} />
                  </div>
              </div>
              <button onClick={this.searchHotels.bind(this)}>Search</button>
          </div>
          <div className="resultsContainer">
            {this.props.children}
          </div>
      </div>
    );
  }
}

Expedia.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(Expedia);
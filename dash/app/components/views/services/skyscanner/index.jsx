import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import axios from 'axios';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';
import * as servicesApi from '../../../../api/services-api'
import Input from '../../../common/Input'
import Ripples from 'react-ripples'
import Autosuggest from '../../../common/autocomplete/AutosuggestContainer';
import MydateFilter from '../../../common/datepicker'; 
import OnwardDayPicker from '../../../views/services/skyscanner/onwardDayPicker';
import ReturnDayPicker from '../../../views/services/skyscanner/returnDayPicker'; 
import SearchResults from './SearchResults'

class Skyscanner extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      sourceValue: '',
      destinationValue: '',
      suggestions: [],
      originPlace: '',
      destinationPlace: '',
      swapButtonActive: false,
      onwardDate: "",
      returnDate: ""
    }
  }

  sourceChange(event, { newValue }){
      this.setState({ sourceValue: newValue })
  }

  destinationChange(event, { newValue }){
      this.setState({ destinationValue: newValue })
  }

  onSuggestionsFetchRequested = ({ value }) => {
      setTimeout(() => {
          servicesApi.getFlightsSuggestions(this, value)
      }, 200);
  };

  onSuggestionsClearRequested = () => {
      this.setState({
        suggestions: []
      });
  };

  getSuggestionValue(type, suggestion) {
    if(type == 1)
      this.setState({ originPlace: suggestion.PlaceId });
    else if(type == 2)
      this.setState({ destinationPlace: suggestion.PlaceId });
    return suggestion.PlaceName;
  }

  handleSwapButton(sourceValue, destinationValue, originPlace, destinationPlace){
    this.setState(
      {
        swapButtonActive: !this.state.swapButtonActive,
      }
    );

    this.setState({ 
      sourceValue: destinationValue,
      destinationValue: sourceValue,
      originPlace: destinationPlace,
      destinationPlace: originPlace
    })
  }
  
  // Use your imagination to render suggestions.
  renderSuggestion(suggestion) {
    return (
      <div>
        <a href="javascript:void(0)">
        <p className="search-result">
          <span dangerouslySetInnerHTML={{__html: suggestion.PlaceName+" ("+suggestion.PlaceId.split("-")[0]+")"}}></span>
        </p>
      </a>
      </div>
    );
  }

  onwardDateHandle(date){
     this.setState({
       onwardDate: date
     })
  }

  returnDateHandle(date){
    this.setState({
      returnDate: date
    })
  }

  render() {
    const { sourceValue, destinationValue, suggestions, originPlace, destinationPlace, onwardDate, returnDate } = this.state;
    // Autosuggest will pass through all these props to the input field.
    const inputPropsSource = { placeholder: 'Origin city or airport', value: sourceValue, onChange: this.sourceChange.bind(this)};
    const inputPropsDestination = { placeholder: 'Destination city or airport', value: destinationValue, onChange: this.destinationChange.bind(this), ref: 'destinationCity'};
    return (
      <div className="services">
          <div className="page-header">
            <h3 className="page-title">Flight Booking <span>(powered by Skyscanner)</span></h3>
              <div className="action-block">
                {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
              </div>
          </div>
          <div className="page-container">
          {/* Search form start */}
          <div className="services-search-container">
            <form id="skyscannerForm" className="services-search">
              <div className="places-control">
                    <Autosuggest
                            suggestions={suggestions}
                            getSuggestionValue={this.getSuggestionValue.bind(this, 1)}
                            renderSuggestion={this.renderSuggestion.bind(this)}
                            onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
                            onSuggestionsClearRequested={this.onSuggestionsClearRequested}
                            inputProps={inputPropsSource} 
                            className="search-box"
                            id="sourceSearch"
                            ref= "originCity"/>

                      <Autosuggest
                          suggestions={suggestions}
                          getSuggestionValue={this.getSuggestionValue.bind(this, 2)}
                          renderSuggestion={this.renderSuggestion.bind(this)}
                          onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
                          onSuggestionsClearRequested={this.onSuggestionsClearRequested}
                          inputProps={inputPropsDestination} 
                          className="search-box"
                          id="destinationSearch"/>
                      <Input type="hidden" id="originPlace" name="originplace" inputValue={originPlace} />
                      <Input type="hidden" id="destinationPlace" name="destinationplace" inputValue={destinationPlace} />

                      <button type="button" className={"swap-button " + this.state.swapButtonActive } onClick={this.handleSwapButton.bind(this, sourceValue, destinationValue, originPlace, destinationPlace)}><i className="icon-swap"></i></button>
              </div>


              <div className="dates-control">
                {/* <MydateFilter ref="datePicker" fromPlaceholder={"Depart"} toPlaceholder={"Return"} changeRequested={false} /> */}
                <OnwardDayPicker dateState={this.state} onChange={this.onwardDateHandle.bind(this)} dateInputName={"depart"}/>
                <ReturnDayPicker dateState={this.state} onChange={this.returnDateHandle.bind(this)} dateInputName={"return"}/>
                <Input type="hidden" id="from-date-hidden" inputValue={onwardDate}/>
                <Input type="hidden" id="to-date-hidden" inputValue={returnDate}/>
              </div>

              <div className="people-and-place">
                <div className="people-selector">
                  <div className="adults" title="Adults">
                    <span className="icon icon-adults"></span>
                    <select name="adults">
                      <option selected value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                    </select>
                  </div>

                  <div className="children" title="Children">
                    <span className="icon icon-children"></span>
                    <select name="children">
                      <option selected value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                    </select>
                  </div>

                  <div className="infants" title="Infants">
                    <span className="icon icon-infants"></span>
                    <select name="infants">
                      <option selected value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                    </select>
                  </div>

                </div>
                <div className="cabin-class-selector">
                  <select name="cabinclass">
                    <option value="Economy" selected>Economy</option>
                    <option value="Premium Economy">Premium Economy</option>
                    <option value="Business">Business</option>
                    <option value="First">First</option>
                  </select>
                </div>
              </div>
              <button className="search-button" type="button" onClick={servicesApi.searchFlights.bind(this, "skyscannerForm")}><i className="icon-search"></i></button>
            </form>
          </div>
          {/* Search form end */}
          </div>
          <div className="resultsContainer">
            <SearchResults />
          </div>
      </div>
    );
  }
}

Skyscanner.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {};
};

export default connect(mapStateToProps)(Skyscanner);
import React from 'react'
import InputRange from 'react-input-range';
import store from '../../store/configureStore'
import { connect } from 'react-redux'
import PlacesAutocomplete, {geocodeByAddress,getLatLng} from 'react-places-autocomplete';
import {toastr} from 'react-redux-toastr'
import * as G from '../../api/common-api';
class SelectArea extends React.Component {
    constructor(props) {
        super(props);
        this.state = { selectedArea: '', addresses: [], address: '', selectedAddress: '', currentAddress:'', postcode: '', lat: '', long: '', gps: true };
        this.postcode = "";
        this.selectedAddress = "";
        this.title = "";
    }

    componentWillMount(){
        this.setState({addresses: this.props.address})

        document.getElementsByClassName("location-search-input").value = "";
        navigator.permissions.query({name:'geolocation'}).then(function(result) {
            if ((result.state == 'granted' || result.state == 'prompt') && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position)=>{this.setState({lat:position.coords.latitude, long: position.coords.longitude})});
                this.setState({gps: true})
            } else {
                this.setState({gps: false})
                console.log("Geolocation is not supported by this browser.");
            }
            result.onchange = function() {
                console.log(result.state)
            }
        }.bind(this));
        if(this.props.selectedAreaProps != undefined && this.props.selectedAreaProps != ""){
            this.setState({selectedArea: this.props.selectedAreaProps['selectedArea'], postcode: this.props.selectedAreaProps['postcode'], title: this.props.selectedAreaProps['selectedAddress']})
        }
        if(this.props.mandatory === true){
            let container = document.querySelector('#spArea');
            let close = container.querySelector('.close');
            close.classList.add("hidden");
        }
    }

    getLocation=() =>{
        var geocoder = geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(this.state.lat, this.state.long);
        geocoder.geocode({ 'latLng': latlng }, 
            function(results, status) 
            {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                  let currentAddress = results[0].formatted_address;
                  let formatted_address = results[0].formatted_address.split(', ');
                  let semi_postcode = formatted_address[formatted_address.length-2].trim();
                  let postcode = semi_postcode.substr(semi_postcode.length-6)
                  let selectedArea = formatted_address[formatted_address.length-4];
                  let arr ={"selectedArea":selectedArea, "postcode":postcode, "selectedAddress":currentAddress, "title":''}
                  this.setState({selectedArea: selectedArea, postcode: postcode, currentAddress: currentAddress, title: '', selectedAddress: ''},function(){console.log(this.state); this.props.onSelect(arr)})
                    let container = document.querySelector('#spArea');
                    console.log(container)
                    let close = container.querySelector('.close');
                    close.classList.remove("hidden");
                    G.closeModal(["spArea"])
                }
            }
        }.bind(this));
    }

    handleChange = address => {
        this.setState({ address });
    };

    handleSelect = address => {
        let result = geocodeByAddress(address)
        .then(results => {
            if(address.split(', ').length < 4){
                toastr.error("Error", "Please select specific area", { icon: "icon-error" });
                return false;
            }
            let title = address.split(', ')[0];
            let selectedAddress = address.replace(title+",", "");
            let ltlg = results[0].geometry.location;
            let latlng = results[0].geometry.location;
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, 
                function(results, status) 
                {
                  if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          let address = results[0].formatted_address;
                          let formatted_address = results[0].formatted_address.split(', ');
                          let semi_postcode = formatted_address[formatted_address.length-2].trim();
                          let postcode = semi_postcode.substr(semi_postcode.length-6)
                          let selectedArea = formatted_address[formatted_address.length-4];
                          this.setState({selectedArea: selectedArea, postcode: postcode, selectedAddress: selectedAddress, title: title},
                            function(){
                                let arr ={"selectedArea":selectedArea, "postcode":postcode, "selectedAddress":selectedAddress, "title":title}
                                this.setState({address: ''})
                                this.props.onSelect(arr)
                                let container = document.querySelector('#spArea');
                                let close = container.querySelector('.close');
                                close.classList.remove("hidden");
                                G.closeModal(["spArea"])
                            })
                  }
                }
            }.bind(this));

        })
        .catch(error => console.error('Error', error));
    };

    componentWillReceiveProps(nextProps){
        console.log(nextProps)
        this.setState({addresses: nextProps.address})
    }

    render() {
        return (
            <div className="select-area-container"> 
                <PlacesAutocomplete value={this.state.address} onChange={this.handleChange} onSelect={this.handleSelect.bind(this)}>
                    {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                      <div className="select-area-input">
                        <input {...getInputProps({placeholder: 'Search Places ...',className: 'location-search-input'})} />
                        <div className="autocomplete-dropdown-container">
                          {loading && <div>Loading...</div>}
                          {suggestions.map(suggestion => {
                            const className = suggestion.active
                              ? 'suggestion-item--active select-area-addresses'
                              : 'suggestion-item select-area-addresses';
                            // inline style for demonstration purpose
                            const style = suggestion.active
                              ? { backgroundColor: '#fafafa', cursor: 'pointer' }
                              : { backgroundColor: '#ffffff', cursor: 'pointer' };
                            let address_data = suggestion.description;
                            let title = address_data.split(", ");
                            let desc = address_data.replace(title[0]+",", "");
                            return (
                                <div {...getSuggestionItemProps(suggestion, {
                                      className,
                                      style,
                                    })} className="select-area-addresses">
                                    <div className="title">
                                        <i className="icon-place-pin"></i>
                                        <p>{title[0]}</p>
                                    </div>
                                    <div className="text">
                                        <p>{desc}.</p>
                                    </div>
                                </div>
                            );
                          })}
                        </div>
                      </div>
                    )}
                </PlacesAutocomplete>
                {this.state.gps === true ?
                <div className="select-area-current-location" onClick={this.getLocation.bind(this)}>
                    <div className="title">
                        <i className="icon-place-pin"></i>
                        <p>Get Current Location</p>
                    </div>
                    <div className="text">
                        <p>Using GPS</p>
                    </div>
                </div>
                : null}
                <div className={this.state.postcode != "" ?"select-area-addresses button-green":"hidden"}>
                    <p className="mini-title">Selected Area</p>
                    <div className="title">
                        <i className="icon-place-pin"></i>
                        <p>{this.state.title ? this.state.title : this.state.currentAddress}</p>
                    </div>
                    <div className="text">
                        <p>{this.state.selectedAddress}</p>
                    </div>
                </div>
                <div className="select-area-addresses-title">
                    <div className="title">
                        <p>Saved Addresses</p>
                    </div>
                </div>
                {this.props.addresses != undefined && this.props.addresses.length >0 ?
                    this.props.addresses.map(address=>{
                    let address_details = address['company']+", "+address['address1']+", "+address['city']+", "+address['state']+", "+address['postcode'];
                    return(
                            <div className="select-area-addresses" id={address['id_address']} onClick={this.handleSelect.bind(this, address_details)}>
                                <div className="title">
                                    <i className="icon-place-pin"></i>
                                    <p>{address['company']}</p>
                                </div>
                                <div className="text">
                                    <p>{address['address1']+","+address['city']+","+address['state']+","+address['postcode']}</p>
                                </div>
                            </div>
                        )
                })
                    :<div id="loader" style={{visibility: "visible"}}><div className="spinner"></div></div>}
            </div>
        )
    }
}


const mapStateToProps = function(store) {
    // console.log(store.searchState)
  return {
    addresses: store.addressState.address
  }
};

export default connect(mapStateToProps)(SelectArea)   


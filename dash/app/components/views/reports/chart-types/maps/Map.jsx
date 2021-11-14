import React, { Component } from 'react';
import { connect } from 'react-redux';
import GoogleMap from 'google-map-react';
import Marker from './Marker';
import * as reportActions from '../../../../../actions/report-actions';

class MapComponent extends Component {
  
  constructor(props){
    super(props)
  }

  componentDidMount(){
    this.captureLocation()
  }

  captureLocation() {
    navigator.geolocation.getCurrentPosition(function(pos){
      var newLoc = {lat: pos.coords.latitude, lng: pos.coords.longitude}
      this.props.dispatch(reportActions.locationCaptured(newLoc))
    }.bind(this))
  }

  render() {
    return (
      <div className="" id={this.props.id}>
        <div className="">
          <div className="" style={{height:"100%"}}>
            <div style={{height:"400px", width:"100%"}}>
              <GoogleMap
                ref="googleMap"
                onChildClick={this.props.onChildClick}
                onChildMouseEnter={this.props.onChildMouseEnter}
                defaultZoom={this.props.map.defaultZoom}
                center={this.props.map.center}
                defaultCenter={this.props.map.defaultCenter}
                bootstrapURLKeys={{key: "AIzaSyCzh2BOejsmgkEWHbFyGASNfNQ1M3hp2mI"}}>
                {
                    this.props.data ? this.props.data.map((data, index) => {
                      return (
                          <Marker icon="icon-warning"
                          key={'marker_'+index}
                          data={data}
                          lat={data.lat}
                          lng={data.lng}
                          onClick={this.props.onClick.bind(this, data.id_address_delivery, data.city, data.city_based)} />
                      )
                }):undefined}
              </GoogleMap>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = function(store) {
  return {
    map: store.reportState
  };
};

export default connect(mapStateToProps)(MapComponent);
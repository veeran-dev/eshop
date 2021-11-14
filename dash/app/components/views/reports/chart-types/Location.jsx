import React from 'react';
import ReactDOM from 'react-dom';
import * as G from '../../../../api/common-api'
import { Map, Marker, Popup, TileLayer } from 'react-leaflet';

class Location extends React.Component {
  constructor() {
    super();
    this.state = {
      lat: 20.5937,
      lng: 78.9629,
      zoom: 4,
    };
  }

  render() {
    const position = [this.state.lat, this.state.lng];
    let data = this.props.stateWiseData, markers = new Array
    for(var i = 0; i < data.length; i++){
      if(data[i].lat != null && data[i].lng != null) {
      	let latitudeLongitude = new Array(parseFloat(data[i].lat), parseFloat(data[i].lng));
      	markers.push(<Marker position={latitudeLongitude} key={i}>
  				          <Popup>
  				            <span><b>{data[i].state_name}</b><br/> 
  				            	     {G.formatPrice(data[i].y)}<br />
  				            	     <a href="javascript:void(0)" onClick={this.props.onClick.bind(this, data[i].id_state)}>More details...</a>
  				           	</span>
  				          </Popup>
  			         </Marker>)
      }
    }

    return (
      <Map center={position} zoom={this.state.zoom} zoomControl={false} scrollWheelZoom={false} doubleClickZoom={false} dragging={false}>
        <TileLayer
          attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
          url='http://{s}.tile.osm.org/{z}/{x}/{y}.png'
        />
        {markers}
      </Map>
    );
  }
}

export default Location
import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';
import * as servicesApi from '../../../../api/services-api'

class SearchResults extends React.Component {
	constructor(props){
		super(props)
	}
	_splitButton(e) {
      let allElem = document.getElementsByClassName('stops-expanded')
      if(e.target.nextSibling.classList.contains("hidden")){
        for(var i = 0; i < allElem.length; i++){
            allElem[i].classList.add("hidden")
            e.target.nextSibling.classList.remove("hidden")
        }
      }
      else{
        e.target.nextSibling.classList.add("hidden")
        for(var i = 0; i < allElem.length; i++)
            allElem[i].classList.add("hidden")
      }
  }

  _outerControl(event){
    var allElem = document.getElementsByClassName('stops-expanded');
    for(var i=0; i < allElem.length; i++){
        let box = allElem[i]
        if(event.target != box && event.target.parentNode != box){
          if(box && box.style.display != undefined)
            if(!box.classList.contains("hidden") && !event.target.classList.contains("stops-label"))
              box.className += " hidden"
        }
    }
  }
  componentDidMount() {
    window.addEventListener("click", this._outerControl.bind(this));
  }
  componentWillUnmount(){
    window.removeEventListener("click", this._outerControl.bind(this));
  }
	getObjectProperties(primaryObject, filterObject) {
		let resultArray = new Array()
		for(var i = 0; i < filterObject.length; i++) {
			for(var j = 0; j < primaryObject.length; j++) {
				if(primaryObject[j].Id == filterObject[i])
					resultArray.push(primaryObject[j])
			}
		}

		return resultArray;
	}

	getAgentDetails(primaryObject, agentIds) {
		let resultArray = new Array()
		for(var i = 0; i < agentIds.length; i++) {
			for(var j = 0; j < primaryObject.length; j++) {
				if(primaryObject[j].Id == agentIds[i].Agents[0])
					resultArray.push({"pricing" : agentIds[i], "agentDetail" : primaryObject[j]})
			}
		}

		return resultArray
	}

	render(){
		const { Agents, Carriers, Currencies, Itineraries, Legs, Places, Segments, SessionKey } = this.props.flights
		let primaryFlights = new Array(), onwardFlights = new Array();
		if(Itineraries != "" && Itineraries != undefined) {
			for(var i = 0; i < Itineraries.length; i++) {
				const { BookingDetailsLink, InboundLegId, OutboundLegId, PricingOptions } = Itineraries[i]
				
				primaryFlights.push({ 
					"OutboundDetails" : (OutboundLegId != undefined ? this.getObjectProperties(Legs, [OutboundLegId]) : ""),
					"InboundDetails" : (InboundLegId != undefined ? this.getObjectProperties(Legs, [InboundLegId]) : "")
				})

				primaryFlights[i]['PricingDetails'] = this.getAgentDetails(Agents, PricingOptions)
				if(primaryFlights[i].InboundDetails[0] != undefined) {
					primaryFlights[i].InboundDetails[0]['StopsDetails'] = this.getObjectProperties(Places, primaryFlights[i].InboundDetails[0].Stops)
					primaryFlights[i].InboundDetails[0]['SegmentDetails'] = this.getObjectProperties(Segments, primaryFlights[i].InboundDetails[0].SegmentIds)
					primaryFlights[i].InboundDetails[0]['CarrierDetails'] = this.getObjectProperties(Carriers, primaryFlights[i].InboundDetails[0].Carriers)
				}
				
				if(primaryFlights[i].OutboundDetails[0] != undefined) {
					primaryFlights[i].OutboundDetails[0]['StopsDetails'] = this.getObjectProperties(Places, primaryFlights[i].OutboundDetails[0].Stops)
					primaryFlights[i].OutboundDetails[0]['SegmentDetails'] = this.getObjectProperties(Segments, primaryFlights[i].OutboundDetails[0].SegmentIds)
					primaryFlights[i].OutboundDetails[0]['CarrierDetails'] = this.getObjectProperties(Carriers, primaryFlights[i].OutboundDetails[0].Carriers)
				}
			}

			let sourceStationOutbound, destionationStationOutbound, sourceStationInbound, destionationStationInbound
			for(var k = 0; k < primaryFlights.length; k++) {
				// Onward flights and return flights data parsing
					//Outbound stations
					if(primaryFlights[k].OutboundDetails != ""){
						sourceStationOutbound = this.getObjectProperties(Places, [primaryFlights[k].OutboundDetails[0].OriginStation]);
						destionationStationOutbound = this.getObjectProperties(Places, [primaryFlights[k].OutboundDetails[0].DestinationStation]);
					}
					//Inbound stations
					if(primaryFlights[k].InboundDetails != ""){
						sourceStationInbound = this.getObjectProperties(Places, [primaryFlights[k].InboundDetails[0].OriginStation]);
						destionationStationInbound = this.getObjectProperties(Places, [primaryFlights[k].InboundDetails[0].DestinationStation]);
					}

					onwardFlights.push(
						<div key={k} className="result-item">
							{primaryFlights[k].OutboundDetails != "" ? <div className="onward-flight">
								<div className="carrier-info">
									<img className="carrier-logo" alt={primaryFlights[k].OutboundDetails[0].CarrierDetails[0].Name} src={primaryFlights[k].OutboundDetails[0].CarrierDetails[0].ImageUrl} />
									<div className="carrier-details">
										<h4 className="carrier-name">{primaryFlights[k].OutboundDetails[0].CarrierDetails[0].Name}</h4>
										<p className="flight-mode">{primaryFlights[k].OutboundDetails[0].Stops.length > 0 ? primaryFlights[k].OutboundDetails[0].Stops.length+" Stops" : "Direct Flight"}</p>
									</div>
								</div>
								<div className="departure-time">
									<i className="icon-flight-takeoff"></i> Departure: <span>{G.getDayWithTime(primaryFlights[k].OutboundDetails[0].Departure)}</span>
								</div>

								<div className="arrival-time">
									<i className="icon-flight-land"></i> Arrival: <span>{G.getDayWithTime(primaryFlights[k].OutboundDetails[0].Arrival)}</span>
								</div>

								<div className="duration">
									<i className="icon-schedule"></i> Duration: <span>{primaryFlights[k].OutboundDetails[0].Duration} mins</span>
								</div>
								<div className="points-box">
									<div className="path">
										<div className="point"></div>
										<div className="connector"></div>
										<div className="point"></div>
									</div>
									{primaryFlights[k].OutboundDetails[0].Stops.length > 0 ? <div className="stops-label" title="Stops">{primaryFlights[k].OutboundDetails[0].Stops.length}</div> : ""}
									<div className="stops-expanded hidden">
										<p>Stops data</p>
									</div>
								</div>
								<div className="points-station">
									<div className="source-point">{sourceStationOutbound[0].Name}</div>
									<div className="destination-point">{destionationStationOutbound[0].Name}</div>
								</div>
								{/* So far '.stops-expanded' div will be expanded when the '.points-station' div is hovered.  */}
								
							</div> : "No data"}
							{primaryFlights[k].InboundDetails != "" ? <div className="return-flight">
								<div className="carrier-info">
									<img className="carrier-logo" alt={primaryFlights[k].InboundDetails[0].CarrierDetails[0].Name} src={primaryFlights[k].InboundDetails[0].CarrierDetails[0].ImageUrl} />
									<div className="carrier-details">
										<h4 className="carrier-name">{primaryFlights[k].InboundDetails[0].CarrierDetails[0].Name}</h4>
										<p className="flight-mode">{primaryFlights[k].InboundDetails[0].Stops.length > 0 ? primaryFlights[k].InboundDetails[0].Stops.length+" Stops" : "Direct Flight"}</p>
									</div>
								</div>

								<div className="departure-time">
									<i className="icon-flight-takeoff"></i> Departure: <span>{G.getDayWithTime(primaryFlights[k].InboundDetails[0].Departure)}</span>
								</div>

								<div className="arrival-time">
									<i className="icon-flight-land"></i> Arrival: <span>{G.getDayWithTime(primaryFlights[k].InboundDetails[0].Arrival)}</span>
								</div>

								<div className="duration">
									<i className="icon-schedule"></i> Duration: <span>{primaryFlights[k].InboundDetails[0].Duration} mins</span>
								</div>

								<div className="points-box">
									<div className="path">
										<div className="point"></div>
										<div className="connector"></div>
										<div className="point"></div>
									</div>
									{primaryFlights[k].InboundDetails[0].Stops.length > 0 ? <div className="stops-label" title="Stops">{primaryFlights[k].InboundDetails[0].Stops.length}</div> : ""}
									<div className="stops-expanded hidden">
										<p>Stops data</p>
									</div>
								</div>
								<div className="points-station">
									<div className="source-point">{sourceStationInbound[0].Name}</div>
									<div className="destination-point">{destionationStationInbound[0].Name}</div>
								</div>
								{/* So far '.stops-expanded' div will be expanded when the '.points-station' div is hovered.  */}
								
							</div> : "No Return Flights"}

							<div className="flight-pricing">
								<div className="price">{G.formatPrice(primaryFlights[k].PricingDetails[0].pricing.Price)}</div>
								<a target="_blank" className="button button-red outline" href={primaryFlights[k].PricingDetails[0].pricing.DeeplinkUrl}>Select <i className="icon-arrow-right"></i></a>
								<div className="agent-name">{primaryFlights[k].PricingDetails[0].agentDetail.Name}</div>
							</div>
						</div>
					)
			}
		}

		return (
		    <div className="flights-data-container">
		    	<div className="onward-flight-data">
		    		{onwardFlights && onwardFlights.length > 0 ? onwardFlights : null}
		    	</div>
    			{ /* <div className="pagination">
	    			<button type="button" className={pageindex == 0 ? "disabled" : ""} onClick={servicesApi.loadMoreFlights.bind(this, pagesize, parseInt(pageindex)-1, SessionKey)}>Previous</button> 
	    			<button type="button" onClick={servicesApi.loadMoreFlights.bind(this, pagesize, parseInt(pageindex)+1, SessionKey)}>Next</button> 
    			</div> */ }
			</div>
	    )
	}
}

const mapStateToProps = function(store) {
  return {
  	flights: store.servicesState.skyscannerFlights
  };
};

export default connect(mapStateToProps)(SearchResults);
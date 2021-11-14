import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';

class SearchResults extends React.Component {
	constructor(props){
		super(props)
	}

	hotelInfo(hotelID){
    	this.context.router.push("expedia/hotel-info/"+hotelID)
  	}

	render(){
		const { hotelList } = this.props.searchResults
		return (
		    <div>
		    	<div className="totalHotels">{hotelList != undefined && hotelList != "" ? hotelList.length+" Hotels Found" : ""}</div>
	            { hotelList != undefined && hotelList != "" ?
	              hotelList.map((data, i) => {
	                return(
	                  <div key={i} style={{marginBottom: "10px"}}>
	                    <div><span>Name:</span> <a href="javascript:void(0)" onClick={this.hotelInfo.bind(this, data.hotelId)}>{data.name}</a></div>
	                    <div>Hotel Availability: {data.isHotelAvailable ? "Yes" : "No"}</div>
	                    <div>Hotel Rating: {data.hotelStarRating} Star</div>
	                    <div>City: {data.city}</div>
	                    <div>Address: {data.address}</div>
	                    <div>Ratings: {data.hotelGuestRating}</div>
	                    <div>Total Reviews: {data.totalReviews}</div>
	                    <div>Total Recommendations: {data.totalRecommendations}</div>
	                    <div>Short Description: {data.shortDescription}</div>
	                    <div>Brand Name: {data.jsonHotelBrand.brandName}</div>
	                  </div>
	                )
	              })
	            : <div>{hotelList == "" ? "No hotels availabe in selected date range." : ""}</div>}
			</div>
	    )
	}
}

SearchResults.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	searchResults: store.commonState.hotelsList
  };
};

export default connect(mapStateToProps)(SearchResults);
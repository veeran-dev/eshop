import React from 'react';

class Line extends React.Component {
 	componentDidMount() {
	  	this._renderChart()
 	}

 	componentDidUpdate() {
 		this._renderChart()
 	}

 	handleClick(idOrder){
 		this.props.onClick(idOrder)
 	}

	_renderChart() {
		let dataConfigs = this.props.data
		
		let totalValue = 0
 		for (var j=0; dataConfigs.length > j ; j++){
			totalValue += parseFloat(dataConfigs[j].y);
		}

	  	for(var i=0; i < dataConfigs.length; i++){
	  		dataConfigs[i].y = parseFloat(dataConfigs[i].y)
			dataConfigs[i].indexLabel = ""
	  		dataConfigs[i].click = this.handleClick.bind(this, dataConfigs[i].id_order)
	  	}

	  	var chartConfigs = {
	  	  theme: "theme1",
	      title:{
	        text: this.props.title,
	        fontFamily: "Source Sans Pro",
	        padding: 16,
	        fontSize: 20,
	        fontColor: "#ea6153"
	      },
		  legend: {
		    fontFamily: "Source Sans Pro"
		  },
	      animationEnabled: true,
	      axisY:{
	      	title: "Spends in INR",
	      	titleFontSize: 18,
	      	titleFontFamily: "Source Sans Pro",
	      	titleFontColor: "#666666",
	      	titleFontWeight: "bold",
	      	labelFontFamily: "Source Sans Pro",
	      	labelFontSize: 14,
	      	gridThickness: 1,
	      	lineThickness: 1,
	      	tickThickness: 1
	      },
		  axisX:{
		  	title: "Month",
		  	titleFontFamily: "Source Sans Pro",
		  	titleFontSize: 18,
		  	titleFontColor: "#666666",
		  	titleFontWeight: "bold",
		  	labelFontFamily: "Source Sans Pro",
		  	labelFontSize: 14,
		  	gridThickness: 1,
		  	lineThickness: 1,
		  	tickThickness: 1
		  },
		  toolTip: {
			borderThickness: 2,
			cornerRadius: 4,
			borderColor: "#999"
		  },
	      renderAt: this.props.id,
	      data: [
		      {        
		        type: "line",
		        color: "#ea6153",
		        markerSize: 10,
		        indexLabelFontColor: "#222222",
		        indexLabelFontSize: 15,
		        indexLabelFontFamily: "Source Sans Pro",
		        toolTipContent: "<div id={label}>{label}</div><hr/><strong>₹ {y}</strong>",      
		        dataPoints: dataConfigs
		      }
	      ]
	  	};

  		var chart = new CanvasJS.Chart(chartConfigs.renderAt, chartConfigs);
    	chart.render();
	}

	render() {
	    return (
	    		<div id={this.props.id}></div>
	    );
	}
}

export default Line;
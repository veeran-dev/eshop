import React from 'react';

class TopCategories extends React.Component {
 	componentDidMount() {
 		this._renderChart()
 	}

 	componentDidUpdate() {
  		this._renderChart()
 	}	

 	handleClick(){
 		this.props.onClick()
 	}

	_renderChart(configs) {
		let dataConfigs = this.props.data
 		let totalValue = 0
 		for (var j=0; dataConfigs.length > j ; j++){
				totalValue += parseFloat(dataConfigs[j].y);
				dataConfigs[j].label = dataConfigs[j].category;
		}

	  	for(var i=0; i < dataConfigs.length; i++){
	  		    dataConfigs[i].y = parseFloat(dataConfigs[i].y)
		  		dataConfigs[i].s = Math.round(dataConfigs[i].y / totalValue * 100)
		  		dataConfigs[i].click = this.handleClick.bind(this)
	  	}

  		var chartConfigs = {
  			title:{
		      text: this.props.title,
		      fontFamily: "Source Sans Pro",
	          padding: 16,
	          fontSize: 20,
	          fontColor: "#ea6153"
		    },
		    zoomEnabled: true,
            animationEnabled: true,
		    axisY:{
		      labelFontFamily: "Source Sans Pro",
	      	  labelFontSize: 14,
	      	  gridThickness: 1,
	      	  lineThickness: 1,
	      	  tickThickness: 1,
		    },
		    toolTip: {
			  borderThickness: 2,
			  cornerRadius: 4,
		    },
		    //width: ,
		    height: 162,
		    responsive: true,
		    renderAt: this.props.id,
		    data: [
		    {  
			    type: "column",
			    bevelEnabled: false,
			    indexLabelFontSize: 14,
			    indexLabelOrientation: "horizontal",
			    indexLabel: "{s}%",
				toolTipContent: "<strong>{label}</strong> <br/> Total Spent: ₹ {y}<br/> Percentage: {s}%",
			    dataPoints: dataConfigs
		    }]
  		}

  		var chart = new CanvasJS.Chart(chartConfigs.renderAt, chartConfigs);
    	chart.render();
	}

	render() {
	    return (
	    	<div id={this.props.id}></div>
	    );
	}
}

export default TopCategories;
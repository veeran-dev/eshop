import React from 'react';

class Pie extends React.Component {
	constructor(props){
		super(props)
	}

 	componentDidMount() {
		this._renderChart();
 	}

 	componentDidUpdate() {
 		this._renderChart();
 	}

 	_renderChart() {
 		var consumed = this.props.consumed / this.props.total * 100;
		var remaining = 100 - consumed;
 		var chart = new CanvasJS.Chart("chartContainer", {
			width: 200,
			height: 80,
			animationEnabled: true,
			legend: {
				verticalAlign: "center",
				horizontalAlign: "right"
			},
			data: [
				{
					type: "pie",
					percentFormatString: "#",
					//indexLabel: "#percent%",
					showInLegend: true,
					toolTipContent: "{name}: {y}%",
					dataPoints: [
						{ y: remaining, name: "Available Spend", legendMarkerType: "square" },
						{ y: consumed, name: "Spent", legendMarkerType: "square" }    
					]
				}
			]
			}
		);
		chart.render();
 	}

	render() {
	    return (
	    	<div className="spend-graph" id="chartContainer"></div>
	    );
	}
}

export default Pie;
import React from 'react';
import Plotly from "plotly.js-basic-dist";
import createPlotlyComponent from 'react-plotly.js/factory';
const Plot = createPlotlyComponent(Plotly);

const MonthlySales =(props)=>{
	let dataConfigs = props.data		
	let x = [], y=[], name = []
	for(var i=0; i < dataConfigs.length; i++){
		    y[i] = parseFloat(dataConfigs[i].sales.replace(",",""))
		    x[i] = dataConfigs[i].month
	}
	  	// this.setState({x: x, y: y})
  return (
		  <Plot
		    data={[{
		    		type: "scatter",
		        	x: x,
		        	y: y,
		        	showlegend: false,
		        	}] 
		    }
		    config={{
		    	displayModeBar : false,
		    }}
		    layout={{
		    	autosize:true,
		    	responsive: true,
		    	yaxis: {
		    		automargin:true,
		    	},
		    	xaxis:{
		    		automargin: true,
		    	},
		    	height: 160,
		    	margin: {
					"b":0,
					"l":0,
					"r":0,
					"t":0,
				}
		    }}
		    style={{ 	responsive: true}}
		  />
		);

}

export default MonthlySales
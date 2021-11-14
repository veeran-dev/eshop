import React, {useState} from 'react';
import Plotly from "plotly.js-basic-dist";
import createPlotlyComponent from 'react-plotly.js/factory';
import * as G from '../../../../api/common-api'

const Plot = createPlotlyComponent(Plotly);

const TopCustomers =(props)=>{
  let dataConfigs = props.data;
  let trace=[],x = [], y=[], name = []
  
  for(var i=0; i < dataConfigs.length; i++){
    if(dataConfigs[i].name != null){
        trace [i] ={
            "y": [parseFloat(dataConfigs[i].sales)],
            "x": [dataConfigs[i].name],
            "text": dataConfigs[i].name,
            "name": dataConfigs[i].name,
            "type": 'bar',
            "showlegend": props.width < 425 ? false:true
          }
    }
  }
  return (
      <Plot
        data={trace}
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
          width: props.width != undefined && props.width>0 ? props.width - 32 : 284,
          margin: {
        "b":0,
        "l":0,
        "r":0,
        "t":0,
      }
        }}
        style={{  responsive: true}}
      />
    );

}

export default TopCustomers
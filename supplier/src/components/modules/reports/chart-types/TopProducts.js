import React, {useState } from 'react';
import Plotly from "plotly.js-basic-dist";
import createPlotlyComponent from 'react-plotly.js/factory';
const Plot = createPlotlyComponent(Plotly);

const TopProducts =(props)=>{
  let dataConfigs = props.data;
  let trace=[], labels = [], values = []
  for(var i=0; i < dataConfigs.length; i++){
    if(dataConfigs[i].product_name != null){
      let name = dataConfigs[i].product_name.length > 18 ? 
                    dataConfigs[i].product_name.substring(0, 18)+"...-"+dataConfigs[i].product_reference:
                    dataConfigs[i].product_name+"-"+dataConfigs[i].product_reference;

      values.push(dataConfigs[i].cnt);
      labels.push(name);
    }
  }
  return (
      <Plot
        data = {[{
            values: values,
            labels: labels,
            type: 'pie',
            showlegend: props.width < 425 ? false:true,
          }]}
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

export default TopProducts
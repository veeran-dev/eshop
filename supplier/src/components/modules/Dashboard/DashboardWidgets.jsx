import React from 'react'
import OrderStatus from './order-status'
// function DashboardWidgets(dashboardWidgets){

//   let componentLoop = new Array()
//   for(var i = 0; i < dashboardWidgets.length; i++) {
//     widgets = dashboardWidgets[i]['filename'];
//     id = dashboardWidgets[i]['id'];
//     componentLoop.push(<widgets key={i} widgetId={id} />);
//   }
//   return ( componentLoop )
// }

const DashboardWidgets =()=>{
    const componentLoop = ['OrderStatus', 'Top4Products']
    return componentLoop.map( {components, i} =>{
      console.log(components)
      <components key/>
    })
}
export default DashboardWidgets;
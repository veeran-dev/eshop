import React from 'react';
import * as moment from 'moment';

class Timer extends React.Component {
  constructor(props) {
      super(props);
      this.state = {
          hour: "00",
          minute: "00",
          callParent: false,
      };
  }
  componentDidMount(){
  	
	this.timer = setInterval(function(){

		let x = moment.duration(moment(this.props.date).add(this.props.hours, 'hours').diff(moment(), 'hours-minutes-seconds'))
	  	let d = x['_data']['days']*24;
	  	let h = x['_data']['hours'] + d;
	  	let m = x['_data']['minutes'];
	  	let s = x['_data']['seconds'];
	  	this.setState({h,m,s})
		if(h ==0 && m ==0 && s==0 && this.state.callParent == false){
		    clearInterval(this.timer)
		    this.props.timerOver();
		    this.setState({callParent: true})
		}
	}.bind(this),1000)
  }
  componentWillUnmount(){
  	clearInterval(this.timer)
  }

  render(){
    return(
      <p>{this.state.h? this.state.h.toString().padStart(2,'0'): "00"} : {this.state.m?this.state.m.toString().padStart(2,'0'):"00"} : {this.state.s?this.state.s.toString().padStart(2,'0'):"00"}</p>
      )}
}
export default Timer
import React, {useState} from 'react';
import TimeKeeper from 'react-timekeeper';

class Time extends React.Component {
  constructor(props) {
      super(props);
      this.state = {
          time: "00:00pm",
          time24: "",
          showTime: false
      };
  }

  componentDidMount() {
    window.addEventListener("click", this.outerControl.bind(this));
  }
  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
  }

  outerControl(event){
    var allElem = event.path;
    let showtime = false;
    for(var i=0; i < allElem.length; i++){
        let el = allElem[i];
        if(el.classList != undefined && (el.classList.contains("timepicker") || el.classList.contains("react-timekeeper"))){
          showtime = true;
        }
        else if(el.classList != undefined && el.classList.contains("react-timekeeper__done-button")){
          break;
          return false;
        }
    }
    let exception = ['delivery_time_id']
    if(!exception.includes(document.activeElement.id)){
      this.setState({showTime: showtime})
    }
  }
  render(){

    return (
          <div className="timepicker">
            <p>
              <input type="text"
                id={this.props.primaryId}
                value={ this.state.time }
                name={this.props.name}
                placeholder={this.props.placeholder}
                onChange={ (e)=>console.log("onChange") }
                ref="inputFocus"
                onFocus={ (e) => {this.setState({showTime: true})}}
              />
            </p>
            {this.state.showTime && <TimeKeeper 
              time={this.state.time} 
              onChange={(data) => {this.setState({time24: data.formatted24, time: data.formatted12})} } 
              closeOnMinuteSelect={false} 
              switchToMinuteOnHourSelect={true}
              onDoneClick={ (e) => {this.setState({showTime: false})}} />}
          </div>  
      )
  }
}

export default Time;
/*
<input type="text"
              id={this.props.primaryId}
              value={ this.state.value }
              name={this.props.name}
              placeholder={this.props.placeholder}
              onChange={ this.handleInputChange.bind(this) }
              onFocus={ this.handleInputFocus.bind(this) }
              onBlur={ this.handleInputBlur.bind(this) }
              */
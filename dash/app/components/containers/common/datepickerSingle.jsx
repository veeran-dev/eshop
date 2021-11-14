import React, { Component } from 'react';
import DayPicker, { DateUtils } from 'react-day-picker';
import moment from 'moment';
import {toastr} from 'react-redux-toastr';

//import 'react-day-picker/lib/style.css';

const overlayStyle = {
  position: 'absolute',
  background: 'white',
  boxShadow: '0 2px 5px rgba(0, 0, 0, .15)',
};

export default class InputFieldOverlay extends Component {

  constructor(props) {
    super(props);
    this.handleDayClick = this.handleDayClick.bind(this);
    this.handleInputFocus = this.handleInputFocus.bind(this);
    this.handleInputBlur = this.handleInputBlur.bind(this);
    this.handleContainerMouseDown = this.handleContainerMouseDown.bind(this);
  }

  state = {
    showOverlay: false,
    value: '',
    selectedDay: null,
    month: 'Month',
    day: 'Day',
    dayOfWeek: 'Day of Week'
  };

  componentWillUnmount() {
    clearTimeout(this.clickTimeout);
  }

  input = null;
  daypicker = null;
  clickedInside = false;
  clickTimeout = null;

  handleContainerMouseDown() {
    this.clickedInside = true;
    // The input's onBlur method is called from a queue right after onMouseDown event.
    // setTimeout adds another callback in the queue, but is called later than onBlur event
    this.clickTimeout = setTimeout(() => {
      this.clickedInside = false;
    }, 0);
  }
  
  handleInputFocus() {
    this.setState({
      showOverlay: true,
    });
  }

  handleInputBlur() {
    const showOverlay = this.clickedInside;

    this.setState({
      showOverlay,
    });

    // Force input's focus if blur event was caused by clicking on the calendar
    if (showOverlay) {
      this.button.focus();
    }
  }

  handleDayClick(e, day) {
    var newDate = new Date();
    var oldDate = new Date(day);
    var oldDate = new Date(oldDate.getFullYear(), oldDate.getMonth()+1, oldDate.getDate()); //Year, Month, Date
    var currentDate = new Date(newDate.getFullYear(), newDate.getMonth()+1, newDate.getDate());

    if(oldDate < currentDate) {
      toastr.error("Error", "Please select valid date.", { icon: "icon-error" })
    }
    else {
       this.setState({
         value: moment(day).format('L'),
         selectedDay: day,
         showOverlay: false,
         month: moment(day).format('MMMM'),
         day: moment(day).format('D'),
         dayOfWeek: moment(day).format('dddd')
       });
       
       this.button.blur();
      
       if(day != null){
         this.props.onChange(day)
       }
    }
  }

  render() {
    return (
      <div onMouseDown={ this.handleContainerMouseDown } className={this.props.datePickerClass}>
        <button type="button"
          ref={ el => { this.button = el; } }
          onFocus={ this.handleInputFocus }
          onBlur={ this.handleInputBlur }
          className={"date-selector " + this.state.showOverlay}
          >
            <span className="date-name">{ this.props.dateInputName }</span>
            <span className="month">{ this.state.month }</span>
            <span className="day">{ this.state.day }</span>
            <span className="day-of-week">{ this.state.dayOfWeek }</span>
        </button>
        { this.state.showOverlay &&
          <div style={ { 'position': 'relative', 'zIndex': 1 } }>
            <div style={ overlayStyle }>
              <DayPicker
                ref={ el => { this.daypicker = el; } }
                onDayClick={ this.handleDayClick.bind(this) }
              />
            </div>
          </div>
        }
      </div>
    );
  }
}
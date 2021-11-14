import React from 'react';
import moment from 'moment';
import DayPicker, { DateUtils } from 'react-day-picker';

const overlayStyle = {
  position: 'absolute',
  background: 'white',
  boxShadow: '0 2px 5px rgba(0, 0, 0, .15)',
};

export default class InputField extends React.Component {

  constructor(props) {
    super(props);
    this.handleDayClick = this.handleDayClick.bind(this);
  }

  state = {
    value: this.props.selected ? moment(this.props.selected).format('LL') : "", // The value of the input field
    month: new Date(), // The month to display in the calendar
    showOverlay: false,
    hiddenValue: "",
    selected: false
  };

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
      showOverlay: showOverlay
    });
  }

  handleInputChange(e) {
    const { value } = e.target;
    if (moment(value, 'L', true).isValid()) {
      this.setState({
        month: moment(value, 'L').toDate(),
        value});
    }
  }

  handleDayClick(day) {
    console.log(day);
    if(this.props.minDate){
        let selectedDate = moment(day).format('YYYY-MM-DD');
        let maxDate = moment().format('YYYY-MM-DD');
        let minDate = moment(this.props.minDate).format('YYYY-MM-DD');
        if(selectedDate >= minDate && selectedDate <= maxDate){
          console.log("caught");
            this.setState({
              selected: true,
              value: moment(day).format('LL'),
              month: day,
              showOverlay: false,
              hiddenValue: day
            }, () => {
              if(this.props.onChange) {
                this.props.onChange(this.state.value);
              }
            });
        }
    }
    else{
      this.setState({
        selected: true,
        value: moment(day).format('LL'),
        month: day,
        showOverlay: false,
        hiddenValue: day
      }, () => {
        if(this.props.onChange) {
          this.props.onChange(this.state.value);
        }
      });
    }
  }

  componentWillReceiveProps(nextProps){
    if(this.props.selected && this.state.value == ""){
      this.setState({value: moment(this.props.selected).format('LL')})
    }
  }

  render() {
    if(this.state.selected == false && this.props.selected != undefined && this.props.selected != null){
      this.setState({selected: true, value: moment(this.props.selected).format('LL')})
    }
    let minDate = this.props.minDate ? new Date():null
    console.log(minDate);
    return (
      <div onMouseDown={ this.handleContainerMouseDown.bind(this) } className={this.props.datePickerClass}>
        <p>
          <input
            type="text"
            id={this.props.primaryId}
            value={ this.state.value }
            name={this.props.name}
            placeholder={this.props.placeholder}
            onChange={ this.handleInputChange.bind(this) }
            onFocus={ this.handleInputFocus.bind(this) }
            onBlur={ this.handleInputBlur.bind(this) }
          />
          <input type="hidden" id={this.props.hiddenId} value={this.state.hiddenValue} />
        </p>
        {this.state.showOverlay || this.props.overrideOverlay ? 
          <div style={ { 'position': 'relative', 'zIndex': 1 } }>
            <div style={ overlayStyle }>
              <DayPicker
                month={new Date(this.state.value)}
                ref={ el => { this.daypicker = el; } }
                onDayClick={ this.handleDayClick }
                disabledDays={this.props.minDate ? [{before: new Date(this.props.minDate)},{after: new Date()}]:null}
              />
            </div>
          </div>
         : null}
      </div>
    );
  }
}
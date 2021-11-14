import React from 'react';
import moment from 'moment';
import DayPicker, { DateUtils } from 'react-day-picker';

export default class MydateFilter extends React.Component {
  constructor(props) {
    super(props);
    this.handleDayClick = this.handleDayClick.bind(this);
    this.handleResetClick = this.handleResetClick.bind(this);

    // this.handleFocus = this.handleFocus.bind(this); // handle focus on input
    this.handleClick = this.handleClick.bind(this); // handle click event in document

    this.state = {
      from: null,
      to: null,
      show: false,
      value: moment().format('L')
    }
  }

  handleDayClick(e, day) {
    const range = DateUtils.addDayToRange(day, this.state);
    this.setState(range);
    if(range.from != null && range.to != null && this.props.changeRequested){
      this.setState({ show: false });
      this.props.onChange(range)
    }
  }

  handleResetClick(e) {
    e.preventDefault();
    this.setState({
      from: null,
      to: null,
    });
  }

  handleInputChange(e) {
    const { value } = e.target;

    // Change the current month only if the value entered by the user
    // is a valid date, according to the `L` format
    if (moment(value, 'L', true).isValid()) {
      this.setState({
        month: moment(value, 'L').toDate(),
        value,
      }, this.showCurrentDate);
    } else {
      this.setState({ value }, this.showCurrentDate);
    }
  }

  handleFocus() {
    //this.showCurrentDate();
    this.setState({
      show: true
    });
  }

  componentWillMount() {
    document.addEventListener('click', this.handleClick, false);
  }

  componentWillUnmount() {
    document.removeEventListener('click', this.handleClick, false);
  }

  handleClick(event) {
    // detect where click event has occured
    // if click on input or calendar (date picker wrapper) -> no need to hide date picker
    // if click on out side element -> set state show = false -> to hide date piker
    if (this.refs.from.contains(event.target) || this.refs.to.contains(event.target) || this.refs.calendar.contains(event.target)) {
    } else {
      this.setState({
        show: false
      });
    }
  }

  render() {
    const { from, to } = this.state;
    return (
      <div className="date-range-picker-wrapper">
        <div className="date-input">
          <input
              ref="from"
              type="text"
              placeholder={this.props.fromPlaceholder ? this.props.fromPlaceholder : "From Date"}
              id="from-date"
              value={from != null ? moment(from).format('LL') : ""}
              onChange={this.handleInputChange.bind(this)}
              onFocus={this.handleFocus.bind(this)}/>
              <input type="hidden" value={from ? from : ""} id="from-date-hidden" />

          <span>to</span>
          <input
            ref="to"
            type="text"
            placeholder={this.props.toPlaceholder ? this.props.toPlaceholder : "To Date"}
            id="to-date"
            value={to != null ? moment(to).format('LL') : ""}
            onChange={this.handleInputChange.bind(this)}
            onFocus={this.handleFocus.bind(this)}/>
            <input type="hidden" value={to ? to : ""} id="to-date-hidden" />
        </div>
        
        <div ref="calendar" style={this.state.show ? {} : { height: '0', overflow: 'hidden', opacity: '0', transition: 'all 300ms ease-in-out' }} className="date-range-picker">
          <DayPicker
            ref="daypicker"
            numberOfMonths={2}
            selectedDays={day => DateUtils.isDayInRange(day, { from, to })}
            onDayClick={this.handleDayClick}
          />
        </div>
      </div>
    );
  }

}
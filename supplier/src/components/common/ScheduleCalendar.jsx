import React from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar'
import moment from 'moment'
import {toastr} from 'react-redux-toastr'
import * as G from '../../api/common-api'
import 'react-big-calendar/lib/sass/styles.scss'

// Setup the localizer by providing the moment (or globalize) Object
// to the correct localizer.
const localizer = momentLocalizer(moment) // or globalizeLocalizer
const now = new Date()
// var now = moment();
const MyCalendar = props => (
    <Calendar
      localizer={localizer}
      events={props.events}
      defaultDate={now}
      views={{ month: true }}
      slots={3}
      selectable
      popup={false}
      onSelectSlot={(e) => {
          if(G.checkPastDate(e['start'], true)){
            props.selectedDate(e, 1)
          }
          else{
            toastr.warning('Warning', 'Please select valid date', { icon: "icon-warning"})
          }
      }}
      onSelectEvent={(e)=>{
          props.selectedDate(e, 2)
      }}
    />
)
export default MyCalendar
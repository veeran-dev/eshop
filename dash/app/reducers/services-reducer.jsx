import * as types from '../constants/action-types';

const initialState = {
  skyscannerFlights: [],
  pageindex: 0,
  pagesize: 50
};

const servicesReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.GET_SKYSCANNER_FLIGHTS_SUCCESS:
      return { ...state, skyscannerFlights: action.skyscannerFlights }
    default:
      return state
  }
}

export default servicesReducer;

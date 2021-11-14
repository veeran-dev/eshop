import * as types from '../constants/action-types';

export function getFlightsSuccess(skyscannerFlights) {
  return {
    type: types.GET_SKYSCANNER_FLIGHTS_SUCCESS,
    skyscannerFlights: skyscannerFlights
  };
}
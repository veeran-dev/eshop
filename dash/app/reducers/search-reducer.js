import * as types from '../constants/action-types';

const initialState = {
  result: [],
  category: [],
  min_price: "",
  max_price: 0,
  brand: [],
  loading: false,
  zones: [],
  search_data: [],
};

const SearchReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.SEARCH_DETAILS:
        return {...state, search_data:action.payload}
    case types.CLEAR_RESULTS:
        return { ...state, result: action.payload}
    case types.ALL_AVAILABLE_RESULTS:
        return { ...state, result: state.result.concat(action.payload)}
    case types.UPDATE_CATEGORY_RESULTS:
        let x = [...new Map(state.category.concat(action.payload).map(o => [o.value, o])).values()]
        // let arr = state.category.concat(action.payload);
        // let pp = arr.filter( (ele, ind) => ind === arr.findIndex( elem => elem.value === ele.value && elem.label === ele.label))
        return { ...state, category: x}
    case types.UPDATE_BRAND_RESULTS:
        let y = [...new Map(state.brand.concat(action.payload).map(o => [o.value, o])).values()]
        return { ...state, brand: y}
    case types.ALL_CATEGORY_RESULTS:
        return { ...state, category: action.payload}
    case types.ALL_BRAND_RESULTS:
        return { ...state, brand: action.payload}
    case types.MAX_PRICE:
        return { ...state, max_price: Math.ceil(state.max_price)>Math.ceil(action.payload) ? state.max_price:action.payload}
    case types.ALL_ZONES:
        return { ...state, zones: action.payload}
    case types.SEARCHING:
        return { ...state, loading: true}
    case types.GOT_IT:
        return { ...state, loading: false}
    case types.CLEAR_FILTERS:
        return {...state, category: [], brand: [], max_price: "", search_data: []}
    default:
      return state
  }
}

export default SearchReducer;
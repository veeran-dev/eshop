import { createStore, applyMiddleware } from 'redux'
import reducers from '../reducers'
import thunkMiddleware from 'redux-thunk'
import promise  from 'redux-promise-middleware'

// applyMiddleware supercharges createStore with middleware
let store = createStore(reducers, applyMiddleware(thunkMiddleware, promise))

export default store

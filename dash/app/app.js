import React from 'react'
import ReactDOM from 'react-dom'
import { Provider } from 'react-redux'
import store from './store/configureStore'
import router from './router/configureRouter'
import { Promise } from 'es6-promise'
import './components/common/api-request-watcher/interceptors'

// Provider is a top-level component that wrapps our entire application, including
// the Router. We pass it a reference to the store so we can use react-redux's
// connect() method for Component Containers.
ReactDOM.render(
  <Provider store={store}>{router}</Provider>,
  document.getElementById('app'), 
  function() { document.getElementById('preloader').style.display = 'none';}
)
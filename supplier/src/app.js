import React from 'react'
import ReactDOM from 'react-dom'
import {Redirect} from 'react-router-dom'
import { Provider } from 'react-redux'
import store from './store/configureStore'
import router from './router/configureRouter'
import { CookiesProvider } from 'react-cookie';
// import { Promise } from 'es6-promise'
import axios from 'axios'
import Interceptors from './components/common/Interceptors'

// Provider is a top-level component that wrapps our entire application, including
// the Router. We pass it a reference to the store so we can use react-redux's
// connect() method for Component Containers.
ReactDOM.render(
	<CookiesProvider>
  		<Provider store={store}>{router}</Provider>
	</CookiesProvider>,
  document.getElementById('app')
)
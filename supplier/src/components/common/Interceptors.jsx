import axios from 'axios'
import LocalStorageService from "../../services/localstorageservice";
const localStorageService = LocalStorageService.getService();
// axios.interceptors.request.use(function (config) {
//   // Do something before request is sent
//   if(config.params != undefined)
//     config.params.token = "Hello";
//   return config;
// }, function (error) {
//   // Do something with request error
//   return Promise.reject(error);
// });

// Add a response interceptor
// axios.interceptors.response.use(function (response) {
//   // Do something with response data
//   return response;
// }, function (error) {
//   // Do something with response error
//   return Promise.reject(error);
// });

// const {dispatch} = store; // direct access to redux store.
axios.interceptors.response.use(
  response => {
    let loader = document.getElementById('loader')
    console.log(loader)
  	if(loader != null && loader != undefined){
  		document.getElementById('loader').style.visibility = 'hidden';	
  	}    
    return response
  },
  error => {
    console.log(error)
    console.log(error.response)
  	if(401 === error.response.status){
		window.location = '/supplier';
	}
  	return error
  },  
);

axios.interceptors.request.use(function (config) {
  document.getElementById('loader').style.visibility = 'visible';
  // Do something before request is sent
  if(config.params != undefined)
    config.params.supplier_token = "true";
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});
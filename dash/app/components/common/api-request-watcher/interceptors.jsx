import axios from 'axios'
//Add a request interceptor
axios.interceptors.request.use(function (config) {
	//document.body.classList.add('loading');
	document.getElementById('loader').style.visibility = 'visible';
	return config;
}, function (error) {
	return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
	//document.body.classList.remove('loading');
	document.getElementById('loader').style.visibility = 'hidden';
	return response;
}, function (error) {
	return Promise.reject(error);
});
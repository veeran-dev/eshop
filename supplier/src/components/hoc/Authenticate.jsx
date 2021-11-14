import React, { Component } from 'react'
import { Redirect } from 'react-router-dom'
import { authenticate } from '../../api/auth-api'

export function withAuthentication(WrappedComponent) 
{
	return class extends Component 
	{
		constructor(props) 
		{
			super(props)
			this.state = {
				authenticated: true
			}
		}

		componentWillMount() 
		{
			console.log("withAuthentication")
			authenticate().then(response => {
				if(response['id_supplier'] == 0 || response['id_supplier'] == null) {
					this.setState({ authenticated: false });
				}
				else {
					this.setState({ authenticated: true });
				}
			})
		}

		render() 
		{
			const { authenticated } = this.state
			if(!authenticated) {
				return <Redirect to="/" />;
			}
			
			return <WrappedComponent {...this.props} />;
		}
	}
}

export function checkLogged(WrappedComponent) {
	return class extends Component {
		constructor(props) {
			super(props)
			this.state = {
				isLogged: false
			}
		}

		componentWillMount() {
			console.log("checkLogged")
			authenticate().then(response => {
				if(response['id_supplier'] && response['id_supplier'] != null && response['id_supplier'] != false) {
					this.setState({ isLogged: true });
				}
			})
		}

		isLogged(){
			if(this.state.isLogged){
				return <Redirect to="/dashboard" />;
			}
			else{
				return true
			}
		}

		render() {
			const { isLogged } = this.state
			this.isLogged();
			return <WrappedComponent {...this.props} />;
		}
	}
}
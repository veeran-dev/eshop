import React,{Fragment} from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import Register from '../common/registerSupplier'
import {authLogin} from '../../api/auth-api'
import {recoverPassword} from '../../api/common-api'

class Home extends React.Component {
  constructor(props) {
    super(props)
    this.state ={
      login: true,
    }
  }

  submitCredential=(e)=>{

    e.preventDefault();
    
    let isError = false;

    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (!re.test(this.login_email.value)) {
        this.login_email_error.innerHTML = "Please enter valid email";
        isError = true;
    }
    
    if (!this.login_password.value.toString().trim().length || this.login_password.value.toString().trim().length < 8) {
      this.login_password_error.innerHTML = "Please enter atleast 8 characters";
      isError = true;
    }
    
    authLogin(this.login_email.value, this.login_password.value);

  }

  checkSignUp(){
    if(window.location.href.indexOf("signup") > -1) {
       return true
    }
    else{
      return false
    }
  }

  checkLogIn(){
    if(window.location.href.indexOf("signup") > -1) {
       return false
    }
    else{
      return true
    }
  }
  
  registerSupplier(e){
    e.preventDefault();
    if(this.checkSignUp() == true){
      this.props.history.push("/")  
    }
    else{
      this.props.history.push("/signup")
    }
    
  }


  render() {
    let location = window.location.href;
    console.log(this.props);
    console.log(this.state);
    return (
      <div className="login-page">
        <header className="navbar navbar-fixed-top padding10 business-fixed-header">
          <a className="logo" href="#">
            <img src="./src/assets/img/kobster-elite-logo.svg" alt="Kobster Elite"/>
          </a>
          <div className="conatct-info">
            <p>New Here? <a className="request-demo-button" href="#" target="_blank" onClick={this.registerSupplier.bind(this)}>{this.checkSignUp() == true ? "Login":"Sign up"}</a> Toll Free <a href="tel:18001210405"> 1800-121-0405</a></p>
          </div>
        </header>
          <div className="container">
            <div id="loader"><div className="spinner"></div></div>
            <div className="welcome">
              <h1>Manage your customers at your finger tips</h1>
              <p>Dashboard, Orders, Catalog...</p>
            </div>
            <div className={this.checkSignUp() == true? "signup-wrapper":"hidden"}>
              <Register id_customer={this.props.match.params.id_customer} id_group={this.props.match.params.id_group} reg_success={this.props.reg_success} user={this.props.user} />
            </div>
            <div className={this.checkLogIn() == true? "login-wrapper":"hidden"}>
              <div className="login-container">
                <form id="supplier_login_form" className="login-form" method="POST" onSubmit={this.submitCredential.bind(this)}>
                  <h1>Login</h1>
                  {this.props.error != undefined && this.props.error.length >0 ? <p className="errors">{this.props.error}</p>:null}
                  <div className="form-group-wrapper">
                      <span className="validation-errors" ref={(node) => {this.login_email_error = node}}></span>
                      <div className="form-group">
                          <span className="icon email"></span>
                          <input autoFocus type="email" ref={(node) => {this.login_email = node}} placeholder="E-mail ID" />
                      </div>
                      <span className="validation-errors" ref={(node) => {this.login_password_error = node}}></span>
                      <div className="form-group">
                          <span className="icon lock"></span>
                          <input type="password" ref={(node) => {this.login_password = node}} className="form-control" placeholder="Password" />
                      </div>
                      <div className="form-group">
                          <button type="submit" className="login-button">Login</button>
                          <a className="forget-password" onClick={recoverPassword}>Forgot Password?</a>
                      </div>
                  </div>
              </form>
              </div>
            </div>
          </div>
      </div>
    );

  }
}

const mapStateToProps = function({authState}) {
  console.log(authState);
  return {
    loading: authState.loading,
    reg_success: authState.supplier.success,
    user: authState.supplier,
    error: authState.registration_error,
    step: authState.step,
  }
}

export default connect(mapStateToProps)(Home);
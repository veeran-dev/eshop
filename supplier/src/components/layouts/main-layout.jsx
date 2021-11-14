import React, { Fragment } from 'react';
import { connect } from 'react-redux'
import {Redirect} from 'react-router-dom'
import Navbar from './header/Navbar';
import Topbar from './header/Topbar';
import {checkAuth} from '../../api/auth-api'
import * as settingsApi from '../../api/settings-api';
class App extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isAuth: true,
      isMobile: false,
    }
  }

  componentWillMount(){
    settingsApi.getCustomerLogo();
  }

  render() {
    return (
      <Fragment>
        
        <header>
          <Topbar user={this.props.user} logo={this.props.logo}/>
          <Navbar/>
        </header>
        <div className="container">
            <div id="loader">
              <div className="spinner"></div> 
            </div>
            {this.props.children}
        </div>
      </Fragment>
    );
  }
}
const mapStateToProps = function({authState, settingState}) {
  return {
    user: authState.supplier,
    logo: settingState.logo,
  }
}

export default connect(mapStateToProps)(App);
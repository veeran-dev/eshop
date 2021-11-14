import React from 'react';
import { Link } from 'react-router';
import Topbar from './header/Topbar';
import Navbar from './header/Navbar';

class App extends React.Component {
  render() {
    return (
      <div>
      <header>
        <Topbar/>
        <Navbar/>
      </header>
      <div className="container">
          <div id="loader">
            <div className="spinner"></div> 
          </div>
          {this.props.children}
      </div>
    </div>
    );

  }
}

export default App;
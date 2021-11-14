import React from 'react'
import { connect } from 'react-redux'
import Desktop from './accept-customer-desktop'
import Mobile from './accept-customer-mobile'

class AcceptCustomer extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
    };
  }

  componentWillMount(){
    if(window.innerWidth <= 992) {
       this.setState({isMobile: true})
     } else {
       this.setState({isMobile: false})
     }
  }

  view(url){
    this.props.history.push(url);
  }
    render() {
        return (
          <div className="page-container">
            {this.state.isMobile != true ? <Desktop view={this.view.bind(this)}/> : <Desktop view={this.view.bind(this)} />}
          </div>
        )
    }
}

export default AcceptCustomer
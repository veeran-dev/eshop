import React from 'react'
import { connect } from 'react-redux'
import Desktop from './inventory-list-desktop'
import Mobile from './inventory-list-mobile'

class InventoryListIndex extends React.Component {
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
          <div>
            {this.state.isMobile != true ? <Desktop view={this.view.bind(this)}/> : <Mobile view={this.view.bind(this)} />}
          </div>
        )
    }
}

// OrderListIndex.contextTypes = {
//   router: React.PropTypes.object.isRequired
// };

export default InventoryListIndex
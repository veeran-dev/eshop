import React from 'react'
import Desktop from './orders-details-desktop'
import Mobile from './orders-details-mobile'
import * as orderApi from '../../../api/orders-api';

class OrderDetailsIndex extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
    };
  }

  componentWillMount(){
    console.log(this.props.params.id)
    if(window.innerWidth <= 992) {
       this.setState({isMobile: true})
     } else {
       this.setState({isMobile: false})
     }
  }

    render() {
        return (
          <div>
            {this.state.isMobile != true ? <Desktop parent_order={this.props.params.id} /> : <Mobile parent_order={this.props.params.id}  />}
          </div>
        )
    }
}

export default OrderDetailsIndex
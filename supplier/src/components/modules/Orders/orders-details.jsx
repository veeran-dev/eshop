import React from 'react'
import Desktop from './orders-details-desktop'
import Mobile from './orders-details-mobile'

class OrderDetailsIndex extends React.Component {
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

    render() {
        return (
          <div>
            {this.state.isMobile != true ? <Desktop parent_order={this.props.match.params.id_order} /> : <Mobile parent_order={this.props.match.params.id_order}  />}
          </div>
        )
    }
}

export default OrderDetailsIndex
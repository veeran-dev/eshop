import React from 'react'
import axios from 'axios'
import InfiniteScroll from 'react-infinite-scroller';
import store from '../../../store/configureStore'
import Desktop from './supplier-list-desktop'
import Mobile from './supplier-list-mobile'

class SupplierIndex extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
       isMobile: false,
       suppliers: [],
       isFetching: false,
    };
  }
  componentDidMount(){
    this.setState({isFetching: true})
    
    if(window.innerWidth <= 992) {
      this.setState({isMobile: true})
    } else {
      this.setState({isMobile: false})
    }
    
    return axios.get('./elite-supplier.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      id_customer: id_customer,
                  }}).then(response => {
                    console.log(response.data['suppliers'].length);
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['suppliers'].length > 0){ 
                      this.setState({suppliers :response.data['suppliers']})  
                    }
                    this.setState({isFetching: false})
                    store.dispatch(action.loading(false))
                    return response
    });
  }

  render() {
      return (
        <div>
          {this.state.isMobile != true ? <Desktop isFetching={this.state.isFetching} suppliers={this.state.suppliers} /> : <Mobile isFetching={this.state.isFetching} suppliers={this.state.suppliers} />}
        </div>
      )
  }
}

SupplierIndex.contextTypes = {
  router: React.PropTypes.object.isRequired
};


export default SupplierIndex
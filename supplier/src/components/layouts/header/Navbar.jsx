import React from 'react';
import { NavLink } from 'react-router-dom';
import Ripples from 'react-ripples';

class Navbar extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isMobile: false,
    }
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
			<div className="navbar">
				<ul>
					<li>
						<Ripples>
							<NavLink to="/dashboard" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-dashboard"></i>
								<span className="menu-label">Dashboard</span>
							</NavLink>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<NavLink to="/quotations/home" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-reports"></i>
								<span className="menu-label">Quotations</span>
							</NavLink>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<NavLink to="/orders" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-cart"></i>
								<span className="menu-label">Orders</span>
							</NavLink>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<NavLink to="/inventory" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-cart"></i>
								<span className="menu-label">Inventory</span>
							</NavLink>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<NavLink to="/catalog/home" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-book"></i>
								<span className="menu-label">Catalog</span>
							</NavLink>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<NavLink to="/settings" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-settings"></i>
								<span className="menu-label">Settings</span>
							</NavLink>
						</Ripples>
					</li>
				</ul>
			</div>
		)
	}
}

export default Navbar;
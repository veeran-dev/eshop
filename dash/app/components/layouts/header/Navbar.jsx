import React from 'react';
import { Link } from 'react-router';
import Ripples from 'react-ripples';

class Navbar extends React.Component {
    render() {
	    return (
			<div className="navbar">
				<ul>
					<li>
						<Ripples>
							<Link to="dashboard" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-dashboard"></i>
								<span className="menu-label">Dashboard</span>
							</Link>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<Link to="procure" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-procure"></i>
								<span className="menu-label">Procure/Buy</span>
							</Link>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<Link to="orders" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-orders-alt"></i>
								<span className="menu-label">Orders</span>
							</Link>
						</Ripples>
					</li>
					<li>
						<Ripples>
							<Link to="reports" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-reports"></i>
								<span className="menu-label">Reports</span>
							</Link>
						</Ripples>
					</li>
					{/*<li>
						<Ripples>
							<Link to="invoices-drs" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-invoices"></i>
								<span className="menu-label">Invoices</span>
							</Link>
						</Ripples>
					</li>*/}
					<li>
						<Ripples>
							<Link to="quotations" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-invoices"></i>
								<span className="menu-label">Quotations</span>
							</Link>
						</Ripples>
					</li>
					{/*<li>
						<Ripples>
							<Link to="suppliers" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-invoices"></i>
									<span className="menu-label">Suppliers</span>
							</Link>
						</Ripples>
					</li>*/}
					{/*}
					<li>
						<Ripples>
							<Link to="pending-payments" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-invoices"></i>
								<span className="menu-label">Payments</span>
							</Link>
						</Ripples>
					</li>*/}
					{ !(role == 0 || role == 1) ?
					<li>
						<Ripples>
							<Link to="approvals" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-approvals"></i>
								<span className="menu-label">Approvals</span>
							</Link>
						</Ripples>
					</li> : null }
					{/*<li>
						<Ripples>
							<Link to="inventory" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-inventory-control"></i>
								<span className="menu-label">Inventory</span>
							</Link>
						</Ripples>
					</li>*/}
					{/* {budgetConfigured != 1 ?
					<li>
						<Ripples>
							<Link to="deals" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-deals2"></i>
								<span className="menu-label">Deals</span>
							</Link>
						</Ripples>
					</li> : null} */}
					<li>
						<Ripples>
							<Link to="services" className="menu-item" activeClassName="is-active">
								<i className="menu-icon icon-services"></i>
								<span className="menu-label">Services</span>
							</Link>
						</Ripples>
					</li>
				</ul>
			</div>
		)
	}
}

export default Navbar;
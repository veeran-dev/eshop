import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as cartApi from '../../../api/cart-api';
import * as addressApi from '../../../api/address-api';

class MobileMoreMenu extends React.Component {
    constructor(props) {
        super(props);
        this._handleOutsideClick = this._handleOutsideClick.bind(this);
        this.state = {
            mobilePopover: false
        }
    }
    _handleClick(e){
        e.preventDefault();
        this.setState({mobilePopover: !this.state.mobilePopover})
    }
    _handleOutsideClick(e){
        if (!this.refs.moreMenuButton.contains(e.target)) {
            this.setState({mobilePopover: false});
        }
    }
    _openStateModal(e){
        e.preventDefault();
        let elementID = document.getElementById("citySelection");
        elementID.setAttribute("style", "display: flex; display: -webkit-flex;");
    }
    componentDidMount() {
        cartApi.getLoyaltyPoints()
		addressApi.getStates()
        document.addEventListener('click', this._handleOutsideClick);
    }
    componentWillUnmount() {
        document.removeEventListener('click', this._handleOutsideClick);
    }
    render() {
        return (
        <div className="topbar-item-mobile">
            <a ref="moreMenuButton" href="#" className={this.state.mobilePopover ? "mobile-popover-trigger is-menu-active" : "mobile-popover-trigger"} onClick={this._handleClick.bind(this)}><i className="icon-more"></i></a>
            <div className="mobile-popover" ref="moreMenu">
                <ul className="popover-content mega-menu-content">
                    <li className="popover-content-item">
                        <p>{username}</p>
                    </li>
                    <li className="popover-content-item" id="state-selection-topbar-mobile" ref="stateSelectionTopbarMobile">
                        <a href="#" onClick={this._openStateModal.bind(this)}>{deliveryRegionName}</a>
                    </li>
                    {/*<li className="popover-content-item">
                        {this.props.loyaltyCount.length ? <Link to="loyalty-points">Loyalty Points</Link> : null}
                    </li>*/}
                    <li className="popover-content-item">
                        <Link to="/help-faqs">Help/FAQs</Link>
                    </li>
                    <li className="popover-content-item">
						<Link to="/feedback">Feedback</Link>
                    </li>
                    <li className="popover-content-item">
                        <Link to="settings">Settings</Link>
                    </li>
                    <li className="popover-content-item">
                        <a href={logoutLink}>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        )
    }
}

const mapStateToProps = function(store) {
  return {
    loyaltyCount: store.cartState.loyaltyCount,
    states: store.addressState.states,
  }
}

export default connect(mapStateToProps)(MobileMoreMenu)
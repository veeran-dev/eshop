import React from 'react';
import { NavLink } from 'react-router-dom';
import { connect } from 'react-redux';
import {clearAuth} from '../../../api/auth-api'

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
    componentDidMount() {
        document.addEventListener('click', this._handleOutsideClick);
    }
    componentWillUnmount() {
        document.removeEventListener('click', this._handleOutsideClick);
    }
    logout=(e)=>{
        clearAuth()
    }
    render() {
        let user = this.props.user;
        return (
        <div className="topbar-item-mobile">
            <a ref="moreMenuButton" href="#" className={this.state.mobilePopover ? "mobile-popover-trigger is-menu-active" : "mobile-popover-trigger"} onClick={this._handleClick.bind(this)}><i className="icon-more"></i></a>
            <div className="mobile-popover" ref="moreMenu">
                <ul className="popover-content mega-menu-content">
                    <li className="popover-content-item">
                        <p>{user.name != undefined && user.name != "" ? user.name :"John Doe "}</p>
                    </li>
                    <li className="popover-content-item">
						<NavLink to="/feedback">Feedback</NavLink>
                    </li>
                    <li className="popover-content-item">
                        <NavLink to="settings">Settings</NavLink>
                    </li>
                    <li className="popover-content-item">
                        <a id="logoutLink" href="#" onClick={(e)=>logout(e)}>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        )
    }
}

export default MobileMoreMenu
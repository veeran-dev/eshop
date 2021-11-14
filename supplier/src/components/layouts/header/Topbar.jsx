import React,{useState} from 'react'
import { NavLink } from 'react-router-dom';
import {clearAuth} from '../../../api/auth-api'
import MobileMoreMenu from './mobile-more-menu'
const Topbar =({user, logo})=> {
	const [mobileMenu, setMobileMenu] = useState('is-hidden');

	const logout=(e)=>{
		clearAuth()
	}
	// document.addEventListener('click', this._handleOutsideClick, false);
	const _handleClick=(e)=>{
    	e.preventDefault();
        if (mobileMenu === 'is-hidden'){
            setMobileMenu('is-active')
        }else {
        	setMobileMenu('is-hidden')
        }
    }

	// const _handleOutsideClick=(event)=>{
	// 	if (this.refs.mobileMenuButton.contains(event.target)) {
	// 		return
 //        } else {
 //            this.setState({mobileMenu: 'is-hidden'});
 //        }
	// }
	const imageSrc = logo != undefined && logo != '' ? logo : 'src/assets/img/logo/default-customer-logo.jpg';

    return (
		<div className="topbar" id={mobileMenu}>
			<div className="topbar-wrapper" id="sticky">
				<div className="topbar-item-mobile">
					<a href="#"  className={mobileMenu} onClick={(e)=>_handleClick(e)}><i className="icon-menu"></i></a>
				</div>
				<div className="logo-section">
					<NavLink to="/dashboard"><span className="logo" title="Kobster Elite"></span></NavLink>
				</div>
				<div className="topbar-right-section">
					<div className="topbar-item account">
						<a href="javascript:void(0)" className="topbar-menu-item">
							<div className="menu-icon-block">
								<i className="menu-icon menu-icon-red icon-account"></i>
							</div>
							<span className="menu-label">Account<i className="icon-arrow-dropdown"></i></span>
						</a>
						<div className="mega-menu">
							<div className="mega-menu-content account tooltip-arrow">
								<div className="profile-cover">
									<img src={imageSrc} alt="Customer Logo" />
									<p className="username">{user.name != undefined && user.name != "" ? user.name :"John Doe "}</p>
								</div>
								<ul>
									<li>
										<NavLink to="/settings">Settings</NavLink>
										<NavLink to="/help-faqs">Help/FAQs</NavLink>
										<NavLink to="/feedback">Give Us Feedback</NavLink>
										<a id="logoutLink" href="#" onClick={(e)=>logout(e)}>Logout</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<MobileMoreMenu user={user} />
			</div>
		</div>
	)
}

export default Topbar
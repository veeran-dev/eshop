import React from 'react'
import './header.scss'
import kobsterLogo from './kobster-logo.svg';

const Header = () => (
    <header>
      <div className="container">
        <div className="header-wrapper">
            <a href="#" className="branding"><img src={kobsterLogo} alt="Kobster Logo" /></a>
            <div className="menu">
                <a href="https://www.kobster.com/about.php">About</a>
                <a href="https://www.kobster.com/careers.php">Careers</a>
                <a href="https://www.kobster.com/contact.php">Contact</a>
                <a className="button-link" href="https://www.kobster.com/signup.php">Sign Up</a>
            </div>
        </div>
      </div>
    </header>
)

export default Header; 
import React from 'react'
import './footer.scss'
import Fb from '-!babel-loader!svg-react-loader?name=Icon!./fb-logo.svg';
import Li from '-!babel-loader!svg-react-loader?name=Icon!./li-logo.svg';
import Tw from '-!babel-loader!svg-react-loader?name=Icon!./tw-logo.svg';
import Yu from '-!babel-loader!svg-react-loader?name=Icon!./yu-logo.svg';

const Footer = () => (
    <footer className="footer_section">
        <div className="container">
        	<div className="fsection">
        		<a href="#" className="head">Kobster</a>
        		<a href="/home/about">About</a>
        		<a href="/home/careers">Careers</a>
        	</div>
        	<div className="fsection">
        		<a href="#" className="head">Categories</a>
        		<a href="../../office-supplies.php">Stationery</a>
        		<a href="../../pantry.php">Pantry</a>
        		<a href="../../electronics.php">Electronics</a>
                <a href="../../house-keeping.php">Housekeeping</a>
        	</div>
        	<div className="fsection">
        		<a href="#" className="head">Policies</a>
        		<a href="../../index.php?controller=cms?id_cms=3">Terms and Conditions</a>
        		<a href="../../blogs/">Blog</a>
        	</div>
        	<div className="fsection">
        		<a href="#">1800-121-0405 (Toll Free)</a>
        		<a href="#">support@kobster.com</a>
        	</div>
        </div>
        <div className="logo-links">
            <a aria-label="kobster_fb" href="https://www.facebook.com/kobsterIndia/">
                <Fb />
            </a>
            <a aria-label="kobster_linkedin" href="https://www.linkedin.com/company/kobster/">
                <Li />
            </a>
            <a aria-label="kobster_twitter" href="https://twitter.com/KobsterOfficial/">
                <Tw />
            </a>
            <a aria-label="kobster_youtube" href="https://www.youtube.com/user/kobsterindia/">
                <Yu />
            </a>
        </div>
        <p className="copyright">&copy; Kobster.com 2012 - 2018. All rights reserved.</p>
    </footer>
)
export default Footer; 
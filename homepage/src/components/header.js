import React from 'react'
import SiteNav, {ContentGroup} from 'react-site-nav';

import './header.scss'
import kobsterLogo from './kobster-logo.svg';
import Menu from '-!babel-loader!svg-react-loader?name=Menu!./menu.svg';
import Close from '-!babel-loader!svg-react-loader?name=Close!./close.svg';


class Header extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            showMenu: false,
            react_site_nav: false,
            load: true,
            intervalId: 0,
        }
        this._toggleMenu = this._toggleMenu.bind(this);
    }

    // componentDidMount(){
    //     let newDate = new Date()
    //     console.log("componentDidMount  " +newDate)
    // }

    // componentDidUpdate(){
    //     let newDate = new Date()
    //     console.log("componentDidUpdate  " +newDate)   
    // }
    componentDidMount(){
        // let newDate = new Date()
        // console.log("componentWillMount  " +newDate)
        if(typeof document !== `undefined`){
            let clear = 0;
            var intervalId = setInterval(function(){
                let newDate = new Date()
                console.log("componentWillMount  " +newDate)
                console.log(document.readyState)
                if(document.readyState === "complete"){
                    clear = 1;
                    this.setState({react_site_nav: true});
                    clearInterval(this.state.intervalId);
                }
            }
            .bind(this),
            1000);
            if(clear === 0)
                this.setState({intervalId: intervalId});
        }

        // setTimeout(
        //     function() {
        //         console.log(this.state.load);
        //         this.setState({react_site_nav: true});
        //     }
        //     .bind(this),
        //     2500
        // );
    }
    _toggleMenu(){
        this.setState({
          showMenu: !this.state.showMenu
        })
    }

    render(){
        const menuActive = this.state.showMenu ? 'mobile-menu onClose' : 'mobile-menu';
        const menu = this.state.showMenu ? 'menu active' : 'menu';
        return (
            <header>
              <div className="header-container">
                <div className="header-wrapper">
                    <a href="/" className="branding"><img src={kobsterLogo} alt="Kobster Logo" /></a>
                    {this.state.react_site_nav ? 
                        <SiteNav
                            background="transparent"
                            color="#3D3D3D">
                            <ContentGroup title="Company" height="200" width="240">
                                <a className="menu-link" href="/home/about">About <span> Learn more about us </span></a>
                                <a className="menu-link" href="/home/careers">Careers <span> Join our growing team </span></a>
                                <a className="menu-link" href="/home/contact">Contact <span> Speak with an expert </span></a>
                            </ContentGroup>
                            <ContentGroup title="Category" height="260" width="300">
                                <a className="menu-link" href="../../pantry.php">Pantry <span> Eat nutritious snacks </span></a>
                                <a className="menu-link" href="../../office-supplies.php">Stationary <span>Stationery from trusted brands</span></a>
                                <a className="menu-link" href="../../electronics.php">Electronics <span> Office devices & accessories </span></a>
                                <a className="menu-link" href="../../house-keeping.php">House Keeping <span> Use, clean & refill </span></a>
                            </ContentGroup>
                            <ContentGroup border="none" title="Newsroom" className="menu-link" rootUrl="/home/newsroom" />
                        </SiteNav>:null
                    }
                    <a className="button-link button22" href="../../dash-index.php">Sign In</a>
                    <div className={menuActive} onClick={this._toggleMenu}>
                        <Menu className="burger-menu"/>
                        <Close className="close"/>
                    </div>
                    {this.state.showMenu ?
                        <div className={menu} >                        
                            <a className='menu-link' href='/home/about' >About<span> Learn more about us </span></a>
                            <a className='menu-link' href='/home/careers' >Careers<span> Join our growing team</span></a>
                            <a className='menu-link' href='/home/contact' >Contact<span> Speak with an expert</span></a>
                            <a className='menu-link' href='/home/newsroom' >Newsroom<span> Media lights on us</span></a>
                            <a className='menu-link' href="../../pantry.php" >Pantry<span> Eat nutritious snacks </span></a>
                            <a className='menu-link' href="../../office-supplies.php" >Stationary<span> Use, clean & refill</span></a>
                            <a className='menu-link' href="../../electronics.php" >Electronics<span> Office devices & accessories</span></a>
                            <a className='menu-link' href="../../house-keeping.php" >House Keeping<span> Stationery from trusted brands</span></a>
                            <a className='sign-link' href="../../elite-auth" >Sign in</a>
                        </div>
                    : null}
                </div>
              </div>
            </header>
        )}
}
export default Header; 
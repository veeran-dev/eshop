import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./svg/Reports&Analytics.svg';
class HeroSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isHeroActive: false,
            animateImage: false,
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
        this._handleWaypointContentEnter = this._handleWaypointContentEnter.bind(this);
        this._handleWaypointContentLeave = this._handleWaypointContentLeave.bind(this);
    }
    _handleWaypointEnter(){
        this.setState({
            isHeroActive: true
        })
    }
    _handleWaypointLeave(){
        this.setState({
            isHeroActive: false
        })
    }
    _handleWaypointContentEnter(){
        this.setState({
            animateImage: true
        })
    }
    _handleWaypointContentLeave(){
        this.setState({
            animateImage: false
        })
    }
    render(){
        return(
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave}>
            <div className={this.props.hide +" section report-section"} >
                <div className={"container" + (this.state.isHeroActive ? " fade-in" : " fade-out")}>
                    <h1 className="section-title">MINDTREE reduced their spend by 10% by unlocking actionable insights with our <span>Reports & Analytics Dashboard</span></h1>
                    <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                    <div className="row">
                        <div className="col-10">
                            <Image className={"hero-image" + (this.state.animateImage ? " anim-in" : " anim-out")}/>
                        </div>
                        <div className="col-5">
                            <p className="section-lead">Leading organisations use our accurate data feeds to increase savings, reduce operational costs and prevent risks from occurring. Also, our e-invoicing processes are transparent, tax compliant and up to date - something all companies are looking for!</p>
                            <a href="/#dmc_form" className="cta">Request Demo</a>
                        </div>
                    </div>
                    </Waypoint>
                </div>
            </div>
        </Waypoint>
        )
    }
}

export default HeroSection;
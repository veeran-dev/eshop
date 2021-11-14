import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./svg/Strategic Sourcing.svg';
class HeroSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isHeroActive: false,
            isAnimActive: false,
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
            isAnimActive: true
        })
    }
    _handleWaypointContentLeave(){
        this.setState({
            isAnimActive: false
        })
    }
    render(){
        return(
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave} >
            <div className={this.props.hide +" section strategic-section"} ref={(section) => { this.view = section; }}>
                <div className="container">
                    <h1 className="section-title">With our <span>Millions of data points + Procurement transactions</span> processed over the years, SCHENKER gained valuable sourcing intelligence from us</h1>
                    <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave} topOffset={'70%'}>
                    <div className="row">
                        <div className="col-10">
                            <Image className={"hero-image" + (this.state.isAnimActive ? " anim-in" : " anim-out")}/>
                        </div>
                        <div className="col-5">
                            <p className="section-lead">Businesses prefer to make fact-based decisions to execute their procurement effectively. Indeed, our years of procurement data suggest that logistic companies consume a lot of copier paper. With this simple insight, Schenker was able to gain a competitive advantage in sourcing paper from us.</p>
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
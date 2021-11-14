import React from 'react'
import Waypoint from 'react-waypoint'
import './e-procurement-section.scss'
import Image from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./svg/Bottomline-chart.svg';
class HeroSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isHeroActive: false,
            animateImage: false,
            error: "",
            success: false,
            button: 'Request for Demo!',    
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
        this._handleWaypointContentEnter = this._handleWaypointContentEnter.bind(this);
        this._handleWaypointContentLeave = this._handleWaypointContentLeave.bind(this);
    }
    _handleWaypointEnter(){
        console.log("viewing..!");
        // scrollToComponent(this.view, { offset: 0, align: 'top', duration: 1000});
        this.setState({
            isHeroActive: true
        })
    }
    _handleWaypointLeave(){
        console.log('viewed..!');
        this.setState({
            isHeroActive: false
        })
    }
    _handleWaypointContentEnter(){
        console.log("new told here");
        this.setState({
            animateImage: true
        })
    }
    _handleWaypointContentLeave(){
        console.log("old here");
        this.setState({
            animateImage: false
        })
    }
    render(){
        return(
            <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave}>
                <div className={this.props.hide +" section e-procurement-section"}>
                    <div className={"container" + (this.state.isHeroActive ? " fade-in" : " fade-out")}>
                        <h1 className="section-title">Procurement can add value to an organisation only if it drives impact on the bottom line.</h1>
                        <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                        <div className="row">
                            <div className="col-10">
                                <Image className={"hero-image" + (this.state.animateImage ? " anim-in" : " anim-out")}/>
                            </div>
                            <div className="col-5">
                                <p className="section-lead">Operating your procurement with our technology can ensure that the savings reach the bottom line. It can support organisational goals far beyond the traditional belief, that procurement’s primary role is to meet their needs for goods only.</p>
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
import React from 'react'
import Waypoint from 'react-waypoint'
import './inspection-section.scss'
import Image from '-!babel-loader!svg-react-loader?name=ManualInspection!./svg/Manual Inspection.svg';
// import image from './PNG/manual-inspection.png'

class DeliverySection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            sectionOneEnter: false,
            animateImage: false,
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
        this._handleWaypointContentEnter = this._handleWaypointContentEnter.bind(this);
        this._handleWaypointContentLeave = this._handleWaypointContentLeave.bind(this);
    }
    _handleWaypointEnter(){
        this.setState({
            sectionOneEnter: true
        })
    }
    _handleWaypointLeave(){
        this.setState({
            sectionOneEnter: false
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
            <div className={this.props.hide+" hide section inspection-section"} ref={(section) => { this.view = section; }}>
                <div className={"container" + (this.state.sectionOneEnter ? " fade-in" : " fade-out")}>
                    <h1 className="section-title">Our genuine <span>Quality Control</span> process delivered 3x times more employee wellness than before, to ORACLE</h1>
                    <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                    <div className="row">
                        <div className="col-5">
                            <p className="section-lead">An expired snack at the office may cost you dear!</p>
                            <p className="section-lead">That’s why in spite of all tech-enabled quality checks, we have the final manual inspection, to ensure safety on what employees consume, which further strengthens the employee-employer relationship.</p>
                            <a href="/#dmc_form" className="cta">Request Demo</a>
                        </div>
                        <div className="col-10">
                            <Image className={"hero-image" + (this.state.animateImage ? " anim-in" : " anim-out")}/>
                        </div>
                    </div>
                    </Waypoint>
                </div>
            </div>
        </Waypoint>
        )
    }
}

export default DeliverySection;
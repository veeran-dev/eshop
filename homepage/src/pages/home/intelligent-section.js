import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=Icon!./svg/Approval workflow.svg';
import './intelligent-section.scss'
class DeliverySection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            sectionOneEnter: false,
            sectionTwoEnter: false,
            sectionThreeEnter: false,
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
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
    render(){
        return(
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave}>
            <div className={this.props.hide +" section intelligent-section"} >
                <div className={"container" + (this.state.sectionOneEnter ? " fade-in" : " fade-out")}>
                    <h1 className="section-title">Implementing our Centre-led Approval System helped URBAN LADDER gain 80% more visibility into their procurement process</h1>
                    <div className="row">
                        <div className="col-5">
                            <p className="section-lead">Our real-time approval workflow empowers enterprises to have more control on purchase requisitions. It reduces all human errors to save precious time and resources; thereby, improving efficiency more easily.</p>
                            <a href="/#dmc_form" className="cta">Request Demo</a>
                        </div>
                        <div className="col-10">
                            <Image className="hero-image"/>
                        </div>
                    </div>
                </div>
            </div>
        </Waypoint>
        )
    }
}

export default DeliverySection;
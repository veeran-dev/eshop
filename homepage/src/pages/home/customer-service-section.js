import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=Icon!./svg/Customer-service.svg';

class DeliverySection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            sectionOneEnter: false,
            animateImage: false,
        }
        
        this._handleWaypointContentEnter = this._handleWaypointContentEnter.bind(this);
        this._handleWaypointContentLeave = this._handleWaypointContentLeave.bind(this);
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
            <div className={this.props.hide +" section customer-service-section"} >
                <div className="container">
                    <h1 className="section-title">Our dedicated <span>Relationship Manager</span> works behind-the-scenes to solve unpredictable problems for ALTISOURCE</h1>
                    <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                    <div className="row">
                        <div className="col-10">
                            <Image className={"hero-image" + (this.state.animateImage ? " anim-in" : " anim-out")}/>
                        </div>
                        <div className="col-5">
                            <p className="section-lead">Procurement can be a thankless, daunting and demanding job. That is why our relationship managers (read sourcing specialists) work behind-the-scenes to solve unpredictable problems and strive to make procurement personalised and delightful experience.</p>
                            <a href="/#dmc_form" className="cta">Request Demo</a>
                        </div>
                    </div>
                    </Waypoint>
                </div>
            </div>
        )
    }
}

export default DeliverySection;
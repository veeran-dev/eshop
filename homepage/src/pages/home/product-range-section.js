import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./svg/Product Range.svg';
import './product-range-section.scss'

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
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave} >
            <div ref={(section) => { this.view = section; }} className={this.props.hide+" section product-range-section"}>
                <div className={"container" + (this.state.sectionOneEnter ? " fade-in" : " fade-out")}>
                    <h1 className="section-title">REVTECH eliminated inconsistency in their supplies by purchasing almost 85% of <span>all Office Supplies</span> from us</h1>
                    <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                    <div className="row">
                        <div className="col-5">
                            <p className="section-lead">Businesses receive all the office supplies throughout the year; from stationery to the pantry eatables, high-end electronics to cleaning products through us. Besides the regular payment terms, they can also make use of our much flexible options such as 30-days credit & corporate cards for purchases.</p>
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
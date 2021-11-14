import React from 'react'
import Waypoint from 'react-waypoint'
import Image from '-!babel-loader!svg-react-loader?name=ManualInspection!./svg/Delivery.svg';
class QualitySection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isQualityActive: false,
            animateImage: false,
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
            isQualityActive: true
        })
    }
    _handleWaypointLeave(){
        console.log('viewed..!');
        this.setState({
            isQualityActive: false
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
                <div className={this.props.hide +" section delivery-section"} >
                    <div className={"container" + (this.state.isQualityActive ? " fade-in" : " fade-out")}>
                        <h1 className="section-title">VIRTUSA enjoys uniform product quality from our <span>pan India Delivery</span> capabilities</h1>
                        <Waypoint onEnter={this._handleWaypointContentEnter} onLeave={this._handleWaypointContentLeave}>
                        <div className="row">
                            <div className="col-10">
                                <Image className={"hero-image" + (this.state.animateImage ? " anim-in" : " anim-out")}/>
                            </div>
                            <div className="col-5">
                                <p className="section-lead">We own the last mile fulfilment to ensure that the goods reach its destination safely. Our unique hyperlocal delivery model takes us close to business locations and enables us to deliver supplies in less than 48 hours. And we do this across five cities today and are coming to many more!</p>
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

export default QualitySection;
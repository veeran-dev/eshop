import React from 'react'
import Waypoint from 'react-waypoint'
import scrollToComponent from 'react-scroll-to-component';
// import './intelligent-section.scss'

class DeliverySection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
        }
    }
    render(){
        const row1 = <div>heloo</div>
        const row2 = <div>fs,mnfoo</div>
        return(
                <div className="container">
                    <NotificationContainer/>
                </div>
        )
    }
}

export default DeliverySection;


export class NotificationContainer extends React.Component{
    render(){
        return(
            <div className="notification-container">
                <div className="notification">
                    <div className="icons">88</div>
                    <div className="contents">Eliminating all manual and human errors saved URBAN LADDER precious time and resources</div>
                    <div className="actions">closse</div>
                </div>
                <div className="notification">
                    <div className="icons">88</div>
                    <div className="contents">Eliminating all manual and human errors saved URBAN LADDER precious time and resources</div>
                    <div className="actions">closse</div>
                </div>
                <div className="notification">
                    <div className="icons">88</div>
                    <div className="contents">Eliminating all manual and human errors saved URBAN LADDER precious time and resources</div>
                    <div className="actions">closse</div>
                </div>
            </div>
            )
    }
}
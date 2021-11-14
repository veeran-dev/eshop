import React from 'react'
import axios from 'axios'
import Waypoint from 'react-waypoint'
import Hero from '-!babel-loader!svg-react-loader?name=hero!./svg/new_eProcurement.svg';
import Expert from '-!babel-loader!svg-react-loader?name=hero!./experts.svg';
import './title-section.scss'
class TitleSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isHeroActive: false,
            error: "",
            success: false,
            button: 'Request for Demo!',
            showForm: false,
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
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
    handleDemo(){
        this.setState({showForm: true})
    }
    
    handleSubmit(e){
        e.preventDefault();

        this.setState({card: 'loading'})
    
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(this.email.value === "" || !re.test(String(this.email.value).toLowerCase())){
            this.setState({card: '',error: "Please verify your email"});
            return false;
        }

        if (this.name.value.replace(/\s/g, '').length <= 0 || this.name.value === "") {
            this.setState({card: '',error: "Please enter your name"});   
            return false;
        }

        var regmm='^([0|+[0-9]{1,5})?([7-9][0-9]{9})$';
        var regmob = new RegExp(regmm);
        if(this.mobile.value === "" || !regmob.test(this.mobile.value)) {
            this.setState({error: "Please enter valid mobile number",card: ''});      
            return false;
        }

        axios.get('../get_eliteResponse2.php?&cust_name='+this.name.value.trim()+'&email='+this.email.value+'&mobile='+this.mobile.value+'&page=0&form=4').then(response => {
        if(response['data'] === "success"){
            this.setState({card: 'final', error: ''})
            setTimeout(
                function() {
                    this.setState({card: ''});
                }
                .bind(this),
                3000
            );
        }
        return response
        })

        this.name.value = "";
        this.email.value = "";
        this.mobile.value = "";

    }

    handleCancel(){
        this.setState({showForm: false})
        var paragraph = window.location.href;
        var regex = 'dmc_form';
        var found = '';
        found = paragraph.match(regex);
        if(found !== null && found[0] === 'dmc_form'){
            window.location.href = paragraph.replace('dmc_form', '')
        }
        
    }
    cardState(){
        return "card "+this.state.card;
    }

    render(){
        return(
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave}>
            <div className={this.props.hide +" section title-section"} ref={(section) => { this.view = section; }}>
            {this.state.showForm  === true ?
                <div className="container form-container">
                    <div className="form-wrapper">
                        <form>
                            <div className="form-cover">
                            <div className={this.cardState()}>
                                <div className="main-card">
                                    <h1>You will hear from us</h1>
                                    <div className="inp-wrapper">
                                        <label>Name</label>
                                        <input type="text" ref={(node) => {this.name = node}} />
                                    </div>
                                    <div className="inp-wrapper">
                                        <label>Email</label>
                                        <input type="text" ref={(node) => {this.email = node}} />
                                    </div>
                                    <div className="inp-wrapper">
                                        <label>Mobile</label>
                                        <input type="text" ref={(node) => {this.mobile = node}} />
                                    </div>
                                    {this.state.error !=="" ?
                                    <div className="inp-wrapper">
                                        <label className="error">{this.state.error}</label>
                                    </div>:null}
                                    <div className="button-wrapper">
                                        <button className="submitBtn" onClick={this.handleSubmit.bind(this)}>Yes, please</button>
                                        <button className="cancelBtn" onClick={this.handleCancel.bind(this)}>No, Thanks</button>
                                    </div>
                                </div>
                                <div className="loading-card">
                                    <div className="loading"></div>
                                </div>
                                <div className="final-card">
                                    <Expert />
                                    <h1>Thank You</h1>
                                    <p>Our experts will contact you very soon</p>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>:null}
                <div className={"container" + (this.state.isHeroActive ? " fade-in" : " fade-out")}>
                    <div className="row">
                        <div className="col-5">
                            <h1 className="section-title">eProcurement Solution for Businesses</h1>
                            <p className="section-lead">The place where buying office supplies and meeting organisational goals unite.</p>
                            <div className="btn-container"><a className="btn" onClick={this.handleDemo.bind(this)}>Request Demo</a></div>
                        </div>
                        <div className="col-5">
                            <Hero />
                        </div>
                    </div>
                </div>
            </div>
        </Waypoint>
        )
    }
}

export default TitleSection;
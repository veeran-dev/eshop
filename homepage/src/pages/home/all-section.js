import React from 'react'
// import './hero-section.scss'
import Waypoint from 'react-waypoint'
import axios from 'axios'
import scrollToComponent from 'react-scroll-to-component';
import './all-section.scss'
import StrategicSourcing from '-!babel!svg-react-loader?name=StrategicSourcing!./ss.svg';
import Hero from '-!babel!svg-react-loader?name=hero!./epso.svg';
class HeroSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            isHeroActive: true
        }
        this._handleWaypointEnter = this._handleWaypointEnter.bind(this);
        this._handleWaypointLeave = this._handleWaypointLeave.bind(this);
    }
    _handleWaypointEnter(){
        console.log("viewing..!");
        // scrollToComponent(this.view, { offset: 0, align: 'top', duration: 1000});
        // this.setState({
        //     isHeroActive: true
        // })
    }
    _handleWaypointLeave(){
        console.log('viewed..!');
        // this.setState({
        //     isHeroActive: false
        // })
    }
    handleSubmit(event){ 
      event.preventDefault();
      if(this.name.value == "" || this.email.value == "" || this.company.value == "" || this.mobile.value == "" || this.city.value =="" || this.customer_type == "")
      {
        this.setState({error: 'Please enter all fields'});
        return false;
      }
      this.setState({
        button: 'Loading...'
      })

    axios.get('../get_eliteResponse2.php?&cust_name2='+this.name.value+'&email2='+this.email.value+'&company_name2='+this.company.value+'&mobile2='+this.mobile.value+'&page=0&city2='+this.city.value+'&customer_type2='+this.customer_type.value+'&form=2').then(response => {
        console.log(response);
        return response
    })

      this.name.value == "";
      this.email.value == "";
      this.company.value == "";
      this.mobile.value == "";
      this.city.value =="";
      this.customer_type == "";
      this.setState({error: '',button: 'Our team will contact you shortly'});
     };

    close(){
        this.setState({open: false});
    }
    open(){
        this.setState({open: true});  
    }

    active(){
        return this.state.open == true ? 'show':'';
    }

    render(){
        return(
            <div>
                <div className="section title-section" ref={(section) => { this.view = section; }}>
                <div className={"container" + (this.state.isHeroActive ? " fade-in" : " fade-out")}>
                    <div className="contents">
                        <h1 className="section-title">eProcurement Solution for Businesses</h1>
                        <p className="section-lead">The place where buying office supplies and meeting organisational goals unite.</p>
                    </div>
                    <div className="background">
                        <Hero />
                    </div>
                    <div className="btn-container"><a className="btn" onClick={this.open.bind(this)}>Request a Demo</a></div>
                    <div className={this.state.open == true ? "modal show":"modal"}>
                        <div className="modal-body">
                        <form > 
                        <div className="close-container">
                            <span className="close" onClick={this.close.bind(this)}>x</span>
                        </div>
                            <h1>Request Demo</h1>
                            <input type="text" ref={(node) => {this.name = node}} placeholder="Name *" /> 
                            <input type="email" ref={(node) => {this.email = node}} placeholder="Email ID *" /> 
                            <input type="text" ref={(node) => {this.company = node}} placeholder="Company Name *"/>
                            <input type="text" ref={(node) => {this.mobile = node}} placeholder="Phone / Mobile Number *"/>
                            <input type="hidden" ref={(node) => {this.page = node}} value="0"/> 
                            <select ref={(node) => {this.city = node}} id="city2" name="city2">
                                <option value="">Select City *</option>
                                <option value="1">Chennai</option>
                                <option value="2">Mumbai</option>
                                <option value="3">Hyderabad</option>
                                <option value="4">Bengaluru</option>
                                <option value="5">Delhi</option>
                                <option value="6">Others</option> 
                            </select> 
                            <select ref={(node) => {this.customer_type = node}} id="customer_type2" name="customer_type2">
                                <option value="">I'm a *</option>
                                <option value="Reseller">Reseller</option>
                                <option value="Corporate Admin">Corporate Admin</option>
                                <option value="SME">SME</option>
                            </select> 
                            <p className="error">{this.state.error}</p>
                            <button onClick={this.handleSubmit.bind(this)} type="submit" name="submit_elite_lead2" id="submit_elite_lead2" > 
                                <span>{this.state.button}</span>
                            </button> 
                            
                        </form>
                        </div>
                    </div>
                </div>
            </div>
                <div className="section strategic-section" ref={(section) => { this.view = section; }}>
                    <div className={"container" + (this.state.isHeroActive ? " fade-in" : " fade-out")}>
                        <h1 className="section-title">With our <span>Millions of data points + Procurement transactions</span> processed over the years, SCHENKER gained valuable sourcing intelligence from us</h1>
                        <div className="row">
                            <div className="col-10">
                                <StrategicSourcing/>
                            </div>
                            <div className="col-5">
                                <p className="section-lead">Businesses prefer to make fact-based decisions to execute their procurement effectively. Indeed, our years of procurement data suggest that logistic companies consume a lot of copier paper. With this simple insight, Schenker was able to gain a competitive advantage in sourcing paper from us.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default HeroSection;
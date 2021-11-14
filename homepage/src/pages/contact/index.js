import React from 'react'
import axios from 'axios'
import Slider from "react-slick";
import './style.scss'

import loading from './loadingAnimation.gif'
import Face from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./tick.svg';
import Help from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./help.svg';
import Sales from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./sales.svg';
import Partner from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./partner.svg';
import Location from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./location2.svg';

class index extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            error: "",
            loc: "",
            form_state: false,
            loading: false,
        }
    }

    handleSubmit(event){ 
        event.preventDefault();
        this.setState({
            loading: true,
        })
        if(this.name.value === "" || this.email.value === "" || this.company.value === "" || this.mobile.value === "" || this.city.value ==="" || this.customer_type.value === "")
        {
            this.setState({error: 'Please enter all fields', loading: false});
            return false;
        }

        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(this.email.value === "" && re.test(String(this.email.value).toLowerCase())){
            this.setState({error: 'Please check your email-id', loading: false});
            return false;
        }

        var regmm='^([0|+[0-9]{1,5})?([7-9][0-9]{9})$';
        var regmob = new RegExp(regmm);
        
        if(this.mobile.value === "" || !regmob.test(this.mobile.value)) {
            this.setState({error: 'Please check your mobile number', loading: false});
            return false;
        }

        axios.get('../../get_eliteResponse2.php?&cust_name2='+this.name.value+'&email2='+this.email.value+'&company_name2='+this.company.value+'&mobile2='+this.mobile.value+'&page=0&city2='+this.city.value+'&customer_type2='+this.customer_type.value+'&form=2').then(response => {
            console.log(response);
            if(response['data'] === "success"){
                this.setState({form_state: true, loading: false})
            }
            return response
        })

        this.name.value = "";
        this.email.value = "";
        this.company.value = "";
        this.mobile.value = "";
        this.city.value ="";
        this.customer_type = "";
        this.setState({error: '',button: 'Our team will contact you shortly'});
    }

    updateSVG(e){
        if(e===1){
            this.setState({loc: "bng"});
        }
        if(e===2){
            this.setState({loc: "mum"});
        }
        if(e===3){
            this.setState({loc: "ncr"});
        }
        if(e===4){
            this.setState({loc: "hyd"})
        }
        if(e===0){
            this.setState({loc: "chn"})
        }
    }
    loc(){
        return this.state.loc + " location"
    }
    render(){
        const settings = {
          dots: false,
          infinite: true,
          speed: 500,
          autoplay: true,
          autoplaySpeed: 3000,
          slidesToShow: 3,
          slidesToScroll: 1,
          arrows: false,
          centerMode: true,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        };
        return(
        	<div className="contact">
                <div className="fluid-wrapper">
                    <div className="section-wrapper">
                        <h1 className="title">We'd love to hear from you</h1>
                        <p className="lead">Send us a message and we'll respond you within 90 seconds</p>
                    </div>
                    <div className="section-wrapper support-section">
                        <div className="wrapper-content">
                            <div className="img">
                                <div className="img-wrapper">
                                    <Help className="face" />
                                </div>
                            </div>
                            <h1 className="name">Help & Support</h1>
                            <p className="details">For general questions and help in using our website mail us at support@kobster.com or call us at 1800-121-0405 (Toll Free) or simply chat with us.</p>
                        </div>
                        <div className="wrapper-content">
                            <div className="img">
                                <div className="img-wrapper">
                                    <Sales className="face" />
                                </div>
                            </div>
                            <h1 className="name">Sales</h1>
                            <p className="details">For personal presentation by our wonderful Sales Team about the advantages of being our beloved customer mail us at support@kobster.com or call us at 1800-121-0405 (Toll Free) or simply chat with us.</p>
                        </div>
                        <div className="wrapper-content">
                            <div className="img">
                                <div className="img-wrapper">
                                    <Partner className="face" />
                                </div>
                            </div>
                            <h1 className="name">Partner With US</h1>
                            <p className="details">If you are a manufacturer, retailer or an importer and would like to Sell with us register here or mail us at support@kobster.com or call us at 1800-121-0405 (Toll Free) or simply chat with us.</p>
                        </div>
                    </div>
                </div>
                <div className="section-wrapper">
                    <div className={this.state.form_state ===false ? "form-section":"form-section success"}>
                    {this.state.form_state ===false ?
                        <form id="contact_form">
                            <div className="inp-wrapper">
                                <h1 className="title">Get in touch</h1>
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" ref={(node) => {this.name = node}} placeholder="Name *" required/> 
                            </div>
                            <div className="inp-wrapper">
                                <input type="email" ref={(node) => {this.email = node}} placeholder="Email ID *" required/> 
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" ref={(node) => {this.company = node}} placeholder="Company Name *" required/>
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" ref={(node) => {this.mobile = node}} placeholder="Phone / Mobile Number *" required/>
                            </div>
                            <div className="inp-wrapper">
                                <input type="hidden" ref={(node) => {this.page = node}} value="0"/> 
                            </div>
                            <div className="inp-wrapper">
                                <select ref={(node) => {this.city = node}} id="city2" name="city2" required>
                                    <option value="">Select City *</option>
                                    <option value="1">Chennai</option>
                                    <option value="2">Mumbai</option>
                                    <option value="3">Hyderabad</option>
                                    <option value="4">Bengaluru</option>
                                    <option value="5">Delhi</option>
                                    <option value="6">Others</option> 
                                </select> 
                            </div>
                            <div className="inp-wrapper">
                                <select ref={(node) => {this.customer_type = node}} id="customer_type2" name="customer_type2" required>
                                    <option value="">I'm a *</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Corporate Admin">Corporate Admin</option>
                                    <option value="SME">SME</option>
                                </select> 
                            </div>
                            <div className="inp-wrapper">
                                <p className="error">{this.state.error}</p>
                            </div>
                            <div className="inp-wrapper">
                                {this.state.loading === true ? <img id="submit_loading" src={loading} width="208" height="13" alt="Loading" />: null}
                                <button type="submit" id="submit_elite_lead2" onClick={this.handleSubmit.bind(this)} >Submit</button> 
                            </div>                            
                        </form>
                        :
                        <div className="thank-you scale-in-center">
                            <Face />
                            <h1>Thank you</h1>
                            <p>We value our relations, our experts will contact you shortly, for more queries please contact us on <span>1800-121-0405</span></p>
                        </div>
                    }
                    </div>
                </div>
                <div className="section-wrapper">
                    <h1 className="title">Our service locations</h1>
                    <div className="address-wrapper">
                        <Slider {...settings} afterChange={this.updateSVG.bind(this)}>
                        <div className="address">
                            <div className="address-content">
                            <p>CHENNAI </p>
                            <p>51-B, Mount Poonamallee Main Road,St. Thomas Mount,(End of Kathipara Flyover - Towards Porur)</p>
                            <p>Chennai – 600016.</p>
                            </div>
                        </div>
                        <div className="address">
                            <div className="address-content">
                            <p>BENGALURU </p>
                            <p>64/2, 6th cross, 3rd main road,Near IdgahMaidan, Chamrajpet,</p>
                            <p>Bengaluru-560018.</p>
                            </div>
                        </div>
                        <div className="address">
                            <div className="address-content">
                            <p>MUMBAI </p>
                            <p>48/52, Parshwakutir CHS, PerinNariman Street, Opp. to ICICI ATM, Bazar Gate, Fort,</p>
                            <p>Mumbai-400059.</p>
                            </div>
                        </div>
                        <div className="address">
                            <div className="address-content">
                            <p>NCR & GURGAON </p>
                            <p>No:202, Second Floor, Municipal No:4832/24, Ansari Road,DaryaGanj</p>
                            <p>Delhi-110034.</p>
                            </div>
                        </div>
                        <div className="address">
                            <div className="address-content">
                            <p>Hyderabad </p>
                            <p>No:5-2-434, Ground Floor, Risala Abdullah, MouzzamJahi Market,Hyderabad,</p>
                            <p>Telangana - 500 012</p>
                            </div>
                        </div>
                        </Slider>
                    </div>
                </div>
                <div className="location-wrapper">
                    <div className={this.loc()}>
                        <Location />
                    </div>
                </div>
            </div>
        )
    }
}

export default index;
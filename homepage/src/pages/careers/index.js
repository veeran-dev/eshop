import React from 'react'
import axios from 'axios'
import './style.scss'
import loading from './loadingAnimation.gif'
import Hero from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./Careers-kobster-new-two.svg';

class index extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            form_state: false,
            loading: false,
            error: "",
            fullname: "",
            jobs: [],
        }
    }
    componentWillMount(){
        return axios.post('../../get_careerResponse.php?jobs=1').then(response => {
            console.log(response.data);
            this.setState({jobs: response.data}, function(){console.log(this.state.jobs)});
          return response
        })
    }
    handleSubmit(event){ 
        event.preventDefault();
        console.log("step 1");
        this.setState({loading: true})    

        if(this.fullname.value === "")
        {
            this.setState({error: 'Please enter name', loading: false});
            return false;
        }
        else if(this.email.value === "" )
        {
            this.setState({error: 'Please enter email', loading: false});
            return false;
        }
        else if(this.mobile.value === "" )
        {
            this.setState({error: 'Please enter mobile number', loading: false});
            return false;
        }
        else if(this.department.value === "")
        {
            this.setState({error: 'Please select department', loading: false});
            return false;
        }
        else if(this.resume.value === "")
        {
            this.setState({error: 'Please select resume', loading: false});
            return false;
        }
        else {
            this.setState({error: '', loading: true});
        }
        console.log("step 2");
        var data = new FormData();
        var fileInput = document.getElementById(this.resume.id);
        var file = fileInput.files[0];

        data.append("file", file)
        data.append("fullname", this.fullname.value);
        data.append("email", this.email.value);
        data.append("mobile", this.mobile.value);
        data.append("department", this.department.value);
        data.append("linkedin", this.linkedin.value);
        data.append("website", this.website.value);
        data.append("message", this.message.value);
        console.log("reached");
        this.setState({fullname: this.fullname.value});
        return axios.post('../../get_careerResponse.php?', data).then(response => {
            console.log(response);
            this.setState({form_state: true, error: ""})
          return response
        })
    }
    render(){
        return(
        	<div className="careers">
                <div className="hero-wrapper">
                    <div className="hero-title">
                        <h1 >Join the best minds and work on the hardest problems</h1>
                        <a href="#goto_form" className="button">Apply for jobs</a>
                    </div>
                    <div className="hero-image">
                        <Hero />
                    </div>
                </div>
                <div className={this.state.jobs.length > 0 ? "section-wrapper":""}>
                    {this.state.jobs.length > 0?
                    <p className="lead">Current Openings</p>:null}
                    {this.state.jobs.length > 0 ?
                    this.state.jobs.map(function(job){
                    return <div className="jobs">
                        <div className="jobs-container">
                            <div className="jobs-title">
                                <div className="left">
                                    <div>{job.title}</div>
                                    <div>{job.city}</div>
                                </div>
                            </div>
                            <div className="job_description">
                                <p>{job.description}</p>
                            </div>
                        </div>
                    </div>}):null}
                </div>
                  <section className="career-form section-wrapper" id="goto_form">
                    <div className={this.state.form_state ===false ? "form-section":"form-section success"}>
                      {this.state.form_state ===false ?
                        <form className="career-form" id="career_form" method="post" enctype="multipart/form-data" >
                            <div className="inp-wrapper">
                                <h2 className="title">Fill in your application</h2>
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" ref={(node) => {this.fullname = node}} className="form-control" id="fullname" name="fullname" placeholder="Full Name *" required />
                            </div>
                            <div className="inp-wrapper">
                                <input type="email" ref={(node) => {this.email = node}} className="form-control" id="email" name="email" placeholder="Email *" required />
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" ref={(node) => {this.mobile = node}} className="form-control" id="mobile" name="mobile" placeholder="Mobile *" required />
                            </div>
                            <div className="inp-wrapper">
                                <select className="form-control" ref={(node) => {this.department = node}} id="department" name="department" required>
                                    <option value="">Choose Department</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Supply Chain">Supply Chain</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Finance & Accounts">Finance & Accounts</option>
                                    <option value="Customer Relationship Manager">Customer Relationship Manager</option>
                                    <option value="Category">Category</option>
                                    <option value="Sales & Marketing">Sales & Marketing</option>
                                </select>
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" className="form-control" ref={(node) => {this.linkedin = node}} id="linkedin" name="linkedin" placeholder="LinkedIn Profile URL (optional)" />
                            </div>
                            <div className="inp-wrapper">
                                <input type="text" className="form-control" ref={(node) => {this.website = node}} id="website" name="website" placeholder="Portfolio/Website (optional)" />
                            </div>
                            <div className="inp-wrapper">
                                <textarea className="form-control" rows="2"  ref={(node) => {this.message = node}} name="message" id="message" placeholder="Tell us anything you want us to know about you (optional)"></textarea>
                            </div>
                            <div className="inp-wrapper upload">
                                <p><strong>Upload Resume</strong> (We accept: PDF, DOC, DOCX, JPG &amp; PNG)</p>
                                <input type="file" id="resume" ref={(node) => {this.resume = node}} name="resume" accept=".pdf,.doc,.docx,.jpg,.png" required />
                                {this.state.loading === true ? <img id="submit_loading" src={loading} width="208" height="13" alt="Loading" />: null}
                            </div>
                            <div className="inp-wrapper">
                                <p className="error">{this.state.error}</p>
                            </div>
                            <div className="inp-wrapper">
                                <button type="submit" id="career_submit" onClick={this.handleSubmit.bind(this)} >Join us</button>
                            </div>                          
                        </form>
                        :
                        <div className="success-section">
                            <div>Hi {this.state.fullname},</div>
                            <p>Thanks for applying to Kobster. We appreciate your interest. Stay tuned for further updates.</p>
                            <p>In the mean time, you can read our blogs at <a href="www.kobster.in/blogs">www.kobster.in/blogs</a> or check us out on social media with the links below.</p>
                        </div>
                      }
                  </div>
                </section>
            </div>
        )
    }
}

export default index;
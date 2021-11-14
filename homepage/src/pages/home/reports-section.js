import React from 'react'
import Waypoint from 'react-waypoint'
import { Radar } from 'react-chartjs'
import './reports-section.scss'


class ReportsSection extends React.Component{
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
        console.log(this.state.sectionOneEnter);
        this.setState({
            sectionOneEnter: true
        })
    }
    _handleWaypointLeave(){
        console.log('viewed..!');
        this.setState({
            sectionOneEnter: false
        })
    }
    data2() {
        return {
          labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
          datasets: [
              {
                  label: "My First dataset",
                  fillColor: "rgba(220,220,220,0.2)",
                  strokeColor: "rgba(220,220,220,1)",
                  pointColor: "rgba(220,220,220,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data: rand(32, 100, 7)
              },
              {
                  label: "My Second dataset",
                  fillColor: "rgba(151,187,205,0.2)",
                  strokeColor: "rgba(151,187,205,1)",
                  pointColor: "rgba(151,187,205,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(151,187,205,1)",
                  data: rand(32, 100, 7)
              }
          ]
        };
        this.setState({
            data: {}
        })
        console.log(this.sate.data2)
    }
    render(){
        return(
        <Waypoint onEnter={this._handleWaypointEnter} onLeave={this._handleWaypointLeave}>
            <div className={"section reports-section" + (this.state.sectionOneEnter ? " fade-in" : " fade-out")}>
                <div className="container">
                    <h1 className="section-title">Maecenas nec odio et ante <span>Virtusa</span> tempus. Donec vitae sapien ut libero venenatis faucibus.</h1>
                    <div className="row">
                        <div className="col-5">
                            <p className="section-lead">Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.</p>
                            <a className="section-cta" href="https://www.kobster.com">LEARN MORE</a>
                        </div>
                        <div className="col-10">
                            {/* <img className="section-thumb" src={"../img.png"} alt="delivery-powers-of-kobster"/> */}
                            {/* <Radar data={chartData} options={chartOptions}/> */}
                        </div>
                    </div>
                </div>
            </div>
        </Waypoint>
        )
    }
}

export default ReportsSection;
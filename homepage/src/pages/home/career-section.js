import React from 'react'
import './career-section.scss'

class CareerSection extends React.Component{
    render(){
        return(
            <div className="section career-section">
                <div className="container">
                    <h1 className="section-title">Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus.</h1>
                    <p className="section-lead">Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.</p>
                    <a className="section-cta" href="https://www.kobster.com/careers.php">JOIN NOW</a>
                </div>
            </div>
        )
    }
}

export default CareerSection;
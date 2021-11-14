import React from 'react'
import './style.scss'
import Image from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./Linkedin.svg';
import faceA from './Karthik.png'
import faceB from './vineeth.jpg'
import faceC from './mohan_new.jpg'

import awardA from './FMW.png'
import awardB from './Insightsuccess.png'
import awardC from './siliconindia.png'
import awardD from './paypal.png'

class index extends React.Component{
    render(){
        return(
        	<div className="about">
        		<div className="section-wrapper">
        			<h1 className="title">About Us</h1>
        			<p className="lead">Back in 2010, corporate procurement in India had hardly seen the brilliance of Digitalization. Though other parts of the business were transforming rapidly, the procurement division was deeply rooted in the traditional method. The first crack was made by Kobster, building an e-procurement platform that makes purchasing office supplies as easy as shopping online. Since then, we have transformed procurement into a much more strategic function not to mention, introducing organisations to a new way of doing procurement; only to add more value!</p>
        		</div>
        		<div className="trio-section">
        			<div className="section-wrapper">
        				<h1 className="title">The Trio that gave us a head start</h1>
        				<p className="lead">It was a pure ambition that led the three-member team to transform the traditional B2B industry in India. Regardless of how much further shaping of the system was left to explore, they gave the industry such a fantastically good head start, with passion, with all the things that we admire about Kobster’s technology. Now with presence across the nation, we are a much bigger team, spread and stretched as Kobsterians.</p>
        			</div>
        			<div className="trio-wrapper section-wrapper">
        				<div className="wrapper-content">
        					<img alt="Karthik"className="face" src={faceA}/>
        					<h1 className="name">Karthik Ramaiah</h1>
        					<p>Co-Founder</p>
        					<div className="linkedin"><a href="www.linked.in"><Image/></a></div>
        					<p className="details">Karthik’s vision is to solve real-life problems with technology. He crafts innovative solutions to business problems which he demonstrated over various projects he did while studying at SRM University. Later he joined Cognizant Technologies as Team Lead & Programmer Analyst until he founded Kobster with Vineet and Mohan. He holds the keys to the innovation at Kobster, bringing ideas to reality with technology. Besides this, he also handles the finance vertical.</p>
        				</div>
        				<div className="wrapper-content">
        					<img alt="Vineet"className="face" src={faceB}/>
        					<h1 className="name">Vineet Neeraj</h1>
        					<p>Co-Founder</p>
        					<div className="linkedin"><a href="www.linked.in"><Image/></a></div>
        					<p className="details">Vineet always dreamed of becoming a successful entrepreneur. His passion directed him towards starting up an Event Management venture while pursuing his bachelor’s degree at the SRM University, Chennai. Even though he worked as a Software Engineer at Cognizant Technologies, he chose to give it up to work as Sales Manager at ArrayShield. His passion once again directed him towards founding Kobster with Karthik and Mohan, where he works to promote growth through aggressive sales and marketing.</p>
        				</div>
        				<div className="wrapper-content">
        					<img alt="Mohan"className="face" src={faceC}/>
        					<h1 className="name">Mohan Gayam</h1>
        					<p>Co-Founder</p>
        					<div className="linkedin"><a href="www.linked.in"><Image/></a></div>
        					<p className="details">Mohan's unique dynamics in business comes from his family's trait of entrepreneurship. His has leadership and decision-making skills at his sleeve. After graduating from SRM University, he cofounded Kobster with Vineet and Karthik. He controls the Operations and Category departments to extend the arms of Kobster's delivery capability to pan India locations and aims to many more.</p>
        				</div>

        			</div>
        		</div>
        		<div className="award-section section-wrapper">
        			<div>
        				<h1 className="title">Awards and Recognition</h1>
        				<p className="lead">Learn more about our accomplishments in driving greater performance, diversity, and innovation.</p>
        			</div>
        			<div className="award-wrapper">
        				<div className="award-wrapper-section">
		    				<div className="award-wrapper-content">
		    					<img alt="Award"src={awardA}/>
		    					<p>Best Online Portal for Corporate Procurement-Future Workplace Challenges Conference & Awards – 2017</p>
		    				</div>
		    				<div className="award-wrapper-content">
		    					<img alt="Award"src={awardB}/>
		    					<p>Top 20 Fastest Growing Companies 2016 InsightSuccess</p>
		    				</div>
        				</div>
        				<div className="award-wrapper-section">
	        				<div className="award-wrapper-content">
	        					<img alt="Award"src={awardC}/>
	        					<p>50 Best Startups to Work For SiliconIndia 2016</p>
	        				</div>
	        				<div className="award-wrapper-content">
	        					<img alt="Award"src={awardD}/>
	        					<p>Certificate of Graduation - PayPal Start Tank 2015</p>
	        				</div>
        				</div>
        			</div>
        		</div>
        		<div className="section-wrapper">
        			<div>
        				<h1 className="title">Want to join our team?</h1>
        				<p className="lead">we are looking for passinoate perfectionists</p>
        				<div className="btn-container">
        					<a href="/home/careers">Join us</a>
    					</div>
        			</div>
        		</div>
        	</div>
        )
    }
}

export default index;
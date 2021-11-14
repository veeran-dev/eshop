import React from 'react'
import TitleSection from './title-section'
import HeroSection from './strategic-section'
import ProductRangeSection from './product-range-section'
import DeliverySection from './delivery-section'
import InspectionSection from './inspection-section'
import CustomerServiceSection from './customer-service-section'
import IntelligentFlow from './intelligent-section'
import ReportsSection from './report-section'
import Eprocurement from './e-procurement-section'
import Footer from './footer'
import Front from '-!babel-loader!svg-react-loader?name=StrategicSourcing!./svg/front.svg';
class home extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            play:0,
            hide: 0,
            direction: "",
            mobile: false,
        }
    }

    componentDidMount() {
        if (typeof window !== `undefined` && window.innerWidth > 767) {
            window.addEventListener('wheel', this.handleScroll.bind(this));
            window.addEventListener('touchmove', this.handleTouch.bind(this));
            window.addEventListener("keydown", this.handleKeyDown.bind(this));
        }
        if(typeof window !== undefined && window.innerWidth < 767){
            this.setState({mobile: true})
        }
    }

    componentWillUnmount() {
        if (typeof window !== `undefined` && window.innerWidth > 767) {
            window.removeEventListener('wheel', this.handleScroll.bind(this));
            window.removeEventListener('touchmove', this.handleTouch.bind(this));
            window.removeEventListener("keydown", this.handleKeyDown.bind(this));
        }
    }

    handleKeyDown(event){
        if(event.keyCode === 40 && this.state.play<10){
            this.changeSection(this.state.play+1, 'jumpup')
        }
        else if(event.keyCode === 38 && this.state.play>1){
            this.changeSection(this.state.play-1, 'jumpdown')
        }
    }

    handleTouch(event){
        var currentY = event.touches[0].screenY;
        if(this.lastY !== undefined){
            var delta = currentY - this.lastY;
            if(delta < 0 && this.state.play<10){
                this.changeSection(this.state.play+1, 'jumpup')
            }
            else if(delta > 0 && this.state.play>1){
                this.changeSection(this.state.play-1, 'jumpdown')
            }
        }
        else{
            this.lastY = currentY;
        }
    }
    handleScroll(event) {
        event.preventDefault();
        event.stopPropagation();
        if(event.deltaY===100 && this.state.play<10){
            this.changeSection(this.state.play+1, 'jumpup')
        }
        else if(event.deltaY===-100 && this.state.play>1){
            this.changeSection(this.state.play-1, 'jumpdown')
        }
    }
    mobileActions(x,e){
        if(x===1 && this.state.play<10){
            this.changeSection(this.state.play+1, 'jumpup')   
        }
        else if(x===2 && this.state.play>1){
            this.changeSection(this.state.play-1, 'jumpdown')   
        }
    }
    playScene(){
        switch(this.state.play) {
            case 1:
                return <TitleSection hide={this.state.hide===1?this.state.direction:""}/>;
            case 2:
                return <HeroSection hide={this.state.hide===2?this.state.direction:""}/>;
            case 3:
                return <ProductRangeSection hide={this.state.hide===3?this.state.direction:""}/>;
            case 4:
                return <DeliverySection hide={this.state.hide===4?this.state.direction:""}/>;
            case 5:
                return <InspectionSection hide={this.state.hide===5?this.state.direction:""}/>;
            case 6:
                return <CustomerServiceSection hide={this.state.hide===6?this.state.direction:""}/>;
            case 7:
                return <IntelligentFlow hide={this.state.hide===7?this.state.direction:""}/>;
            case 8:
                return <ReportsSection hide={this.state.hide===8?this.state.direction:""}/>;
            case 9:
                return <Eprocurement hide={this.state.hide===9?this.state.direction:""}/>;
            case 10:
                return <Footer hide={this.state.hide===10?this.state.direction:""}/>;
            default:
                return <TitleSection hide={this.state.hide===1?this.state.direction:""}/>;
          }
    }

    changeSection(play, direction){
        this.setState({hide:this.state.play, direction: direction},function(){
            setTimeout(
                function() {
                    this.setState({play: play});
                }
                .bind(this),
                600
            );
        })
    }
    mobileActionsUI(){

    }
    render(){
        return(
            <div>
                {this.state.mobile === true ?
                <div className="mobile_nav">
                    <div className="first" onClick={this.mobileActions.bind(this,2)}><Front /></div>
                    <div onClick={this.mobileActions.bind(this,1)}><Front /></div>
                </div>
                : null}
                <div className="showcase">
                    <div className={this.state.play ===1 ? "dot active":"dot"} onClick={this.changeSection.bind(this,1)}></div>
                    <div className={this.state.play ===2 ? "dot active":"dot"} onClick={this.changeSection.bind(this,2)}></div>
                    <div className={this.state.play ===3 ? "dot active":"dot"} onClick={this.changeSection.bind(this,3)}></div>
                    <div className={this.state.play ===4 ? "dot active":"dot"} onClick={this.changeSection.bind(this,4)}></div>
                    <div className={this.state.play ===5 ? "dot active":"dot"} onClick={this.changeSection.bind(this,5)}></div>
                    <div className={this.state.play ===6 ? "dot active":"dot"} onClick={this.changeSection.bind(this,6)}></div>
                    <div className={this.state.play ===7 ? "dot active":"dot"} onClick={this.changeSection.bind(this,7)}></div>
                    <div className={this.state.play ===8 ? "dot active":"dot"} onClick={this.changeSection.bind(this,8)}></div>
                    <div className={this.state.play ===9 ? "dot active":"dot"} onClick={this.changeSection.bind(this,9)}></div>
                    <div className={this.state.play ===10 ? "dot active":"dot"} onClick={this.changeSection.bind(this,10)}></div>
                </div>
                <div className="play_wrapper">
                   {this.playScene()}
                </div>
            </div>
            )
    }
}
export default home

import React from 'react';
import * as G from '../../../../api/common-api';
import { Scrollbars } from 'react-custom-scrollbars';

class ViewWidget extends React.Component {
	constructor(props){
		super(props);
		this.state = {
			description: false
		};
		this._handleClick = this._handleClick.bind(this);
	}

	_handleClick(event) {
		event.preventDefault();
    	this.setState({description: !this.state.description});
  	}
  	
	installWidget(idWidget, isPaid, active, position){
		G.installWidget(idWidget, isPaid, active, position);
	}

	uninstallWidget(idWidget){
		G.uninstallWidget(idWidget);
	}

	render(){
		const descriptionButton = this.state.description ? 'Read Less' : 'Read More';
		return (
			<Scrollbars autoHeight autoHeightMax={504} className="modal-wrapper">
	    		<div id={"widget_"+this.props.data.id_widget} className="widget-full-view">
					<div className="widget-header">
						<div className="widget-thumb widget-thumb-big">
							<img src={"dash/img/widgets/icons/"+this.props.data.id_widget+".svg"} alt={this.props.data.name}/>
						</div>
						<div className="widget-info">
							<h3 className="widget-title">{this.props.data.name}</h3>
							<p className="widget-short-description" dangerouslySetInnerHTML={{__html: this.props.data.description}}></p>
							<p>{this.props.data.price == "0.000000" ? <span className="free">Free</span> : <span className="price">{G.formatPrice(this.props.data.price)}</span>}</p>
							<div className="widget-actions">
								{this.props.data.is_new == 1 ? <button className="button-green button-small outline">Coming Soon</button> : this.props.data.installed ? <button className="button-black" onClick={this.uninstallWidget.bind(this, this.props.data.id_widget)}>Remove</button> : (this.props.data.price == "0.000000" ?
										<button className="button-black" onClick={this.installWidget.bind(this, this.props.data.id_widget, 0, 1, 0)}>Add Now</button> :
										<button className="button-black">Buy Now</button>)
								}
							</div>
						</div>
					</div>

					{ /* <div className="widget-screenshots">
						<a href="#"><i className="icon icon-left-arrow"></i></a>
						<img src="dash/img/widgets/screenshots/reports-widget.jpg" alt="screenshot"/>
						<a href="#"><i className="icon icon-left-arrow"></i></a>
					</div> */ }

					{ /* <div className="widget-detailed-description">
						<p className={"description "+ this.state.description}>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
						<a className="read-more" href="#" onClick={this._handleClick}>{descriptionButton}</a>
					</div> */ }
	    		</div>
			</Scrollbars>
	    );
	}
}

export default ViewWidget;
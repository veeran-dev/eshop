import React from 'react'
import ReactDOM from 'react-dom'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import store from '../../../../store/configureStore'
import * as G from '../../../../api/common-api'
import Ripples from 'react-ripples'
import PoOptionSet from './poOptionSet'

class Store extends React.Component {
	constructor(props){
		super(props)
	}

	componentDidMount(){
		G.getAllWidgets();
	}

	installWidget(idWidget, isPaid, active, position){
		if(idWidget == 17 && role != '1') {
			ReactDOM.render(<PoOptionSet route={this.context.router} idWidget={idWidget} />, document.getElementById('setPoOptionContent'));
			G.displayModal('setPoOption');
		}
		else {
			G.installWidget(idWidget, isPaid, active, position);
		}
	}

	uninstallWidget(idWidget){
		G.uninstallWidget(idWidget);
	}

	goConfigurationPage(idWidget) {
		if(idWidget == 17) // Budget control configuration
			this.context.router.push("budget-configuration");
	}

	render(){
		return (
		    <div className="store">
			<div className="page-header">
				<button className="back" onClick={this.context.router.goBack.bind(this)}>
					<i className="icon-back-arrow"></i>
				</button>
				<h3 className="page-title">Widget Store</h3>
				<div className="action-block">
					{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
				</div>
			</div>
			<div className="store-container">
			    {this.props.widgets.map((data, i) => {
			    	return (
			    		<div key={i} id={"widget_"+data.id_widget} className="widget widget-small">
			    			<a href="javascript:void(0)" onClick={G.viewWidget.bind(this, data)}>
				    			<div className="widget-thumb">
									<img src={"dash/img/widgets/icons/"+data.id_widget+".svg"} alt={data.name}/>
								</div>
							</a>
							<div className="widget-info">
								<a href="javascript:void(0)" onClick={G.viewWidget.bind(this, data)}>
									<h3>{data.name}</h3>
									<p className="widget-short-description" dangerouslySetInnerHTML={{__html: data.description}}></p>
								</a>
								<p>{data.price == "0.000000" ? <span className="free">Free</span> : <span className="price">{G.formatPrice(data.price)}</span>}</p>
								<div className="widget-actions">
									{ /* data.configure == 1 && data.installed ? <button className="button-green button-small outline" onClick={this.goConfigurationPage.bind(this, data.id_widget)}>Configure</button> : null */}
									{
										(() => {
											if(data.new == 1)
												return <button className="button-green button-small outline">Coming Soon</button>
											else if(data.installed)
												return <button className="button-green button-small outline" onClick={this.uninstallWidget.bind(this, data.id_widget)}>Remove</button>
											else if(data.price == "0.000000")
												return <button className="button-green button-small" onClick={this.installWidget.bind(this, data.id_widget, 0, 1, 0)}>Add Now</button>
											else
												return <button className="button-green button-small">Buy Now</button>
										})()
									}
								</div>
							</div>
			    		</div>
			    	)
			    })}
			</div>
		    </div>
	    )
	}
}

Store.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	widgets: store.commonState.widgets
  };
};

export default connect(mapStateToProps)(Store);
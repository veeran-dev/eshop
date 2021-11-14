import React from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import { Link } from 'react-router';
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import ViewWidget from '../../../components/views/widgets/store/ViewWidget'

class WidgetNotInstalled extends React.Component {
    constructor(props){
        super(props)
    }

    componentDidMount() {
        G.getWidgetById(this.props.idWidget)
    }

    componentWillReceiveProps(newProps) {
        if(this.props.idWidget != newProps.idWidget) {
            G.getWidgetById(newProps.idWidget)
        }
    }

    viewWidget() {
        ReactDOM.render(<ViewWidget data={this.props.uniqueWidget} />, document.getElementById("viewWidgetContent"));
        G.displayModal("viewWidget")
    }

    render() {
        return (
            <div className="empty-state-container">
                <div className="empty-state">
                    <div className="empty-state-thumb not-installed"></div>
                    <h1>Looks like you have not installed this widget yet!</h1>
                    <p>Fortunately, it's very easy to install one</p>
                    <a href="javascript:void(0)" onClick={this.viewWidget.bind(this)}>Add Widget</a>
                </div>
            </div>
        );
    }
}

const mapStateToProps = function(store) {
  return {
    uniqueWidget: store.commonState.uniqueWidget[0]
  };
};

export default connect(mapStateToProps)(WidgetNotInstalled);
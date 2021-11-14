import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../store/configureStore';
import * as G from '../../api/common-api';
import Ripples from 'react-ripples'
import moment from 'moment'

class Notifications extends React.Component {
  constructor(props){
    super(props)
  }

  componentDidMount(){
    G.getNotifications(2)
  }

  handleClick(url, id_notification){
    G.readNotification(id_notification)
    this.context.router.push(url)
  }

  render() {
    return (
      <div className="notifications">
        <div className="page-header">
          <button className="back" onClick={this.context.router.goBack.bind(this)}>
					  <i className="icon-back-arrow"></i>
				  </button>
					<h3 className="page-title">Notifications</h3>
					<div className="action-block">
            {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
          </div>
				</div>
        <div className="page-container">
          {this.props.notifications.map((notification, i) => {
            return (
              <div key={i} className={notification.status == 1 ? "notification-item" : "notification-item unread"}>
                <a className="notification-link" href="javascript:void(0)" onClick={this.handleClick.bind(this, notification.url, notification.id_notification)}>
                <div>
                  <i className="icon-info"></i>
                </div>
                <div>
                    <div className="notification-message">{notification.content}</div>
                    <div className="notification-date"><i className="icon-schedule"></i> {moment(notification.date_add).format('LL')}</div>
                </div>
                </a>

              </div>
            )
          })}
        </div>
      </div>
    )
  }
}

Notifications.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    notifications: store.commonState.pageNotifications
  };
};

export default connect(mapStateToProps)(Notifications);
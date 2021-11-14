import React from 'react';
import { connect } from 'react-redux';
import Ripples from 'react-ripples';
import {toastr} from 'react-redux-toastr';
import store from '../../../store/configureStore';
import { openRequestQuote } from '../../../api/common-api';
import * as settingsApi from '../../../api/settings-api';
import * as addressApi from '../../../api/address-api';
import { getAddress, deleteAddress } from '../../../api/common-api'
//import {Cropper} from 'react-image-cropper'

// Using "Stateless Functional Components"
class SettingsProfile extends React.Component {
  constructor(props){
  	super(props)
  }

  upload() {
  	settingsApi.uploadProfilePicture();
  }

  updatePassword(){
  	if(this.refs.cpwd.value == "") {
  		toastr.error("Error", "Please provide your old password.", {icon: "icon-error"})
  	}
  	else if(this.refs.newpwd.value == "") {
  		toastr.error("Error", "Please provide your new password.", {icon: "icon-error"})
  	}
  	else if(this.refs.confpwd.value == "") {
  		toastr.error("Error", "Please confirm your new password.", {icon: "icon-error"})
  	}
  	else if(this.refs.newpwd.value != this.refs.confpwd.value) {
  		toastr.error("Error","New passwords not matching.", {icon: "icon-error"});
  	}
  	else if(this.refs.newpwd.value != "" && this.refs.confpwd.value != "" && this.refs.cpwd.value != "") {
  		const { cpwd, newpwd } = this.refs
  		settingsApi.updatePassword(cpwd, newpwd);
  	}
  }

  render() {
  	return (
		<div className="settings">
			<div className="settings-container">
				<div className="column-wrapper">
					<div className="column">
					<div className="column-content-container">
							<h3 className="setting-title">Account Profile Picture</h3>
							<div className="new-logo">
								<div className="customer-logo">
									<img id="current-logo" src={this.props.logo != "" ? baseDir+this.props.logo : baseDir+'dash/img/logo/default-customer-logo.jpg'} alt="Customer Logo" />
								</div>

								<div className="upload-button-wrapper">
									<form id="upload-profile-picture" method="post" encType="multipart/form-data">
										<input type="file" name="po-file" id="upload-profile-picture-input"/>
									</form>
									<button className="button-blue" onClick={this.upload.bind(this)}>Change Profile Picture</button>

									<div className="info">
										<p>Must be your company's logo within 500 KB</p>
										<p>Allowed Formats: <span>.jpg</span>, <span>.png</span> or <span>.svg</span></p>
										<p>Recommended Size: <span>84px</span> x <span>84px</span></p>
									</div>
								</div>
							</div>
						</div>
					</div>

          			<div className="column">
						<div className="column-content-container">
								<h3 className="setting-title">Change password</h3>
								<div className="form-control">
									<span>Old Password:</span> <input className="" type="password" name="cpwd" ref="cpwd"/>
								</div>

								<div className="form-control">
									<span>New Password:</span>
									<input type="password" name="newpwd" ref="newpwd"/>
								</div>

								<div className="form-control">
									<span>Confirm New Password:</span>
									<input type="password" name="confpwd" ref="confpwd"/>
								</div>
								<div className="form-control">
									<button className="button-blue outline" onClick={this.updatePassword.bind(this)}>Save</button>
								</div>
								
						</div>
          </div>
				</div>
			</div>
		</div>
	);
  }
}

const mapStateToProps = function(store) {
  return {
  	logo: store.settingsState.customerLogo
  };
};

export default connect(mapStateToProps)(SettingsProfile);

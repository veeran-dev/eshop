import React from 'react';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import * as settingsApi from '../../../api/settings-api';

class SettingsProfile extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount(){
  	settingsApi.getCustomerLogo();
  	settingsApi.getDrDetails();
  }

  upload() {
  	settingsApi.updateCustomerLogo();
  }
  updateDrDetails(){
  	settingsApi.updateDrDetails(this.dr_prefix.value, this.dr_number.value );	
  }

  componentWillReceiveProps(nextProps){
  	if(this.props.prefix && this.props.number){
	  	this.dr_prefix.value = this.props.prefix;
	  	this.dr_number.value = this.props.number;
	  }
  	if(nextProps.number != this.props.number){
  		this.dr_number.value = nextProps.number;
  	}
  	if(nextProps.prefix != this.props.prefix){
  		this.dr_prefix.value = nextProps.prefix;
  	}
  }
  render() {
  	return (
		<>
			{this.props.isFetching == true ? <div className="loader"><div className="spinner"></div></div> : null}
			<div className="page-header">
			    <h3 className="page-title">Settings</h3>
			</div>
			<div className="page-container">
				<div className="column-wrapper">
					<div className="column">
					<div className="column-content-container">
							<h3 className="setting-title">Account Profile Picture</h3>
							<div className="new-logo">
								<div className="customer-logo">
									<img id="current-logo" src={this.props.logo != undefined && this.props.logo != "" ? this.props.logo : './src/assets/img/logo/default-customer-logo.jpg'} alt="Customer Logo" />
								</div>

								<div className="upload-button-wrapper">
									<form id="upload-profile-picture" method="post" encType="multipart/form-data">
										<input type="file" name="profile-file" id="upload-supplier-profile-picture-input"/>
									</form>
									<button className="button-blue" onClick={this.upload.bind(this)}>Change Profile Picture</button>

									<div className="info">
										<p>Must be your company's logo within 500 KB</p>
										<p>Allowed Formats: <span>.jpg</span> <span>.png</span></p>
										<p>Recommended Size: <span>84px</span> x <span>84px</span></p>
									</div>
								</div>
							</div>
						</div>
					</div>

          			<div className="column">
						<div className="column-content-container">
								<h3 className="setting-title">Delivery Receipt</h3>
								<div className="form-control">
									<span>DR Prefix:</span> 
									<input className="prefix" maxlength="3" type="text" name="dr_prefix" 
											ref={(node) => {this.dr_prefix = node}} 
											defaultValue={this.props.prefix != undefined ? this.props.prefix:""}/>
								</div>

								<div className="form-control">
									<span>DR Number:</span>
									<input type="number" name="dr_number" maxlength="6" 
											oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
											ref={(node) => {this.dr_number = node}} 
											defaultValue={this.props.number != undefined ? this.props.number:""}/>
								</div>
								<div className="form-control">
									<button className="button-blue outline" onClick={this.updateDrDetails.bind(this)}>Save</button>
								</div>								
						</div>
					</div>
				</div>
			</div>
		</>
	);
  }
}

const mapStateToProps = function({settingState}) {
  return {
  	logo: settingState.logo,
  	dr: settingState.drDetails,
  	number: settingState.number,
  	prefix: settingState.prefix,
  	isFetching: settingState.isFetching,
  };
};

export default connect(mapStateToProps)(SettingsProfile);

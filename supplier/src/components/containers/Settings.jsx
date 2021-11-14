import React, { Component } from 'react';
import { Route} from "react-router-dom";
import Profile from '.././modules/Settings/SettingsProfile'

const Settings = ({ match }) => (
  <div className="settings-container">
    <Route exact path={match.url} component={Profile} />
  </div>
)

export default Settings;
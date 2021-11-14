import React from 'react';
import { Link } from 'react-router';

class WidgetNoAccess extends React.Component {
        constructor(props){
        super(props)
    }

    render() {
        return (
            <div className="empty-state-container">
                <div className="empty-state">
                    <div className="empty-state-thumb no-access"></div>
                    <h1>Sorry, you don't have access to use this widget!</h1>
                    <p>Contact your Relationship Manager for more info.</p>
                    <Link className="" to="dashboard">Back to Home</Link>
                </div>
            </div>
        );
    }
}

export default WidgetNoAccess;
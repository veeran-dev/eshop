import React, {PropTypes, Component} from 'react';

export default class Marker extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    const MARKER_SIZE = 20;
    const markerStyle = {
      color:'#ea6153',
      position: 'absolute',
      width: MARKER_SIZE,
      height: MARKER_SIZE,
      left: -MARKER_SIZE / 2,
      top: -MARKER_SIZE / 2,
      cursor: 'pointer',
      fontSize: "20px"
    }

    return (
      <div>
        <div className="tooltip">
          <i style={markerStyle} className={this.props.icon} onClick={this.props.onClick}></i>
          <span className="tooltiptext">
            <table>
              <tbody>
                <tr>
                  <td>Total Spent</td>
                  <td><b>₹ {this.props.data.y}</b></td>
                </tr>
                <tr>
                  <td>City</td>
                  <td><b>{this.props.data.city}</b></td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td><b>{this.props.data.address_line}</b></td>
                </tr>
              </tbody>
            </table>
          </span>
        </div>
      </div>
    );
  }
}

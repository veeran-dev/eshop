import React from  'react';
import { Scrollbars } from 'react-custom-scrollbars';

class ControlledScrollbar extends React.Component {
  constructor(props) {
    super(props);
    this.handleWindowWheel = this.handleWindowWheel.bind(this);
  }

  componentDidMount() {
    window.addEventListener("mousewheel", this.handleWindowWheel, false);
  }

  componentWillUnmount() {
    window.removeEventListener("mousewheel", this.handleWindowWheel);
  }

  handleWindowWheel(event) {
    const { top } = this.refs.scrollbars.getValues();
    if (top >= 1 && event.deltaY > 0) event.preventDefault();
  }

  render() {
    return (
        <Scrollbars ref="scrollbars" autoHeight autoHeightMin={0} autoHeightMax={224}>
          {this.props.itemsContainer}
        </Scrollbars>
    );
  }

}

export default ControlledScrollbar;
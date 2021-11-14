import React from 'react';
import ReactDOM from 'react-dom';

class ShopSaleStatus extends React.Component {
  constructor(props){
    super(props)
  }

  closePop() {
    var modal = document.getElementById('shopSaleStatus');
    modal.style.display = 'none';
    localStorage.setItem('shopSaleStatus', 1);
  }

  render() {
    return(
    	<div className="modal" id="shopSaleStatus">
    	  <div className="modal-dialog animated">
            <div className="modal-content">
              <div className="modal-header">
                <h4 className="modal-title">Important Message!</h4>
                <button type="button" className="close" onClick={this.closePop.bind(this)}><i className="icon-close"></i></button>
              </div>
              <div className="modal-body">
			          <div className="modal-message">
                  <p className="gst-alert">Due to GST implementations there won't be any sales from <br /> <span>28<sup>th</sup> June</span> to <span>5<sup>th</sup> July</span></p>
                </div>
              </div>
            </div>
          </div>
	    </div>
    )
  }
}

export default ShopSaleStatus;
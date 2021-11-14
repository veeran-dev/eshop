import React from 'react'
import { Scrollbars } from 'react-custom-scrollbars'

class Modal extends React.Component {
	constructor(props){
		super(props)
	}

	closeModal(elementID){
	    document.body.className = document.body.className.replace('modal-open',"");
	    var modal = document.getElementById(elementID);
	    modal.style.display = 'none';
	}

  outerControl(event){
    let elementObj = document.getElementById(event.target.id);
    if(elementObj != null && elementObj.style != null && elementObj.style.display == "flex" && elementObj.style.display == "-webkit-flex" && elementObj.getAttribute("tabindex") == -1)
      if(event.target == document.getElementById(event.target.id)){
        document.getElementById(event.target.id).style.display = "none"
        document.body.className = document.body.className.replace('modal-open',"");
      }
  }
  handleEscKey(event){
        console.log("escaped");
        if(event.keyCode == 27){
          document.body.className = document.body.className.replace('modal-open',"");
          var modal = document.getElementById(elementID);
          modal.style.display = 'none';
        }
   }

  componentDidMount(){
    window.addEventListener("click", this.outerControl.bind(this));
    window.addEventListener("onKeyDown", this.handleEscKey.bind(this));
  }

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
    window.removeEventListener("onKeyDown", this.handleEscKey.bind(this));
  }

	render(){
		return(
			<div className="modal" tabIndex="-1" id={this.props.id}>
          <div className={"modal-dialog " + this.props.modalSize + " animated zoomIn"}>
            <div className="modal-content">
              <div className="modal-header">
                <h4 className="modal-title">{this.props.title}</h4>
                <button type="button" className="close" onClick={this.closeModal.bind(this, this.props.id)}>
                  <i className="icon-close"></i>
                </button>
              </div>
              <div className="modal-body">
                  <div id={this.props.contentID}></div>
              </div>
              
            </div>
          </div>
      </div>
		)
	}
}

export default Modal
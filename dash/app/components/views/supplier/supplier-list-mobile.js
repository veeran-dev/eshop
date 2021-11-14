import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import store from '../../../store/configureStore'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ReactImageFallback from "react-image-fallback";

class SupplierListsDesktop extends React.Component {
  constructor(props) {
      super(props);

      this.state = {
          hasMoreItems: true,
          page: 0,
          searchString: '',
          isMobile: false,
      };
  }

  componentDidMount() {
    window.addEventListener("click", this.outerControl.bind(this));
  }

  _handleKeyDown = (e) => {    
    if (e.key === 'Enter') {
        this.setState({searchString: e.target.value})
    }
  }

  outerControl(event){
    var allElem = document.getElementsByClassName('split-button-dropdown');
    for(var i=0; i < allElem.length; i++){
        let box = allElem[i]
        if(event.target != box && event.target.parentNode != box){
          if(box && box.style.display != undefined)
            if(!box.classList.contains("hidden") && !event.target.classList.contains("split-button-arrow"))
              box.className += " hidden"
        }
    }
  }

  _splitButton(e) {
    let allElem = document.getElementsByClassName('split-button-dropdown')
    if(e.target.nextSibling.classList.contains("hidden")){
      for(var i = 0; i < allElem.length; i++){
          allElem[i].classList.add("hidden")
          e.target.nextSibling.classList.remove("hidden")
      }
    }
    else{
      e.target.nextSibling.classList.add("hidden")
      for(var i = 0; i < allElem.length; i++)
          allElem[i].classList.add("hidden")
    }
  }

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
  }

  render() {
      let listSupplier = this.props.suppliers, searchString = this.state.searchString.trim().toLowerCase();
      
      if(searchString.length > 0){
          // We are searching. Filter the results.
          listSupplier = listSupplier.filter(function(l){
              return l.company.toLowerCase().match( searchString ) || 
                   l.reference.toLowerCase().match( searchString );
          });
      }

      return (
          <div className="page-container">
            {listSupplier != undefined && listSupplier.length > 0 ? listSupplier.map((supplier, i)=>{
              console.log(supplier)
                return (
                  <div className="supplier-box">
                    <div className="hero-content">
                      <ReactImageFallback
                        src={supplier.image?supplier.image:null}
                        fallbackImage="./img/p/en-default-large.jpg"
                        initialImage="./img/p/en-default-large.jpg"
                        alt={supplier.company}/>
                      <p><strong>{supplier.company}</strong></p>
                      <p>{supplier.reference}</p>
                    </div>
                    <div className="supplier-details">
                      <p>{supplier.email}</p>
                      <p>{supplier.mobile}</p>
                      <p>{supplier.address1}</p>
                      <p>{supplier.city}</p>
                      <p>{supplier.postcode}</p>
                      <p>{supplier.vat_number}</p>
                      <div className="split-button">
                        <div className={"split-button-default-action"}>
                          <button >Documents</button>
                          <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                          <ul className="split-button-dropdown hidden">
                            <li>
                              <a className="button button-blue outline" href='javascript:void(0)' >
                                  <i className="icon-download"></i> GST FILE
                              </a>
                            </li>
                            <li>
                              <a className="button button-blue outline" href='javascript:void(0)' >
                                  <i className="icon-download"></i> CIN FILE
                              </a>                                    
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                )
              })
              :
              <div>
                  <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Sorry you don't have any supplier yet.</p></div>
              </div>
            }
          </div>
      )
  }
}
export default SupplierListsDesktop
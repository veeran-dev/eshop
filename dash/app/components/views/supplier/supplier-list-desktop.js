import React from 'react'
import InfiniteScroll from 'react-infinite-scroller';
import { connect } from 'react-redux'
import store from '../../../store/configureStore'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

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

  // toSupplier =(id) =>{
  //       let old_url = window.location.href;
  //       var new_url = old_url.substring(0, old_url.indexOf("list"));
  //       var win = window.open(new_url+'details/'+id, '_blank');
  //       win.focus();
  // }

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
            <div className="table-filter"></div>
            <table>
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Supplier</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>
                    <input type="text" placeholder="Search supplier" 
                        onKeyDown={this._handleKeyDown.bind(this)} />
                  </th>
                </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                {this.props.isFetching ? <tr><td className="fetching" colSpan="5"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (listSupplier != undefined && listSupplier.length > 0 ? listSupplier.map((supplier, i)=>{
                    return (
                      <tr colSpan="5" key={supplier.id_supplier+"_id"} id={supplier.id_supplier+"_id"} className={supplier.id_supplier+"_class"} >
                          <td>{i+1}</td>
                          <td className="name">
                            <p><strong>{supplier.company}</strong></p>
                            <p>{supplier.reference}</p>
                          </td>
                          <td className="contact">
                            <p>{supplier.email}</p>
                            <p>{supplier.mobile}</p>
                          </td>
                          <td className="address">
                            <p>{supplier.address1}</p>
                            <p>{supplier.city}</p>
                            <p>{supplier.postcode}</p>
                            <p>{supplier.vat_number}</p>
                          </td>
                          <td data-title="Actions" className="text-align-right">
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
                          </td>
                      </tr>
                    );
                  }):
                  <tr className="no-results-wrapper"><td colSpan="7"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Quotations Found!</h2><p>Search products and find supplier to get quote</p></div></td></tr>
                )}
                </ReactCSSTransitionGroup>
            </table>
          </div>
      )
  }
}
export default SupplierListsDesktop
import React from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import * as inventoryApi from '../../../api/inventory-api';
import * as G from '../../../api/common-api';
import Select from 'react-select';
import ReactImageFallback from "react-image-fallback";
import ReactPaginate from 'react-paginate';
import MydateFilter from '../../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ConfirmationContent from '../../common/ConfirmationContent'
import ReportContent from '../../common/ReportContent'
import CreateInventory from '../../common/createInventory'
import UploadInventory from '../../common/uploadInventory'
// Using "Stateless Functional Components"
class InventoryLists extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      pageNumber: 0,
      offset:0,
      limit: 10,
      duration: 5,
      fromDate: "",
      toDate: "",
      orderBy: "koha.`date_add`",
      orderWay: "DESC",
      q: "",
      idPage: "",
      updatePagination: false,
      input: '',
    }
  }

  componentDidMount(){
    window.addEventListener("click", this.outerControl.bind(this));
    inventoryApi.getInventory();
    inventoryApi.getInventoryProductsList();
  }

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
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
  
  createInventory(){
    ReactDOM.render(<CreateInventory />, document.getElementById("createInventoryContent"));
    G.displayModal("createInventory");
  }

  uploadInventoryProducts(inventory){
    console.log(inventory.value)
    ReactDOM.render(<UploadInventory inventory={inventory}/>, document.getElementById("uploadInventoryContent"));
    G.displayModal("uploadInventory");
  }

  viewInventory(){

  }

  getInventoryLists(){

  }

  viewOrder(){

  }

  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination, pageNumber  } = this.state
    return (
        <div>
          <div className="list-search">
          {/*}
            <select>
              <option id="">--</option>
              {this.props.inventoryLists.map( inventory =>{
                return(<option id={inventory.id_warehouse}>{inventory.name}</option>)
              })}
            </select>
          */}
          {this.props.inventoryLists != undefined && this.props.inventoryLists.length > 0 ?
            <Select 
                isMulti={false}
                id="selectedWarehouse"  
                className='react-select-container'
                classNamePrefix='react-select'
                placeholder="Select Inventory" 
                defaultValue={{ label: this.props.inventoryLists[0]['label'], value: this.props.inventoryLists[0]['value'] }}
                options={this.props.inventoryLists} 
                value={this.state.chosenInventory}
                onChange={(inventory) =>{
                  this.setState({chosenInventory: inventory});
                  inventoryApi.getInventoryProductsList( inventory.value);
                }} 
                ref={component => { this.inventory = component }} 
              />
              : null}
            <div className="searchWrapper">
            <input ref="searchQuery" type="text" placeholder="Search your orders and customers" 
              onChange={(e)=>{
                console.log(e.target.value)
                if (this.state.typingTimeout) {
                  clearTimeout(this.state.typingTimeout);
                }
                this.setState({
                  input: e.target.value,
                  typing: false,
                  typingTimeout: setTimeout(function(){
                      this.getInventoryLists(limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, this.state.input, false, true, null)
                      console.log("done launch")
                    }.bind(this), 750)
                });
            }}/>
            <i className="icon-search"></i>
            </div>
            <div>
            {this.props.inventoryLists != undefined && this.props.inventoryLists.length > 0 ?
              <div className="split-button">
                <div className={"split-button-default-action"}>
                  <button >Inventory Actions</button>
                  <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                  <ul className={"split-button-dropdown align-right hidden"}>
                    <li className={"active"} onClick={this.uploadInventoryProducts.bind(this, this.state.chosenInventory ? this.state.chosenInventory : this.props.defaultInventory)}>
                      <a className="button button-blue outline padding-0404" href='javascript:void(0)'>
                        <i className="icon-upload"></i><span>Upload Products</span>
                      </a>                                      
                    </li>
                  </ul>
                </div>
              </div>
              : null}
            </div>
          </div>
          <div className="list-container">
              <div className="list-wrapper">
                <div className="table-filter">
                  <div className="page-filter">
                    <div className="duration-filter">
                      <MydateFilter ref={el => (this.datePicker = el)} changeRequested={true} onChange={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                    </div>
                    <div className="reset-button">
                      <Ripples><button onClick={this.getInventoryLists.bind(this, 10, 0, "", "", 5, "", "koha.`date_add`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                    </div>
                  </div>

                  <div className="pagination-container">
                    <select ref="orderPerPage" className="pagination-select" name="orderPerPage" defaultValue={10} onChange={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
                      <option >10</option>
                      <option >25</option>
                      <option >50</option>
                      <option >100</option>
                    </select>
                    <ReactPaginate 
                      nextLabel={<i className="icon-arrow-right"></i>}
                      previousLabel={<i className="icon-arrow-left"></i>}
                      breakLabel={<a href="javascript: void(0)">...</a>}
                      breakClassName={"break-me"}
                      pageCount={parseInt(this.props.inventoryCount)}
                      marginPagesDisplayed={0}
                      pageRangeDisplayed={0}
                      totalRecordsDisplay={true}
                      shouldUpdate={updatePagination}
                      onPageChange={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                      containerClassName={"pagination"}
                      subContainerClassName={"pages pagination"}
                      activeClassName={"active"}
                      forcePage={pageNumber} />
                  </div>
              </div>

              <table>
                <thead>
                  <tr>
                    <th>
                      Image
                    </th>
                    <th className="text-align-left">
                      Product Name
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`name`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`name`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th className="text-align-left">
                      Product Reference
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid_sort`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid_sort`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th>
                      Stock Quantity
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`name`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInventoryLists.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`name`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th>
                      Actions        
                    </th>
                  </tr>
                </thead>
                <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                    {this.props.isFetching && this.props.inventoryProducts && this.props.inventoryProducts.length > 0 ? 
                      <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td><td></td></tr> : 
                      (this.props.inventoryProducts && this.props.inventoryProducts.length > 0 ? this.props.inventoryProducts.map(product => {
                        return (
                          <tr key={product.id_product}>
                              <td data-title="Image">
                                <ReactImageFallback
                                    src={product.imageLink}
                                    fallbackImage=".././img/p/en-default-small_default.jpg"
                                    initialImage=".././img/p/en-default-small_default.jpg"
                                    alt={product.product_name}/>
                              </td>
                              <td data-title="Product">{product.name}</td>
                              <td className="text-align-left" data-title="Reference">{product.reference}</td>
                              <td className="text-align-left" data-title="Stock">{product.stock}</td>
                              <td data-title="Actions">
                                <button className="button-blue outline">View</button>
                              </td>
                          </tr> 
                        );
                      }) : 
                      this.props.inventoryLists != undefined && this.props.inventoryLists.length > 0 ?
                        <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2 >No Products Available in Inventory!</h2><p>Please add products to your Inventory</p></div></td><td></td></tr>
                        :<tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><button className="btn button-blue" onClick={this.createInventory.bind(this)}>Create Inventory</button><p>Handle your inventory better with us</p></div></td><td></td></tr>)
                    }
                </ReactCSSTransitionGroup>
              </table>
          </div>
        </div> 
      </div>
    )
  }
}

const mapStateToProps = function({inventoryState}) {
  console.log(inventoryState);
  return {
    isFetching: inventoryState.isFetching,
    inventoryCount: inventoryState.inventoryCount,
    inventoryLists: inventoryState.inventoryLists,
    inventoryProducts: inventoryState.inventoryProducts,
    defaultInventory: inventoryState.defaultInventory,
    
  };
};

export default connect(mapStateToProps)(InventoryLists);

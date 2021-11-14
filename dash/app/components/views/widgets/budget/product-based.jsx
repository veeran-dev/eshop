import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr';
import store from '../../../../store/configureStore';
import * as G from '../../../../api/common-api';
import * as procureApi from '../../../../api/procure-buy-api'
import * as addressApi from '../../../../api/address-api';
import Input from '../../../../components/common/Input';

class ProductBasedBudget extends React.Component {
  constructor(props){
    super(props)
  }

  render() {
    const { purchaseOrderProducts } = this.props;
    return(
      <div>
        <h4 className="block-title">Download</h4>
        <div className="po-download">
          <div className="control-group">
            <label>Download the products in your rate contract</label>
            <button className="button-blue outline" onClick={this.props.download}><i className="icon-cloud-download"></i> Download Excel Template</button>
          </div>
        </div>

        <h4 className="block-title">Upload</h4>
        <div className="po-upload">
          <div className="control-group">
            <label>In the sheet downloaded from above, enter the quantities against each product as per your purchase order</label>
            <form id="upload-purchase-order" method="post" encType="multipart/form-data">
              <input type="file" name="excel-file" id="upload-purchase-order-budget-input" className="file-input" onChange={this.props.fileInputHandler}/>
              <label htmlFor="upload-purchase-order-budget-input">{this.props.state.selectedExcel}</label>
              <button type="button" className="button-blue" onClick={this.props.upload}><span><i className="icon-cloud-upload"></i></span> {this.props.isUploadingPo ? "Uploading..." : "Upload Excel"} </button>
            </form>
          </div>
        </div>

        {purchaseOrderProducts.length > 0 ?
        <div className={"products-list "+ this.props.state.productsBlock}>
            <h4 className="block-title">Products List</h4>
            {/* Form for products list to create budget purchase order*/}
            <div className="scroll-wrapper">
              <form id="purchaseOrderProducts">
                <table>
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Reference</th>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Price (Tax Excl.)</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    {purchaseOrderProducts.map((data, i) => {
                      return (
                        <tr key={i}>
                          <td data-title="S. No.">{++i}</td>
                          <td data-title="Product Code">{data.reference}</td>
                          <td data-title="Product">{data.name}</td>
                          <td data-title="Quantity">{data.quantityGiven}</td>
                          <td data-title="Price">₹ {data.price_tax_exc}</td>
                          <td data-title="Status">
                            <span>{data.productStatus.toUpperCase()}</span>
                            <span>
                              <Input type="hidden" 
                                  inputValue={data.id_product+"-"+data.quantityGiven}
                                  name={data.productStatus == "active" ? "activeProducts" : "nonActiveProducts"} />
                            </span>
                          </td>
                        </tr>
                      )
                    })}
                  </tbody>
                </table>
              </form>
            </div>
        </div>
        : "" }
      </div>
    )
  }
}

ProductBasedBudget.contextTypes = {
  router: React.PropTypes.object.isRequired
};

export default ProductBasedBudget;
import React from 'react'
import { connect } from 'react-redux'
import store from '../../../store/configureStore'
import { Scrollbars } from 'react-custom-scrollbars'

class CompaniesAlsoBought extends React.Component {
    constructor(props){
        super(props)
    }

    render() {
        return (
            <div className="suggested-products">
               <h3 className="block-header">Companies Also Bought</h3>
               <Scrollbars className="scroll-table">
                  <table className="widget-compressed-table">
                    <tbody>
                      <tr>
                        <td className="product-thumb">
                          <img src="kobsterElite" width="32" height="32" alt="12 Color Sticky Notes"/>
                        </td>

                        <td className="product-name">
                          12 Color Sticky Notes
                        </td>

                        <td className="product-quantity">
                          12
                        </td>

                        <td className="product-price">
                          1220
                        </td>

                        <td className="product-actions">
                          <button className="button-blue">Add</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
               </Scrollbars>
            </div>
        )
    }
}

CompaniesAlsoBought.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {}
}

export default connect(mapStateToProps)(CompaniesAlsoBought)
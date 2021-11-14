import React from 'react'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group'
import * as procureBuyApi from '../../../api/procure-buy-api'
import store from '../../../store/configureStore'

class CategoryList extends React.Component {
    
  componentDidMount() {
  	procureBuyApi.getListCategories()
	}

  render() {
      return (
        <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={true} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="div">
        {this.props.isFetching ? <div className="fetching-content grids"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div> : 
            <div className="category-list-container">
                {this.props.purchaseCategories && this.props.purchaseCategories.length > 0 ? this.props.purchaseCategories.map((category, index) => {
            			return(
                    <Link to={"procure/purchase-list-categories/"+category.id_category} className="category" key={index+1}>
              				<img className="category-thumb" src={"dash/img/categories/"+category.id_category+".jpg"} alt={category.category} />
                      <span className="category-title">{category.category}</span>
                    </Link>
              		)
            		}): 
                  <div className="no-results">
                    <img src="dash/img/no-data.png" alt="No Results"/>
                    <p>From cleansers to chocolates, pins to printers, visiting cards to vending machines, we have it all! Get in touch with your RM to explore more on our wide-range of Categories.</p>
                  </div>
                }
            </div>
        }
      </ReactCSSTransitionGroup>
  	)
	}
}

const mapStateToProps = function(store) {
  return {
  	purchaseCategories: store.procureBuyState.purchaseCategories,
    isFetching: store.procureBuyState.isFetchingPurchaseCategories
  }
}

export default connect(mapStateToProps)(CategoryList) 
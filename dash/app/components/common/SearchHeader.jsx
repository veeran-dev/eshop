import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import store from '../../store/configureStore'
import ReactPaginate from 'react-paginate';
import ReactMultiSelectCheckboxes from 'react-multiselect-checkboxes';
import InputRange from 'react-input-range';
import SelectArea from './SelectArea'
import * as G from '../../api/common-api'
import {search} from '../../api/search-api'
import {get} from '../../api/address-api';
import cookie from 'react-cookie'

class SearchHeader extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
          isMobile: false,
          showFilter: false,
          postcode: "",
          selectedArea: "Select Location ...",
          input: "",
          zone: "",
          category_lists: [],
          brand_lists: [],
          selected_price: "",
          sort: "",
          address: "",
          addresses: [],
          maxPriceRange: 0,
        }
    }

    componentWillMount = () => {
        G.checkWidget(21, true)
        //fetch addresses
        get();
        var element = document.getElementsByClassName("sp-container");
        element.className="hidden";
        if(window.innerWidth <= 992) {
            this.setState({isMobile: true})
        } else {
            this.setState({isMobile: false})
        }
        this.setState({input: this.props.query})
        this.setState({maxPriceRange: Math.ceil(this.props.max_price)});        
        this.setState({addresses: this.props.addresses})
    }

    componentWillReceiveProps(nextProps){
        console.log(nextProps.zones['selectedArea'])
        if(this.props.max_price != nextProps.max_price){
            if(nextProps.max_price == false){
                this.setState({selected_price: 0});     
            }
            else if(nextProps.max_price != false && Math.ceil(this.props.max_price)<Math.ceil(nextProps.max_price)){
                this.setState({
                    selected_price: Math.ceil(nextProps.max_price), 
                    maxPriceRange: Math.ceil(nextProps.max_price) > this.state.maxPriceRange ? Math.ceil(nextProps.max_price) : this.state.maxPriceRange
                },
                ()=>console.log("maxPriceRange ="+nextProps.max_price));
            }
           
        }
        if(this.state.selectedArea != nextProps.zones['selectedArea']){
            this.setState({selectedArea: nextProps.zones['selectedArea'] !=undefined && nextProps.zones['selectedArea'] != "" ? nextProps.zones['selectedArea'] : "Select Location ..."})
        }
        if(nextProps.zones['selectedArea'] === undefined || nextProps.zones['selectedArea'] == ""){
            this.showSelectArea()
        }
        this.setState({addresses: this.props.addresses})

    }

    updateInput(e){
        this.refs.sort.value = "";
        if (this.state.typingTimeout) {
           clearTimeout(this.state.typingTimeout);
        }
        this.setState({
           input: e.target.value,
           typing: false,
           typingTimeout: setTimeout(function () {
               search(1, this.state.input, [], [],[], "","", false, true)
             }.bind(this), 750)
        });
    }

    updateCategory(lists){
        let price = this.state.selected_price == this.props.max_price ? "" : this.state.selected_price;
        let category_lists = lists.map(list => list.value);
        this.setState({category_lists: category_lists})
        search(1, this.state.input, this.state.zone, category_lists,this.state.brand_lists, price, this.state.sort, false, true)
    }

    updateBrand(lists){
        let price = this.state.selected_price == this.props.max_price ? "" : this.state.selected_price;
        let brand_lists = lists.map(list => list.value);
        this.setState({brand_lists: brand_lists})
        search(1, this.state.input, this.state.zone, this.state.category_lists, brand_lists, price,this.state.sort, false, true)
    }

    updatePrice(e, value){
        search(1, this.state.input, this.state.zone, this.state.category_lists, this.state.brand_lists, this.state.selected_price,this.state.sort, false, true)   
    }

    updateSort(e){
        let price = this.state.selected_price == this.props.max_price ? "" : this.state.selected_price;
        this.setState({sort:e.target.value},()=>{
            search(1, this.state.input, this.state.zone, this.state.category_lists, this.state.brand_lists, price,this.state.sort, false, true)
        });
    }
    showSelectArea=()=>{
        ReactDOM.render(<SelectArea store={store} mandatory={this.props.zones['selectedArea'] === undefined} onSelect={this.getSelectedArea} address={this.state.addresses} selectedAreaProps={this.props.zones}/>, document.getElementById("spLocaationContent"))
        G.displayModal("spArea")
    }

    getSelectedArea = (address) =>{
        cookie.save('selectedArea', address['selectedArea'])
        G.closeModal(["spArea"])
        this.setState({selectedArea: address['selectedArea'], zone: address},()=>{
            search(1, this.state.input, this.state.zone, this.state.category_lists, this.state.brand_lists, this.state.selected_price,this.state.sort, false, true)
        })
    }

    render() {
        const options = [
          { label: 'Thing 1', value: 1, key: 12},
          { label: 'Thing 2', value: 2, key: 13},
        ];
        return (
            <div className="sp-search-header">
                {/*<div className="sp-container">
                    <div className={this.props.idProduct && this.props.idProduct>0 ? "sp-location hidden":"sp-location"} onClick={this.showSelectArea.bind(this)} >
                      {this.state.selectedArea}
                    </div>
                    <input type="text" placeholder="Search product name or product code and find supplier" onChange={this.updateInput.bind(this)} />
                    <div><i className="icon-search" /></div>
                  </div>*/}
                    <div className={this.props.idProduct && this.props.idProduct>0 ?"sp-filter-container hidden" : "sp-filter-container"}>
                        <div className="sp-result-count">
                            <p>Search results: {this.props.products.length} products found</p>
                            <i className={this.state.isMobile == true?"icon-filter":"hidden"} onClick={(e)=>this.setState({showFilter: true})}></i>
                        </div>
                        <div className={this.state.showFilter == true ? "sp-filter-wrapper show-filter" : "sp-filter-wrapper "}>
                            <div className={this.state.isMobile == true ?"sp-filter":"hidden"}>
                                <i className="icon-back-arrow" onClick={(e)=>this.setState({showFilter: false})}></i>
                            </div>
                            <div className="sp-filter sp-location-wrapper" onClick={this.showSelectArea.bind(this)} >
                                    <i className="icon-place-pin icon-red"></i>
                                    <p className="sp-location">{this.state.selectedArea}</p>
                                    <i className="icon-arrow-down"></i>
                            </div>
                            <div className="sp-filter">
                                <ReactMultiSelectCheckboxes placeholderButtonLabel="Search Category..." options={this.props.category} onChange={this.updateCategory.bind(this)}/>
                            </div>
                            <div className="sp-filter">
                                <ReactMultiSelectCheckboxes placeholderButtonLabel="Search Brand..." options={this.props.brand} onChange={this.updateBrand.bind(this)}/>
                            </div>
                            <div className="sp-filter sp-filter-price">
                                <div className="sp-price-range">
                                    <InputRange
                                    draggableTrack
                                    maxValue={this.state.maxPriceRange}
                                    minValue={0}
                                    formatLabel={values => '₹ '+values}
                                    value={this.state.selected_price}
                                    onChange={(e,value) => this.setState({ selected_price: value },function(){console.log("price sets "+this.state.selected_price)})}
                                    onChangeComplete={value => this.updatePrice(value)}
                                    />
                                </div>
                            </div>
                            <div className="sp-filter">
                                <select onChange={this.updateSort.bind(this)} ref="sort">
                                    <option value="">Sort By</option>
                                    <option value="desc">Price High to Low</option>
                                    <option value="asc">Price Low to High</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
        )
    }   
}

const mapStateToProps = function(store) {
    // console.log(store.searchState)
  return {
    category: store.searchState.category,
    brand: store.searchState.brand,
    max_price: store.searchState.max_price,
    products: store.searchState.result,
    zones: store.searchState.zones,
    addresses: store.addressState.address
  }
};

export default connect(mapStateToProps)(SearchHeader)   
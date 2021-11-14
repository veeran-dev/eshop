import React, { Component, PropTypes } from 'react';
import ReactDOM from 'react-dom';
import scrollIntoView from 'dom-scroll-into-view';
import cookie from 'react-cookie'
import { connect } from 'react-redux';
import store from '../../store/configureStore'
import * as actions from '../../actions/common-actions';
import ControlledScrollbar from './controlled-scrollbar';

class Autocomplete extends Component {
  constructor(props) {
    super(props);

    this._ignoreBlur = false;
    this._performAutoCompleteOnUpdate = false;
    this._performAutoCompleteOnKeyUp = false;

    this.state = {
      menuTop: 0,
      menuLeft: 0,
      menuWidth: 0,
    };
  }

  componentWillMount() {
    this.props.dispatch(actions.init({ props: this.exportProps() }));
  }

  componentDidUpdate(prevProps) {
    if (this.props.isOpen === true && prevProps.isOpen === false) {
      this.setMenuPositions();
    }

    if (this.props.isOpen && this._performAutoCompleteOnUpdate) {
      this._performAutoCompleteOnUpdate = false;
      this.maybeAutoCompleteText();
    }

    this.maybeScrollItemIntoView();
  }

  exportProps() {
    const { staticItems, getItemValue, shouldItemRender, sortItems, sortGroups } = this.props;
    return { staticItems, getItemValue, shouldItemRender, sortItems, sortGroups };
  }

  maybeScrollItemIntoView () {
    if (this.props.isOpen === true && this.props.highlightedIndex !== null) {
      var itemNode = ReactDOM.findDOMNode(this.refs[`item-${this.props.highlightedIndex}`]);
      var menuNode = ReactDOM.findDOMNode(this.refs.menu);
      itemNode && scrollIntoView(itemNode, menuNode, { onlyScrollIfNeeded: true });
    }
  }

  handleKeyDown (event) {
    if (Autocomplete.keyDownHandlers[event.key]) {
      Autocomplete.keyDownHandlers[event.key].call(this, event);
    }
  }

  handleChange (event) {
    this._performAutoCompleteOnKeyUp = true;
    this.props.dispatch(actions.setText({ text: event.target.value, props: this.exportProps() }));
    this.props.onChange(event, event.target.value);
  }

  handleKeyUp () {
    if (this._performAutoCompleteOnKeyUp) {
      this._performAutoCompleteOnKeyUp = false;
      //this.maybeAutoCompleteText();
    }
  }

  maybeAutoCompleteText () {
    var { text, highlightedIndex, getItemValue } = this.props;
    if (text === '') {
      return;
    }
    var items = this.props.items;
    if (items.length === 0) {
      return;
    }
    var matchedItem = highlightedIndex !== null ?
      items[highlightedIndex] : items[0];
    var itemValue = getItemValue(matchedItem);
    var itemValueDoesMatch = (itemValue.toLowerCase().indexOf(
      text.toLowerCase()
    ) === 0);
    if (itemValueDoesMatch) {
      if (highlightedIndex === null) {
        this.highlightItemFromMouse(matchedItem, 0);
      }
      var node = ReactDOM.findDOMNode(this.refs.input);
      node.value = itemValue;
      node.setSelectionRange(text.length, itemValue.length);
    }
  }

  setMenuPositions () {
    var node = ReactDOM.findDOMNode(this.refs.input)
    var rect = node.getBoundingClientRect()
    var computedStyle = getComputedStyle(node)
    var marginBottom = parseInt(computedStyle.marginBottom, 10)
    var marginLeft = parseInt(computedStyle.marginLeft, 10)
    var marginRight = parseInt(computedStyle.marginRight, 10)
    this.setState({
      menuTop: rect.bottom + marginBottom,
      menuLeft: rect.left + marginLeft,
      menuWidth: rect.width + marginLeft + marginRight
    })
  }

  highlightItemFromMouse (item, index) {
    this.props.dispatch(actions.setHighlight(index));
  }

  selectItemFromMouse (item, index) {
    const { onSelect, getItemValue, dispatch } = this.props;
    const value = getItemValue(item);
    dispatch(actions.selectItem({ index, props: this.exportProps() }));
    dispatch(actions.clearItems());
    onSelect(value, item);
    this.setIgnoreBlur(false);
  }

  setIgnoreBlur (ignore) {
    this._ignoreBlur = ignore;
  }

  renderMenu () {
    let group;
    var items = this.props.items.map((item, index) => {
      var element = this.props.renderItem(
        item,
        this.props.highlightedIndex === index,
        { cursor: 'default' }
      );
      let header;
      if (item.group && group !== item.group) {
        header = <div style={this.props.headerStyle}>{item.group}</div>;
        group = item.group;
      }
      return [header, React.cloneElement(element, {
        onMouseDown: () => this.setIgnoreBlur(true),
        onMouseEnter: () => this.highlightItemFromMouse(item, index),
        onClick: () => this.selectItemFromMouse(item, index),
        ref: `item-${index}`,
      })];
    }).reduce((list, ary) => list.concat(ary.filter(i => !!i)), []);
    var style = {
      left: this.state.menuLeft,
      top: this.state.menuTop,
      minWidth: this.state.menuWidth,
    };
    var menu = this.props.renderMenu(items, this.props.text, style);
    return React.cloneElement(menu, { ref: 'menu' });
  }

  handleInputBlur () {
    if (this._ignoreBlur) {
      return;
    }
    this.props.dispatch(actions.closeList());
  }

  handleInputFocus () {
    if (this._ignoreBlur) {
      return;
    }
    this.props.dispatch(actions.openList({ props: this.exportProps() }));
  }

  handleInputClick () {
    if (this.props.isOpen === false) {
      this.props.dispatch(actions.openList({ props: this.exportProps() }));
    }
  }

  render () {
    let searchTypeSelected = cookie.load("search_type")
    return (
        <div className="searchbox">
          <select name="search-filter" id="search-filter" onChange={this.props.changeSearchType} className={this.props.selectOption}>
            <option value="1" selected={searchTypeSelected ? (searchTypeSelected == 1 ? true: false) : false}>All Products</option>
            <option value="2" selected={searchTypeSelected ? (searchTypeSelected == 2 ? true : false) : true}>My Products</option>
          </select>
          <input
            {...this.props.inputProps}
            role="combobox"
            aria-autocomplete="both"
            ref="input"
            onFocus={this.handleInputFocus.bind(this)}
            onBlur={this.handleInputBlur.bind(this)}
            onChange={event => this.handleChange(event)}
            onKeyDown={event => this.handleKeyDown(event)}
            onKeyUp={event => this.handleKeyUp(event)}
            onKeyPress={this.props.onKeyPress}
            onClick={this.handleInputClick.bind(this)}
            id={this.props.id}
            name={this.props.name}
            value={this.props.text}
          />
          {this.props.isOpen && this.renderMenu()}
        </div>
    )
  }
}

Autocomplete.propTypes = {
  // Props from state tree
  text: PropTypes.string.isRequired,
  isOpen: PropTypes.bool.isRequired,
  highlightedIndex: PropTypes.number,
  items: PropTypes.array.isRequired,

  // Props from wrapper props
  renderItem: PropTypes.func.isRequired,
  getItemValue: PropTypes.func.isRequired,
  inputProps: PropTypes.object,
  staticItems: PropTypes.array,
  onChange: PropTypes.func,
  onSelect: PropTypes.func,
  shouldItemRender: PropTypes.func,
  sortItems: PropTypes.func,
  sortGroups: PropTypes.func,
  menuStyle: PropTypes.object,
  headerStyle: PropTypes.object,
};

Autocomplete.defaultProps = {
  inputProps: {},
  onChange: () => {},
  onSelect: (value, item) => {},
  renderMenu: (items, value, style) => {
    return (
    <div className="search-results">
      <ControlledScrollbar children={items} />
    </div>
    )
  },
  shouldItemRender: () => true
};

Autocomplete.keyDownHandlers = {
  ArrowDown: function (event) { // Make 'this' free
    event.preventDefault();
    var { highlightedIndex, dispatch } = this.props;
    var index = (
      highlightedIndex === null ||
      highlightedIndex === this.props.items.length - 1
    ) ?  0 : highlightedIndex + 1;
    this._performAutoCompleteOnKeyUp = true;
    dispatch(actions.setHighlight(index));
  },

  ArrowUp: function (event) { // Make 'this' free
    event.preventDefault();
    var { highlightedIndex, dispatch } = this.props;
    var index = (
      highlightedIndex === 0 ||
      highlightedIndex === null
    ) ? this.props.items.length - 1 : highlightedIndex - 1;
    this._performAutoCompleteOnKeyUp = true;
    dispatch(actions.setHighlight(index));
  },

  Enter: function (event) { // Make 'this' free
    const { isOpen, highlightedIndex, text, onSelect, dispatch } = this.props;
    if (isOpen === false) {
      // already selected this, do nothing
      return
    } else if (highlightedIndex == null) {
      // hit enter after focus but before typing anything so no autocomplete attempt yet
      dispatch(actions.closeList());
      ReactDOM.findDOMNode(this.refs.input).select();
    } else {
      var item = this.props.items[highlightedIndex];
      dispatch(actions.selectItem({ index: highlightedIndex, props: this.exportProps() }));
      // ReactDOM.findDOMNode(this.refs.input).focus() // TODO: file issue
      ReactDOM.findDOMNode(this.refs.input).setSelectionRange(text.length, text.length);
      onSelect(text, item);
    }
  },

  Escape: function (event) { // Make 'this' free
    this.props.dispatch(actions.closeList());
  },

  Backspace: function (event) { // Make 'this' free
    const node = ReactDOM.findDOMNode(this.refs.input);
    node.value = this.props.text;
  }
};

const mapStateToProps = function(store) {
  return {
    text: store.commonState.text,
    isOpen: store.commonState.isOpen,
    highlightedIndex: store.commonState.highlightedIndex,
    items: store.commonState.items
  }
}

export default connect(mapStateToProps)(Autocomplete)
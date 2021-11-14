import React from 'react';
import ReactDOM from 'react-dom'

class SearchCatalog extends React.Component {
	constructor(props){
		super(props)
		this.state={
			input: '',
        }
	}

	updateInput(e){
		// this.setState({input: e.target.value},function(){
		// 	this.props.onChange(this.state.input);
		// });
	    if (this.state.typingTimeout) {
	       clearTimeout(this.state.typingTimeout);
	    }
	    this.setState({
	       input: e.target.value,
	       typing: false,
	       typingTimeout: setTimeout(function () {
	       		console.log(this.props);
	           this.props.onChange(this.state.input);
	         }.bind(this), 750)
	    });
	}

	render(){
		return(
			<div className="catalog-search-container">
				<div className="search-box">
					<input type="text" placeholder="Search" ref={(node) => {this.searchBox = node}} value={this.state.input} onChange={this.updateInput.bind(this)} />
				</div>
				<div className="catalog-results">
					<table>
						<tbody>
							<tr>
								<td colSpan="1">
									<img src="https://www.kobster.com/126713-large/paperone-copier-paper-a3-70gsm-500-sheets.jpg"/>
								</td>
								<td colSpan="5" className="name-section">
									<div className="name">Edit: Visiontek 21G GSM Fixed Wireless Telephoneordless Landline Phone</div>
									<div className="code">Ref: 201520</div>
								</td>
								<td colSpan="1" className="price">
									<div>MRP</div>
									<div>92,000.00</div>
								</td>
								<td>
									<button className="button-blue">Add to Catalog</button>
								</td>
							</tr>
							<tr>
								<td colSpan="1">
									<img src="https://www.kobster.com/126713-large/paperone-copier-paper-a3-70gsm-500-sheets.jpg"/>
								</td>
								<td colSpan="5" className="name-section">
									<div className="name">Edit: Visiontek 21G GSM Fixed Wireless Telephoneordless Landline Phone</div>
									<div className="code">Ref: 201520</div>
								</td>
								<td colSpan="1" className="price">
									<div>MRP</div>
									<div>92,000.00</div>
								</td>
								<td>
									<button className="button-blue">Add to Catalog</button>
								</td>
							</tr>
							<tr>
								<td colSpan="1">
									<img src="https://www.kobster.com/126713-large/paperone-copier-paper-a3-70gsm-500-sheets.jpg"/>
								</td>
								<td colSpan="5" className="name-section">
									<div className="name">Edit: Visiontek 21G GSM Fixed Wireless Telephoneordless Landline Phone</div>
									<div className="code">Ref: 201520</div>
								</td>
								<td colSpan="1" className="price">
									<span>92,000.00</span>
								</td>
								<td>
									<button className="button-blue">Add to Catalog</button>
								</td>
							</tr>
							<tr>
								<td colSpan="1">
									<img src="https://www.kobster.com/126713-large/paperone-copier-paper-a3-70gsm-500-sheets.jpg"/>
								</td>
								<td colSpan="5" className="name-section">
									<div className="name">Edit: Visiontek 21G GSM Fixed Wireless Telephoneordless Landline Phone</div>
									<div className="code">Ref: 201520</div>
								</td>
								<td colSpan="1" className="price">
									<span>92,000.00</span>
								</td>
								<td>
									<button className="button-blue">Add to Catalog</button>
								</td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		)
	}
}
export default SearchCatalog
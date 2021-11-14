import React from 'react'

class Input extends React.Component{
	constructor(props){
		super(props)
	}
	
	componentDidUpdate(prevProps){
		if(prevProps.inputValue != this.props.inputValue){
			document.getElementById(this.props.id).removeAttribute("value");
			document.getElementById(this.props.id).setAttribute("value", "");
			document.getElementById(this.props.id).value = this.props.inputValue;
		}
	}

	render(){
		return(
			<input type={this.props.type} 
				   defaultChecked={this.props.defaultChecked} 
				   name={this.props.name} 
				   className={this.props.className} 
				   id={this.props.id} 
				   min={this.props.min}
				   max={this.props.max}
				   maxLength={this.props.maxLength}
				   defaultValue={this.props.inputValue} 
				   onChange={this.props.onChange}
				   onClick={this.props.onClick}
				   onKeyUp={this.props.onKeyUp}
				   onBlur={this.props.onBlur}
				   placeholder={this.props.placeholder}
				   disabled={this.props.disabled}
				   data-required={this.props.dataRequired} />
		)
	}
}

export default Input
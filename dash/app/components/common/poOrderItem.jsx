import React from 'react'

class PoOrderItem extends React.Component{
    constructor(props){
		super(props);
		this.state = {
			isViewMore: false
		}
	}
	toggleView(){
		this.setState({
			isViewMore: !this.state.isViewMore
		})
	}
    render(){
        return(
            <div className={this.state.isViewMore ? "po-order-item active" : "po-order-item"}>
                <table>
                    <tbody>
                        <tr>
                            <td>{this.props.id}</td>
                            <td>{this.props.date}</td>
                            <td>{this.props.total}</td>
                            <td className="text-align-right">
                                <button className={this.state.isViewMore ? "view-more active" : "view-more" } onClick={() => this.toggleView()}>
                                    {this.state.isViewMore ? <i className="icon-arrow-up"></i> : <i className="icon-arrow-down"></i>}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        )
    }
}

export default PoOrderItem;
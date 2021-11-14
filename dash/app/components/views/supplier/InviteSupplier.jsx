import React, { Component } from 'react'
import CreatableSelect from 'react-select/lib/Creatable';
import { inviteSupplier } from '../../../api/common-api';
import { toastr } from 'react-redux-toastr';

const defaultOptions = [
  { value: 'ocean', label: 'Please enter valid email. Ex. user@gmail.com', color: '#00B8D9', isFixed: true, isDisabled: true },
];

const customStyles = {
    control: (base, state) => ({
      ...base,
      'min-height': '38px',
      'max-height': '100px',
      'overflow-y': 'auto'
    }),
};

export default class InviteSupplier extends Component {
	constructor(props) {
		super(props);
		this.state = {
    		options: defaultOptions,
    		value: [],
		}

		this.initialState = this.state
	}

	handleChange = (newValue, actionMeta) => {
		this.setState({ value: newValue });
	};

	isEmail(data) {
		return data.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
	}

	inviteSupplier = () => {
		let emails = []
		if(this.state.value.length > 0) {
			this.state.value.filter(option => { 
				if(this.isEmail(option.value)) {
					emails.push(option.value)
				}
				else{
					let msg ="Please check "+option.value+" and try again";
            		toastr.error('Error', msg, { icon: 'icon-error' });
            		return false;
				}
			});

			if(emails.length > 0) {
				inviteSupplier(emails).then(response => {
					if(response == 1) {
						toastr.success('Success', 'Supplier'+(emails.length > 1 ? 's' : '')+' invited successfully.', { icon: 'icon-succes' })
					} else {
						toastr.error('Error', response.data, { icon: 'icon-error' });
					}
					this.setState(this.initialState);
				});
			}
			else {
				toastr.error('Error', 'Please provide atleast one valid email.', { icon: 'icon-error' });
			}
		}
		else {
			toastr.error('Error', 'Please add atleast one email.', { icon: 'icon-error' });
		}
	}
 
	render() {
		const { value, options } = this.state
		return (
			<div>
				<div className="invite-supplier">
					<div className="page-header">
              			<h3 className="page-title">Invite Supplier</h3>
              		</div>
              		<div className="page-container">
              			<div className="invite-supplier-container">
	              			<div className="invite-supplier-input form-group">
		              			<div className="form-control">
			              			<CreatableSelect
			              				ref={r => (this.selectRef = r)}
			              				isMulti
										isClearable
										delimiter=","
										onChange={this.handleChange}
										options={options}
										value={value}
										placeholder="Type email and press enter.."
										styles={customStyles}
									/>
								</div>
								<div className="form-control invite-btn">
									<button className="button button-blue" onClick={this.inviteSupplier}>Invite</button>
								</div>
							</div>
						</div>
              		</div>
				</div>
			</div>
		)
	}
}
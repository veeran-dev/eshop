import React from 'react'

const ConfirmQuotation =(props)=> {
    return (
        <div className="quotation-confirmation-container">
            <div className="stage_6">
                    <i className='icon-succes'></i>
                    <p>{props.msg}</p>
                </div>

        </div>
    )
}

export default ConfirmQuotation
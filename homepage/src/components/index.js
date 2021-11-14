import React from 'react'
import PropTypes from 'prop-types'
import Helmet from 'react-helmet'
import Header from './header'
import Footer from './footer'
import './index.scss'

const TemplateWrapper = ({ children }) => (
  <div>
    <Helmet
      title="eProcurement Solution for Businesses | Office Supplies | Kobster"
      meta={[
        { name: 'description', content: 'B2B Procurement | e-Procurement and e-Purchasing Tool | Kobster Elite - Kobster.com' },
        { name: 'keywords', content: 'eProcurement Tool, Buy Office Supplies online, ePurchasing Tool, pan India Delivery, Office Stationery, Pantry,  Electronics, Housekeeping. Chennai, Bangalore, Mumbai, Hyderabad, Delhi' },
      ]}
    />
    <Header />
    {children()}
    <Footer />
  </div>
)

TemplateWrapper.propTypes = {
  children: PropTypes.func,
}

export default TemplateWrapper

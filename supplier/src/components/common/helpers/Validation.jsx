import isEmpty from 'lodash/isEmpty';

export default function validateQuoteForm(config) {
  let validForm = document.getElementById(config.form), errors = {}
  if(validForm != null && validForm.tagName == 'FORM'){
    let rules = config.rules, messages = config.messages
    if(rules == undefined){
      errors.global = "Validation rule is not defined"
    }
    else{
      if(!isEmpty(rules)){
        for(var key in rules){
          let data = document.getElementById(key).value
          // Validating field is required
          if(data.trim() == "")
            errors[key] = messages[key].required
          // Validating field is numeric and is negative number
          if(rules[key].numeric){
            if(data.length > 0 && !data.match(/^[0-9]+$/))
              errors[key] = messages[key].numeric
            if(data && data == 0)
              errors[key] = "Number should be greater than zero."
            if(data && data < 0)
              errors[key] = "Negative numbers not allowed."
          }
          //validation Address
          if(rules[key].isAddress){
              if(data.match(/[!@#$%^&*_+\=\[\]{};':"\\|<>\?]+/)){
                errors[key] = messages[key].isAddress
              }
          }
          // Validating GST          
          if(rules[key].isGst){
            let re ='\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}';
            if(!data.match(/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/)){
              	errors[key] = messages[key].isGst
            }
          }
          // Validating maximun of input size
          if(rules[key].maxlength){
            if(data.length > 0 && data.match(/^[0-9]+$/) && (data.length !== rules[key].maxlength.length))
              errors[key] = messages[key].maxlength
          }
          if(rules[key].email){
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if(!re.test(data))
              errors[key] = messages[key].email
          }
          
          // Validating mobile number
          if(rules[key].mobile){
            if(!data.match(/^\d{10}$/))
              errors[key] = messages[key].mobile
          }
          // Validate pincode
          if(rules[key].pincode){
            var regex=/^\d{6}$/;
            if(!regex.test(data)){
              errors[key] = messages[key].pincode
            }
          }
          // String validation
          if(rules[key].string) {
            var regex = /^[a-zA-Z '.]*$/;
            if(!regex.test(data))
              errors[key] = messages[key].string
          }
          if(rules[key].gst){
            var regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            if(!regex.test(data)){
              errors[key] = messages[key].gst   
            }
          }
          if(rules[key].password) {
            // password should have minimum of 8 chars, at least one special char, one letter and one number
            // var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
            if(data.length < 8){
              errors[key] = messages[key].password
            }
          }
          if(rules[key].confirmPassword) {
            var password = document.getElementById('password').value;
            if(password !== data){
              errors[key] = messages[key].confirmPassword
            }
          }
        }
      }
      else{
        errors.global = "Atleast one validation rule is required"
      }
    }

    if(messages == undefined){
      errors.global = "Validation messages not specified."
    }
  }
  else{
    errors.global = "Invalid form element is supplied."
  }

  return {
    errors,
    isValid: isEmpty(errors)
  }
}
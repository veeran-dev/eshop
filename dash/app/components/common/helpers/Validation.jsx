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
          // let data = string.replace(/^\s+|\s+$/gm,'');
          console.log(data)
          console.log(messages[key])
          // Validating field is required
          if(data == "") {
            errors[key] = messages[key].required
          }
          else {
            // Validating field is numeric and is negative number
            if(rules[key].numeric){
              if(data.length > 0 && !data.match(/^[0-9]+$/))
                errors[key] = messages[key].numeric
              if(data && data == 0)
                errors[key] = "Number should be greater than zero."
              if(data && data < 0)
                errors[key] = "Negative numbers not allowed."
            }
            // Validating maximun of input size
            if(rules[key].maxlength){
              if(data.length > 0 && data.match(/^[a-zA-Z\d\-.,\s]+$/) && (data.length !== rules[key].maxlength.length))
                errors[key] = messages[key].maxlength
            }
            
            // Validating email
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

            // String validation
            if(rules[key].string) {
              var regex = /^[a-zA-Z '.]*$/;
              if(!regex.test(data))
                errors[key] = messages[key].string
            }

            //Alphanumeric with some special characters allowed validation
            if(rules[key].alphanumeric_with_symbol) {
              var letters = /^[a-zA-Z\d\-.,\s]+$/;
              if(!data.match(letters)) {
                errors[key] = messages[key].alphanumeric_with_symbol
              }
            }

            //Alphanumeric validation
            if(rules[key].alphanumeric) {
              var letters = /^[a-zA-Z0-9]+$/;
              if(!data.match(letters)) {
                errors[key] = messages[key].alphanumeric
              }
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
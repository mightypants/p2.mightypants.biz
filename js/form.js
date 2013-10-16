

function validateLength(field, min, max) {
	return field.value.length > min && field.value.length < max; 
}

function validateEmailFormat(field) {
	var regexEmail = /.+@.+\..{2,}/;
	return regexEmail.test(field.value);
}

function validateAlphaNum(field) {
	var regexAlphaNum = /.*[^\w].*/;
	return regexAlphaNum.test(field.value);
}

function validatePWChars(field) {
	var regexNum = /[0-9]/;
	var regexAlpha = /[A-Za-z]/;
	return regexNum.test(field.value) && regexAlpha.test(field.value);
}

function showInvalid(field){
	field.childNodes[1].style.color = '#f66';
	field.childNodes[5].style.display = 'inline-block';
}

function clearWarnings(field){
	field.childNodes[1].style.color = '#000';
	field.childNodes[5].style.display = 'none';
}

function validateForm(currField) {
	var validField = true;

	//check for valid e-mail address
	if (currField.getAttribute('id') == 'email') {
		var emailResult = validateEmailFormat(currField);
		if(!emailResult ){ 
			validField = false;
		}
	}
	//check for valid and unused username
	else if (currField.getAttribute('id') == 'username') {
		//var userAlphaNumResult = validateAlphaNum(currField);
		if(!validateLength(currField, 5, 16)) { 
			validField = false;
		}
	}
	else if (currField.getAttribute('id') == 'first_name') {
		//var userAlphaNumResult = validateAlphaNum(currField);
		if(!validateLength(currField, 2, 16)) { 
			validField = false;
		}
	}
	else if (currField.getAttribute('id') == 'last_name') {
		//var userAlphaNumResult = validateAlphaNum(currField);
		if(!validateLength(currField, 2, 16)) { 
			validField = false;
		}
	}
	//check for valid password, 6 or more characters
	else if (currField.getAttribute('id') == 'password') {
		var pwLengthResult = validateLength(currField, 5, 16);
		var pwCharsResult = validatePWChars(currField);
		if(!pwLengthResult || !pwCharsResult){
			validField = false;
		}
	}

	//show invalid entry warnings
	if (!validField) {
		showInvalid(currField.parentNode);
	}
}

function setupFieldValidation(currField) {
	currField.onblur = function() {
		validateForm(currField);
	}
	currField.onfocus = function() {
		clearWarnings(currField.parentNode);
	}
}

var reqFields = document.getElementsByClassName('reqTextField');

for (i = 0; i < reqFields.length; i++) {
	setupFieldValidation(reqFields[i]);
}



function validateLength(field, min, max) {
	return field.value.length > min && field.value.length < max; 
}

function validateEmailFormat(field) {
	var regexEmail = /.+@.+\..{2,}/;
	return regexEmail.test(field.value);
}

function validateAlphaNum(field) {
	var regexAlphaNum = /.*[^\w].*/;
	return !regexAlphaNum.test(field.value);
}

function validatePWChars(field) {
	var regexNum = /[0-9]/;
	var regexAlpha = /[A-Za-z]/;
	return regexNum.test(field.value) && regexAlpha.test(field.value);
}

function showInvalid(field){
	field.childNodes[1].style.color = '#f01010';
	
	if(field.childNodes[5].getAttribute('class') == 'tooltipIcon') {
		field.childNodes[5].src = '/images/tooltip_warn.png';
	} 
	else {
		field.childNodes[5].style.display = 'inline-block';
	}
}

function clearWarnings(field){
	field.childNodes[1].style.color = '#000';
	
	if(field.childNodes[5].getAttribute('class') == 'tooltipIcon') {
		field.childNodes[5].src = '/images/tooltip.png';
	} 
	else {
		field.childNodes[5].style.display = 'none';
	}
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
	//check for valid username
	else if (currField.getAttribute('id') == 'user_name') {
		var userLengthResult = validateLength(currField, 5, 16);
		var userAlphaNumResult = validateAlphaNum(currField);
		if(!userLengthResult || !userAlphaNumResult) { 
			validField = false;
		}
	}
	else if (currField.getAttribute('id') == 'first_name') {
		if(!validateLength(currField, 0, 25)) { 
			validField = false;
		}
	}
	else if (currField.getAttribute('id') == 'last_name') {
		if(!validateLength(currField, 0, 25)) { 
			validField = false;
		}
	}
	else if (currField.getAttribute('id') == 'content') {
		if(!validateLength(currField, 0, 25)) { 
			validField = false;
		}
	}

	//check for valid password, 6 or more characters
	else if (currField.getAttribute('id') == 'password') {
		var pwLengthResult = validateLength(currField, 5, 16);
		var pwCharsResult = validatePWChars(currField);
		var alphaNumResult = validateAlphaNum(currField);
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

function setupToolTips(currToolTip) {
	currToolTip.onmouseover = function() {
		currToolTip.parentNode.childNodes[7].style.display = 'block';
	}
	currToolTip.onmouseout = function() {
		currToolTip.parentNode.childNodes[7].style.display = 'none';
	}
}

var tooltips = document.getElementsByClassName('tooltipIcon'); 
for (i = 0; i < tooltips.length; i++) {
	setupToolTips(tooltips[i]);
}






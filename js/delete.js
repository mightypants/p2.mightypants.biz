	function deleteWarning(post) {
		var proceed = confirm("y'all tryin to delete me?");
		if(!proceed) {
			return false;
		}
		else {
			console.log('go ahead');
		}
	}

	function setupDeleteWarning(post) {
		post.onclick = function() {
			deleteWarning(post);
		}
	}


	var deletablePosts = document.getElementsByClassName('delPost');


	for (i = 0; i < deletablePosts.length; i++) {
		setupDeleteWarning(deletablePosts[i]);
	}
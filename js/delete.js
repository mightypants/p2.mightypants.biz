	function deleteWarning(post) {
		var proceed = confirm("Are you sure you want to delete this post?");
		if(!proceed) {
			return false;
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
	
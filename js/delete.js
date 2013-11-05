	function deleteWarning() {
		return confirm("Are you sure you want to delete this post?");
	}

	function setupDeleteWarning(post) {
		post.onclick = function() {
			var confirmDelete = deleteWarning();

			if (!confirmDelete) {
				return false;
			}
			else {
				return true;
			}
		}
	}

	var deletablePosts = document.getElementsByClassName('delPost');

	for (i = 0; i < deletablePosts.length; i++) {
		setupDeleteWarning(deletablePosts[i]);
	}

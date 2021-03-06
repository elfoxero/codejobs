$(document).on("ready", function() {
	$("#cpublish").on("click", function() {
		var content = escape($(".cke_wysiwyg_frame").contents().find('body').html());
		var content2 = $(".cke_wysiwyg_frame").contents().find('body').html();
		var fid = $('#fid').val();
		var fname = $('#fname').val();
		var avatar = $('#avatar').val();
		var needContent = '<div id="alert-message" class="alert alert-error">' + $("#needcontent").val() + '</div>';
		

		if (content.length < 30) {
			$("#comment-alert").html(needContent);
			$("#comment-alert").show();
			$("#comment-alert").hide(4000);
		}

		if (content.length > 22 && fid > 0 && content != "%3Cp%3E%26nbsp%3B%3C/p%3E" && content != "%3Cp%3E%26nbsp%3B%26nbsp%3B%3C/p%3E" && content != "%3Cp%3E%26nbsp%3B%20%26nbsp%3B%3C/p%3E" && content != "%3Cp%3E%26nbsp%3B%20%26nbsp%3B%20%26nbsp%3B%3C/p%3E" && content != "%3Cp%3E%26nbsp%3B%20%26nbsp%3B%26nbsp%3B%3C/p%3E") {
			var newComment = '';
			$.ajax({
				type: 'POST',
				url: PATH + '/forums/publishComment',
				dataType: 'json',
				data: 'fid=' + fid + '&content=' + content + '&fname=' + fname,
				success: function(response) {
					console.log(response);
					$("#comment-alert").html(response.alert);
					var oldComments = $("#forum-content").html();
					newComment = newComment + '<div class="comments">';
					newComment = newComment + '	<div class="comments-author">';
					newComment = newComment + '	  <img src="' + avatar + '" class="dotted" style="max-width: 70px;" /> ';
					newComment = newComment + '	</div>';
					newComment = newComment + '	<div class="comments-content">';
					newComment = newComment + '   <p class="comment-data">' + response.date + ' | <a href="' + response.edit + '">Edit</a> | <a href="' + response.delete + '" onclick=" return confirm(\'Do you want to delete this post?\')">Delete</a></p>';
					newComment = newComment + '   <p class="comment-post">' + content2 + '</p>';
					newComment = newComment + '	</div>';
					newComment = newComment + '</div>';
					$("#forum-content").html(oldComments + newComment);
					$("#comment-alert").show();
					$("#comment-alert").hide(4000);
					$(".cke_wysiwyg_frame").contents().find('body').html("");
				}
			});
		}
	});

	$("#fpublish").on("click", function() { 
		var fid = $("#fid").val();
		var forumName = $("#fname").val();
		var title = $("#ftitle").val();
		var tags = $("#ftags").val();
		var content = escape($(".cke_wysiwyg_frame").contents().find('body').html());
		var needTitle = '<div id="alert-message" class="alert alert-error">' + $("#needtitle").val() + '</div>';
		var needContent = '<div id="alert-message" class="alert alert-error">' + $("#needcontent").val() + '</div>';
		var needTags = '<div id="alert-message" class="alert alert-error">' + $("#needtags").val() + '</div>';

		if (tags == $("#ftags-temp").val()) {
			tags = "";
		}

		if (title.length == 0 || title == $("#ftitle-temp").val()) { 
			$("#fmessage").html(needTitle);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else if (content.length < 30 || content == $("#fcontent-temp").val()) { 
			$("#fmessage").html(needContent);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else if (tags.length == 0 || tags == $("#ftags-temp").val()) { 
			$("#fmessage").html(needTags);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else {
			$.ajax({
				type: 'POST',
				url: PATH + '/forums/publish',
				data: 'title=' + title + '&content=' + content + '&tags=' + tags + '&forumID=' + fid + '&fname=' + forumName,
				success: function(response) {
					window.location.href = response;
				}
			});
		}
	});

	$("#fcancel").on("click", function(e) {
		e.preventDefault();
		$("ftitle").focus();
		$("#ftitle").val("");
		$("#ftags").val("");
		$(".cke_wysiwyg_frame").contents().find('body').html("")
	});

	$("#pcancel").on("click", function() {
		var fname = $("#fname").val();
		$.ajax({
			type: 'POST',
			url: PATH + '/forums/cancelEdit',
			data: 'fname=' + fname,
			success: function(response) {
				window.location.href = response;
			}
		});
	});

	$("#ccancel").on("click", function() {
		var fname = $("#fname").val();
		var fid = $("#fid").val();
		$.ajax({
			type: 'POST',
			url: PATH + '/forums/cancelComment',
			data: 'fname=' + fname + '&fid=' + fid,
			success: function(response) {
				window.location.href = response;
			}
		});
	});

	$("#ppublish").on("click", function() {

		var pid = $("#pid").val();
		var fid = $("#fid").val();
		var forumName = $("#fname").val();
		var title = $("#ptitle").val();
		var tags = $("#ptags").val();
		var content = escape($(".cke_wysiwyg_frame").contents().find('body').html());
		var needTitle = '<div id="alert-message" class="alert alert-error">' + $("#needtitle").val() + '</div>';
		var needContent = '<div id="alert-message" class="alert alert-error">' + $("#needcontent").val() + '</div>';
		var needTags = '<div id="alert-message" class="alert alert-error">' + $("#needtags").val() + '</div>';
		console.log(content);
		if (tags == $("#ftags-temp").val()) {
			tags = "";
		}

		if (title.length == 0 || title == $("#ptitle-temp").val()) { 
			$("#fmessage").html(needTitle);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else if (content.length < 30 || content == $("#pcontent-temp").val()) { 
			$("#fmessage").html(needContent);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else if (tags.length == 0 || tags == $("#ptags-temp").val()) { 
			$("#fmessage").html(needTags);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else {
			$.ajax({
				type: 'POST',
				url: PATH + '/forums/updatePost',
				data: 'title=' + title + '&content=' + content + '&tags=' + tags + '&postID=' + pid + '&forumID=' + fid + '&fname=' + forumName,
				success: function(response) {
					window.location.href = response;
				}
			});
		}
	});

	$("#cedit").on("click", function() {

		var pid = $("#pid").val();
		var fid = $("#fid").val();
		var forumName = $("#fname").val();
		var content =  escape($(".cke_wysiwyg_frame").contents().find('body').html());

		console.log(content);
		var needContent = '<div id="alert-message" class="alert alert-error">' + $("#needcontent").val() + '</div>';

		if (content.length == 0 || content == $("#pcontent-temp").val()) { 
			$("#fmessage").html(needContent);
			$("#fmessage").show();
			$("#fmessage").hide(4000);
		} else {
			$.ajax({
				type: 'POST',
				url:   PATH + '/forums/updateComment',
				data: 'content=' + content + '&postID=' + pid + '&forumID=' + fid + '&fname=' + forumName,
				success: function(response) {
					console.log(response);
					window.location.href = response;
				}
			});
		}
	});
});
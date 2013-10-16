/***
HTML5 Server code below
*/
$("#msgText").keydown(function(e){
  if (e.which == 13) {
		server.sendMyChatMessage($("#msgText").val());
		$("#msgText").val("");
  }
});

function addBubble(avatar, text) {

  // Get the bytes of the image and convert it to a BASE64 encoded string and then
  // we use data URI to add dynamically the image data
  var avatarUri = "data:image/png;base64," + avatar.toBase64();

  var bubble = $('<div class="bubble-container"><span class="bubble"><img class="bubble-avatar" src="' + avatarUri + '" /><div class="bubble-text"><p>' + text + '</p></div><span class="bubble-quote" /></span></div>');
  $("#msgText").val("");

  $(".bubble-container:last")
  .after(bubble);

  if (bubbles >= maxBubbles) {
  	var first = $(".bubble-container:first")
  	.remove();
  	bubbles--;
  }

  bubbles++;
  $('.bubble-container').show(250, function showNext() {
  	if (!($(this).is(":visible"))) {
  		bubbles++;
  	}

  	$(this).next(".bubble-container")
  	.show(250, showNext);

  	$("#wrapper").scrollTop(9999999);
  });
}
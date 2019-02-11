

$(function()
{
  var ws = new WebSocket('ws://localhost:8080/');

  var defaultChannel = 'general';
  var userName = $('#user').val();
  ws.onopen = function () {
    ws.send(JSON.stringify({
      action: 'subscribe',
      channel: defaultChannel,
      user: userName
    }));
  };

  ws.onmessage = function (event) {
    addMessageToChannel(event.data);
  };

  ws.onclose = function () {
    botMessageToGeneral('Connection closed');
  };

  ws.onerror = function () {
    botMessageToGeneral('An error occured!');
  };


  $('#send-btn').click(function(){
    sendTextInputContent();
  });

  $('#message').keyup(function(e) {
    var enterKeyCode = 13;
    if (e.keyCode === enterKeyCode) {
      sendTextInputContent();
    }
  });


});

function addMessageToChannel (message) {
  $('#history').append('<div class="message">' + message + '</div>');
}

function botMessageToGeneral (message) {
  var defaultChannel = 'general';
  var botName = 'ChatBot';

  return addMessageToChannel(JSON.stringify({
    action: 'message',
    channel: defaultChannel,
    user: botName,
    message: message
  }));
}

function sendTextInputContent() {
  // Get text input content
  var content = $('#message').val();
  var userName = $('#user').val();
  
  // Send it to WS
  ws.send(JSON.stringify({
    action: 'message',
    user: userName,
    message: content,
    channel: 'general'
  }));

  // Reset input
  $('#message').val('');
};
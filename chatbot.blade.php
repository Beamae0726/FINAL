<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>AntiFakeNews</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/dc98551fc7.js" crossorigin="anonymous"></script>
  <style>
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      width: 100%;
    }

    .card {
      width: 100%;
    }

    .card-header,
    .card-body,
    .card-footer {
      width: 100%;
    }

    .chat-history {
      overflow-y: auto;
      max-height: 400px;
    }

    .progress-loader {
      display: none;
      text-align: center;
      padding: 10px;
    }

    .alert-info {
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Fake News Chat Interface</div>
          <div class="card-body chat-history">
            <div class="progress-loader"></div>
            <!-- Chat history content here -->
          </div>
          <div class="card-footer chat-input">
            <div class="input-group">
              <input id="chat-input" type="text" class="form-control" placeholder="Type a question...">
              <div class="input-group-append">
                <button id="send-button" class="btn btn-primary" type="button">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
  $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    // Random greetings array
    var greetings = [
      'Hello!',
      'Hi there!',
      'Greetings!',
      'Welcome!',
      'Nice to meet you!'
    ];

    // Get a random greeting
    function getRandomGreeting() {
      var randomIndex = Math.floor(Math.random() * greetings.length);
      return greetings[randomIndex];
    }

    // Handle send button click event
    $('#send-button').click(function() {
      var question = $('#chat-input').val();
      if (question.trim() !== '') {
        // Send AJAX request to the Laravel backend
        $.ajax({
          url: '{{route('question') }}', // Replace with your Laravel route URL
          method: 'POST',
          data: { question: question },
          beforeSend: function() {
            // Show the progress loader message
            var loaderMessage = $('<div>').addClass('alert alert-info').attr('role', 'alert').text('Thinking...');
            $('.chat-history').append(loaderMessage);

            // Scroll to the bottom of the chat history
            $('.chat-history').scrollTop($('.chat-history')[0].scrollHeight);
          },
          success: function(response) {
            // Remove the progress loader message
            $('.alert-info').remove();

            // Handle the response from the backend
            handleResponse(response);
          },
          error: function() {
            // Remove the progress loader message
            $('.alert-info').remove();

            // Handle error case
            alert('An error occurred during the request.');
          }
        });
      }
    });

    // Handle enter key press event
    $('#chat-input').keypress(function(event) {
      if (event.which === 13) { // 13 is the key code for the enter key
        $('#send-button').click();
        event.preventDefault();
      }
    });

    // Function to handle the response from the backend
    function handleResponse(response) {
      // Get the question from the input field
      var question = $('#chat-input').val().trim();

      // Clear the input field
      $('#chat-input').val('');

      // Append the response to the chat history
      var chatHistory = $('.chat-history');
      var alertClass = response.message === 'Fake' ? 'alert-danger' : 'alert-info';
      var message = $('<div>').addClass('alert ' + alertClass).attr('role', 'alert').html('<h5 class="alert-heading">' + question + '</h5><hr><p>' + response.message + '</p>');

      chatHistory.append(message);

      // Scroll to the bottom of the chat history
      chatHistory.scrollTop(chatHistory[0].scrollHeight);

      // Process additional response data
      if (response.articles.length > 0) {
        // Append article information to the chat history
        var articles = $('<div>').addClass('alert alert-primary').attr('role', 'alert').text('Articles:');
        response.articles.forEach(function(article) {
          var articleInfo = $('<p>').html(article.title + '<br>' + article.details);

          articles.append(articleInfo);
        });
        chatHistory.append(articles);
      }

      if (response.reliable_sources.length > 0) {
        // Append reliable source information to the chat history
        var reliableSources = $('<div>').addClass('alert alert-secondary').attr('role', 'alert').text('Reliable Sources:');
        response.reliable_sources.forEach(function(source) {
          var sourceInfo = $('<p>').html('<a href="' + source.source_url + '">' + source.source_url + '</a>');

          reliableSources.append(sourceInfo);
        });
        chatHistory.append(reliableSources);
      }
    }

    // Display a random greeting on page load
    var randomGreeting = getRandomGreeting();
    var chatHistory = $('.chat-history');
    var greetingMessage = $('<div>').addClass('alert alert-info').attr('role', 'alert').html('<p>' + randomGreeting + '</p>');
    chatHistory.append(greetingMessage);
    chatHistory.scrollTop(chatHistory[0].scrollHeight);
  });
  </script>
</body>
</html>


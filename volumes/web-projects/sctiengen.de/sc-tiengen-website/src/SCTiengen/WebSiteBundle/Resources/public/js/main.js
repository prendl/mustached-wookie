$(document).ready(function() {
  $('.trigger-toggle-login-box').on('click', function($event) {
    $event.preventDefault();
    $('#login-box').toggle();
  });
  
  $('a[href^="http://"]').attr('target', '_blank');
});

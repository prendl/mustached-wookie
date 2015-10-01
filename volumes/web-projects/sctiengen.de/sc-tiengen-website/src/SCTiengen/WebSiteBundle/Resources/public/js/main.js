$(document).ready(function() {
  $('.trigger-toggle-login-box').on('click', function($event) {
    $event.preventDefault();
    $('#login-box').toggle();
  });
  
  $('a[href^="http://"],a[href^="https://"]').attr('target', '_blank');
  
  /*
  var dummyData = [
   {
     "start": "2015-05-15T17:30:00-02:00",
     "end": "2015-05-15T18:30:00-02:00",
     "title": "G-Junioren",
     "type": "Training",
     "desc": "Sportplatz Tiengen"
   },
   {
     "start": "2015-05-15T17:00:00-02:00",
     "end": "2015-05-15T19:00:00-02:00",
     "title": "A-Junioren",
     "type": "Training",
     "desc": "Sportplatz Tiengen"
   },
   {
     "start": "2015-05-15T17:00:00-02:00",
     "end": "2015-05-15T19:00:00-02:00",
     "title": "B-Junioren",
     "type": "Training",
     "desc": "Sportplatz Tiengen"
   },
   {
     "start": "2015-05-15T17:00:00-02:00",
     "end": "2015-05-15T19:00:00-02:00",
     "title": "C-Junioren",
     "type": "Training",
     "desc": "Sportplatz Tiengen"
   }
  ];
  
  var fetchDataBuilder = function(dataUrl) {
    return function(start, count) {
      var data = [];
      if (start < dummyData.length) {
        var end = Math.min(start + count, dummyData.length);
        data = dummyData.slice(start, end);
      }
      console.log('%d, %d, %d', start, count, data.length);
      this.updateCache(start, data);
    };
  };
  
  var updateContent = function(domEl, data) {
    console.log('%s %s', domEl, data);
    if (!data) {
      return;
    }
    $(domEl).html('<div class="event"><div class="title">' + data.title + '</div></div>');
  };
  
  $('.scroll-wrapper').each(function() {
    var $wrapper = $(this), dataUrl = $wrapper.data('dataUrl'), iscroll;
    iscroll = new IScroll(
      $wrapper.get(0), {
      mouseWheel: true,
      infiniteElements: $('.list-group-item', $wrapper).get(),
      dataset: fetchDataBuilder(dataUrl),
      dataFiller: updateContent,
      cacheSize: 10
    });
    $wrapper.data('iscroll', iscroll);
  });
  */
  
  $('.scroll-wrapper').each(function() {
    var $wrapper = $(this), iscroll;
    iscroll = new IScroll(
      $wrapper.get(0), {
      mouseWheel: true
    });
    $wrapper.data('iscroll', iscroll);
  });
  
  $('.trigger-event-category-filter input[type="checkbox"]').on('change', function($event) {
    var $el = $(this), category = $el.data('category');
    $('.event.event-category-' + category).toggle(!$el.prop('checked'));
  });
});

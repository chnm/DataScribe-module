$(document).ready(function() {
  
  // Applies panning and zooming functionality to media viewer. 
  var applyPanzoom = function(element) {
      var container = element.parent();
      if (!container.hasClass('image')) {
          return;
      }
      $panzoom = element.panzoom({
          $zoomIn: container.find(".zoom-in"),
          $zoomOut: container.find(".zoom-out"),
          $reset: container.find(".reset"),
          maxScale: 20
      });
      container.on('mousewheel.focal', function(e) {
          e.preventDefault();
          var delta = e.delta || e.originalEvent.wheelDelta;
          var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
          $panzoom.panzoom('zoom', zoomOut, {
              increment: 0.1,
              animate: false,
              focal: e
          });
      });
  }

  applyPanzoom($('.media-render'));
  
  // Allows media to be rotated.
  var setRotation = function(obj, direction) {
      var matrix = obj.css("-webkit-transform")
          || obj.css("-moz-transform")
          || obj.css("-ms-transform")
          || obj.css("-o-transform")
          || obj.css("transform");
      if (matrix !== 'none') {
          var values = matrix.split('(')[1].split(')')[0].split(',');
          var a = values[0];
          var b = values[1];
          var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
      } else {
          var angle = 0;
      }
      var currentRotation = (angle < 0) ? angle + 360 : angle;
      var newRotation = (direction == 'left') ? currentRotation - 90 : currentRotation + 90;
      obj.css('transform', 'rotate(' + newRotation + 'deg)');
  }

  $('.panzoom-container').on('click', '.rotate-left', function(e) {
      e.preventDefault();
      var panzoomImg = $(this).parents('.panzoom-container').find('img');
      setRotation(panzoomImg, 'left');
  });

  $('.panzoom-container').on('click', '.rotate-right', function(e) {
      e.preventDefault();
      var panzoomImg = $(this).parents('.panzoom-container').find('img');
      setRotation(panzoomImg, 'right');
  });

  $('.panzoom-container').on('click', '.reset', function(e) {
      e.preventDefault();
      var panzoomImg = $(this).parents('.panzoom-container').find('img');
      panzoomImg.css('transform', 'none');
  });
  
  // Manages a select that switches the active media being viewed.

  var currentImage = $('.media-render img');
  var mediaSelect = $('.media-select select');
  var mediaCount = $('.media-select select option').length;
  var mediaSelectNumber = $('.media-select input[type="number"]');
  var mediaPrevButton = $('.media-select .previous.button');
  var mediaNextButton = $('.media-select .next.button');

  var replaceImage = function(mediaUrl, mediaText, mediaIndex, mediaSelectorType) {
      $.get(mediaUrl, function(data) {
        currentImage.attr('src', mediaUrl);
        currentImage.attr('title', mediaText);
        $('.reset').trigger('click');
      });    

      if (mediaSelectorType !== 'select') {
        mediaSelect.val(mediaUrl);          
      }

      if ((mediaSelectorType !== 'number') && (mediaSelectNumber.val() !== mediaIndex)) {
        mediaSelectNumber.val(mediaIndex);
      }
      
      if (mediaSelectNumber.val() == 1) {
        mediaPrevButton.addClass('inactive').attr('disabled', true);
      } else {
        mediaPrevButton.removeClass('inactive').attr('disabled', false);
      }
      if (mediaSelectNumber.val() == mediaCount) {
        mediaNextButton.addClass('inactive').attr('disabled', true);
      } else {
        mediaNextButton.removeClass('inactive').attr('disabled', false);
      }
  }
  
  var activateMediaPaginationNumber = function(mediaNumber) {
      var mediaIndex = mediaNumber.val();
      var mediaOption = $('.media-select select option:nth-child(' + mediaIndex + ')');
      replaceImage(mediaOption.val(), mediaOption.text(), 'number');
  }
  
  mediaSelect.change(function() {
      var mediaUrl = $(this).val();
      var mediaText = $(this).text();
      var mediaIndex = $(this).find(':selected').index() + 1;
      replaceImage(mediaUrl, mediaText, mediaIndex, 'select');
  });
  
  mediaSelectNumber.keypress(function(e) {
      if (e.keyCode == 13) {
          activateMediaPaginationNumber($(this));
      }
  });
  
  mediaSelectNumber.change(function() {
      activateMediaPaginationNumber($(this));
  });
  
  mediaPrevButton.click(function() {
      var oldMediaIndex = $('.media-select option:selected').index();
      var newMediaOption = $('.media-select select option:nth-child(' + oldMediaIndex + ')');
      if (mediaSelectNumber.val() !== oldMediaIndex) {
        mediaSelectNumber.val(oldMediaIndex);
      }
      replaceImage(newMediaOption.val(), newMediaOption.text(), oldMediaIndex, 'button');
  });

  mediaNextButton.click(function() {
      var oldMediaIndex = $('.media-select option:selected').index();
      var newMediaIndex = oldMediaIndex + 2;
      var newMediaOption = $('.media-select select option:nth-child(' + newMediaIndex + ')');
      replaceImage(newMediaOption.val(), newMediaOption.text(), newMediaIndex, 'button');
  });
});
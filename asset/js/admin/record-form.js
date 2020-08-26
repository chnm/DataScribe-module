$(document).ready(function() {

$('.set-null-checkbox input[type="checkbox"]').on('change', function(e) {
    var fieldset = $(this).closest('fieldset');
    var inputs = fieldset.find('div.value-elements :input');
    inputs.prop('disabled', !fieldset.hasClass('set-to-null'));
    fieldset.toggleClass('set-to-null');
});

$('.previous-next-toggle').click(function() {
    var container = $(this).parents('.tablesaw-swipe-wrapper');
    container.toggleClass('collapsed');
});

// Handle record position change control.
var directionSelect = $('#position_change_direction');
var recordIdSelect = $('#position_change_record_id');
recordIdSelect.hide();
directionSelect.on('change', function(e) {
    if ('' === directionSelect.val()) {
        recordIdSelect.hide();
    } else {
        recordIdSelect.show();
    }
});

$('.open-guidelines').click(function() {
    $('.guidelines-container').removeClass('closed');
});

$('.close-guidelines').click(function() {
    $('.guidelines-container').addClass('closed');
});

// Lose input focus on scroll so the page scrolls instead of the input value.
$(document).on('wheel', 'input[type=number]', function (e) {
    $(this).blur();
});

var fastEntryButton = $('.fast-entry-mode');
fastEntryButton.on('click', e => {
    $('.common-elements').toggleClass('hidden');
    if ($('.common-elements').hasClass('hidden')) {
      fastEntryButton.text(Omeka.jsTranslate('Disable fast entry mode'));
    } else {
      fastEntryButton.text(Omeka.jsTranslate('Enable fast entry mode'));
    }
});

});

jQuery(function ($) {
  if ($('#adv-settings .columns-prefs-3 input').is(':checked')) {
    $('#post-body').removeClass('columns-2').addClass('columns-3');
  }

  $('#left-sortables, #right-sortables, #column3-sortables').on('sortactivate', function(event, ui) {
    $(this).addClass('sortable-bump');
  }).on('sortdeactivate', function(event, ui) {
    $(this).removeClass('sortable-bump');
  });
});
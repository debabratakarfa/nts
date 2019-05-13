$ = jQuery.noConflict();

$('a.nts__vote__click').click(function (event) {
  event.preventDefault();
  var post_id   = $(this).data('id');
  var vote_type = $(this).data('vote');
  // This does the ajax request
  $.ajax({
    url : nts_ajax_obj.ajaxurl,   // or example_ajax_obj.ajaxurl if using on frontend
    data: {
      'action': 'nts_ajax_request',
      'id'    : post_id,
      'type'  : vote_type
    },
    success: function (data) {
      // This outputs the result of the ajax request
      if (data.data.type == 'positive') {
        $('#pCount').html(data.data.count);
      } else if (data.data.type == 'negative') {
        $('#nCount').html(data.data.count);
      }
      $('#pollTotal').html(data.data.total);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    }
  });
});


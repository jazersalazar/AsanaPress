jQuery(document).ready(function($) {
  
  $('.subtask-add').click(function() {
    let subtask = '<tr>\
                    <td><input name="asanawp_subtasks[]"></td>\
                    <td><a href="javascript:void(0);" class="subtask-remove">Remove</a></td>\
                  </tr>';
    $('#asanawp_subtasks tbody').append( subtask );
  });

  $(document).on('click', '.subtask-remove', function() {
    // Fetch two level parent since parents are getting root table instead
    $(this).parent().parent().remove();
  });

});
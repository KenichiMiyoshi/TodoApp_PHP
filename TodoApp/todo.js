$(function() {
  'use strict';

  $('#new_todo').focus();

  // update
  $('#todos').on('click', '.update_todo', function() {
    // idを取得
    var id = $(this).parents('li').data('id');
    // ajax処理
    $.post('_ajax.php', {
      id: id,
      mode: 'update',
      token: $('#token').val()
    }, function(res) {
      if (res.status === '1') {
        $('#todo_' + id).find('.todo_task').addClass('done');
      } else {
        $('#todo_' + id).find('.todo_task').removeClass('done');
      }
    })
  });

  // delete
  $('#todos').on('click', '.delete_todo', function() {
    // idを取得
    var id = $(this).parents('li').data('id');
    // ajax処理
    if (confirm('Do you want to delete the task?')) {
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        token: $('#token').val()
      }, function() {
        $('#todo_' + id).fadeOut(800);
      });
    }
  });

  // create
  $('#new_todo_form').on('submit', function() {
    //入力フォームが空かスペース・改行のみか判断
    if (!$('#new_todo').val().match(/\S/g) || $('#new_todo').val() == null) {
      alert('Please enter task!');
    } else {
      // taskを取得
      var task = $('#new_todo').val();
      // ajax処理
      $.post('_ajax.php', {
        task: task,
        mode: 'create',
        token: $('#token').val()
      }, function(res) {
        // liを追加
        var $li = $('#todo_template').clone();
        $li
          .attr('id', 'todo_' + res.id)
          .data('id', res.id)
          .find('.todo_task').text(task);
        $('#todos').prepend($li.fadeIn());
        $('#new_todo').val('').focus();
      });
      return false;
    }
  });
});

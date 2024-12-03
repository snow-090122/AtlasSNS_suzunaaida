// accordion-menu
$(function () {
  $('.triangle-btn').click(function () {
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $('.accordion-menu').addClass('active');
    } else {
      $('.accordion-menu').removeClass('active');
    }
  });
});


// modal
$(function () {
  $('.modalOpen').each(function () {
    $(this).on('click', function () {
      $('.modal-main').fadeIn();
      var post = $(this).attr('post');
      var post_id = $(this).attr('post_id');
      $('.edit-post').val(post);
      $('.edit-id').val(post_id);
      return false;
    });

    $('.modal-inner').on('click', function () {
      $('.modal-main').fadeOut();
      return false;
    });
  });
});

// modal-validate
$(function () {
  $('#modal-form').validate({
    rules: {
      editpost: {
        required: true, minlength: 1, maxlength: 150,
      },
    },
    messages: {
      editpost: {
        required: '投稿は1文字以上150文字以内で編集してください。',
        minlength: '投稿は1文字以上150文字以内で編集してください。',
        maxlength: '投稿は1文字以上150文字以内で編集してください。',
      },
    },

    errorClass: "red center",
    errorElement: "p",

    errorPlacement: function (error, element) {
      error.insertAfter(element)
    },

  });
});

if (user && user.username) {
  console.log(user.username);
} else {
  console.log('Username not found');
}

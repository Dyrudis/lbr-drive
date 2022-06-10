
$('.btn-modif').click(function() {
    $('.creation').addClass('remove-section');
      $('.modif').removeClass('active-section');
      $('.delete').addClass('delete-section');
    $('.btn-modif').removeClass('active');
    $('.btn-delete').addClass('active');
    $('.btn-creation').addClass('active');
  });
  
  $('.btn-creation').click(function() {
    $('.creation').removeClass('remove-section');
      $('.modif').addClass('active-section');
      $('.delete').addClass('delete-section');
    $('.btn-creation').removeClass('active');
    $('.btn-modif').addClass('active');
    $('.btn-delete').addClass('active');
  });

  $('.btn-delete').click(function() { 

    if($('.btn-delete').hasClass('active')){
      $('.creation').addClass('remove-section');
      $('.modif').addClass('active-section');
      $('.delete').removeClass('delete-section');
      $('.btn-delete').removeClass('active');
      $('.btn-creation').addClass('active');
      $('.btn-modif').addClass('active');
    }

  });
$(function () {

  let num = 0;

  $('#append').on('click', function(){
    num++;
    $('#good').text('👍' + num);
  });
  
});
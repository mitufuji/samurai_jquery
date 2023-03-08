$(function () {
    let like = $('.button'); 
    let likePostId; 
    like.on('click', function () { 
      let $this = $(this); 
      likePostId = $this.data('post-id'); 
      
      $.ajax({
        headers: { 
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },  
        url: '/like', 
        method: 'POST', 
        data: { 
          'post_id': likePostId 
        },
      })
      
      .done(function (data) {
        $this.next('.like-counter').html(data.post_likes_count);
      })
      
      .fail(function () {
        console.log('fail'); 
      });
    });
});
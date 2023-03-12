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
        url: '/laravel-samuraimart/public/likes', 
        method: 'POST', 
        data: { 
          'post_id': likePostId 
        },
      })
      
      .done(function (data) {
        $this.next('.like-counter').html(data.post_likes_count);
      })
      
      .fail(function(jqXHR, textStatus, errorThrown){
        console.log('fail'); 
        console.log("ajax通信に失敗しました");
                    console.log("jqXHR          : " + jqXHR.status); 
                    console.log("textStatus     : " + textStatus);    
                    console.log("errorThrown    : " + errorThrown.message); 
                    // console.log("URL            : " + url);
      });
    });
});
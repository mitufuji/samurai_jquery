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
        url: '/likes', 
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
                    console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                    console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                    console.log("errorThrown    : " + errorThrown.message); // 例外情報
                    console.log("URL            : " + url);
      });
    });
});
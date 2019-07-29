$(document).ready(function () {
        $('.trigger').on('click',function(){
           if($(this).find('i').hasClass('down')){
            $(this).find('i').addClass('up').removeClass('down');
            $(this).parent().parent().find('.hidden').slideDown(200);
           }else{
            $(this).find('i').removeClass('up').addClass('down');
            $(this).parent().parent().find('.hidden').slideUp(200);
           }
        });

        setInterval(function(){ 
            var id = $(".tweets_container:first-child").attr("rel");
            var handle = $('.twitter_handle').val();
            checkForNewTweets(id,handle); 
        }, 30000);

        function checkForNewTweets(tweet_id,tweet_handle){

            $("#show_messages").hide().html('Checking for new Tweets...').fadeIn(200);
            var id_ready = encodeURIComponent(JSON.stringify(tweet_id));
            var handle_ready = encodeURIComponent(JSON.stringify(tweet_handle));
            $.ajax({
              type:'POST',
              url:ajaxurl,
              data:{_token:token, id:id_ready, handle:handle_ready},
              success:function(data){
                if(data.status!='no-change'){
                  $("#show_messages").hide().html('No new tweets found').fadeIn(200).delay(2000).slideUp(500);
                }else{
                  $("#show_messages").hide().html('New Tweet found, refreshing ...').fadeIn(200,function(){location.reload();});
                }
              }
            });
        }   
});
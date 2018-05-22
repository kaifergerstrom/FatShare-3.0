$("#add-new-chat-btn").click(function()
{
   $('#options_container').fadeOut(0);
   $('.new-chat-btn-block').fadeOut(0);
   $('.create-chat-form').fadeIn(500);

});

$("#remove-chat-btn").click(function()
{

   $('.create-chat-form').hide(0);
   $('#options_container').fadeIn(500);
   $('.new-chat-btn-block').fadeIn(500);

});
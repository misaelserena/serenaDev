$(document).ready( function(){

   $('#show').attr('checked', false);

   $('#show').click(function(){

      name = $('#password').attr('name');
      value = $('#password').attr('value');
      if($(this).attr('checked'))
      {
         html = '<input type="text" name="'+ name + '" value="' + value + '" id="password"/>';
         $('#password').after(html).remove();
      }
      else
      {
         html = '<input type="password" name="'+ name + '" value="' + value + '" id="password"/>';
         $('#password').after(html).remove();
      }
   });
});
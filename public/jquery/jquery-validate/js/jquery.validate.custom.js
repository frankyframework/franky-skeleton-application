
$(window).load(function(){
    jQuery.validator.addMethod("ValidaCaracteres", function(value,element) {


        var checkOK = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" + "abcdefghijklmnopqrstuvwxyz-_.";
         var checkStr = value;
         var allValid = true;

       for (i = 0; i < checkStr.length; i++)
       {
              ch = checkStr.charAt(i);
              for (j = 0; j < checkOK.length; j++)
           if (ch == checkOK.charAt(j))
           break;
              if (j == checkOK.length)
           {
                  allValid = false;
                  break;
             }
         }

       if (!allValid)
       {
             return false;
       }
       else
       {
           return true;
       }

   }, jQuery.validator.format("Existen caracteres no permitidos para este campo"));

   jQuery.validator.addMethod("name-validation", function(value,element) {


       var regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;

       return  regex.test(value);
   }, jQuery.validator.format("El campo contiene caracteres no v&acute;lidos"));


});
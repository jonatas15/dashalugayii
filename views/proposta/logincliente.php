<html lang="en">
  <head>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="846905942616-kt48f6bklj96nneoh2u1kair9hssj2b8.apps.googleusercontent.com">
    <!-- JFKXBhnirYgf_RjVZtM0Flhq -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </head>
  <body>
    <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    <a href="#" onclick="signOut();">Sign out</a>
    <div id="msg">

    </div>
    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile   = googleUser.getBasicProfile();
        var userId    = profile.getName();
        var userName  = profile.getGivenName();
        var userImage = profile.getImageUrl();
        var userEmail = profile.getEmail();
        var userToken = googleUser.getAuthResponse().id_token;
        /*
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
        */

        if(userEmail !== '') {
            var dados = {
                userId: userId,
                userName: userName,
                userEmail: userEmail,
                userImage: userImage,
            };
            $.post('valida', dados, function(eee){
                $('#msg').html("sss"+eee);
            });
        }



      }
      function signOut() {
          var auth2 = gapi.auth2.getAuthInstance();
          auth2.signOut().then(function () {
            console.log('User signed out.');
          });
      }
    </script>

  </body>
</html>

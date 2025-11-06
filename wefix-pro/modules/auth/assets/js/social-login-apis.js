document.addEventListener("DOMContentLoaded", function () {
  // -------------------------------------------
  // FACEBOOK LOGIN SETUP
  // -------------------------------------------
  if (
    typeof wefix_social_api !== "undefined" &&
    wefix_social_api.facebook_app_id
  ) {
    window.fbAsyncInit = function () {
      FB.init({
        appId: wefix_social_api.facebook_app_id,
        cookie: true,
        xfbml: false,
        version: "v19.0",
      });
      FB.AppEvents.logPageView();
    };

    (function (d, s, id) {
      var js,
        fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    })(document, "script", "facebook-jssdk");

    window.fbLogin = function () {
      document.cookie =
        "wefix_fb_redirect=" +
        encodeURIComponent(window.location.href) +
        "; path=/; max-age=300";

      FB.login(
        function (response) {
          if (response.authResponse) {
            fetchUserProfile(response);
          } else {
            alert("Facebook login was cancelled.");
          }
        },
        { scope: "public_profile,email" }
      );
    };

    function fetchUserProfile(response) {
      const accessToken = response.authResponse.accessToken;
      FB.api(
        "/me",
        {
          fields: "name,email",
          access_token: accessToken,
        },
        function (user) {
          fetch(wefix_social_api.ajax_url, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              action: "facebook_login_callback",
              name: user.name,
              email: user.email || "",
              id: user.id,
              token: accessToken,
            }),
          })
            .then((res) => res.json())
            .then((data) => {
              handleLoginRedirect(data);
            })
            .catch((error) => {
              console.error("Error during Facebook login AJAX:", error);
              alert("Something went wrong.");
            });
        }
      );
    }
  }
  // -------------------------------------------
  // GOOGLE LOGIN USING CUSTOM BUTTON (POPUP FLOW)
  // -------------------------------------------
  if (typeof wefix_social_api !== "undefined" && wefix_social_api.google_client_id) {
    window.googleLogin = function () {
      // Save current URL to restore after login
      document.cookie = "wefix_google_redirect=" + encodeURIComponent(window.location.href) + "; path=/; max-age=300";

      // Construct Google OAuth 2.0 URL
      const authUrl = "https://accounts.google.com/o/oauth2/v2/auth?" + new URLSearchParams({
        client_id: wefix_social_api.google_client_id,
        redirect_uri: "https://wdtwefix.wpengine.com/google-login-callback/", // ✅ must be registered in Google Console
        response_type: "id_token",
        scope: "openid email profile",
        nonce: Math.random().toString(36).substring(2),
        prompt: "select_account",
        response_mode: "fragment"
      });

      // Open Google login popup
      const popup = window.open(authUrl, "googleLoginPopup", "width=500,height=600");

      // Fallback in case the popup is blocked
      if (!popup) {
        alert("Popup blocked. Please allow popups for this site.");
        return;
      }

      // Listen for message from callback window
      const listener = function (event) {
        if (
          event.origin === window.location.origin &&
          event.data &&
          event.data.type === "google_id_token"
        ) {
          window.removeEventListener("message", listener);

          const idToken = event.data.token;

          // Send ID token to WordPress backend
          fetch(wefix_social_api.ajax_url, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              action: "google_login_handler",
              id_token: idToken,
            }),
          })
            .then((res) => res.json())
            .then((data) => {
              handleLoginRedirect(data); // your redirect handler
            })
            .catch((error) => {
              console.error("Google login error:", error);
              alert("Something went wrong during login.");
            });
        }
      };

      window.addEventListener("message", listener);
    };
  }


  // -------------------------------------------
  // Common Redirect Handler
  // -------------------------------------------
  function handleLoginRedirect(data) {
	if (data.success && data.data && data.data.status === true) {
		const d = data.data;
		const isNewUser = d.newuser === true || d.profileupdate === true;
		const fallback = window.location.href;

		const redirectUrl = isNewUser
			? (d.redirect_url || wefix_social_api.new_user_redirect || fallback)
			: (d.redirect_url || wefix_social_api.redirect_url || fallback);

		if (isNewUser) {
			const url = new URL(redirectUrl, window.location.origin);
			url.searchParams.set("profileupdate", "1");
			window.location.href = url.toString();
		} else {
			window.location.href = redirectUrl;
		}
	} else {
		const errorMsg =
			typeof data.message === "string" ? data.message : "Login failed.";
		alert(errorMsg);
	}
}
});

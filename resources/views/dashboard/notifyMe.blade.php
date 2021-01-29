<button onclick="notifyMe()">notifyMe()</button>

    <script src="https://www.gstatic.com/firebasejs/3.7.2/firebase.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>


function notifyMe() {
   // alert(0);
  // Let's check if the browser supports notifications
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have already been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    var notification = new Notification("Hi mohamed!");
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== "denied") {
    Notification.requestPermission().then(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        var notification = new Notification("mohamed!");
      }
    });
  }

  // At last, if the user has denied notifications, and you 
  // want to be respectful there is no need to bother them any more.
}




</script>
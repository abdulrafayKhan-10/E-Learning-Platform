<?php 
session_start();
if((isset($_SESSION['lc_username']) && isset($_SESSION['lc_email'])) || (isset($_COOKIE['lc_username']) && isset($_COOKIE['lc_email']))){
  $lc_username = $_SESSION['lc_username'];
  $lc_email = $_SESSION['lc_email'];
  setcookie("lc_username", $lc_username , time() + (86400 * 30), "/"); 
 setcookie("lc_email", $lc_email , time() + (86400 * 30), "/"); 
  
}
else{
  header('location: ../../contact.php');
  exit();
}
 
 
if(isset($_POST['btnEnd'])){
  unset($_SESSION["lc_username"]);
  unset($_SESSION["lc_email"]);
    setcookie("lc_username", "", time() - 3600, "/");
    setcookie("lc_email", "", time() - 3600, "/");
    header('location: ../../contact.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat</title>
   
    <link rel="stylesheet" href="./chat.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
</head>
<body>

<div class="page-content page-container" id="page-content">
    <div class="padding" >
        <div class="row container d-flex justify-content-center " >
        <div class="col-lg-12 col-md-12 col-sm-12 " >
            <div class="card card-bordered"  style="width: 100% !important;" >
              <div class="card-header">
                <h4 class="card-title pt-3"><strong>Live Chat With Admin</strong></h4>
             
              </div>


              <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important; width: 100% !important">
               

             

              <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div></div></div>

              <div class="publisher bt-1 border-light">
                <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                <input class="publisher-input" type="text" id="user_messagebox" placeholder="Write something">
               <button class="publisher-btn text-info" href="#" data-abc="true" onclick="sendMessage('Anonymous')"><i class="fa fa-paper-plane"></i></button>
              </div>

             </div>
          </div>
        </div>
        <form action="" method="POST">
        <input type="submit" name="btnEnd" class="btn btn-danger mx-3" value="End Chat">
        </form>
      </div>
          </div>
         

          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script>

          function fetchMessages() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_messages.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var new_message = xhr.responseText;
        var chatContainer =  document.getElementById("chat-content");
        chatContainer.innerHTML = new_message;
        chatContainer.scrollTop = chatContainer.scrollHeight;
      }
    };
    xhr.send();
  }
  
  function sendMessage(user) {
    var message = document.getElementById('user_messagebox').value.trim();
    if (message !== "") {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "send_message.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          fetchMessages(); // Refresh chat after sending message
          document.getElementById('user_messagebox').value = ""; // Clear input field
        }
      };
      xhr.send("user=" + user + "&message=" + encodeURIComponent(message));
    }
  }
  
  
  document.addEventListener("DOMContentLoaded", function() {
    fetchMessages(); // Fetch initial messages asynchronously when the page loads
    setInterval(fetchMessages, 2000); // Fetch new messages periodically
  });            
          </script>
</body>
</html>

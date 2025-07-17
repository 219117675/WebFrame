<!-- Home Page -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UniEvents - Home</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="assets/js/script.js" defer></script>
</head>
<body>
<header>
  <div class="logo">
    <a href="{{url('/')}}"><img src="assets/images/logo.png" alt="Logo"></a>
  </div>
  <nav>
    <ul>
      <li><a href="{{url('/')}}">Home</a></li>
      <li><a href="{{url('/event')}}">Events</a></li>
      <li><a href="{{url('/about')}}">About Us</a></li>
      <li><a href="{{url('/contact')}}">Contact Us</a></li>
      <li id="authLink"><a href="{{url('/register')}}">Login/Register</a></li>
      <li id="dashboardLink" style="display:none;"><a href="{{url('/dashboard')}}">Dashboard</a></li>
      <li id="logoutBtn" style="display:none;"><a href="#" onclick="logout()">Logout</a></li>
    </ul>
    <input type="text" id="search" placeholder="Search Events..." />
  </nav>
</header>
{{ $slot }}


<footer>
  <p>&copy; 2025 UniEvents. All rights reserved.</p>
</footer>
</body>
</html>


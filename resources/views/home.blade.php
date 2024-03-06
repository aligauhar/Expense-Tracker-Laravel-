<!DOCTYPE html>
<html lang="en">

<head>
    <title>Expense Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #2e2c2c; /* Dark brownish-grey background color */
            color: #ffffff; /* Light text color */
        }

        .navbar {
            background-color: #5c5a5a; /* Darker navbar background color */
        }

        .container {
            margin-top: 20px;
        }

        h1 {
            color: #ffffff; /* Light text color for headings */
        }

        p {
            color: #d6d6d6; /* Slightly lighter text color for paragraphs */
        }

        .card {
            background-color: #383636; /* Darker card background color */
            color: #ffffff; /* Light text color for card content */
            border: none; /* Remove card border for a cleaner look */
            transition: transform 0.3s; /* Add a smooth transition effect on hover */
        }

        .card:hover {
            transform: scale(1.02); /* Enlarge the card slightly on hover for a subtle effect */
        }

        .card-title {
            color: #ffffff; /* Light text color for card titles */
        }

        .card-text {
            color: #d6d6d6; /* Slightly lighter text color for card text */
        }

        .card-body {
            padding: 20px; /* Add some padding for better spacing */
        }

        .btn-primary {
            background-color: #5c5a5a; /* Match the navbar color for consistency */
            border: none; /* Remove button border for a cleaner appearance */
        }

        .btn-primary:hover {
            background-color: #383636; /* Darker color on hover for visual feedback */
        }

        .img-fluid {
            border-radius: 8px; /* Add a slight border radius to images for a modern touch */
        }
         .hidden {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .mt-5, .my-5 {
    margin-top: 1rem!important;
}
a.btn.btn-primary {
    background-color: #0069d9;
}
.dropdown-menu.show {
    background-color: #7f7b7b;
}
    </style>
</head>

<body>
  

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Expense Tracker</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                
        <li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        @php
          $userId = session('id');
          $loggedIn = !is_null($userId);
        @endphp
        <li class="nav-item">
          @if ($loggedIn)
            @php
              $user = \App\Models\User::find($userId);
            @endphp
            <a class="nav-link" href="/dashboard">
              Dashboard
            </a>
          @endif
        </li>
        <li class="nav-item dropdown">
          @if ($loggedIn)
            @php
              $user = \App\Models\User::find($userId);
            @endphp
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Logged in as {{ $user->name }}
            </a>
            <div style="background-color: #440000;" class="dropdown-menu" aria-labelledby="navbarDropdown">
           
              <form id="logoutForm"  class="dropdown-item"  action="{{ route('logout') }}" method="POST">
              @csrf
              <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>
            </form>
            </div>
          @else
            <li class="nav-item dropdown">
                    <!-- Added dropdown class -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/login">Login</a>
                        <a class="dropdown-item" href="/register">Register</a>
                    </div>
                </li>
          @endif
        </li>
            </ul>
        </div>
    </nav>
      @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
     <h1>
        <span class="hidden">T</span>
        <span class="hidden">r</span>
        <span class="hidden">y</span>
        <span>&nbsp;</span> <!-- Add spaces between words if needed -->
        <span class="hidden">E</span>
        <span class="hidden">x</span>
        <span class="hidden">p</span>
        <span class="hidden">e</span>
        <span class="hidden">n</span>
        <span class="hidden">s</span>
        <span class="hidden">e</span>
        <span>&nbsp;</span> <!-- Add spaces between words if needed -->
        <span class="hidden">T</span>
        <span class="hidden">r</span>
        <span class="hidden">a</span>
        <span class="hidden">c</span>
        <span class="hidden">k</span>
        <span class="hidden">e</span>
        <span class="hidden">r</span>
    </h1>

    <p>
        <span class="hidden">K</span>
        <span class="hidden">e</span>
        <span class="hidden">e</span>
        <span class="hidden">p</span>
        <span>&nbsp;</span> <!-- Add spaces between words if needed -->
        <span class="hidden">M</span>
        <span class="hidden">a</span>
        <span class="hidden">n</span>
        <span class="hidden">a</span>
        <span class="hidden">g</span>
        <span class="hidden">i</span>
        <span class="hidden">n</span>
        <span class="hidden">g</span>
        <span>&nbsp;</span> <!-- Add spaces between words if needed -->
        <span class="hidden">y</span>
        <span class="hidden">o</span>
        <span class="hidden">u</span>
        <span class="hidden">r</span>
        <span>&nbsp;</span> <!-- Add spaces between words if needed -->
        <span class="hidden">E</span>
        <span class="hidden">x</span>
        <span class="hidden">p</span>
        <span class="hidden">e</span>
        <span class="hidden">n</span>
        <span class="hidden">s</span>
        <span class="hidden">e</span>
        <span class="hidden">s</span>
    </p>

  
                <p class="lead">Take control of your financial well-being and gain peace of mind by managing your
                    expenses efficiently with our powerful expense tracking system.</p>
                <p class="lead" >Our user-friendly software allows you to easily track and categorize your expenditures, analyze your
                    spending patterns, and create detailed reports. With our advanced tools and intuitive dashboard, you
                    can stay organized, make informed financial decisions, and achieve your savings goals. Join our
                    satisfied clients who have experienced the benefits of effective expense management.</p>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <p class="card-text">Create an account to get started.</p>
                        <a href="/register" class="btn btn-primary">Register</a>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Sign In</h5>
                        <p class="card-text">Already have an account? Sign in here.</p>
                        <a href="login" class="btn btn-primary">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
 
</div>

 

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const hiddenElements = document.querySelectorAll(".hidden");
            hiddenElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = 1;
                }, index * 200); // Adjust the delay (in milliseconds) between each letter
            });
        });
    </script>
    <!-- Services -->
    <div class="container mt-5">
        <h2>Our Services</h2>
        <p>Manage your expenses with ease using our advanced features:</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Check Monthly Limit</h5>
                        <p class="card-text">Check if you have reached your monthly limit of expenses.</p>
                         <img src="{{ asset('img/3.PNG') }}" alt="Client 3" class="card-img-top">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Report Generation</h5>
                        <p class="card-text">Generate detailed reports to track your spending patterns and trends.</p>
                        <img src="{{ asset('img/2.PNG') }}" alt="Client 3" class="card-img-top">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">Organize your expenses into categories to understand your spending habits.</p>
                        <img src="{{ asset('img/1.PNG') }}" alt="Client 3" class="card-img-top">
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Additional Content -->
    <div class="container-fluid additional-content" style="margin-top:20px; text-align:center; background-color: #343a40!important;padding-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <h6>@copyright Expense Tracker</h6>
                <p>Explore more about our services and features in this section.</p>
            </div>
        
        </div>
    </div>
<script>
    // Get the element with the class "alert"
    var alertElement = document.querySelector('.alert');

    // Function to disable the element
    function disableAlert() {
        alertElement.style.opacity = 0;
    }

    // Set a timeout to call the function after 5 seconds
    setTimeout(disableAlert, 5000);
</script>
</body>

</html>

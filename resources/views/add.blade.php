<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Expense</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 20px;
      height: 100vh;
    }
    .sidebar h3 {
      margin-bottom: 30px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar li {
      margin-bottom: 10px;
    }
    .sidebar a {
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }
    .sidebar a:hover {
      color: #007bff;
    }
    .main-content {
      padding: 20px;
    }
    .report-container {
      width: 100%;
    }
    .report-container h2 {
      margin-bottom: 20px;
    }
    .timeframe-buttons {
      margin-top: 20px;
    }
    #expenseTable th,
    #expenseTable td {
      padding: 10px;
    }
    #expenseTable thead {
      background-color: #f8f9fa;
    }
    #expenseTable tbody tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    #expenseTable tbody td {
      border-bottom: 1px solid #dee2e6;
    }
  </style>
  <style>
    @media (max-width: 575.98px) {
      .sidebar {
        padding: 10px;
        height: auto;
      }
      .sidebar h3 {
        margin-bottom: 20px;
      }
    }
    /* Additional styles */
ul.nav.flex-column a {
    border: 2px solid black !important;
    padding: 10px; /* Adjust padding as needed */
    margin-bottom: 5px; /* Adjust margin as needed */
    border-radius: 5px; /* Optional: Add border-radius for rounded corners */
    background-color: #555; /* Optional: Add background color */
    color: #ffffff; /* Optional: Set text color */
    text-decoration: none; /* Remove default underline */
    transition: background-color 0.3s ease; /* Add transition for a smoother effect */
}

ul.nav.flex-column a:hover {
    background-color: #777; /* Change background color on hover */
}
.col-12.col-lg-2.sidebar {
    background-color: darkgray;
}
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Expense Tracker</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        @php
          $userId = session('id');
          $loggedIn = !is_null($userId);
        @endphp
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
            <a class="nav-link" href="/login">Login</a>
            <a class="nav-link" href="/register">Register</a>
          @endif
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-2 sidebar">
        <div class="collapse show" id="sidebarCollapse">
          <h3>Expense Tracker</h3>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">Generate Report</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/add">Add New expense</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/setting">Check Monthly Limit</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12 col-lg-10 main-content">
        <div class="report-container">
          <h2>Add New Expense</h2>
            @if(session('ssuccess'))
        <div class="alert alert-success">
            {{ session('ssuccess') }}
        </div>
    @endif
          <form action="{{ route('productadd') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="product-name">Product Name</label>
              <input type="text" name="productname" id="product-name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="product-price">Product Price</label>
              <input type="number" name="productprice" id="product-price" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="product-type">Payment Type</label>
              <select name="paymenttype" id="paymenttype" class="form-control" required>
                <option value="CreditCard">Credit Card</option>
                <option value="Cash">Cash</option>
                <option value="Crypto">Crypto</option>
              </select>
            </div>
            <div class="form-group">
              <label for="product-category">Product Category</label>
              <input type="text" name="productcategory" id="product-category" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Expense</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function generateReport(timeframe) {
      var reportElement = $('#expenseTableBody');

      reportElement.html('<tr><td colspan="2">Generating report...</td></tr>');

      $.ajax({
        url: '/generate-report',
        method: 'GET',
        data: { timeframe: timeframe },
        success: function (response) {
          reportElement.html(response.reportData);
        },
        error: function () {
          reportElement.html('<tr><td colspan="2">Failed to generate report.</td></tr>');
        }
      });
    }
  </script>
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Basic Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <h1>Welcome to Bootstrap</h1>
        <p>This is a simple example page using Bootstrap for layout and styling.</p>
      </div>
    </div>

    <!-- Table displaying id, email, created -->
    <div class="row mt-4">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>example1@example.com</td>
              <td>2024-10-01</td>
            </tr>
            <tr>
              <td>2</td>
              <td>example2@example.com</td>
              <td>2024-10-02</td>
            </tr>
            <tr>
              <td>3</td>
              <td>example3@example.com</td>
              <td>2024-10-03</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Card Title 1</h5>
            <p class="card-text">Some quick example text to build on the card title.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Card Title 2</h5>
            <p class="card-text">More example text for this card.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Card Title 3</h5>
            <p class="card-text">Another card with some text.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
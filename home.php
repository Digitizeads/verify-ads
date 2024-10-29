<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header('Location: admin'); // Redirect to login page if not logged in
  exit();
}

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Ads Admin</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarNav">

        <!-- Admin Page Title in Center -->
        <span class="navbar-text">
          <h5>Admin Page</h5>
        </span>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">

    <!-- Date Filter Form -->
    <div class="row mt-4">
      <div class="col-md-12">
        <form id="filterForm" class="d-flex justify-content-center align-items-end flex-wrap" method="GET">
          <div class="mb-3 me-3">
            <label for="fromDate" class="form-label">From Date:</label>
            <input type="date" class="form-control" id="fromDate" name="fromDate"
              value="<?php echo isset($_GET['fromDate']) ? htmlspecialchars($_GET['fromDate']) : ''; ?>">
          </div>
          <div class="mb-3 me-3">
            <label for="toDate" class="form-label">To Date:</label>
            <input type="date" class="form-control" id="toDate" name="toDate"
              value="<?php echo isset($_GET['toDate']) ? htmlspecialchars($_GET['toDate']) : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary mb-3" id="filterBtn">
            <i class="bi bi-filter"></i> Filter
          </button>
          <button type="button" class="btn btn-secondary mb-3" id="resetBtn">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </button>
        </form>
      </div>
    </div>

    <!-- Table displaying id, email, created -->
    <div class="row mt-4">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>
                <input type="checkbox" id="selectAll" />
              </th>
              <th>ID</th>
              <th>Email</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="resultBody">
            <?php
            // Database connection settings for local
            /* $host = 'localhost';
            $db = 'verifyads';
            $user = 'root';
            $password = ''; */

            //Database connection for Live
            $servername = "localhost";
            $username = "verifyadmin";
            $password = "qq%*=W=5;j6f";
            $dbname = "verifyads";
            
            // Create connection
            $conn = new mysqli($host, $user, $password, $db);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Initialize date variables for filtering
            $fromDate = '';
            $toDate = '';

            // Check if GET parameters are set
            if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
              $fromDate = $_GET['fromDate'];
              $toDate = $_GET['toDate'];
            }
            // echo $toDate;exit;

            // Query to fetch data with date filter
            $sql = "SELECT * FROM newsletter";
            if (!empty($fromDate) && !empty($toDate)) {
              $sql .= " WHERE createdDt BETWEEN '$fromDate' AND '$toDate'";
            }
            $result = $conn->query($sql);

            // Initialize a counter for the serial number
            $serialNumber = 1;

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' class='rowCheckbox' /></td>";
                echo "<td>" . $serialNumber . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['createdDt'])) . "</td>";
                echo "</tr>";

                // Increment the serial number
                $serialNumber++;
              }
            } else {
              echo "<tr><td colspan='4' class='text-center fw-bold'>No data available</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12 text-end"> <!-- Align button to the right -->
        <?php if ($result && $result->num_rows > 0): ?>
          <button id="actionButton" class="btn btn-success mt-3">Download</button>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

  <script>
    $(document).ready(function() {
      // Reset button functionality
      $('#resetBtn').click(function() {
        $('#fromDate').val(''); // Clear from date
        $('#toDate').val(''); // Clear to date
        window.location.href = window.location.pathname; // Reload the page without query parameters
      });

      // Select All checkbox functionality
      $('#selectAll').click(function() {
        $('.rowCheckbox').prop('checked', this.checked);
      });

      // Event for individual checkboxes
      $(document).on('change', '.rowCheckbox', function() {
        if ($('.rowCheckbox:checked').length < $('.rowCheckbox').length) {
          $('#selectAll').prop('checked', false); // Uncheck "Select All" if any individual checkbox is unchecked
        } else {
          $('#selectAll').prop('checked', true); // Check "Select All" if all checkboxes are checked
        }
      });

      // Hide the "Select All" checkbox if there are fewer than 2 results
      const rowCount = $('#resultBody tr').length; // Get the number of rows in the tbody
      if (rowCount < 2) {
        $('#selectAll').closest('th').hide(); // Hide the "Select All" checkbox
      }

      // Action button validation and download
      $('#actionButton').click(function() {
        const selectedIds = [];
        $('.rowCheckbox:checked').each(function() {
          const row = $(this).closest('tr');
          const id = row.find('td:nth-child(2)').text(); // Adjust as per your ID column
          selectedIds.push(id);
        });

        // Check if at least one checkbox is selected
        if (selectedIds.length === 0) {
          alert('Please select at least one entry to proceed.');
        } else {
          // Send the selected IDs to download_excel.php
          $.ajax({
            type: "POST",
            url: "download_excel.php",
            data: {
              ids: selectedIds
            },
            success: function(data) {
              // Create a blob and a link to download the file
              const blob = new Blob([data], {
                type: 'application/vnd.ms-excel'
              });
              const url = URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;

              // Get current date and time for file naming
              const now = new Date();
              const formattedDate = now.toISOString().slice(0, 19).replace(/T/, '_').replace(/:/g, '-'); // Format: YYYY-MM-DD_HH-MM-SS
              a.download = `verifyads_newsletter_emaillist_${formattedDate}.xls`; // Set the file name
              document.body.appendChild(a);
              a.click();
              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function() {
              alert('An error occurred while downloading the file.');
            }
          });
        }
      });
    });
  </script>

</body>

</html>
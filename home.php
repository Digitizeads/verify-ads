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
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home">Home</a>
          </li>
        </ul>

        <!-- Admin Page Title in Center -->
        <span class="navbar-text mx-auto">
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
        <form id="filterForm" class="d-flex justify-content-center align-items-end flex-wrap">
          <div class="mb-3 me-3">
            <label for="fromDate" class="form-label">From Date:</label>
            <input type="date" class="form-control" id="fromDate" name="fromDate"
              value="<?php echo isset($fromDate) ? htmlspecialchars($fromDate) : ''; ?>">
          </div>
          <div class="mb-3 me-3">
            <label for="toDate" class="form-label">To Date:</label>
            <input type="date" class="form-control" id="toDate" name="toDate"
              value="<?php echo isset($toDate) ? htmlspecialchars($toDate) : ''; ?>">
          </div>
          <button type="button" class="btn btn-primary mb-3" id="filterBtn">
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
            // Database connection settings
            $host = 'localhost';
            $db = 'verifyads';
            $user = 'root';
            $password = '';

            // Create connection
            $conn = new mysqli($host, $user, $password, $db);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Initialize date variables for filtering
            $fromDate = '';
            $toDate = '';

            // Check if form has been submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get date filter values from POST request
              $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
              $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
            }

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
        <button id="actionButton" class="btn btn-success mt-3">Perform Action</button>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

  <script>
    $(document).ready(function () {
      $('#filterBtn').click(function () {
        // Get values from date inputs
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        // Ensure both dates are selected before submission
        if (fromDate && toDate) {
          // Create a form to submit the filter values via POST
          var form = $('<form>', {
            method: 'POST',
            action: window.location.pathname
          });

          // Append the date values to the form
          form.append($('<input>', {
            type: 'hidden',
            name: 'fromDate',
            value: fromDate
          }));
          form.append($('<input>', {
            type: 'hidden',
            name: 'toDate',
            value: toDate
          }));

          // Submit the form
          form.appendTo('body').submit();
        } else {
          alert('Please select both From Date and To Date.');
        }
      });

      // Reset button functionality
      $('#resetBtn').click(function () {
        $('#fromDate').val(''); // Clear from date
        $('#toDate').val('');   // Clear to date
        window.location.href = window.location.pathname; // Reload the page without query parameters
      });

      // Select All checkbox functionality
      $('#selectAll').click(function () {
        $('.rowCheckbox').prop('checked', this.checked);
      });

      // Event for individual checkboxes
      $(document).on('change', '.rowCheckbox', function () {
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
      $('#actionButton').click(function () {
        const selectedIds = [];
        $('.rowCheckbox:checked').each(function () {
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
            data: { ids: selectedIds },
            success: function (data) {
              // Create a blob and a link to download the file
              const blob = new Blob([data], { type: 'application/vnd.ms-excel' });
              const url = URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = 'selected_records.xls';
              document.body.appendChild(a);
              a.click();
              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function () {
              alert('An error occurred while downloading the file.');
            }
          });
        }
      });
    });
  </script>

</body>

</html>
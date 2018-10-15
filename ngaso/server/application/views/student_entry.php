<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student Entry</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

</head>

<body>
  <div class="container mt-5">
    <h1>Student Entry</h1>

    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="error-modal-label">Error</h5>
          </div>
          <div class="modal-body">
						<p id="error-msg">
						</p>
					</div>
					<div class="modal-footer">
					<div class="container-fluid">
            <button type="button" class="btn btn-secondary mb-2" data-dismiss="modal">Close</button>
          </div>
					</div>
				</div>
			</div>
		</div>


    <div class="modal fade" id="alter-modal" tabindex="-1" role="dialog" aria-labelledby="alter-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="alter-modal-label">Student Form</h5>
          </div>
          <div class="modal-body">
					<div class="container-fluid">
            <form>
              <div class="form-group">
                <label for="id-input">ID</label>
                <input type="text" class="form-control" id="id-input" aria-describedby="id-help" placeholder="Enter ID" autocomplete="off">

              </div>
              <div class="form-group">
                <label for="name-input">Name</label>
                <input type="text" class="form-control" id="name-input" aria-describedby="name-help" placeholder="Enter name" autocomplete="off">

              </div>
              <div class="form-group">
                <label for="email-input">Email</label>
                <input type="email" class="form-control" id="email-input" aria-describedby="email-help" placeholder="Enter email" autocomplete="off">

              </div>
              <div class="form-group">
                <label for="dob-input">Date of Birth</label>
                <input type="date" class="form-control" id="dob-input" aria-describedby="dob-help" placeholder="Enter your birth date" autocomplete="off">

              </div>
              <div class="form-group">
                <label for="address-input">Address</label>
                <textarea class="form-control" id="address-input" aria-describedby="address-help" placeholder="Enter your address" autocomplete="off"></textarea>

              </div>
              <div class="form-group">
                <label for="phone-input">Phone</label>
                <input type="text" class="form-control" id="phone-input" aria-describedby="phone-help" placeholder="Enter your phone" autocomplete="off">

              </div>
              <div class="father-group">
                <label for="father-input">Father Name</label>
                <input type="text" class="form-control" id="father-input" aria-describedby="father-help" placeholder="Enter your father name "
                  autocomplete="off">

              </div>
              <div class="mother-group">
                <label for="mother-input">Mother Name</label>
                <input type="text" class="form-control" id="mother-input" aria-describedby="mother-help" placeholder="Enter your mother name "
                  autocomplete="off">

              </div>
            </form>
						</div>
          </div>
          <div class="modal-footer">
					<div class="container-fluid">
            <button type="button" id="cancel-button" class="btn btn-secondary mb-2" data-dismiss="modal">Discard and close</button>
            <button type="button" id="save-button" class="btn btn-primary mb-2">Save changes</button>
            <button type="button" id="delete-button" class="btn btn-danger mb-2">Delete record</button>
          </div>
					</div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="create-modal-label">Entry Student Form</h5>
            </div>
            <div class="modal-body">
						<div class="container-fluid">
              <form id="create-form">
                <div class="form-group">
                  <label for="id-input-c">ID</label>
                  <input type="text" class="form-control" id="id-input-c" aria-describedby="id-help" placeholder="Enter ID" autocomplete="off">
  
                </div>
                <div class="form-group">
                  <label for="name-input-c">Name</label>
                  <input type="text" class="form-control" id="name-input-c" aria-describedby="name-help" placeholder="Enter name" autocomplete="off">
  
                </div>
                <div class="form-group">
                  <label for="email-input-c">Email</label>
                  <input type="email" class="form-control" id="email-input-c" aria-describedby="email-help" placeholder="Enter email" autocomplete="off">
  
                </div>
                <div class="form-group">
                  <label for="dob-input-c">Date of Birth</label>
                  <input type="date" class="form-control" id="dob-input-c" aria-describedby="dob-help" placeholder="Enter your birth date" autocomplete="off">
  
                </div>
                <div class="form-group">
                  <label for="address-input-c">Address</label>
                  <textarea class="form-control" id="address-input-c" aria-describedby="address-help" placeholder="Enter your address" autocomplete="off"></textarea>
  
                </div>
                <div class="form-group">
                  <label for="phone-input-c">Phone</label>
                  <input type="text" class="form-control" id="phone-input-c" aria-describedby="phone-help" placeholder="Enter your phone" autocomplete="off">
  
                </div>
                <div class="father-group">
                  <label for="father-input-c">Father Name</label>
                  <input type="text" class="form-control" id="father-input-c" aria-describedby="father-help" placeholder="Enter your father name "
                    autocomplete="off">
  
                </div>
                <div class="mother-group">
                  <label for="mother-input-c">Mother Name</label>
                  <input type="text" class="form-control" id="mother-input-c" aria-describedby="mother-help" placeholder="Enter your mother name "
                    autocomplete="off">
  
                </div>
              </form>
							</div>
            </div>
            <div class="modal-footer">
						<div class="container-fluid">
              <button type="button" id="cancel-button-c" class="btn mb-2 btn-secondary" data-dismiss="modal">Discard and close</button>
              <button type="button" id="save-button-c" class="btn mb-2 btn-primary">Create Entry</button>
						</div>
            </div>
          </div>
        </div>
      </div>
    <div>
      <button type="button" id="create-button" class="btn btn-primary mb-4 mt-3">Entry Student</button>
      <br>
      <table class="table table-hover table-responsive-md">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody id="table-body"></tbody>
      </table>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="<?php echo base_url(); ?>static/js/main.js"></script>
</body>

</html>

<!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <title>Simple CRUD php Demo</title>
    <link 
      rel="stylesheet" 
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
      crossorigin="anonymous" />
  </head>
  <body>
    <div class="container">

      <!-- Create/Edit Form -->
      <h2>Enter Information</h2><br>
      <form method="post">
        <?php
        if (array_key_exists('edit',$_POST)) {
          echo '
            <div class="form-group">
              <label for="formGroupExampleInput">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name" value="'.$_POST['name'].'"/>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="text" class="form-control" name="email" value="'.$_POST['email'].'"/>
            </div>
            <div class="form-group">
            <label for="formGroupExampleInput">Address</label>
              <input type="text" class="form-control" name="address" value="'.$_POST['address'].'"/>
            <input type="hidden" name="id" value="'. $_POST["id"]. '">
            <input type="submit" class="btn btn-primary" name="editUser" value="Edit" />
          ';
        } else{
          echo'
            <div class="form-group">
              <label for="formGroupExampleInput">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name"/>
            </div>
            <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="email" placeholder="Enter email"/>
            </div>
            <div class="form-group">
            <label for="formGroupExampleInput">Address</label>
              <input type="text" class="form-control" name="address" placeholder="112 Example Ave"/>
            </div>
            <input type="submit" class="btn btn-primary" name="create" value="Submit" />';
        }
        ?>
      </form>
      <!-- End- Create/Edit Form -->

      <?php
      include('./default.php');

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 

      // INSERT & EDIT INFORMATION

      if(array_key_exists('create',$_POST)) {
        $sql = "INSERT INTO Users (name, email, address)
                  VALUES ('$_POST[name]', '$_POST[email]', '$_POST[address]')";
        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else if (array_key_exists('editUser',$_POST)) {
        $sql = "UPDATE Users SET name='$_POST[name]', email='$_POST[email]', address='$_POST[address]' WHERE id=".$_POST['id'].";";
        if ($conn->query($sql) === TRUE) {
          echo "Edited successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }

      // DELETE INFORMATION

      if(array_key_exists('delete',$_POST)) {
        $sql= "DELETE FROM Users WHERE id=".$_POST['id'].";";
        if ($conn->query($sql) === TRUE) {
          echo "Record deleted successfully";
        }
        else {
          echo "'Error: ' . $sql . '<br>' . $conn->error";
        }
      }

      // VIEW INFORMATION

      echo '<br><table class="table">
      <thead>
      <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col"></th>

      </tr>
      </thead>';
      $sql = "SELECT id, name, email, address FROM Users";
      $result = $conn->query($sql);
                  
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<tr>
              <td>'. $row["id"]. '</td>
              <td>'. $row["name"]. '</td>
              <td>'. $row["email"]. '</td>
              <td>'. $row["address"]. '</td>
              <td> <form method="post">
                  <input type="hidden" name="id" value="'. $row["id"]. '">
                  <input type="hidden" name="name" value="'. $row["name"]. '">
                  <input type="hidden" name="email" value="'. $row["email"]. '">
                  <input type="hidden" name="address" value="'. $row["address"]. '">
                  <input class="btn btn-outline-primary" type="submit" name="edit" value="Edit" />
                  <input class="btn btn-outline-danger" type="submit" name="delete" value="Delete" />
                </form>
              </td>
            </tr>
          ';       
        } 
      } else {
        echo "0 results";
      }


      $conn->close();
      ?>

    </div>
  </body>
</html>
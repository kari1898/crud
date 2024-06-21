<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
  </head>
  <body class="container">
      <?php include "connection.php"; ?>
      <div class="navbar">
          <ul class="nav navbar-dark bg-dark">
              
              <?php foreach($Result as $link): ?>
                <li class="nav-item active">
                  <a href="index.php?link=<?php echo $link['model']; ?>" class="nav-link text-light"><?php echo $link['model']; ?></a>
                </li>
              <?php endforeach; ?>
              
              <li class="nav-item active">
                  <a href="create.php" class="nav-link text-light">Create a new SCP record.</a>
            </li>
          </ul>
      </div>
    <h1>SCP CRUD Application</h1>
    <div class="row pb-5">
               <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <img src="images/scp-main.jpg" class="d-block w-100" alt="Slide1">
                        <div class="carousel-caption d-none d-md-block">
                           <h5>First slide label</h5>
                           <p>Some representative placeholder content for the first slide.</p>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <img src="images/IMG2.jpg" class="d-block w-100" alt="Slide2">
                        <div class="carousel-caption d-none d-md-block">
                           <h5>Third slide label</h5>
                           <p>Some representative placeholder content for the third slide.</p>
                        </div>
                     </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                  </button>
               </div>
            </div>
    <div>
        <?php
            
            if(isset($_GET['link']))
            {
                $model = $_GET['link'];
                
                // prepared statement
                $stmt = $mysqli->prepare("select * from kenworth where model = ?");
                if(!$stmt)
                {
                    echo "<p>Error in preparing SQL statement</p>";
                    exit;
                }
                $stmt->bind_param("s", $model);
                
                if($stmt->execute())
                {
                    $result = $stmt->get_result();
                    
                    // check if a record has been retrieved
                    if($result->num_rows > 0)
                    {
                        $array = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        echo "
                            <div class='card card-body shadow mb-3'>
                            <h2 class='card-title'>Item: {$array['model']}</h2>
                            <h4>Object Class: {$array['tagline']}</h4>
                            <p class='text-center'><img src='{$array['image']}' alt='{$array['model']}' class='img-fluid w-50'></p>
                            <p>{$array['content']}</p>
                            <p>
                                <a href='{$update}' class='btn btn-info'>Update Record</a>
                                <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                            </p>
                            </div>
                        ";
                    }
                    else
                    {
                        echo "<p>No record found for Item: {$array['model']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing the statement,  {$stmt->error}</p>";
                }
               
            }
            else
            {
                echo "
                    <p>Welcome to this SCP Foundation.</p>
                ";
            }
            
            // delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $mysqli->prepare("delete from kenworth where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Recorded Deleted...</div>";
                    echo "<script type='text/javascript'> 
                    setTimeout(function () {
                    window.location.href='https://30073647.2024.labnet.nz/SCP/' 
                    },5000);
                    </script>";
                }
                else
                {
                     echo "<div class='alert alert-danger'>Error deleting record {$delete->error}.</div>";
                }
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
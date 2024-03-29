<?php
include("datacnx.php");

    $sql = "CREATE TABLE IF NOT EXISTS agency(
      id INT(20) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
      longitude VARCHAR(60) NOT NULL,
      latitude VARCHAR(60) NOT NULL,
      adresse VARCHAR(100) NOT NULL,
      bank_id INT(20) UNSIGNED NOT NULL,
      FOREIGN KEY (bank_id) REFERENCES bank(id) 
      ON DELETE CASCADE
      ON UPDATE CASCADE
      )";

if ($cnx->query($sql) === TRUE) {
  // echo "Table created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

        

           if(isset($_POST['submit'])){
             $longitude = isset($_POST['longitude'])? htmlspecialchars(strtolower(trim($_POST['longitude']))) : '';
             $latitude = isset($_POST['latitude']) ? htmlspecialchars(strtolower(trim($_POST['latitude']))) : '';
             $adresse = isset($_POST['adresse'])? htmlspecialchars(strtolower(trim($_POST['adresse']))) : '';
             $bank_id = isset($_POST['bank_id'])? htmlspecialchars(strtolower(trim($_POST['bank_id']))) : '';

                 if($longitude && $latitude && $adresse){
                   $insertsql = "INSERT INTO agency(longitude,latitude,adresse,bank_id) 
                   VALUES ('$longitude', '$latitude', '$adresse', '$bank_id')";
                       mysqli_query($cnx, $insertsql);
                       echo "insert valid";
                 }else{
                   echo "insert invalidooooooooooooooooooooooooooooo";
                 }
           }





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body class="overflow-x-hidden">


<?php
include("navbar.php");
?>
<div class="container ml-[260px]">
    <button id="cardagency" class="font-bold mt-10 ml-10 px-5 py-1 border-3 shadow-md transition ease-in duration-500 border-blue-300 dark:bg-gray-700 text-gray-200  font-serif ">+ Add Agency</button>

<div class="relative ml-[40px] top-10">
    <table class="w-[1200px] text-center text-sm text-left rtl:text-right text-gray-200 dark:text-gray-200">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    LONGITUDE
                </th>
                <th scope="col" class="px-6 py-3">
                    LATITUDE
                </th>
                <th scope="col" class="px-6 py-3">
                    ADRESSE
                </th>
                <th scope="col" class="px-6 py-3">
                    BANK ID
                </th>
                <th scope="col" class="px-6 py-3"> ACTION </th>
            </tr>
            </thead>
        </tbody>

          <?php
          if(!$cnx){
            die("your database is not connected :" . mysqli_connect_error());
          }


          $tableName = 'agency';
            $sql = "SELECT * FROM $tableName";
              $result = mysqli_query($cnx, $sql);

              if ($result){
                while ($row = mysqli_fetch_array($result)){
                  echo "<tr>
                  <td> {$row['id']}</td>
                  <td> {$row['longitude']}</td>
                  <td> {$row['latitude']}</td>
                  <td> {$row['adresse']}</td>
                  <td> {$row['bank_id']}</td>
                  
                  <td>
                        <a href='{$row["id"]}' class='font-bold text-white h-8 rounded cursor-pointer px-3 bg-gray-700 shadow-md transition ease-out duration-500 border-gray-700 '>EDIT</a>
                        <a href='deletagency.php?id={$row["id"]}' class='font-bold text-white h-8 rounded  cursor-pointer px-2 bg-red-700 shadow-md transition ease-out duration-500 border-red-700 '>DELET</a>
                  </td>
                  </tr>";
                }
                echo "</tbody></table>";
              } else {
                  echo "Erreur lors de l'exécution de la requête : " . mysqli_error($cnx);
              }
        ?>


</div>

<div class="flex flex-row gap-10 mx-auto fixed top-48 left-[600px] w-[400px]  z-10  justify-between p-10 items-center bg-black border border-gray-500 rounded-md max-w-screen-lg  transform scale-0  transition duration-700 ease-in-out" id="formagency">
        <form action="agency.php" method="POST" class="max-w-md mx-auto">
          <div class="flex justify-end">
          <a href="agency.php"><img class="h-[20px]" src="icons8-close-50.png" alt="" ></a>
          </div>
          
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="longitude" id="longitude" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="longitude" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">LONGITUDE</label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="latitude" id="latitude" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="latitude" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">LATITUDE</label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="adresse" id="adresse" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="adresse" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">ADRESSE</label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="bank_id" id="bank_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="bank_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">BANK ID</label>
          </div>
          
            
          <div class="flex justify-center">
            <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
          </div>
        </form>
      </div>

</div>




<script src="styleagency.js"></script>
</body>
</html>

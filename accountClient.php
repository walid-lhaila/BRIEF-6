<?php
        include("datacnx.php");


  //create table

  $sql = "CREATE TABLE IF NOT EXISTS account (
    id INT(20) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    balance VARCHAR(30) NOT NULL,
    devise VARCHAR(30) NOT NULL,
    rib VARCHAR(30) NOT NULL,
    id_client INT(20) UNSIGNED NOT NULL,
    FOREIGN KEY (id_client) REFERENCES clients(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    )";



          $cnx-> query($sql);
          $date = date("10YmdHis");
          $rib = $date.substr($date,0,16);

          if ($cnx->errno) {
            echo "Error creating table: " . $cnx->error;
        } else {
            // echo "Table created successfully";
        }

            //insert

            if (isset($_POST["submit"])) {
              $balance = isset($_POST['balance']) ? htmlspecialchars(strtolower(trim($_POST['balance']))) : '';
              $devise = isset($_POST['devise']) ? htmlspecialchars(strtolower(trim($_POST['devise']))) : '';
              $rib = isset($_POST['rib']) ? htmlspecialchars(strtolower(trim($_POST['rib']))) : '';
              $id_client = isset($_POST['id_client']) ? htmlspecialchars(strtolower(trim($_POST['id_client']))) : '';
            
          
              if ($balance && $devise && $rib && $id_client) {
                  $insertsql = "INSERT INTO account(balance,devise,rib,id_client)
                                VALUES('$balance','$devise','$rib','$id_client')";
                  mysqli_query($cnx, $insertsql);
                  echo "Valid";
              } else {
                  // echo "Veuillez saisir tous les champs";
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
    <button id="cardaccount" class="font-bold mt-10 ml-10 px-5 py-1 border-3 shadow-md transition ease-in duration-500 border-blue-300 dark:bg-gray-700 text-gray-200  font-serif ">+ Add Account</button>

<div class="relative ml-[40px] top-10">
    <table class="w-[1200px] text-center text-sm text-left rtl:text-right text-gray-200 dark:text-gray-200">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    BALANCE
                </th>
                <th scope="col" class="px-6 py-3">
                    DEVISE
                </th>
                <th scope="col" class="px-6 py-3">
                    RIB
                </th>
                <th scope="col" class="px-6 py-3">
                    CLIENTS BY ID
                </th>
                <th scope="col" class="px-6 py-3">
                    ACTION
                </th>
            </tr>
        </tbody>

        <?php

if(!$cnx){
  die("connection is not connected : " .mysqli_connection_error());
}
    $sql = "SELECT * FROM account";
    $result = mysqli_query($cnx, $sql);

    if($result) {
      while($row = mysqli_fetch_array($result)){
        echo "<tr>
                                              <td>{$row['id']}</td>
                                              <td>{$row['balance']}</td>
                                              <td>{$row['devise']}</td>
                                              <td>{$row['rib']}</td>
                                              <td>{$row['id_client']}</td>
                                              <td>
                                                  <a href='{$row["id"]}' class='font-bold text-white h-8 rounded cursor-pointer px-3 bg-gray-700 shadow-md transition ease-out duration-500 border-gray-700 '>EDIT</a>
                                                  <a href='delet_account.php?id={$row["id"]}' class='font-bold text-white h-8 rounded  cursor-pointer px-2 bg-red-700 shadow-md transition ease-out duration-500 border-red-700 '>DELET</a>
                                              </td>
                                              
                                              </tr>";
        
        
      }
      echo "</tbody></table>";
          } else {
              echo "Erreur lors de l'exécution de la requête : " . mysqli_error($cnx);
          }
    



?>

    </table>
</div>


<div class="flex flex-row gap-10 mx-auto fixed top-48 left-[600px]  z-10  justify-between p-10 items-center bg-black border border-gray-500 rounded-md max-w-screen-lg  transform scale-0  transition duration-700 ease-in-out" id="formaccount">
        <form action="accountClient.php" method="POST" class="max-w-md mx-auto">
          <div class="flex justify-end">
          <a href="accountClient.php"><img class="h-[20px]" src="icons8-close-50.png" alt="" ></a>
          </div>
         
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="balance" id="balance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="balance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">BALANCE</label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="devise" id="devise" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="devise" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">DEVISE</label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="rib" id="rib" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="rib" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RIB</label>
          </div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="id_client" id="client_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
              <label for="id_client" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">CLIENT ID</label>
            </div>
            
          <div class="flex justify-center">
            <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-0 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
          </div>
        </form>
      </div>

</div>


<script src="styleaccount.js"></script>
</body>
</html>

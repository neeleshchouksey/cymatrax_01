<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users Update List</title>
</head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<body>
   
    <p>Updated Users list</p>
    <br>
    <table>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    
    <?php 
            if(isset($userslist)){
                foreach($userslist as $key=>$value){ 
            ?>
            <tr>
        <td>  <?php echo $value->name; ?> </td>
        <td>  <?php echo $value->email; ?> </td>
        </tr>
        <?php }} ?>
   
    

        
      
    
    <p>Thanks!</p>
    <p>Team Cymatrax</p>
    <br><br><br>
</body>

</html>

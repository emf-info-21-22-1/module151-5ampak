<!doctype html>
<html>
  <header>
    <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
</header>
  <body>
    <div id="conteneur">
      <h1>Les équipes de National League</h1>    
      <table border= "1">
      <tr>
        <td>ID</td>
        <td>Club</td>
      </tr>
      <?php
        include_once('ctrl.php');
        //instance
        $ctrl = new ctrl();
        //met le résultat
        $equipe = $ctrl->getEquipes();

        $num = 1;

      foreach($equipe as $equip) {
        echo "<tr>";
        echo "<td>".$num."</td>";
        echo "<td>".$equip."</td>";
        echo "</tr>";
        $num++;
      }

      ?>
      </table>
    </div>
  </body>
</html>
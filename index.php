<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="lib/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/notif.css">
        <title> Cours </title>
    </head>
    <body>
      <?php include("include/header.php");

      $page = $_GET['page'] ?? "";
      $page = "page/" . $page . ".inc.php";
      $files = glob("page/*.inc.php");

      if (in_array($page,$files))
      {
        include $page;
      }
      else
      {
        include("page/test.inc.php");
      }

      include("include/footer.php"); ?>
    </body>

</html>

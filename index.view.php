<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Jed Murdock's CSS Parser Demo</title>

  <!-- bootstrap stuff -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="cssparser.css">
</head>
<body role="document">
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <div class="container" role="main">

    <?php if ($errorMsg != null) : ?>
      <div class="alert alert-danger" role="alert"><strong>Oops!</strong> <?= $errorMsg ?></div>
    <?php endif; ?>
    <?php if ($successMsg != null) : ?>
      <div class="alert alert-success" role="alert"><strong></strong><?= $successMsg ?></div>
    <?php endif; ?>

    <div class="page-header">
      <h1>Simple CSS Report</h1>
      <p>Upload a css file and see some exciting statistics!</p>
    </div>
    <form action="index.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
      <span class="btn btn-default btn-file">
        Browse <input type="file" name="uploadFile">
      </span>
      <input type="submit" class="btn btn-primary" value="Upload">
      <input type="button" class="btn btn-default" value="Cancel" onclick="location.reload(true);">
    </form>
  </div>
</body>


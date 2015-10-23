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
  <script>
    $(document).ready(function(){
      $('#btnCancel').click(function(){
        window.location = window.location.href;
      });
      $('#btnReport').click(function(){
        $('#divReport').hide();
        $('#divReportData').html('');
        $.get( "report.php", function( response ) {
          if ( response.status == "unavailable" ) {
            $('#divMsg .alert').addClass('alert-success');
            $('#divMsg .alert').html("Report unavailable. Please try uploading another CSS file.");
            $('#divMsg .alert').show();
          }
          else if( response.status == "success" ) {
            $('#divReportData').append('<h3>Colors : ' + response.data['summary']['num_colors'] +  '</h3>');
            $('#divReportData').append('<h3>Font Families : ' + response.data['summary']['num_font_families'] + '</h3>');
            $('#divReportData').append('<h3>Comments : ' + response.data['summary']['num_comments'] + '</h3>');
            $('#divReportData').append('<h3>Selectors : ' + response.data['summary']['num_selectors'] + '</h3>');
            $('#divReport').show();
          }
        });
      });
      // in reality i wouldn't mix ajax and normal page reload messaging like this
      <?php if ($errorMsg != null) : ?>
        $('#divMsg .alert').addClass('alert-danger');
        $('#divMsg .alert').html('<?= $errorMsg ?>');
        $('#divMsg .alert').show();
      <?php endif; ?>
      <?php if ($successMsg != null) : ?>
        $('#divMsg .alert').addClass('alert-success');
        $('#divMsg .alert').html('<?= $successMsg ?>');
        $('#divMsg .alert').show();
      <?php endif; ?>
    });
  </script>
  <div class="container" role="main">

    <div id="divMsg">
        <div class="alert" role="alert" style="display:none"></div>
    </div>

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
      <input type="button" class="btn btn-success" value="Get Report" id="btnReport">
      <input type="reset" class="btn btn-default" value="Cancel" id="btnCancel">
    </form>

    <div id="divReport" class="page-header" style="display:none">
      <h1>Results</h1>
      <div class="well" id="divReportData">
      </div>
    </div>
  </div>
</body>


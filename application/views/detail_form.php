<!DOCTYPE html>
<html>

<head>
  <title>Detail Form</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css'); ?>">
</head>

<body>
  <h2 id="head1">Detail Form</h2>
  <div id="response"></div>
  <form id="detailForm" method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name"><br><br>

    <label>Email:</label>
    <input type="email" name="email"><br><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Male">Male
    <input type="radio" name="gender" value="Female">Female<br><br>

    <label>Hobbies:</label>
    <input type="checkbox" name="hobbies[]" value="Reading">Reading
    <input type="checkbox" name="hobbies[]" value="Sports">Sports
    <input type="checkbox" name="hobbies[]" value="Music">Music<br><br>

    <label>Image:</label>
    <input type="file" name="image"><br><br>

    <label>Files:</label>
    <input type="file" name="files[]" multiple><br><br>

    <label>Description:</label>
    <textarea name="description" rows="10"></textarea><br><br>

    <button type="submit">Submit</button>
  </form>



  <script>
    $(document).ready(function () {
      $('#detailForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          url: '<?= base_url("detail/save") ?>',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            if (response.status == 'success') {
              $('#response').html('<p style="color:green">' +  response.message + '</p>');
              $('#detailForm')[0].reset();
            } else {
              $('#response').html('<p style="color:red">' + response.errors + '</p>');
            }
          }
        });
      });
    });
  </script>
</body>

</html>
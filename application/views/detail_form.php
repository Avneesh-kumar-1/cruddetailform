<!DOCTYPE html>
<html>
<head>
    <title>Detail Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    /* General Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

/* Form Container */
#detailForm {
  max-width: 600px;
  margin: 30px auto;
  padding: 20px;
  /* background: #4ad6e8ff; */
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Label Styling */
#detailForm label {
  display: block;
  font-weight: bold;
  margin-bottom: 6px;
  color: #333;
}

/* Inputs and Textarea */
#detailForm input[type="text"],
#detailForm input[type="email"],
#detailForm input[type="file"],
#detailForm textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 18px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  transition: border 0.3s ease;
}

#detailForm input:focus,
#detailForm textarea:focus {
  border-color: #007bff;
  outline: none;
}

/* Radio & Checkbox */
#detailForm input[type="radio"],
#detailForm input[type="checkbox"] {
  margin-right: 6px;
}

#detailForm .inline-options {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 18px;
}

/* Button */
#detailForm button {
  width: 100%;
  padding: 12px;
  background: #007bff;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

#detailForm button:hover {
  background: #0056b3;
}

/* Responsive */
@media (max-width: 480px) {
  #detailForm {
    padding: 15px;
  }
  #detailForm label {
    font-size: 14px;
  }
  #detailForm button {
    font-size: 15px;
  }
}
#head1{
    display:flex;
    align-items: center;
    justify-content: center;
}

</style>
<body>
<h2  id="head1">Detail Form</h2>
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

<div id="response"></div>

<script>
$(document).ready(function(){
    $('#detailForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url("detail/save") ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    $('#response').html('<p style="color:green">'+response.message+'</p>');
                    $('#detailForm')[0].reset();
                } else {
                    $('#response').html('<p style="color:red">'+response.errors+'</p>');
                }
            }
        });
    });
});

// $(document).ready(function(){
//     $('#detailForm').on('submit', function(e){
//         e.preventDefault();
//         var formData = new FormData(this);
//         $.ajax({
//             url: '<?= base_url("detail/update") ?>',
//             type: 'POST',
//             data: formData,
//             contentType: false,
//             processData: false,
//             dataType: 'json',
//             success: function(response){
//                 if(response.status == 'success'){
//                     $('#response').html('<p style="color:green">'+response.message+'</p>');
//                     $('#detailForm')[0].reset();
//                 } else {
//                     $('#response').html('<p style="color:red">'+response.errors+'</p>');
//                 }
//             }
//         });
//     });
// });
</script>
</body>
</html>

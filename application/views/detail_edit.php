<!DOCTYPE html>
<html>
<head>
    <title>Edit Detail</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
/* General Reset */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }

#detailForm { max-width: 600px; margin: 30px auto; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
#detailForm label { display: block; font-weight: bold; margin-bottom: 6px; color: #333; }
#detailForm input[type="text"], #detailForm input[type="email"], #detailForm input[type="file"], #detailForm textarea {
  width: 100%; padding: 10px; margin-bottom: 18px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; transition: border 0.3s ease;
}
#detailForm input:focus, #detailForm textarea:focus { border-color: #007bff; outline: none; }
#detailForm input[type="radio"], #detailForm input[type="checkbox"] { margin-right: 6px; }
#detailForm .inline-options { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 18px; }
#detailForm button { width: 100%; padding: 12px; background: #007bff; color: #fff; font-size: 16px; font-weight: bold; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s; }
#detailForm button:hover { background: #0056b3; }
@media (max-width: 480px) { #detailForm { padding: 15px; } #detailForm label { font-size: 14px; } #detailForm button { font-size: 15px; } }
#head1{ display:flex; align-items:center; justify-content:center; margin-top:20px; }
img.preview-img { width: 100px; margin-top: 5px; }
</style>
<body>

<h2 id="head1">Edit Detail</h2>

<form id="detailForm" method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $detail->name; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $detail->email; ?>" required>

    <label>Gender:</label>
    <div class="inline-options">
        <input type="radio" name="gender" value="Male" <?= $detail->gender=='Male'?'checked':''; ?>> Male
        <input type="radio" name="gender" value="Female" <?= $detail->gender=='Female'?'checked':''; ?>> Female
    </div>

    <label>Hobbies:</label>
    <div class="inline-options">
        <?php $hobbies = explode(',', $detail->hobbies); ?>
        <input type="checkbox" name="hobbies[]" value="Reading" <?= in_array('Reading', $hobbies)?'checked':''; ?>> Reading
        <input type="checkbox" name="hobbies[]" value="Sports" <?= in_array('Sports', $hobbies)?'checked':''; ?>> Sports
        <input type="checkbox" name="hobbies[]" value="Music" <?= in_array('Music', $hobbies)?'checked':''; ?>> Music
    </div>

    <label>Image:</label>
    <input type="file" name="image">
    <?php if($detail->image): ?>
        <br><img src="<?= base_url('uploads/images/'.$detail->image) ?>" class="preview-img">
    <?php endif; ?>

    <label>Files:</label>
    <input type="file" name="files[]" multiple>
    <?php if($detail->files): 
        $filesArr = explode(',', $detail->files);
        foreach($filesArr as $f):
    ?>
        <br><a href="<?= base_url('uploads/files/'.$f) ?>" target="_blank"><?= $f ?></a>
    <?php endforeach; endif; ?>

    <label>Description:</label>
    <textarea name="description" rows="10"><?= $detail->description; ?></textarea>

    <button type="submit">Update</button>
</form>

<div id="response" style="text-align:center; margin-top:15px;"></div>

<script>
// $(document).ready(function(){
//     $('#detailForm').on('submit', function(e){
//         e.preventDefault();
//         var formData = new FormData(this);
//         $.ajax({
//             url: '<?= base_url("detail/update/".$detail->id) ?>',
//             type: 'POST',
//             data: formData,
//             contentType: false,
//             processData: false,
//             dataType: 'json',
//             success: function(response){
//                 if(response.status == 'success'){
//                     $('#response').html('<p style="color:green">'+response.message+'</p>');
//                     // $('#detailForm')[0].reset();
//                 } else {
//                     $('#response').html('<p style="color:red">'+response.errors+'</p>');
//                 }
//             },
//             error: function(xhr, status, error){
//                 $('#response').html('<p style="color:red">AJAX Error: '+error+'</p>');
//             }
//         });
//     });
// }
// reset();
// );
$(document).ready(function(){
    $('#detailForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '<?= base_url("detail/update/".$detail->id) ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    $('#response').html('<p style="color:green">'+response.message+'</p>');
                    
                    // Reset form fields
                    $('#detailForm')[0].reset();

                    // Remove existing preview image
                    $('img.preview-img').remove();

                    // Remove file links
                    $('a').filter(function(){
                        return $(this).attr('href').includes('uploads/files/');
                    }).remove();
                } else {
                    $('#response').html('<p style="color:red">'+response.errors+'</p>');
                }
            },
            error: function(xhr, status, error){
                $('#response').html('<p style="color:red">AJAX Error: '+error+'</p>');
            }
        });
    });
});

</script>

</body>
</html>

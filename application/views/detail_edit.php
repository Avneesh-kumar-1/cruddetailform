<!DOCTYPE html>
<html>

<head>
    <title>Edit Detail</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body>

    <h2 id="head1"> Detail Form</h2>

    <form id="detailForm" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $detail->name; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $detail->email; ?>" required>

        <label>Gender:</label>
        <div class="inline-options">
            <input type="radio" name="gender" value="Male" <?= $detail->gender == 'Male' ? 'checked' : ''; ?>> Male
            <input type="radio" name="gender" value="Female" <?= $detail->gender == 'Female' ? 'checked' : ''; ?>> Female
        </div>

        <label>Hobbies:</label>
        <div class="inline-options">
            <?php $hobbies = explode(',', $detail->hobbies); ?>
            <input type="checkbox" name="hobbies[]" value="Reading" <?= in_array('Reading', $hobbies) ? 'checked' : ''; ?>>
            Reading
            <input type="checkbox" name="hobbies[]" value="Sports" <?= in_array('Sports', $hobbies) ? 'checked' : ''; ?>>
            Sports
            <input type="checkbox" name="hobbies[]" value="Music" <?= in_array('Music', $hobbies) ? 'checked' : ''; ?>> Music
        </div>

        <label>Image:</label>
        <input type="file" name="image">
        <?php if ($detail->image): ?>
            <br><img src="<?= base_url('uploads/images/' . $detail->image) ?>" class="preview-img">
        <?php endif; ?>

        <label>Files:</label>
        <input type="file" name="files[]" multiple>
        <?php if ($detail->files):
            $filesArr = explode(',', $detail->files);
            foreach ($filesArr as $f):
                ?>
                <br><a href="<?= base_url('uploads/files/' . $f) ?>"target="_blank"><?= $f ?></a>
            <?php endforeach; endif; ?>

        <label>Description:</label>
        <textarea name="description" rows="10"><?= $detail->description; ?></textarea>

        <button type="submit">Update</button>
    </form>

    <div id="response" style="text-align:center; margin-top:15px;"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
$(document).ready(function () {
    $('#detailForm').on('submit', function (e) {
        e.preventDefault(); 

        var formData = new FormData(this);

        $.ajax({
            url: '<?= base_url("detail/update/" . $detail->id) ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#response').html('<p style="color:green">' + response.message + '</p>');
                } else {
                    $('#response').html('<p style="color:red">' + response.errors + '</p>');
                }
            },
            error: function (xhr, status, error) {
                $('#response').html('<p style="color:red">AJAX Error: ' + xhr.responseText + '</p>');
            }
        });
    });
});
</script>

</body>

</html>
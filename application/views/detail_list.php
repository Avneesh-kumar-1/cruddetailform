<!DOCTYPE html>
<html>

<head>
    <title>Details List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style2.css'); ?>">

</head>

<body>
    <h2>Details Table</h2>

    <div id="response"></div>

    <div class="table-wrap">
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Hobbies</th>
                <th>Image</th>
                <th>Files</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($details as $d) { ?>
                <tr id="row-<?= $d->id ?>">
                    <td><?= $d->id ?></td>
                    <td><?= $d->name ?></td>
                    <td><?= $d->email ?></td>
                    <td><?= $d->gender ?></td>
                    <td><?= $d->hobbies ?></td>
                    <td>
                        <?php if ($d->image): ?>
                            <a href="<?= base_url('uploads/images/' . $d->image) ?>" target="_blank">
                                <img src="<?= base_url('uploads/images/' . $d->image) ?>" width="80" height="80"
                                    style="cursor:pointer;">
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($d->files):
                            $files = explode(',', $d->files);
                            foreach ($files as $f): ?>
                                <a href="<?= base_url('uploads/files/' . $f) ?>" target="_blank"><?= $f ?></a><br>
                            <?php endforeach;
                        endif; ?>
                    </td>
                    <td><?= $d->description ?></td>
                    <td>
                        <a href="<?= base_url("detail/edit/" . $d->id) ?>">Update</a> |
                        <a href="<?= base_url("detail/delete/" . $d->id) ?>" class="delete-btn"
                            data-id="<?= $d->id ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $('.delete-btn').on('click', function (e) {
                e.preventDefault();

                if (!confirm('Are you sure you want to delete this record?')) return;

                var id = $(this).data('id');
                var row = $('#row-' + id);
                var url = '<?= base_url("detail/delete/") ?>' + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            row.remove();
                            $('#response').html('<p style="color:green">' + response.message + '</p>');
                        } else {
                            $('#response').html('<p style="color:red">Error deleting record</p>');
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#response').html('<p style="color:red">AJAX error: ' + error + '</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>
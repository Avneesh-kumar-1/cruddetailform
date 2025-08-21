<!DOCTYPE html>
<html>

<head>
    <title>Details List</title>
</head>



<style>
    Wrap the table in a scroll container
    .table-wrap {
        width: 100%;
        overflow-x: auto;
        /* Enables sideways scroll on small screens */
        -webkit-overflow-scrolling: touch;
        /* smooth on iOS */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        /* or fixed; if you want equal columns */
    }

    th,
    td {
        text-align: left;
        white-space: nowrap;
        /* prevent ugly wraps; remove if you prefer wrapping */
    }

    td img {
        max-width: 120px;
        height: auto;
        display: block;
    }

    /* Let long text wrap inside Description/Files only */
    td:nth-child(7),
    td:nth-child(8) {
        white-space: normal;
        word-break: break-word;
    }

    /* Make action buttons wrap nicely */
    td:last-child {
        white-space: normal;
        gap: .5rem;
    }
</style>

<body>
    <h2>Details Table</h2>
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
            <tr>
                <td><?= $d->id ?></td>
                <td><?= $d->name ?></td>
                <td><?= $d->email ?></td>
                <td><?= $d->gender ?></td>
                <td><?= $d->hobbies ?></td>
                <td>
                    <!-- <?php if ($d->image) echo "<img src='" . base_url("uploads/images/" . $d->image) . "' width='50'>"; ?> -->

                    <?php if ($d->image): ?>
                        <img src="<?= base_url('uploads/images/' . $d->image) ?>" width="80" height="80">
                    <?php endif; ?>
                </td>
                <td>
                    
                    <!-- <?php if ($d->files)   echo $d->files; ?> -->
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
                    <a href="<?= base_url("detail/delete/" . $d->id) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
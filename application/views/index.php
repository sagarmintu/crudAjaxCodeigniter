<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">

    <br>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Add Record
        </button>

        <!-- Modal -->
        <form id="createform">
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <input type="text" class="form-control" name="message" placeholder="Enter Message">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" name="age" placeholder="Enter Age">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
        <br><br>
        <table id="table1" class="display">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name</th>
                    <th>Messaage</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Edit Model Start-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editID">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="editName" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <input type="text" class="form-control" name="message" id="editMessage" placeholder="Enter Message">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" name="age" id="editAge" placeholder="Enter Age">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Model End-->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('#createform').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '<?php echo base_url('my_controller/create'); ?>',
                data: $('#createform').serialize(),
                type: 'post',
                async: false,
                dataType: 'json',
                success: function(response)
                {
                    $('#createModal').modal('hide');
                    $('#createform')[0].reset();
                    alert("successfully inserted");
                    $('#table1').DataTable().ajax.reload();
                },
                error: function()
                {
                    alert('Error');
                }
            });
        });

        //display data on datatable with ajax
        $(document).ready(function() {
            $('#table1').DataTable({
                "ajax": "<?php echo base_url('my_controller/fetchData'); ?>",
                "order": [],
            });
        });

        //edit function start here
        function editFun(id)
        {
            //alert(id);
            $.ajax({
                url: '<?php echo base_url('my_controller/editData'); ?>',
                type: 'post',
                data: {id: id},
                dataType: 'json',
                success: function(response)
                {
                    $('#editID').val(response.id);
                    $('#editName').val(response.name);
                    $('#editMessage').val(response.message);
                    $('#editAge').val(response.age);
                    $('#editModal').modal({
                        backdrop: "static",
                        keyboard: false
                    });
                }
            });
        }

        $('#editForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '<?php echo base_url('my_controller/update'); ?>',
                data: $('#editForm').serialize(),
                type: 'post',
                async: false,
                dataType: 'json',
                success: function(response)
                {
                    $('#editModal').modal('hide');
                    $('#editForm')[0].reset();
                    if(response == 1)
                    {
                        alert("successfully updated");
                    }
                    else
                    {
                        alert("Failed To Update");
                    }
                    $('#table1').DataTable().ajax.reload();
                },
                error: function()
                {
                    alert('Error');
                }
            });
        });

        // delete function start here
        function deleteFun(id)
        {
            if(confirm('Are you sure?') == true)
            {
                $.ajax({
                    url: '<?php echo base_url('my_controller/deleteSingleData'); ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {id: id},
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            alert("Data deleted successfully");
                            $('#table1').DataTable().ajax.reload();
                        }
                        else
                        {
                            alert("Failed To Delete");
                        }
                    }
                });
            }
        }

    </script>
</body>
</html>
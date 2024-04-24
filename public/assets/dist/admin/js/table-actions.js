$(function () {
    //Category Table
    var category_table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'id'},
            {data: 'name', "width": "70%", name: 'name'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'action', "width": "12%",  name: 'action', orderable: false},
        ],
        "order": [[1, "ASC"]]
    });

    // Sub Category Table
    var table = $('#subCategoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'id'},
            {data: 'name', "width": "40%", name: 'name'},
            {data: 'category', "width": "20%", name: 'category'},
            {data: 'status', "width": "15%",  name: 'status', orderable: false},
            {data: 'action', "width": "15%", name: 'action', orderable: false, searchable: false},
        ]
    });

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var section = $(this).attr("data-section");

        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        if(section=='category'){
                            category_table.row('.selected').remove().draw(false);
                        } else if(section=='sub_category'){
                            sub_category.row('.selected').remove().draw(false);
                        }
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    //Change Status
    $('.datatable-dynamic tbody').on('click', '.assign_unassign', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var section = $(this).attr("data-table_name");

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: {
                'id': id,
                'type': type,
                'table_name': table_name,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                l.stop();

                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }

                if(section=='category'){
                    category_table.draw(false);
                } else if(section=='sub_category'){
                    sub_category.draw(false);
                }

            }
        });
    });
});


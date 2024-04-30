$(function () {
    //User Table
    var users_table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'name'},
            {data: 'name', name: 'name'},
            {data: 'email',  name: 'email'},
            {data: 'phone',  name: 'phone'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%",  name: 'action', orderable: false},
        ],
        "order": [[1, "ASC"]]
    });

    //Category Table
    var category_table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'id'},
            {data: 'section', name: 'section'},
            {data: 'name', name: 'name'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%",  name: 'action', orderable: false},
        ],
        "order": [[1, "DESC"]]
    });

    // Sub Category Table
    var sub_category = $('#subCategoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'category', name: 'category'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%", name: 'action', orderable: false, searchable: false},
        ],
        "order": [[1, "DESC"]]
    });

    // Sub Category Table
    var listing = $('#listingTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'id', "width": "10%", name: 'id'},
            {data: 'company_name', name: 'company_name'},
            {data: 'section', name: 'section'},
            {data: 'is_featured', name: 'is_featured'},
            {data: 'has_special', name: 'has_special'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%", name: 'action', orderable: false, searchable: false},
        ],
        "order": [[0, "DESC"]]
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
                        if(section=='category_table'){
                            category_table.row('.selected').remove().draw(false);
                        } else if(section=='sub_category_table'){
                            sub_category.row('.selected').remove().draw(false);
                        } else if(section=='users_table'){
                            users_table.row('.selected').remove().draw(false);
                        } else if(section=='listing_table'){
                            listing_table.row('.selected').remove().draw(false);
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
                }   else if(section=='users'){
                    users_table.draw(false);
                } else if(section=='listing_table'){
                    listing_table.row('.selected').remove().draw(false);
                }

            }
        });
    });

    //Get Sub Category
    $('#category').on('change', function(){
       var category = $(this).val();
       var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: "POST",
            headers: {'category':category, 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(response){
                console.log(response);
                $('#subCategory').empty();
                var scatOptions = response.option;
                $.each(scatOptions, function(index, option) {
                    $('#subCategory').append('<option value="' + option.id + '">' + option.text + '</option>');
                });
                $('#subCategory').trigger('change');
            }
        });
    });
});

function initialize() {
    var mapOptions, map, marker, searchBox, city, infoWindow = '',
        addressEl = document.querySelector('#address'),
        latEl = document.querySelector('.latitude'),
        longEl = document.querySelector('.longitude'),
        element = document.getElementById('map-canvas');
        city = document.querySelector('.reg-input-city');

    var latitudeVar = latEl.value;
    if(latEl.value==''){
        var latitudeVar = '-26.1715045';
    }

    var longitudeVar = longEl.value;
    if(longEl.value==''){
        var longitudeVar = '27.9698122';
    }

    mapOptions = {
        zoom: 8,
        center: new google.maps.LatLng(latitudeVar,longitudeVar),
        disableDefaultUI: false,
        scrollWheel: true,
        draggable: true,
    };
    map = new google.maps.Map(element, mapOptions); // Till this like of code it loads up the map.
    marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        draggable: true
    });
    searchBox = new google.maps.places.SearchBox(addressEl);
    google.maps.event.addListener(searchBox, 'places_changed',function() {
        var places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i,
            place,
            lat,
            long,
            resultArray,
            addresss = places[0].formatted_address;

        for (i = 0; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location); // Set marker position new.
        }

        map.fitBounds(bounds);
        map.setZoom(15);
        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        latEl.value = lat;
        longEl.value = long;

        resultArray = places[0].address_components;

        for (var i = 0; i < resultArray.length; i++) {
            if (resultArray[i].types[0] && 'administrative_area_level_2' === resultArray[i].types[0]) {
                citi = resultArray[i].long_name;
                city.value = citi;
            }
        }

        if (infoWindow) {
            infoWindow.close();
        }
        infoWindow = new google.maps.InfoWindow({
            content: addresss
        });
        infoWindow.open(map, marker);
    });
    google.maps.event.addListener(marker, "dragend",function(event) {
        var lat, long, address, resultArray, citi;
        console.log('i am dragged');
        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            latLng: marker.getPosition()
        },
        function(result, status) {
            if ('OK' === status) { // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                address = result[0].formatted_address;
                resultArray = result[0].address_components;

                // Get the city and set the city input value to the one selected
                for (var i = 0; i < resultArray.length; i++) {
                    if (resultArray[i].types[0] && 'administrative_area_level_2' === resultArray[i].types[0]) {
                        citi = resultArray[i].long_name;
                        console.log(citi);
                        city.value = citi;
                    }
                }
                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }

            // Closes the previous info window if it already exists
            if (infoWindow) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open(map, marker);
        });
    });
}

function toggleSpecialDescription(radioButton) {
    if(radioButton === "yes") {
        $('.special_div').show();
    } else {
        $('.special_div').hide();
        $('#special_heading').val('');
        $('#special_description').val('');
    }
}
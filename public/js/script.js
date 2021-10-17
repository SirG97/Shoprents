
document.addEventListener('DOMContentLoaded', (event) => {
    const hamburger = document.getElementById('hamburger');
    const main = document.getElementById('main');
    const sidebar = document.querySelector('.nav-sidebar');
    const profile = document.querySelector('.header-nav-item');
    const ndropdown = document.querySelector('.nav-dropdown');

    hamburger.addEventListener('click', () =>{
        sidebar.classList.toggle('nav-sidebar-open');
    });
    profile.addEventListener('click', () => {
        ndropdown.classList.toggle('active');
    });
    main.addEventListener('click', () =>{
            sidebar.classList.remove('nav-sidebar-open');
    });

    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        console.log('hie');
        $(this).tab('show')
    })

    // Show search dropdown
    const search = $('#search_order');
    const search_result = $('.search-result');
    search.on('input', ()=>{
        search.addClass('no-bottom-borders');
        $('.search-result').css('display','block');
        let terms = search.val();
        const url = `/orders/${terms}/search`;
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function(){
                search_result.html('loading...');
            },
            success: function (response) {
                let data = JSON.parse(response);
                console.log(JSON.parse(response))
                let ul = '<ul class="list-group list-group-flush">';
                $.each(data, (key, value) => {
                    $.each(value, (index, item)=>{
                        console.log(item);
                        ul += `<li class="list-group list-group-item">
                                   <a href="/order/${item.order_no}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6>${item.parcel_name}  by ${item.fullname}</h6>
                                        <small>${item.order_no}</small>
                                    </div>
                                    <p class="mb-1">${item.email}</p> 
                                    </a>
                                </li>`;
                    });
                });
                ul += '</ul>';
                $('.search-result').html(ul);
            },
            error: function(request, error){
                let errors = JSON.parse(request.responseText);
                $('#search-result-list').html('No r');
            }
        });
    });
    // ul += '<li class="list-group list-group-item"><div class="d-flex w-100 justify-content-between"><h6>' + item.firstname + ' ' + item.surname + '</h6><small>'+ item.phone +'</small></div><p class="mb-1">'+ item.email +'</p></li>';
    search.on('blur', ()=>{
        $('#search').removeClass('no-bottom-borders');
        // $('.search-result').css('display','none');
    });

    const search_contribution = $('#search-contribution');
    const search_contribution_result = $('.search-contribution-result');
    search_contribution.on('input', ()=>{
        search_contribution.addClass('no-bottom-borders');
        $('.search-result').css('display','block');
        let terms = search_contribution.val();
        const url = `/contributions/${terms}/search`;
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function(){
                search_result.html('<div class="d-flex justify-content-center pt-1 pb-1"><i class="fa fa-spinner fa-spin"></i> &nbsp; Searching...</div>');
            },
            success: function (response) {
                let data = JSON.parse(response);
                console.log(JSON.parse(response))
                let ul = '<ul class="list-group list-group-flush">';

                if(data !== undefined){
                    $.each(data, (key, value) => {
                        $.each(value, (index, item)=>{
                            ul += `<li class="list-group list-group-item">
                         
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6>${item.phone} </h6>
                                        <small>${item.updated_at}</small>
                                    </div>
                                    <p class="mb-1">${item.pin}</p> 
                                    
                                </li>`;
                        });
                    });
                    ul += '</ul>';
                }else{
                    ul += `<li class="list-group list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                                <p>No result found</p>
                        </div>
                    </li>`;
                    ul += '</ul>';
                }

                $('.search-result').html(ul);
            },
            error: function(request, error){
                let errors = JSON.parse(request.responseText);
                $('#search-result-list').html('No result for this query');
            }
        });
    });
    // ul += '<li class="list-group list-group-item"><div class="d-flex w-100 justify-content-between"><h6>' + item.firstname + ' ' + item.surname + '</h6><small>'+ item.phone +'</small></div><p class="mb-1">'+ item.email +'</p></li>';
    search_contribution.on('blur', ()=>{
        $('#search_contribution').removeClass('no-bottom-borders');
        $('.search-result').css('display','none');
    });

    // Show the edit modal and populate the fields for customer edit
    $('#paymentModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes


        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this);

        modal.find('#id').val(id);

    });

    // $('#markPaymentBtn').on('click', (e)=>{
    //     e.preventDefault();
    //
    //     const url = `/route/${route_id}/edit`;
    //     const data = {
    //         token : $('#token').val(),
    //         district : $('#district').val(),
    //         district_id : $('#district_id').val(),
    //         name : $('#name').val(),
    //     };
    //     $.ajax({
    //         url: url,
    //         type: 'POST',
    //         data: data,
    //         beforeSend: function(){
    //             $('#editBtn').html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
    //         },
    //         success: function (response) {
    //             let data = JSON.parse(response);
    //             console.log(JSON.parse(response));
    //             let message = data.success;
    //             msg.innerHTML = alertMessage('success', message);
    //             $('#editBtn').html('Save');
    //             //interval(5000);
    //             window.location.reload()
    //         },
    //         error: function(request, error){
    //
    //             let errors = JSON.parse(request.responseText);
    //             console.log(errors);
    //             let ul = '';
    //             $.each(errors, (key, value) => {
    //                 $.each(value, (index, item)=>{
    //                     console.log(item);
    //                     ul += `${item} <br>`;
    //                 });
    //
    //             });
    //
    //             msg.innerHTML = alertMessage('danger', ul);
    //             $('#editBtn').html('Save');
    //             interval(5000);
    //         }
    //     });
    // });

    // show the delete confirmation modal
    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let route_id = button.data('route_id'); // Extract info from data-* attributes
        let form_action = `/route/${route_id}/delete`;

        let modal = $(this);
        modal.find('#routeDeleteForm').attr("action", form_action);
    });

    $('#deleteRouteBtn').on('click', (e)=>{
        e.preventDefault();
        $("#routeDeleteForm").submit();
    });

    // Edit order modal


    // show the delete confirmation modal for an order
    $('#deleteCustomerModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let customer_id = button.data('customer_id'); // Extract info from data-* attributes
        let form_action = `/customer/${customer_id}/delete`;

        let modal = $(this);
        modal.find('#customerDeleteForm').attr("action", form_action);
    });

    $('#deleteCustomerBtn').on('click', (e)=>{
        e.preventDefault();
        $("#customerDeleteForm").submit();
    });

    // Edit staff modal
    $('#editPlazaModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this);
        modal.find('#id').val( button.data('id')); // Extract info from data-* attributes

        modal.find('#name').val(button.data('name')); // Extract info from data-* attributes
        modal.find('#address').val(button.data('address')); // Extract info from data-* attributes


    });

    $('#editPlazaBtno').on('click', (e)=>{
        e.preventDefault();
        // e.preventDefault();
        $("#plazaEditForm").submit();
        // let plaza_id = $('#id').val();
        // const url = `/plaza/${plaza_id}/edit`;

        // let d = new FormData();
        // d.append('token', $('#token').val());
        //
        // d.append('firstname', $('#firstname').val());
        // d.append('lastname', $('#lastname').val());
        //
        //
        //
        // $.ajax({
        //     url: url,
        //     type: 'POST',
        //     processData: false,
        //     contentType: false,
        //     cache: false,
        //     data: d,
        //     beforeSend: function(){
        //         $('#editStaffBtn').html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
        //     },
        //     success: function (response) {
        //         let data = JSON.parse(response);
        //         console.log(JSON.parse(response));
        //         let message = data.success;
        //         msg.innerHTML = alertMessage('success', message);
        //         $('#editStaffBtn').html('Save');
        //         //interval(5000);
        //         window.location.reload()
        //     },
        //     error: function(request, error){
        //         let errors = JSON.parse(request.responseText);
        //         console.log(errors);
        //         let ul = '';
        //         $.each(errors, (key, value) => {
        //             $.each(value, (index, item)=>{
        //                 console.log(item);
        //                 ul += `${item} <br>`;
        //             });
        //         });
        //
        //         msg.innerHTML = alertMessage('danger', ul);
        //         $('#editStaffBtn').html('Save');
        //         interval(5000);
        //     }
        // });
    });

    // show the delete confirmation modal for staff
    $('#deletePaymentModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let form_action = `/payment/${id}/delete`;

        let modal = $(this);
        modal.find('#paymentDeleteForm').attr("action", form_action);
    });

    $('#deletePaymentBtn').on('click', (e)=>{
        e.preventDefault();
        $("#paymentDeleteForm").submit();
    });


    $('#customer_id').on('keyup', ()=>{
        // let district = $("#district" + " option:selected").val();
        let customer_id = $("#customer_id").val();

        const data = {
            customer_id: customer_id
        };
        $.ajax({
            url: `/verifycustomer/${customer_id}`,
            type: 'GET',
            data: data,
            beforeSend: function(){
                $('#name').val('Searching...');
            },
            success: function (response) {
                $('#name').html(``);
                let customer = JSON.parse(response);
                console.log(JSON.parse(response));

                if(customer.success){
                    $("#name").val(customer.success.name);
                    $("#number").val(customer.success.phone);
                }else{
                    $("#name").val(`Customer not found!`);
                }
            },
            error: function(request, error){
                let errors = JSON.parse(request.responseText);
                console.log(errors);
                let ul = '';
                $.each(errors, (key, value) => {
                    $.each(value, (index, item)=>{
                        console.log(item);
                        ul += `${item} <br>`;
                    });
                });

            }
        });

    });


    // show the delete confirmation modal for an order
    $('#approveTransaction').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let customer_id = button.data('id'); // Extract info from data-* attributes
        console.log(customer_id);
        // let form_action = `/customer/${customer_id}/delete`;

        let modal = $(this);
        modal.find('#contribution_id').val( button.data('id'));
    });

    $("#approveBtn").on('click', (e)=>{
        e.preventDefault();
        $("#approveForm").submit();
    });


    function alertMessage(status, message){
        return `<div class="alert alert-${status} m-t-20 alert-dismissible fade show" role="alert">
                    ${message}
                </div>`;
    }

    function interval(duration){
        setTimeout(()=>{
            $(".alert").alert('close');
        }, duration);
    }

    // Search name for bulk sms

    const searchname = $('#searchname');
    const searchname_result = $('.searchname-result');
    searchname.on('input', ()=>{
        $('.searchname-result').css('display','block');
        let terms = searchname.val();
        console.log(terms.length);
        if(terms.length === 0){
            searchname.addClass('no-bottom-borders');
            $('.searchname-result').css('display','none');
        }else{
            console.log(terms);
            const url = `/getnumber/${terms}/search`;
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    searchname_result.html('loading...');
                },
                success: function (response) {

                    let data = JSON.parse(response);
                    if(data.success){
                        let ul = '<ul class="list-group list-group-flush">';
                        $.each(data, (key, value) => {
                            $.each(value, (index, item)=>{
                                console.log(item);
                                ul += `<li class="list-group list-group-item">
                                   <div>
                                        <div id="cl" data-phone="${item.phone}" class="d-flex w-100 justify-content-between">
                                            <h6 data-phone="${item.phone}">${item.name}</h6>
                                            <p data-phone="${item.phone}">${item.phone}</p>
                                        </div>
                                    </div>
                                </li>`;
                            });
                        });
                        ul += '</ul>';
                        $('.searchname-result').html(ul);
                    }else{
                        let ul = '<ul class="list-group list-group-flush">';
                            ul += '<li>No result found</li>';
                        ul += '</ul>';
                        $('.searchname-result').html('No result found');
                    }

                },
                error: function(request, error){
                    let ul = '<ul class="list-group list-group-flush">';
                    ul += '<li>No result found</li>';
                    ul += '</ul>';
                    $('.searchname-result').html('No result found');
                }
            });
        }

    });
    // ul += '<li class="list-group list-group-item"><div class="d-flex w-100 justify-content-between"><h6>' + item.firstname + ' ' + item.surname + '</h6><small>'+ item.phone +'</small></div><p class="mb-1">'+ item.email +'</p></li>';
    search.on('blur', ()=>{
        $('#search').removeClass('no-bottom-borders');
        // $('.search-result').css('display','none');
    });

    $(document).on('click', '#cl', function(e){
        $('.searchname-result').css('display','none');
       let num =  e.target.getAttribute('data-phone');
       $("#number").val('');
       $("#number").val(num);
    });


});

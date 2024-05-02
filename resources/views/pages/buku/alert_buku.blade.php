@if(Session::has('success_insert_buku'))
    <div id="success-insert-alert" class="alert alert-success" role="alert">
        {{ Session::get('success_insert_buku') }}
    </div>
@endif

@if(Session::has('success_update_buku'))
    <div id="success-update-alert" class="alert alert-success" role="alert">
        {{ Session::get('success_update_buku') }}
    </div>
@endif

@if(Session::has('delete_buku'))
    <div id="success-delete-alert" class="alert alert-danger" role="alert">
        {{ Session::get('delete_buku') }}
    </div>
@endif

<script>
    setTimeout(function(){
        $('#success-update-alert').alert('close');
    }, 2500);
    setTimeout(function(){
        $('#success-insert-alert').alert('close');
    }, 2500);
    setTimeout(function(){
        $('#success-delete-alert').alert('close');
    }, 2500);
</script>

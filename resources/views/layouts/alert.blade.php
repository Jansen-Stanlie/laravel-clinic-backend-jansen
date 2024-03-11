@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible show fade" role="alert" id="successAlert">
        <div class="alert-body">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible show fade" role="alert" id="errorAlert">
        <div class="alert-body">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Auto-close success alert after 5 seconds
        setTimeout(function() {
            $("#successAlert").alert('close');
        }, 5000);

        // Auto-close error alert after 5 seconds
        setTimeout(function() {
            $("#errorAlert").alert('close');
        }, 5000);
    });
</script>

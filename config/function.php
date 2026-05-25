<?php
function statusSuccess($status, $location)
{
    return "<div class='alert alert-success' role='alert'>A simple success alert—check it out!</div>

<script>
    setTimeout(function(){
        window.location.href = '$location';
    }, 5000);

</script>
";
}

function statusFailed($status, $location)
{
    return "<div class='alert alert-danger' role='alert'>$status</div>

<script>
    setTimeout(function(){
        window.location.href = '$location';
    }, 5000);

</script>
";
}

function inputFailed($status, $location)
{
    return "<div class='alert alert-warning' role='alert'>$status</div>

<script>
    setTimeout(function(){
        window.location.href = '$location';
    }, 5000);

</script>
";
}

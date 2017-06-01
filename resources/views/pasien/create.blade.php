<!-- app/views/nerds/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('pasien') }}">Nerd Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('pasien') }}">View All Nerds</a></li>
        <li><a href="{{ URL::to('pasien/create') }}">Create a Nerd</a>
    </ul>
</nav>

<h1>Registrasi Pasien</h1>

<!-- if there are creation errors, they will show here -->


{!! Form::open(array('url' => 'pasien/create')) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('dob', 'Tanggal Lahir') !!}
        {!! Form::text('dob', Input::old('dob'), array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'datepicker')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('gender', 'Jenis Kelamin') !!}
        {!! Form::select('gender', array('0' => 'Select an option', '1' => 'Laki-laki', '2' => 'Perempuan'), Input::old('gender'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Alamat') !!}
        {!! Form::text('address', Input::old('address'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('phone', 'Kontak') !!}
        {!! Form::text('phone', Input::old('phone'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Simpan', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker({
          changeMonth: true,
          changeYear: true,
          format: "dd/mm/yyyy",
          yearRange: "1900:+0",
          forceParse: false
        });
    });
</script>
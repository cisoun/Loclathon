<?php
$date = [
  '2020' => '5 septembre 2020',
  '2019' => '24 août 2019'
];
?>

@extend('views/layouts/photos')

@data('title', '{{ year }}')

@section('css')
.grid > a > img { height: 100%; width: 100%; }
@endsection

@section('header')
<h1>{{ year }}</h1>
Tournée du <?php echo $date[$params['year']]; ?>.
@endsection

@section('grid')
<?php
  $year = $params['year'];
  $root = getcwd() . "/static/photos/$year";
  $files = scandir($root);
  $files = array_filter($files, function ($file) use ($root) {
    return !is_dir($root . "/$file");
  });
  foreach ($files as $file):
?>
<a href="/static/photos/{{ year }}/<?php echo $file; ?>"><img src="/static/photos/{{ year }}/min/<?php echo $file; ?>"/></a>
<?php endforeach; ?>
@endsection

<?php
$albums = [
  '2020' => '_DSC4825',
  '2019' => '_DSC4627'
];
?>

@extend('views/layouts/photos')
@data('title', 'Photos')

@section('css')
#photos #grid div a span { background-color: rgba(0, 0, 0, 0.8); }
@endsection

@section('header')
<h1>Albums</h1>
@endsection

@section('grid')
<?php foreach ($albums as $year => $file): ?>
  <div style="background-image: url('/static/photos/<?php echo $year ?>/min/<?php echo $file ?>.jpg')">
    <a href="/photos/<?php echo $year ?>"><div><?php echo $year ?></div></a>
  </div>
<?php endforeach; ?>
@endsection

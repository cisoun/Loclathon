@extend('views/layouts/main')
@section('css')
.photos { text-align: center; }
#photos { max-width: 800px; text-align: center; }
#photos h1 { margin-bottom: 0; }
.grid {
  display: grid;
  grid-gap: 0;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  grid-auto-rows: 1fr;
  margin: 6rem 0;
}
@media screen and (max-width: 400px) {
  .grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }
}
.grid::before {
  content: '';
  width: 0;
  padding-bottom: 100%;
  grid-row: 1 / 1;
  grid-column: 1 / 1;
}
.grid > *:first-child {
  grid-row: 1 / 1;
  grid-column: 1 / 1;
}
.grid > div,
.grid > a {
  background-repeat: no-repeat;
  background-size: cover;
  border: 2px solid transparent;
  transition: border var(--transition);
}
.grid > div:hover, .grid > a:hover { border: 2px solid var(--foreground); }
.grid > div > a {
  align-items: center;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  height: 100%;
  justify-content: center;
  transition: background var(--transition);
  width: 100%;
}
.grid > div:hover > a { background-color: rgba(0, 0, 0, 0.9); }
.grid > div > a > div { font-size: 2rem; }

@render('css');
@endsection

@section('content')
<section id="photos" class="container">
  @render('header')
  <div id="grid" class="grid">
  @render('grid')
  </div>
</section>
@endsection

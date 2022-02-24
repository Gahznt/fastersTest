<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <title>Teste de Laravel - Gabriel Zanata</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/album/">
    <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>

<header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="{{url('/')}}" class="navbar-brand d-flex align-items-center">
        <strong>PHP FASTERS TEST - Laravel</strong>
      </a>
    </div>
  </div>
</header>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">API REST (Web App)</h1>
        <p class="lead text-muted">Os dados devem climáticos devem ser coletados na API do OpenWeather (https://openweathermap.org/api).</p>
        @if (!empty($new_clima['message']))
          <p class="danger">$new_clima['message'])</p>
        @else
        <p>Local: <b>{{$new_clima['city'] ?? 'Cidade não encontrada'}}</b>, Temperatura: <b>{{$new_clima['temp'] ?? '-'}} °C </b></p>
        @endif
        <a href="{{url('/')}}" class="btn btn-primary col-md-4 mt-3 order-md-1" type="submit">Voltar</a>
      </div>
    </div>
  </section>

</main>
  </body>
</html>

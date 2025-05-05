<H1> Teste Rede Parcerias </H1>

<h3> Tecnologias: </h3>
<ul>
  <li> Laravel 12 </li>
  <li> Inertia + React JS </li>
  <li> Tailwind </li>
  <li> Styled Component </li>
  <li> JWT </li>
  <li> SweetAlert2 </li>
</ul>

<h3> Instalação: </h3>
<ul>
  <li> composer install</li>
  <li> cp .env.example .env </li>
  <li> ATUALIZE O  <i>.env</i> COM SUAS CREDENCIAIS DO BANCO DE DADOS </li>
  <li> php artisan key:generate </li>
  <li> php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" </li>
  <li> php artisan jwt:secret </li>
  <li> php artisan migrate </li>
  <li> php artisan db:seed </li>
  <li> npm install </li>
  <li> composer dev </li>
</ul>

<h3> Teste Unitário: </h3>
<h6>Executar PEST PHP</h6>

<strong>Executar o PEST e todos os casos de testes: </strong> <br>
<i> php artisan test tests </i>
<br><br>
<strong>Ou apenas casos especificos: </strong> <br>
<i> php artisan test tests/Nome da pasta/Nome do arquivo.php </i>

@extends('layouts.simple')

@section('contenido')
<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Moneda</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody id="tabla-tipo-cambio">
        <tr><td colspan="2">Cargando datos...</td></tr>
    </tbody>
</table>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        axios.get("https://api.exchangerate-api.com/v4/latest/USD")
            .then(function (response) {
                const rates = response.data.rates;
                const tbody = document.getElementById("tabla-tipo-cambio");

                tbody.innerHTML = '';

                const monedas = ['EUR', 'JPY', 'GBP', 'MXN', 'CAD', 'CRC'];
                monedas.forEach(moneda => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td>${moneda}</td><td>${rates[moneda]}</td>`;
                    tbody.appendChild(tr);
                });
            })
            .catch(function (error) {
                console.error("Error al obtener datos del API:", error);
                toastr.error('No se pudo cargar el tipo de cambio.');
            });
    });
</script>
@endsection

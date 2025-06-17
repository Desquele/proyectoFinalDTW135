@extends('layouts.simple')

@section('contenido')
<style>
    body {
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: #202124;
    }
</style>
<table class="table" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #3a3a3a; color: #f1f1f1;">
            <th style="padding: 12px 15px; text-align: left; border: 1px solid #555;">Moneda</th>
            <th style="padding: 12px 15px; text-align: left; border: 1px solid #555;">Valor</th>
        </tr>
    </thead>
    <tbody id="tabla-tipo-cambio">
        <tr style="background-color: #dcdcdc;">
            <td colspan="2" style="padding: 12px 15px; text-align: center; border: 1px solid #aaa; color: #202124;">
                Cargando datos...
            </td>
        </tr>
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
                monedas.forEach((moneda, index) => {
                    const tr = document.createElement("tr");
                    const bgColor = index % 2 === 0 ? '#f0f0f0' : '#e0e0e0';
                    tr.style.backgroundColor = bgColor;
                    tr.innerHTML = `
                        <td style="padding: 12px 15px; border: 1px solid #bbb; font-weight: bold; color: #202124;">${moneda}</td>
                        <td style="padding: 12px 15px; border: 1px solid #bbb; color: #202124;">${rates[moneda]}</td>
                    `;
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

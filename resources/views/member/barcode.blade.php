<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>
    <style>
        .text-center {
            text-align: center;
        }

    </style>
</head>

<body>
    <table class="table table-light" width="100%">
        <tr>
            @foreach ($data as $key => $item)
                <td class="text-center" style="border: 1px solid;">
                    {{ $item->nama_produk }} - Rp. {{ format_uang($item->harga_jual) }}
                    <img src="data:image/png;base64,{{ DNS1D::getBardcodePNG($item->kode, 'C39') }}"
                        alt="{{ $item->kode }}">
                    <br>
                    {{ $item->kode }}
                </td>
                @if ($key + (1 % 3) == 0)
        <tr></tr>
        @endif
        @endforeach

        </tr>
    </table>
</body>

</html>

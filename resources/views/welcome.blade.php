<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: #f5f5f5;
            padding-left: 20px;
            padding-right: 20px;
        }

        .calculator {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            background: #fff;
        }

        .form-control,
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 20px);
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .col-md-3 {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <div class="calculator">
        <form action="/calculate" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <input type="number" name="bil_1" class="form-control" placeholder="Masukan angka pertama"
                        required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="bil_2" class="form-control" placeholder="Masukan angka kedua"
                        required>
                </div>
                <div class="col-md-3">
                    <select name="operasi" class="form-control">
                        <option value="tambah">+</option>
                        <option value="kurang">-</option>
                        <option value="bagi">/</option>
                        <option value="kali">*</option>
                        <option value="mod">%</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn">Calculate</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-3">
                {{-- Periksa jika ada user dan tampilkan menggunakan looping --}}
                @if ($calculations->count())
                    <table border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>bilangan1</th>
                                <th>operasi</th>
                                <th>bilangan2</th>
                                <th>hasil</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calculations as $index => $calculation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $calculation->operand1 }}</td>
                                    <td>
                                        @if ($calculation->operation == 'tambah')
                                            +
                                        @elseif($calculation->operation == 'kurang')
                                            -
                                        @elseif($calculation->operation == 'bagi')
                                            /
                                        @elseif($calculation->operation == 'kali')
                                            *
                                        @elseif($calculation->operation == 'mod')
                                            %
                                        @else
                                            {{ $calculation->operation }}
                                        @endif
                                    </td>
                                    <td>{{ $calculation->operand2 }}</td>
                                    <td>{{ $calculation->result }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button onclick="useCalculation({{ $index }})" class="btn btn-use">gunakan</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada operasi yang ditemukan.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function useCalculation(index) {
            const row = document.querySelectorAll("table tbody tr")[index];
            const operand1 = row.cells[1].textContent;
            const operand2 = row.cells[3].textContent;
            const operation = row.cells[2].textContent;

            document.querySelector('input[name="bil_1"]').value = operand1;
            document.querySelector('input[name="bil_2"]').value = operand2;

            const operationDropdown = document.querySelector('select[name="operasi"]');
            for (let option of operationDropdown.options) {
                if (option.value === operation) {
                    option.selected = true;
                    break;
                }
            }
        }
    </script>
</body>

</html>

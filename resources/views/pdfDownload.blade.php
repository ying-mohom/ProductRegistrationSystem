<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Item</title>
    <style>
        #table-border {
            border: 1px solid black !important;
        }

        .textColor {
            color: #FFFFFF !important;
        }
        .table-cell {
        font-size: 20px; /* Adjust the font size as needed */
    }
    </style>
</head>

<body>
    <h1 class="text-center " style="font-size: 2em;">"Item List"</h1>
    <br>
    <table class="table text-center" id="table-border">
        <thead>
            <tr style="background-color:#037171;">
                <th class="p-3 col-1 text-center textColor table-cell" id="table-border">No</th>
                <th class="p-3 col-2 text-center textColor table-cell" id="table-border">Item ID</th>
                <th class="p-3 col-2 text-center textColor table-cell" id="table-border">Item Code</th>
                <th class="p-3 col-3 text-center textColor table-cell" id="table-border">Item Name</th>
                <th class="p-3 col-3 text-center textColor table-cell" id="table-border">Category Name</th>
                <th class="p-3 col-3 text-center textColor table-cell" id="table-border">Safety Stock</th>
                <th class="p-3 col-3 text-center textColor table-cell" id="table-border">Received Date</th>
                <th class="p-3 col-3 text-center textColor table-cell" id="table-border">Description</th>





            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr id="table-border" class="" style="background-color:#FFFFFF;">
                    <td class="p-3 table-cell" id="table-border"> {{ $loop->iteration }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->item_id }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->item_code }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->item_name }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->category_name }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->safety_stock }}</td>
                    <td class="p-3 table-cell" id="table-border">{{ $item->received_date }}</td>
                    @if ($item->description == null)
                        <td class="p-3 table-cell" id="table-border">{{ '-' }}</td>
                    @else
                        <td class="p-3 table-cell " id="table-border" style="text-align: left;">{{ $item->description }}</td>
                    @endif

                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>

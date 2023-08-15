<style>
    table,table tr th, table tr td {
        padding-left: 15px;
        padding-right: 15px;
    }
    table,table tr th, table tr td { border:1px solid #e1e8ea; box-shadow: 0 1px 1px rgba(0,0,0,.1);}
    table { min-height: 30px; line-height: 30px; text-align: center; border-collapse: collapse; padding:2px;}
</style>

<table>
    <thead>
    <tr>
        <th>產品名稱</th>
        <th>單價</th>
        <th>數量</th>
        <th>總價</th>
    </tr>
    </thead>
    <tbody>
    @php
        $num = 0;
        $total_price = 0
    @endphp
    @foreach($products as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ $item->number }}</td>
            <td>{{ $item->number*$item->unit_price }}</td>
        </tr>

        @php
            $num += $item->number;
            $total_price += $item->number*$item->unit_price;
        @endphp

    @endforeach

    <tr>
        <td colspan="2">合計</td>
        <td>{{ $num }}</td>
        <td>{{ $total_price }}</td>
    </tr>
    </tbody>
</table>


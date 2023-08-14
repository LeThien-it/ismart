<div id="wrap-inner" style="font-family:Arial;background-color: #ececec;padding: 15px 0px; font-size: 14px;">
    <div class="content-confirmation" style="padding: 15px; max-width: 600px; background-color: white; margin: 0px auto;">
        <h3 style="margin-top: 0px;">Cảm ơn quý khách {{ $data['info']->name }} đã đặt hàng tại Ismart Store</h3>
        <div id="customer">
            <h3 style="color:#02acea; border-bottom: 1px solid #333">Thông tin khách hàng</h3>
            <p>
                <strong>Khách hàng: </strong>
                {{ $data['info']->name }}
            </p>
            <p>
                <strong class="info">Email: </strong>
                {{ $data['info']->email }}
            </p>
            <p>
                <strong class="info">Điện thoại: </strong>
                {{ $data['info']->phone }}
            </p>
            <p>
                <strong class="info">Địa chỉ: </strong>
                {{ $data['info']->address }}
            </p>
        </div>
        <div id="order-detail">
            <h3 style="color:#02acea;border-bottom: 1px solid #333;">Chi tiết đơn hàng {{ $data['order_code'] }}</h3>
            <table style="width: 100%; background-color: #eeeeee;" cellspacing="0">
                <thead style="background-color: #02acea; color: white">
                    <tr class="bold">
                        <td width="35%" style="padding:5px;"><strong>Tên sản phẩm</strong></td>
                        <td width="20%" style="text-align: center;"><strong>Đơn giá</strong></td>
                        <td width="10%"><strong>Màu</strong></td>
                        <td width="15%"><strong>Số lượng</strong></td>
                        <td width="20%" style="padding:5px; text-align: right;"><strong>Tổng tạm</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['cart'] as $item)
                        <tr>
                            <td style="padding: 5px;">{{ $item->name }}</td>
                            <td class="price" style="text-align: center;">
                                {{ number_format($item->price, 0, ',', '.') }}đ
                            </td>
                            <td>{{ $item->options->color }}</td>
                            <td style="text-align: center;">{{ $item->qty }}</td>
                            <td style="padding: 5px; text-align: right;" class="price">
                                {{ number_format($item->price * $item->qty, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td align="right" colspan="4" style="font-weight: bold; padding:5px">Tổng giá trị đơn hàng:</td>
                    <td class="total-price" style="font-weight: bold; padding:5px; text-align:right">
                        {{ number_format($data['total'], 0, ',', '.') }}đ
                    </td>
                </tr>
            </table>
           
        </div>
        <div id="info">
            <br>
            <p>
                Ismart Store rất vui thông báo đơn hàng {{ $data['order_code'] }} của quý khách đã được tiếp nhận và đang trong quá trình xử lý. Ismart Store sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao.
            </p>
            <b>Một lần nữa Ismart Store cảm ơn quý khách.</b>
        </div>
    </div>
</div>

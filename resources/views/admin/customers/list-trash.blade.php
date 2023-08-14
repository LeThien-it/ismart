@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách khách hàng</h5>
                <form class="form-inline" action="#">
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="input-group-text bg-white font-weight-custom" name="field" id="">
                                    @foreach ($list_field as $field => $nameField)
                                        <option {{ request()->field == $field ? 'selected' : '' }}
                                            value="{{ $field }}">
                                            {{ $nameField }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="form-control" placeholder="Tìm theo trường bị vô hiệu hóa"
                                name="keyword1" value="{{ request()->keyword1 }}" style="width: 273px;">
                        </div>

                    </div>
                    <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary">
                </form>
            </div>

            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('customer.list', ['kind' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ route('customer.list', ['kind' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>

                @if (Session('status'))
                    <div class="alert alert-success mb-0">
                        {{ Session('status') }}
                    </div>
                @endif
                @if (Session('error'))
                    <div class="alert alert-danger mb-0">
                        {{ Session('error') }}
                    </div>
                @endif

                <form action="{{ route('customer.action') }}">
                    <div class="form-action form-inline py-3">
                        @can('delete_customer')
                            <select class="form-control" id="" name="act">
                                <option value="">Chọn tác vụ</option>
                                @foreach ($list_act as $act => $act_content)
                                    <option value="{{ $act }}">{{ $act_content }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Áp dụng" class="btn btn-primary mx-2">
                        @endcan
                        <table class="table table-striped table-bordered table-checkall mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="2%">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col" width="2%">ID</th>
                                    <th scope="col" width="30%">Khách hàng</th>
                                    <th scope="col" width="13%">Email</th>
                                    <th scope="col" width="13%">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($customers->count() > 0)
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="listCheck[]" value="{{ $customer->id }}">
                                            </td>
                                            <td scope="row">{{ $customer->id }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->address }}</td>
                                            <td>{{ date('d/m/Y', strtotime($customer->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="bg-white">
                                            Không tìm thấy bản ghi nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $customers->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

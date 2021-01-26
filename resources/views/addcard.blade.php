<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 4 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header" style="text-align: right;">
                    {{--<button type="button" class="btn btn-primary">Load</button>
                    <button type="button" class="btn btn-info">Add card</button>--}}
                </div>
                <div class="card-body">
                    @if(!empty($alert))
                        @foreach($alert as $alertItem)
                            <div class="alert alert-danger">
                                <strong>Thông báo!</strong> {{$alertItem}}
                            </div>
                        @endforeach
                    @endif
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>account_id</th>
                            <th>Trạng thái</th>
                            <th>Trạng thái thẻ</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $adsItem)
                            <tr>
                                <td>{{ $loop->index + 1}}</td>
                                <td>{{$adsItem['id']}}</td>
                                <td>{{$adsItem['name']}}</td>
                                <td>{{$adsItem['account_id']}}</td>
                                <td>{{(($adsItem['account_status']==1)? "Hoạt động": "Không hoạt động")}}</td>
                                <td>{{$adsItem['hasCard']}}</td>
                                <td>{{--<input type="checkbox" class="form-check-input" value=""
                                           style="margin-left: 0;">--}}
                                    @if($adsItem['canAddCard'])
                                        <button type="button" data-id="{{$adsItem['account_id']}}"
                                                class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="text-align: right;">
                    {{--<button type="button" class="btn btn-primary">Load</button>
                    <button type="button" class="btn btn-info">Add card</button>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loading" style="display: none;">
    <div class="loading-overlay"></div>
    <div class="loading-pre">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve" width="30" height="30">

		<rect fill="#FBBA44" width="15" height="15">
            <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="1.7s"
                              values="0,0;15,0;15,15;0,15;0,0;" repeatCount="indefinite"/>
        </rect>

            <rect x="15" fill="#E84150" width="15" height="15">
                <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="1.7s"
                                  values="0,0;0,15;-15,15;-15,0;0,0;" repeatCount="indefinite"/>
            </rect>

            <rect x="15" y="15" fill="#62B87B" width="15" height="15">
                <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="1.7s"
                                  values="0,0;-15,0;-15,-15;0,-15;0,0;" repeatCount="indefinite"/>
            </rect>

            <rect y="15" fill="#2F6FB6" width="15" height="15">
                <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="1.7s"
                                  values="0,0;0,-15;15,-15;15,0;0,0;" repeatCount="indefinite"/>
            </rect>
    </svg>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/addcard.js') }}" defer></script>
</body>
</html>

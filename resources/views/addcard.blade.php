<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 4 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header" style="text-align: right;">
                    <button type="button" class="btn btn-primary">Load</button>
                    <button type="button" class="btn btn-info">Add card</button>
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
                                    <button type="button" data-id="{{$adsItem['account_id']}}"
                                            class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>1</td>
                            <td>act_121079589878148</td>
                            <td>2401NgocTrinh 0134</td>
                            <td>121079589878148</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="121079589878148" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>act_122301956397535</td>
                            <td>122301956397535</td>
                            <td>122301956397535</td>
                            <td>Hoạt động</td>
                            <td>Đã add</td>
                            <td>
                                <button type="button" data-id="122301956397535" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>act_128174222411223</td>
                            <td>2401NgocTrinh 0269</td>
                            <td>128174222411223</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="128174222411223" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>act_139337127922545</td>
                            <td>139337127922545</td>
                            <td>139337127922545</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="139337127922545" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>act_165538791710690</td>
                            <td>2401NgocTrinh 0085</td>
                            <td>165538791710690</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="165538791710690" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>act_217650413337429</td>
                            <td>217650413337429</td>
                            <td>217650413337429</td>
                            <td>Hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="217650413337429" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>act_254886759404461</td>
                            <td>254886759404461</td>
                            <td>254886759404461</td>
                            <td>Hoạt động</td>
                            <td>Đã add</td>
                            <td>
                                <button type="button" data-id="254886759404461" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>act_259085002592000</td>
                            <td>Antimo Grasso</td>
                            <td>259085002592000</td>
                            <td>Hoạt động</td>
                            <td>Đã add</td>
                            <td>
                                <button type="button" data-id="259085002592000" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>act_407244577047486</td>
                            <td>Anselmo Pellegrino</td>
                            <td>407244577047486</td>
                            <td>Hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="407244577047486" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>act_493936062002662</td>
                            <td>2401NgocTrinh 0160</td>
                            <td>493936062002662</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="493936062002662" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>act_685268508824180</td>
                            <td>2401NgocTrinh 0075</td>
                            <td>685268508824180</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="685268508824180" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>act_696564261225110</td>
                            <td>Ferdinando Pellegrino</td>
                            <td>696564261225110</td>
                            <td>Hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="696564261225110" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>act_960441077697310</td>
                            <td>2401NgocTrinh 0084</td>
                            <td>960441077697310</td>
                            <td>Không hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="960441077697310" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>act_3649838371761251</td>
                            <td>Vienna Bianchi</td>
                            <td>3649838371761251</td>
                            <td>Hoạt động</td>
                            <td>Đã add</td>
                            <td>
                                <button type="button" data-id="3649838371761251" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>act_3809107872515393</td>
                            <td>Cesidia Silvestri</td>
                            <td>3809107872515393</td>
                            <td>Hoạt động</td>
                            <td>Chưa add</td>
                            <td>
                                <button type="button" data-id="3809107872515393" class="btn btn-primary btn-sm add-card-btn">Add thẻ
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="text-align: right;">
                    <button type="button" class="btn btn-primary">Load</button>
                    <button type="button" class="btn btn-info">Add card</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/addcard.js') }}" defer></script>
</body>
</html>

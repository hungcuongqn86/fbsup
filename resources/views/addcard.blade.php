<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 4 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <div class="card-header">
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
                    <table class="table table-dark table-striped table-hover">
                        <thead>
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
                                <td><input type="checkbox" class="form-check-input" value=""></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary">Load</button>
                    <button type="button" class="btn btn-info">Add card</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

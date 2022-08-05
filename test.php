<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Bộ lọc thay đổi tỉnh thành quận huyện phường xã</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center p-2">
            <div class="col-md-auto">
                <select class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                    <option value="" selected>Chọn tỉnh thành</option>
                </select>

                <select class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                    <option value="" selected>Chọn quận huyện</option>
                </select>

                <select class="form-select form-select-sm" id="ward" aria-label=".form-select-sm">
                    <option value="" selected>Chọn phường xã</option>
                </select>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");
        var Parameter = {
            url: "vietnam.json", //Đường dẫn đến file chứa dữ liệu hoặc api do backend cung cấp
            method: "POST",
            responseType: "application/json",
        };

        var promise = axios(Parameter);
        //Xử lý khi request thành công
        promise.then(function(result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Id);
            }

            citis.onchange = function() {
                district.length = 1;
                ward.length = 1;
                if (this.value != "") {
                    const result = data.filter(n => n.Id === this.value);

                    for (const k of result[0].Districts) {
                        district.options[district.options.length] = new Option(k.Name, k.Id);
                    }
                }
            };

            district.onchange = function() {
                ward.length = 1;
                const dataCity = data.filter((n) => n.Id === citis.value);
                if (this.value != "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                }
            };
        }
    </script>

</body>

</html>
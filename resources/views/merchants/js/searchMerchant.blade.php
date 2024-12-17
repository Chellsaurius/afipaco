<script>
    function searchMerchant(){
        $('#showResult').empty();
        var curp = document.getElementById('scurp').value;
        var url = 'ajaxSearchMerchant/' + curp;
        // console.log(curp);
        if (curp.length >= 10) {
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
            }).done(function(merchant){
                // console.log(merchant)
                if (merchant.merchant_id > 1) {
                    var date = merchant.created_at;
                    date = date.substring(0, 10);
                    var resultado = "<div class='col-12  align-middle' style='align-self: center'>" +
                                        "<button class='btn btn-outline-success col-3'>Registrado el: " + date + "</button>" +
                                    "</div>"
                    document.getElementById("showResult").innerHTML = resultado;
                } else {
                    var resultado = "<div class='col-12  align-middle' style='align-self: center'>" +
                                        "<button class='btn btn-outline-danger col-3'>Comerciante no registrado</button>" +
                                    "</div>"
                    document.getElementById("showResult").innerHTML = resultado;
                }
            })
        } else {
            alert('datos incorrectos')
            curp = "";
        }
        
    }
</script>
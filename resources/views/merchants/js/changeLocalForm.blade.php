<script>
    function changeForm(sel) {
        Tianguista.style.display = "none";
        Semifijo.style.display = "none";
        Ambulante.style.display = "none";
        Ocasional.style.display = "none";
        Otro.style.display = "none";

        var cat = document.getElementById("categoria").value;
        var catName = document.getElementById(cat).innerHTML;
        // console.log(catName);

        // tianguis
        var TUbicacion = document.getElementById("TUbicacion");
        TUbicacion.required = false;
        TUbicacion.disabled = true; 
        var tianguis = document.getElementById("tianguis");
        tianguis.required = false;
        tianguis.disabled = true; 
        var lugares = document.getElementById("lugares");
        lugares.required = false;
        lugares.disabled = true; 
        lugares = document.getElementById("lugares").value;
        if (lugares > 0) {
            for (let index = 1; index <= lugares; index++) {
                var dimx = document.getElementById("dimx" + [index]);
                dimx.required = false;
                dimx.disabled = true; 
            }
            for (let index = 1; index <= lugares; index++) {
                var dimy = document.getElementById("dimy" + [index]);
                dimy.required = false;
                dimy.disabled = true; 
            } 
        }
        disabled = true; 

        // semifijo
        var SIHour = document.getElementById("SIHour");
        SIHour.required = false;
        SIHour.disabled = true; 
        var SFHour = document.getElementById("SFHour");
        SFHour.required = false;
        SFHour.disabled = true; 
        
        var SDimx = document.getElementById("SDimx");
        SDimx.required = false;
        SDimx.disabled = true; 
        var SDimy = document.getElementById("SDimy");
        SDimy.required = false;
        SDimy.disabled = true; 

        var SUbicacion = document.getElementById("SUbicacion");
        SUbicacion.required = false;
        SUbicacion.disabled = true; 

        // ambulante
        var AIHour = document.getElementById("AIHour");
        AIHour.required = false;
        AIHour.disabled = true; 
        var AFHour = document.getElementById("AFHour");
        AFHour.required = false;
        AFHour.disabled = true; 
        
        var ADimx = document.getElementById("ADimx");
        ADimx.required = false;
        ADimx.disabled = true; 
        var ADimy = document.getElementById("ADimy");
        ADimy.required = false;
        ADimy.disabled = true; 

        var AUbicacion = document.getElementById("AUbicacion");
        AUbicacion.required = false;
        AUbicacion.disabled = true; 
        var OIHour = document.getElementById("OIHour");

        // ocasional

        var OUbicacion = document.getElementById("OUbicacion");
        OUbicacion.required = false;
        OUbicacion.disabled = true; 
        
        var OLugar = document.getElementById("OLugar");
        OLugar.required = false;
        OLugar.disabled = true; 
        var OLugares = document.getElementById("OLugares");
        OLugares.required = false;
        OLugares.disabled = true; 

        OLugares = document.getElementById("OLugares").value;
        if (OLugares > 0) {
            for (let index = 1; index <= lugares; index++) {
                var ODimx = document.getElementById("ODimx" + [index]);
                ODimx.required = false;
                ODimx.disabled = true; 
            }
            for (let index = 1; index <= lugares; index++) {
                var ODimy = document.getElementById("ODimy" + [index]);
                ODimy.required = false;
                ODimy.disabled = true; 
            } 
        }
        
        //otros
        var OtrosIHour = document.getElementById("OtrosIHour");
        OtrosIHour.required = false;
        OtrosIHour.disabled = true; 
        var OtrosFHour = document.getElementById("OtrosFHour");
        OtrosFHour.required = false;
        OtrosFHour.disabled = true; 
        
        var OtrosDimx = document.getElementById("OtrosDimx");
        OtrosDimx.required = false;
        OtrosDimx.disabled = true; 
        var OtrosDimy = document.getElementById("OtrosDimy");
        OtrosDimy.required = false;
        OtrosDimy.disabled = true; 

        var OtrosUbicacion = document.getElementById("OtrosUbicacion");
        OtrosUbicacion.required = false;
        OtrosUbicacion.disabled = true; 

        // aquí empieza a ver qué se seleccionó y que debe de activar
        if(catName == 'Tianguista'){
            var selectableDays = document.getElementById("selectableDays");
            selectableDays.style.display = "none";
            
            var TUbicacion = document.getElementById("TUbicacion");
            TUbicacion.required = true;
            TUbicacion.disabled = false; 
            var tianguis = document.getElementById("tianguis");
            tianguis.required = true;
            tianguis.disabled = false; 
            var lugares = document.getElementById("lugares");
            lugares.required = true;
            lugares.disabled = false; 
            lugares = document.getElementById("lugares").value;
            if (lugares > 0) {
                for (let index = 1; index <= lugares; index++) {
                    var dimx = document.getElementById("dimx" + [index]);
                    dimx.required = true;
                    dimx.disabled = false; 
                }
                for (let index = 1; index <= lugares; index++) {
                    var dimy = document.getElementById("dimy" + [index]);
                    dimy.required = true;
                    dimy.disabled = false; 
                } 
            }
        }

        if(catName == 'Semifijo'){
            var selectableDays = document.getElementById("selectableDays");
            selectableDays.style.display = "block";

            var SIHour = document.getElementById("SIHour");
            SIHour.required = true;
            SIHour.disabled = false; 
            var SFHour = document.getElementById("SFHour");
            SFHour.required = true;
            SFHour.disabled = false; 
            
            var SDimx = document.getElementById("SDimx");
            SDimx.required = true;
            SDimx.disabled = false; 
            var SDimy = document.getElementById("SDimy");
            SDimy.required = true;
            SDimy.disabled = false; 

            var SUbicacion = document.getElementById("SUbicacion");
            SUbicacion.required = true;
            SUbicacion.disabled = false; 
        }

        if(catName == 'Ambulante'){
            var selectableDays = document.getElementById("selectableDays");
            selectableDays.style.display = "block";

            var AIHour = document.getElementById("AIHour");
            AIHour.required = true;
            AIHour.disabled = false; 
            var AFHour = document.getElementById("AFHour");
            AFHour.required = true;
            AFHour.disabled = false; 
            
            var ADimx = document.getElementById("ADimx");
            ADimx.required = true;
            ADimx.disabled = false; 
            var ADimy = document.getElementById("ADimy");
            ADimy.required = true;
            ADimy.disabled = false; 

            var AUbicacion = document.getElementById("AUbicacion");
            AUbicacion.required = true;
            AUbicacion.disabled = false; 
        }

        if(catName == 'Ocasional'){
            var selectableDays = document.getElementById("selectableDays");
            selectableDays.style.display = "block";

            var OUbicacion = document.getElementById("OUbicacion");
            OUbicacion.required = true;
            OUbicacion.disabled = false; 
            var centros = document.getElementById("OLugar");
            centros.required = true;
            centros.disabled = false; 
            var lugares = document.getElementById("OLugares");
            lugares.required = true;
            lugares.disabled = false; 
            lugares = document.getElementById("OLugares").value;
            if (lugares > 0) {
                for (let index = 1; index <= lugares; index++) {
                    var ODimx = document.getElementById("ODimx" + [index]);
                    ODimx.required = true;
                    ODimx.disabled = false; 
                }
                for (let index = 1; index <= lugares; index++) {
                    var ODimy = document.getElementById("ODimy" + [index]);
                    ODimy.required = true;
                    ODimy.disabled = false; 
                } 
            }
            
        }
        
        
        if(catName != 'Tianguista' && catName != 'Semifijo' && catName != 'Ambulante' && catName != 'Ocasional'){
            
            var selectableDays = document.getElementById("selectableDays");
            selectableDays.style.display = "block";

            var OtrosIHour = document.getElementById("OtrosIHour");
            OtrosIHour.required = true;
            OtrosIHour.disabled = false; 
            var OtrosFHour = document.getElementById("OtrosFHour");
            OtrosFHour.required = true;
            OtrosFHour.disabled = false; 
            
            var OtrosDimx = document.getElementById("OtrosDimx");
            OtrosDimx.required = true;
            OtrosDimx.disabled = false; 
            var OtrosDimy = document.getElementById("OtrosDimy");
            OtrosDimy.required = true;
            OtrosDimy.disabled = false; 

            var OtrosUbicacion = document.getElementById("OtrosUbicacion");
            OtrosUbicacion.required = true;
            OtrosUbicacion.disabled = false; 
            
            Otro.style.display = "block";
        } else {
            var show = document.getElementById(catName);
            // console.log(show);
            show.style.display = "block";
        }
        
    }
</script>
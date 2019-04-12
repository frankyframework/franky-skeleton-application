$.fn.numeroaletras = function(content)
{

    var  self = this;
    var numero = parseFloat($(this).val());

    self.Unidades = function(num){

        switch(num)
        {
            case 1: return "UN";
            case 2: return "DOS";
            case 3: return "TRES";
            case 4: return "CUATRO";
            case 5: return "CINCO";
            case 6: return "SEIS";
            case 7: return "SIETE";
            case 8: return "OCHO";
            case 9: return "NUEVE";
        }
        return "CERO";
    }

    self.Decenas = function(num){

        decena = Math.floor(num/10);
        unidad = num - (decena * 10);

        switch(decena)
        {
            case 1:
                switch(unidad)
                {
                    case 0: return "DIEZ";
                    case 1: return "ONCE";
                    case 2: return "DOCE";
                    case 3: return "TRECE";
                    case 4: return "CATORCE";
                    case 5: return "QUINCE";
                    default: return "DIECI" + self.Unidades(unidad);
                }
            case 2:
                switch(unidad)
                {
                    case 0: return "VEINTE";
                    default: return "VEINTI" + self.Unidades(unidad);
                }
            case 3: return self.DecenasY("TREINTA", unidad);
            case 4: return self.DecenasY("CUARENTA", unidad);
            case 5: return self.DecenasY("CINCUENTA", unidad);
            case 6: return self.DecenasY("SESENTA", unidad);
            case 7: return self.DecenasY("SETENTA", unidad);
            case 8: return self.DecenasY("OCHENTA", unidad);
            case 9: return self.DecenasY("NOVENTA", unidad);
            case 0: return self.Unidades(unidad);
        }
    }

    self.DecenasY = function(strSin, numUnidades) {
        if (numUnidades > 0)
        {
          return strSin + " Y " + self.Unidades(numUnidades)
        }


        return strSin;
    }

    self.Centenas = function(num) {
        centenas = Math.floor(num / 100);
        decenas = num - (centenas * 100);

        switch(centenas)
        {
            case 1:
                if (decenas > 0)
                    return "CIENTO " + self.Decenas(decenas);
                return "CIEN";
            case 2: return "DOSCIENTOS " + self.Decenas(decenas);
            case 3: return "TRESCIENTOS " + self.Decenas(decenas);
            case 4: return "CUATROCIENTOS " + self.Decenas(decenas);
            case 5: return "QUINIENTOS " + self.Decenas(decenas);
            case 6: return "SEISCIENTOS " + self.Decenas(decenas);
            case 7: return "SETECIENTOS " + self.Decenas(decenas);
            case 8: return "OCHOCIENTOS " + self.Decenas(decenas);
            case 9: return "NOVECIENTOS " + self.Decenas(decenas);
        }

        return self.Decenas(decenas);
    }

    self.Miles = function(num) {
        divisor = 1000;
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        strMiles = self.Seccion(num, divisor, "UN MIL", "MIL");
        strCentenas = self.Centenas(resto);

        if(strMiles == "")
            return strCentenas;

        return strMiles + " " + strCentenas;
    }

    self.Millones = function(num) {
        divisor = 1000000;
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        strMillones = self.Seccion(num, divisor, "UN MILLON DE", "MILLONES DE");
        strMiles = self.Miles(resto);

        if(strMillones == "")
            return strMiles;

        return strMillones + " " + strMiles;
    }


    self.Seccion = function(num, divisor, strSingular, strPlural) {
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        letras = "";

        if (cientos > 0)
            if (cientos > 1)
                letras = self.Centenas(cientos) + " " + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += "";

        return letras;
    }

    self.convertir = function()
    {

      var data = {
          numero: numero,
          enteros: Math.floor(numero),
          centavos: (((Math.round(numero * 100)) - (Math.floor(numero) * 100))),
          letrasCentavos: "",
          letrasMonedaPlural: 'PESOS',//"PESOS", 'Dólares', 'Bolívares', 'etcs'
          letrasMonedaSingular: 'PESO', //"PESO", 'Dólar', 'Bolivar', 'etc'

          letrasMonedaCentavoPlural: 'CENTAVOS',
          letrasMonedaCentavoSingular: 'CENTAVO'
      };

      if (data.centavos > 0) {
          data.letrasCentavos = "CON " + (function (){
              if (data.centavos == 1)
              {
                  return (self.Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular);
              }
              else
              {

                  return (self.Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural);
              }

              })();
      };

      if(data.enteros == 0)
          $(content).html('CERO ' + data.letrasMonedaPlural +' ' + data.letrasCentavos);
      if (data.enteros == 1)
          $(content).html(self.Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos);
      else
          $(content).html(self.Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos);
    }


    self.convertir();

};

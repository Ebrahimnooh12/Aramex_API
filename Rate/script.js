
function getCities(country) {
    //test data
    const bahrainCities=[ 'Manama','Riffa', 'Muharraq','Hamad Town','A\'ali',
    'Isa Town','Sitra','Budaiya','Jidhafs','Al-Malikiyah',
    'Jid Ali','Sanabis','Tubli', 'Saar','Al Dur', 'Qudaibiya',
    'Salmabad','Jurdab','Diyar AlMuharraq','Amwaj Island',
    'Hidd','Arad','Busaiteen',
    ];

    const saudiCities =['Riyadh','Jeddah','Mecca','Medina','Hofuf',
                        'Ta\'if','Dammam','Buraidah','Khobar','Tabuk']

    switch (country) {
        case "BH":
            return bahrainCities;
            break;

        case "SA":
        return saudiCities;
        break;

        default:
            return "none"
            break;
    }
}

function appendCites(countryElement,cityElement) {
    var country = $(countryElement).val();
    var cities= getCities(country);
    
    $.each(cities, function(val,text) {
        var option = new Option(text, text);
        $(option).html(text);
        $(cityElement).append(option)
    });
    
    $(countryElement).change(function(){
        $(cityElement).empty();
        var val = $(this).val();
        var cities= getCities(val);
        if(cities !="none") {            
            $.each(cities, function(val,text) {
                var option = new Option(text, text);
                $(option).html(text);
                $(cityElement).append(option)
            });
        }
    })
}

function retraiveRate(form) {
    $.ajax({
        type: "POST",
        url : 'RateCalculator.php',
        data: $(form).serialize(),
        beforeSend: function(){
          $(".spinner-border").show();
          $(".rate").hide();
        },
        complete: function(){
          $(".spinner-border").hide();
          $(".rate").show();
        },
        success: function(res) {
            console.log(res);  
            var data = JSON.parse(res);
            if(data.success == "false"){
                $(".rate-error").text(data.Notifications.Notification.Message);
                $(".rate-body").hide();
                $(".rate-error").show();
            }
            else{
                $(".price").text(data.TotalAmount.Value+' '+ data.TotalAmount.CurrencyCode);
                $(".rate-error").hide();
                $(".rate-body").show();
            }
        }
      });
}


$(document).ready(function() {
    
    appendCites('#from-country','#from-city');
    appendCites('#to-country','#to-city');
    appendCites('#from-country-domestic','#from-city-domestic');
    appendCites('#from-country-domestic','#to-city-domestic');


    $('#calculate-international').click(function(){
        $("#rate-form-international").validate({
          rules: {
            weight: {
              required: true,
              min: 0.1
            }
          },
          messages: {
            weight: "Invalid weight value",
          },
          errorElement : 'span',
          errorLabelContainer: '.error',
          submitHandler: function() {
            retraiveRate("#rate-form-international");
          }
        });
      });


      $('#calculate-domestic').click(function(){
        $("#rate-form-domestic").validate({
          rules: {
            weight: {
              required: true,
              min: 0.1
            }
          },
          messages: {
            weight: "Invalid weight value",
          },
          errorElement : 'span',
          errorLabelContainer: '.error',
          submitHandler: function() {
            retraiveRate("#rate-form-domestic");
          }
        });
      });  


})



  
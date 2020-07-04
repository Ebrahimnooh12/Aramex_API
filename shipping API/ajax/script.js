function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }
function validation(header,section , inputs) {
    
    var open;
 
    for (let i = 0; i < inputs.length; i++) {
        for (let j= 0; j < inputs[i].rule.length; j++) {
            switch (inputs[i].rule[j]) {
                case 'required':
                        var value = $(inputs[i].id).val();
                
                        if(value.trim() == "" ){
                            $(inputs[i].error).text("Required field");
                            open = true;
                        }
                        else{
                            $(inputs[i].error).text("");
                        }     
                    break;
    
                case 'digit':
                        var value = $(inputs[i].id).val();
                        if(!isNumber(value)) { 
                            $(inputs[i].error).text("field should contain number only");
                            open = true;
                        }
                        else{
                            $(inputs[i].error).text("");
                        }   
                    break;

                    case 'email':
                        var value = $(inputs[i].id).val();
                        if (! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)){
                        $(inputs[i].error).text("Invalid Email");
                        }
                        else{
                            $(inputs[i].error).text("");

                        }   
                    break; 
                    
                    case 'one':
                        var value = $(inputs[i].id).val();
                        if (!isNumber(value) || value < 1){
                        $(inputs[i].error).text("Invalid data enterd");
                            open = true;
                        }
                        else{
                            $(inputs[i].error).text("");
                        }   
                    break;
                    
                    case 'fraction':
                        var value = $(inputs[i].id).val();
                        if (!isNumber(value) || value < 0.1){
                        $(inputs[i].error).text("Invalid data enterd");
                            open = true;
                        }
                        else{
                            $(inputs[i].error).text("");
                            open = false;
                        }   
                    break;
                        
                default:
                    break;
            }        
            
        }
    }

    if(open) {
        $(section).collapse("show");
        $(header).css({'border-color':'red'});
        $([document.documentElement, document.body]).animate({
            scrollTop: $(header).offset().top
        }, 1000);
        return false;
    }
    else{
        $(header).css({'border-color':'rgba(0,0,0,.125)'});
        return true;
    }
}


$(document).ready(function() {

    const client_info = [                         
                        {
                            'id':'#client-username',
                            'rule':['required'],
                            'error':'#error-client-username'
                        },
                        {
                            'id':'#client-password',
                            'rule':['required'],
                            'error':'#error-client-password'
                        },
                        {
                            'id':'#client-acccount',
                            'rule':['digit'],
                            'error':'#error-client-account'
                        },
                        {
                            'id':'#client-pin',
                            'rule':['digit'],
                            'error':'#error-client-pin'
                        },
                        {
                            'id':'#client-entity',
                            'rule':['required'],
                            'error':'#error-client-entity'
                        }
                    ]
                    
    const shipper = [                         
        {
            'id':'#shipper-company',
            'rule':['required'],
            'error':'#error-shipper-company'
        },
        {
            'id':'#shipper-person',
            'rule':['required'],
            'error':'#error-shipper-person'
        },
        {
            'id':'#shipper-city',
            'rule':['required'],
            'error':'#error-shipper-city'
        },
        {
            'id':'#shipper-phone',
            'rule':['digit'],
            'error':'#error-shipper-phone'
        },
        {
            'id':'#shipper-phone-ext',
            'rule':['required'],
            'error':'#error-shipper-phone-ext'
        },
        {
            'id':'#shipper-mobile',
            'rule':['digit'],
            'error':'#error-shipper-mobile'
        },
        {
            'id':'#shipper-line1',
            'rule':['required'],
            'error':'#error-shipper-line1'
        },
        {
            'id':'#shipper-email',
            'rule':['email'],
            'error':'#error-shipper-email'
        }
        
    ]
    
    const receiver = [                         
        {
            'id':'#receiver-company',
            'rule':['required'],
            'error':'#error-receiver-company'
        },
        {
            'id':'#receiver-city',
            'rule':['required'],
            'error':'#error-receiver-city'
        },
        {
            'id':'#receiver-phone',
            'rule':['digit'],
            'error':'#error-receiver-phone'
        },
        {
            'id':'#receiver-phone-ext',
            'rule':['required'],
            'error':'#error-receiver-phone-ext'
        },
        {
            'id':'#receiver-mobile',
            'rule':['digit'],
            'error':'#error-receiver-mobile'
        },
        {
            'id':'#receiver-line1',
            'rule':['required'],
            'error':'#error-receiver-line1'
        },
        {
            'id':'#receiver-email',
            'rule':['email'],
            'error':'#error-receiver-email'
        }
    ]
    
    const shipment = [                         
        {
            'id':'#shipment-pieces',
            'rule':['one'],
            'error':'#error-shipment-pieces'
        },
        {
            'id':'#receiver-phone',
            'rule':['digit'],
            'error':'#error-receiver-phone'
        },
        {
            'id':'#shipment-weight',
            'rule':['fraction'],
            'error':'#error-shipment-weight'
        },
        {
            'id':'#desc-goods',
            'rule':['required'],
            'error':'#error-desc-goods'
        }
        
    ]    
    

    $("#shipping-form").submit(function(e){
            e.preventDefault(e);
        });


    $("#create").click(function(){
        var x = false;
        var y = false;
        var z = false;
        var submit = false;
        
        x = validation('#headingOne','#collapseOne',client_info);

         if(x == true){
            y = validation('#headingFour','#collapseFour',shipper);
         }
         if(y){
            z= validation('#headingFive','#collapseFive',receiver);
         } 
         if(z){
            submit= validation('#headingSix','#collapseSix',shipment);                   
         }
		
        if(submit){                        
            $.ajax({
                type: "POST",
                url : 'Shipping.php',
                data: $("#shipping-form").serialize(),
                beforeSend: function(){
                    $(".loader-container").show();
                  },
                  complete: function(){
                    $(".loader-container").hide();
                  },
                  success: function(res) {
                    $(".loader-container").hide();
                      var data = JSON.parse(res);
                      var hasErrors = data.HasErrors;
                      
                      if(hasErrors) {            
                        $("#details-body").hide();
                        var notifications = data.Shipments.ProcessedShipment.Notifications.Notification;
                        
                        for(i=0 ; i < notifications.length ; i++ ){
                              var error = "<span class=\"error\">"+ notifications[i].Code + " :" + notifications[i].Message+"</span></br>";
                              $("#response").append(error)
                          }
                      }
                      else{
                        
                        //Get shipment information
                        var shipment = data.Shipments.ProcessedShipment;
                        var shipmentId = shipment.ID;
                        var shipmentLabel = shipment.ShipmentLabel;
                        var shipmentdetails = shipment.ShipmentDetails;
                        var chargeableWeight = shipmentdetails.ChargeableWeight;
                         
                        //Append elements
                        $("#s-id").text(shipmentId);
                        $("#s-label-url").text(shipmentLabel.LabelURL);
                        $("#s-label-url").attr("href", shipmentLabel.LabelURL);
                        $("#s-label-file").text(shipmentLabel.LabelFileContents);
                        $("#s-origin").text(shipmentdetails.Origin);
                        $("#s-destination").text(shipmentdetails.Destination);
                        $("#s-goods-desc").text(shipmentdetails.DescriptionOfGoods);
                        $("#s-weight").text(chargeableWeight.Value + " " + chargeableWeight.Unit);
                        $("#s-pieces").text(shipmentdetails.NumberOfPieces);

                      }
 
                   $("#request").fadeOut();   
                   $("#response").fadeIn();   
                  }
                });
        }
    });
});

function printValues(obj) {
    for(var k in obj) {
        if(obj[k] instanceof Object) {
            printValues(obj[k]);
        } else {
            document.write(obj[k] + "<br>");
        };
    }
};
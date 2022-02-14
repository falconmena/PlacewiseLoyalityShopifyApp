var xmlhttp = new XMLHttpRequest(); 
xmlhttp.open("GET", "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js");
xmlhttp.onreadystatechange = function(){
	if ((xmlhttp.status == 200) && (xmlhttp.readyState == 4)){
		eval(xmlhttp.responseText);
		var getCustomerId = function () {
            try {
                let curr = window.ShopifyAnalytics.meta.page.customerId;
                if (curr !== undefined && curr !== null && curr !== "") {
                  return curr;
                }
            } catch (e) {}
            try {
                let curr = window.meta.page.customerId;
                if (curr !== undefined && curr !== null && curr !== "") {
                  return curr;
                }
            } catch (e) {}
            try {
                let curr = _st.cid;
                if (curr !== undefined && curr !== null && curr !== "") {
                  return curr;
                }
            } catch (e) {}
            try {
                let curr = ShopifyAnalytics.lib.user().traits().uniqToken;
                if (curr !== undefined && curr !== null && curr !== "") {
                  return curr;
                }
            } catch (e) {}
            return null;
        };
        function checkCustomerLoyaltyFound(){
            let customer_id = getCustomerId();
            let shop_url = $('#data-shop-name').attr('data-shop');
            if(customer_id.toString().includes("-")){
                customer_id = ""
            }
            let data = {
                type: "checkCustomerLoyaltyFound",
                id: customer_id,
                shop: shop_url
            };
            $.ajax({
                type: "GET",
                url: "https://brustad1.placewise-services.com/api/loyality.php",
                data: data,
                dataType: "json",
                success: function (data) {
                    console.log('data')
                    console.log(data)
                    // if(data['properties'] != undefined){
                    //     $('#loyaltymember').hide();
                    //     $('#modal_iframe_buttom').show();
                    //     // account page 
                    //     data['properties']['bonus_points'] = data['properties']['bonus_points'] != undefined ? data['properties']['bonus_points'] : 0;
                    //     let gender = data['properties']['gender'];
                    //     let consents = data['consents']
                    //     // $('.loyalty_section').hide()
                    //     $('.loyalty_section').remove()
                    //     $('.loyalty_section_active').show()
                    //     $('.loyalty_info_points').text(data['properties']['bonus_points']);
                    //     // $('.loyalty_info_points_used').text();
                    //     $('.loyalty_info_email').text(data['properties']['email']);
                    //     $('.loyalty_info_phone').text(data['properties']['msisdn']);
                    //     $('#input-fname').val(data['properties']['first_name']);
                    //     $('#input-lname').val(data['properties']['last_name']);
                    //     $('#input-birthday').val(data['properties']['birthday']);
                    //     $("input[name=gender][value=" + gender + "]").prop('checked', true);
                    //     $("input[name=input-sms][value=" + consents['sms_marketing']['status'] + "]").prop('checked', true);
                    //     $("input[name=input-email][value=" + consents['email_marketing']['status'] + "]").prop('checked', true);
                    //     $("input[name=input-offers][value=" + consents['dmp_profiling']['status'] + "]").prop('checked', true);
                    //     $("input[name=input-device][value=" + consents['cookie_tracking']['status'] + "]").prop('checked', true);
                    //     // getRewardsData(customer_id,shop_url);
                    //     $(".table_offers_view").show();
                    //     $('#cart_actual_points').text(data['properties']['bonus_points']);
                    //     getCustomerRewards(customer_id,shop_url);
                    // }else{
                    //     if(data['phone'] != null && data['phone'] != ""){
                    //       $('#phone_loyalty_sysytem').hide();
                    //       $('#input-phone').val(data['phone']);
                    //     }else{
                    //       $('#phone_loyalty_sysytem').show();
                    //     }
                    //     $('#input-fname').val(data['first_name']);
                    //     $('#input-lname').val(data['last_name']);
                    //     $('.loyalty_section').show()
                    //     $('.loyalty_section_active').remove()
                    //     // $('.loyalty_section_active').hide();
                    //     let time = localStorage.getItem("popup_close_time");
                    //     var one_hour = 1000;
                    //     let diff = Date.now() - time;
                    //     if(diff < one_hour){
                    //         $('#loyaltymember').hide();
                    //     }else{
                    //         $('#loyaltymember').show();
                    //     }
        
                    // }
                    // if(data.length == 0){
                    //     $('.loyalty_section').remove()
                    //     $('.loyalty_section_active').remove()
                    // }
                    // let path = window.location.pathname
                    // if(!(path == "/" || path == "/index" || path == "/index/")){
                    //     $('#loyaltymember').hide();
                    // }
                },
            });
        }
        // function getTokenJwt(){
        //   let customer_id = getCustomerId();
        //   if(customer_id.toString().includes("-")){
        //     customer_id = ""
        //   }
        //   let data = {
        //     type: "CreateJwtToken",
        //     id: customer_id,
        //   };
        //   $.ajax({
        //     type: "GET",
        //     url: "https://brustad1.placewise-services.com/api/auth.php",
        //     data: data,
        //     dataType: "json",
        //     success: function (data) {
        //       if(data['status'] == "ok"){
        //         let src = $('#iframe_link').attr('src');
        //         if(src.includes("?token")){
        //           src = src.split("?token")[0];
        //           src = src.replace("?token", "");
        //         }
        //         $('#iframe_link').attr('src',src+`?token=${data['token']}`);
        //       }
        //     },
        //   });
        
        // }
        $(function() {
            
          checkCustomerLoyaltyFound();
        //   let customer_id = getCustomerId();
        //   if(customer_id.toString().includes("-")){
        //     $('#div-btn-login-cart').show();
        //   }
        
        });

        // $('#submit_loyalty_system_add_account').on('click',function(e){
        //     e.preventDefault();
        //     let customer_id = getCustomerId();
        //     let shop_url = $('#data-shop-name').attr('data-shop');
        //     let fname = $('#input-fname').val();
        //     let lname = $('#input-lname').val();
        //     let password = $('#input-password').val();
        //     let cpassword = $('#input-cpassword').val();
        //     let gender = $('input[name="gender"]:checked').val();
        //     let phone = $('#input-phone').val();
        //     let birthday = $('#input-birthday').val();
        //     let sms = $('input[name="input-sms"]:checked').val();
        //     let email = $('input[name="input-email"]:checked').val();
        //     let offers = $('input[name="input-offers"]:checked').val();
        //     let device = $('input[name="input-device"]:checked').val();
        //     let data = {
        //         type: "addMember",
        //         fname:fname,
        //         lname:lname,
        //         gender:gender,
        //         birthday:birthday,
        //         sms:sms,
        //         email:email,
        //         offers:offers,
        //         device:device,
        //         password:password,
        //         cpassword:cpassword,
        //         phone:phone
        //     };
        //     $.ajax({
        //         type: "POST",
        //         url: `https://brustad1.placewise-services.com/api/loyality.php?shop=${shop_url}&customer_id=${customer_id}`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //             if(data['error_count'] == 1){
        //               $('#error_msg_add_member').text(data['error']);
        //             }else{
        //               window.location.reload()
        //             }
        //         },
        //     });
        // })


        // $('.member-notification__close-button').on('click',function(){
        //   localStorage.setItem("popup_close_time", Date.now());
        //   $('#loyaltymember').hide();
        // })
        
        // $('#link_open_iframe').on('click',function(e){
        //   let customerId = getCustomerId();
        //   let shop_url = $('#data-shop-name').attr('data-shop');
        //   if(customerId.toString().includes("-")){
        //       e.preventDefault();
        //       window.location.href = "/account/register"
        //   }else{
        //       localStorage.setItem("popup_close_time", Date.now());
        //       $('#loyaltymember').hide();
        //       let src = $('#iframe_link').attr('src');
        //       $('#iframe_link').attr('src',src+`/?customer_id=${customerId}&shop=${shop_url}`);
        //       $('.container-loading').show();
        //       $('.responsive-iframe').hide();
        //       if(shop_url == "placewiseas.myshopify.com"){
        //         jQuery.noConflict();
        //       }
        //       $('#iframe_loyalty').modal('show');
        //   }
        // })
        
        // $('#modal_iframe_buttom').on('click',function(e){
        //     let customerId = getCustomerId();
        //     let shop_url = $('#data-shop-name').attr('data-shop');
        //     if(customerId.toString().includes("-")){
        //         e.preventDefault();
        //         window.location.href = "/account"
        //     }else{
        //         localStorage.setItem("popup_close_time", Date.now());
        //         $('#loyaltymember').hide();
        //         let src = $('#iframe_link').attr('src');
        //         if(src.includes("?customer_id")){
        //             src = src.split("?customer_id")[0];
        //             src = src.replace("?customer_id", "");
        //         }
        //         $('#iframe_link').attr('src',src+`?customer_id=${customerId}&shop=${shop_url}`);
        //         $('.container-loading').show();
        //         $('.responsive-iframe').hide();
        //         if(shop_url == "placewiseas.myshopify.com"){
        //             jQuery.noConflict();
        //         }
        //         $('#iframe_loyalty').modal('show');
        //     }
        // })

        // function validate(phone) {
        //     var regex = /^\+?[1-9]\d{1,14}$/;
            
        //     if (regex.test(phone)) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        
        // function can_submit(){
        //     let customer_id = getCustomerId();  
        //     let shop_url = $('#data-shop-name').attr('data-shop');
        //     let is_loyalty = "yes"
        //     if(is_loyalty == "yes"){
        //         let validate_phone = validate($('#techs_phone_number').val())
        //         let password_check = $('#RegisterForm-password').val()
        //         let re_password_check = $('#re-passwsord').val()
        //         console.log(password_check)
        //         console.log(re_password_check)
        //         if(password_check != re_password_check){
        //             $('#error_msg').text("Passord og ompassordet må være det samme");
        //         }else if(!validate_phone){
        //           $('#error_msg').text("Ugyldig telefonnummer, eksempel gyldig nummer:+16135551212");
        //         }else{
        //             let data = {
        //                 type: "checkCanSubmitCreateAccount",
        //                 id: customer_id,
        //                 shop: shop_url,
        //                 phone:$('#techs_phone_number').val(),
        //                 password:$('#RegisterForm-password').val(),
        //                 birthday:$('#techs-birthday-layolty').val(),
        //                 email:$('#RegisterForm-email').val(),
        //                 is_loyalty:is_loyalty
        //             };
        //             $.ajax({
        //                 type: "GET",
        //                 url: "https://brustad1.placewise-services.com/api/loyality.php",
        //                 data: data,
        //                 dataType: "json",
        //                 success: function (data) {
        //                     let check_email = data['error']
        //                     if(check_email != 1){
        //                       $('#RegisterForm').submit();
        //                       $('#error_msg').text("");
        //                     }else{
        //                       $('#error_msg').text(data['msg']);
        //                     }
        //                 },
        //             });
        //         }
        //     }
        // }


        // $('#button_generate_discount').on('click',function(e){
        //       e.preventDefault();
        //       let customer_id = getCustomerId();
        //       let shop_url = $('#data-shop-name').attr('data-shop');
        //       let points = $('#input_generate_discount').val();
        //       $('#input_generate_discount').val('')
        //       addCustomerRewards(customer_id,shop_url,points);
        // })

        // function addCustomerRewards(customer_id,shop_url,points){
        //     let data = {
        //         type: "addRewardsDataByCustomer",
        //         shop: shop_url,
        //         customer_id: customer_id,
        //         points:points
        //     };
        //     $.ajax({
        //         type: "GET",
        //         url: `https://brustad1.placewise-services.com/api/loyality.php`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //           if(data['found_loyalty']){
        //             if(data['add_reward']){
        //               $('#msg_generate_discount').text("");
        //               $('#cart_actual_points').text(data['actual_point']);
        //               getCustomerRewards(customer_id,shop_url);
        //             }else{
        //               // You don't have enough points
        //               $('#msg_generate_discount').text("You don't have enough points");
        //             }
        //           }else{
        //             // you not a loyalty member
        //             $('#msg_generate_discount').text("you not a loyalty member");
        //           }
        //         },
        //     });
        // }


        // function getCustomerRewards(customer_id,shop_url){
        //     let data = {
        //         type: "getCustomerRewards",
        //         shop: shop_url,
        //         customer_id: customer_id,
        //     };
        //     $('#record_generate_discount').html("");
        //     $.ajax({
        //         type: "GET",
        //         url: `https://brustad1.placewise-services.com/api/loyality.php`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //           let rewards_html = ''
        //           if(data['found_loyalty']){
        //             if(data['data'].length > 0){
        //               for (const key in data['data']) {
        //                 rewards_html += `<tr>`
        //                 rewards_html += `   <td ><span class='copied-loyality-code ' data-val="${data['data'][key]['code']}" style='cursor: pointer;'>${data['data'][key]['code']}</span></td>`
        //                 rewards_html += `   <td>${data['data'][key]['points']}</td>`
        //                 rewards_html += `   <td>${data['data'][key]['used'] == 1 ? 'Brukt' : 'Ikke brukt'}</td>`
        //                 rewards_html += `</tr>`
        //               }
        //               $('#record_generate_discount').html(rewards_html);
        //             }
        //           }
        //         },
        //     });
        // }    




        // $('#techs_submit_value').on('click',function(e){
        //     let is_loyalty_radio = "yes";
        //     if(is_loyalty_radio == "yes"){
        //         e.preventDefault();
        //         let val = "phone=" + $('#techs_phone_number').val() + "&";
        //         if(!$('#techs_hidden_tags').val().includes(val)){
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let gender= "gender=" + $('input[name="gender"]:checked').val() + "&";
        //         if(!$('input[name="gender"]:checked').val().includes(gender)){
        //           val += gender
        //           $('#techs_hidden_tags').val(val);
        //         }

        //         let birthday= "birthday=" + $('#techs-birthday-layolty').val() + "&";
        //         if(!$('#techs_hidden_tags').val().includes(birthday)){
        //           val += birthday
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let password= "password=" + $('#RegisterForm-password').val() + "&";
        //         if(!$('#RegisterForm-password').val().includes(password)){
        //           val += password
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let sms_status= "sms_status=" + $('input[name="loyalty_radio_sms"]:checked').val() + "&";
        //         if(!$('input[name="loyalty_radio_sms"]:checked').val().includes(sms_status)){
        //           val += sms_status
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let email_status= "email_status=" + $('input[name="loyalty_radio_email"]:checked').val() + "&";
        //         if(!$('input[name="loyalty_radio_email"]:checked').val().includes(email_status)){
        //           val += email_status
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let offers_status= "offers_status=" + $('input[name="loyalty_radio_offers"]:checked').val() + "&";
        //         if(!$('input[name="loyalty_radio_offers"]:checked').val().includes(offers_status)){
        //           val += offers_status
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let device_status= "device_status=" + $('input[name="loyalty_radio_device"]:checked').val() + "&";
        //         if(!$('input[name="loyalty_radio_device"]:checked').val().includes(device_status)){
        //           val += device_status
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         let is_loyalty = "is_loyalty=yes&"
        //         if(is_loyalty == "is_loyalty=yes&"){
        //           val += is_loyalty
        //           $('#techs_hidden_tags').val(val);
        //         }
        //         can_submit();
        //     }

        // })
        
        // $('#btn-login-cart').on('click',function(e){
        //   e.preventDefault();
        //   window.location.href = "/account"
        // })

        // $('#techs_phone_number').on('keyup',function(){
        //     let customer_id = getCustomerId();  
        //     let shop_url = $('#data-shop-name').attr('data-shop');
        //     let is_loyalty = "yes"
        //     $('#error_phone_loyalty').text("");
        //     if(is_loyalty == "yes"){
        //         let validate_phone = validate($('#techs_phone_number').val())
        //         if(!validate_phone){
        //             $('#error_phone_loyalty').text("Vennligst skriv inn gyldig telefonnummer");
        //         }else{
        //             let phone = $('#techs_phone_number').val(); 
        //             let data = {
        //               type: "checkCustomerPhoneLoyaltyFound",
        //               id: customer_id,
        //               shop: shop_url,
        //               phone:phone
        //             };
        //             $.ajax({
        //               type: "GET",
        //               url: "https://brustad1.placewise-services.com/api/loyality.php",
        //               data: data,
        //               dataType: "json",
        //               success: function (data) {
        //                   if(data.msg == "This phone already exists"){
        //                     $('#error_phone_loyalty').text("Denne telefonen eksisterer allerede.");
        //                   }else{
        //                     if(data.error == 1){
        //                         $('#error_phone_loyalty').text("Du er allerede medlem. Opprett en konto for å slå sammen profiler.");
        //                     }   
        //                   }
        //               },
        //             });
        //         }
        //     }
        // })

        // $('#submit_loyalty_system_account').on('click',function(e){
        //     e.preventDefault();
        //     let customer_id = getCustomerId();
        //     let shop_url = $('#data-shop-name').attr('data-shop');
        //     let fname = $('#input-fname').val();
        //     let lname = $('#input-lname').val();
        //     let gender = $('input[name="gender"]:checked').val();
        //     let birthday = $('#input-birthday').val();
        //     let sms = $('input[name="input-sms"]:checked').val();
        //     let email = $('input[name="input-email"]:checked').val();
        //     let offers = $('input[name="input-offers"]:checked').val();
        //     let device = $('input[name="input-device"]:checked').val();
        //     let data = {
        //         type: "editMember",
        //         fname:fname,
        //         lname:lname,
        //         gender:gender,
        //         birthday:birthday,
        //         sms:sms,
        //         email:email,
        //         offers:offers,
        //         device:device,
        //     };
        //     $.ajax({
        //         type: "POST",
        //         url: `https://brustad1.placewise-services.com/api/loyality.php?shop=${shop_url}&customer_id=${customer_id}`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //             if(data['error'] != undefined){
        //               $('#error_msg_edit_member').text(data['msg']);
        //             }else{
        //               window.location.reload()
        //             }
        //         },
        //   });
        // })


        // function getRewardsData(customer_id,shop_url){
        //     let data = {
        //         type: "getRewardsData",
        //         shop: shop_url,
        //         customer_id: customer_id
        //     };
        //     $.ajax({
        //         type: "GET",
        //         url: `https://brustad1.placewise-services.com/api/loyality.php`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //             let rewards_html = ''
        //             if(data.length > 0){
        //                 for (const key in data) {
        //                   rewards_html += `<div class="col-lg-4 col-sm-4 card-group-row__col mb-2">`
        //                   rewards_html += ` <div class="card card-group-row__card text-center o-hidden card--raised navbar-shadow" style="height: 100%;margin-bottom: 0;background: darkgray;padding: 18px;margin-bottom: 10px;">`
        //                   rewards_html += `   <div class="card-body d-flex flex-column">`
        //                   rewards_html += `     <div class="flex-grow-1 mb-16pt" style="height: 100%;">`
        //                   rewards_html += `       <h4 class="mb-8pt">${data[key]['code']}</h4>`
        //                   rewards_html += `       <p class="text-black-70">${data[key]['title']}</p>`
        //                   rewards_html += `     </div>`
        //                   rewards_html += `   </div>`
        //                   rewards_html += `   <div class="card-footer">Nåværende saldo : ${data[key]['counter']}</div>`
        //                   rewards_html += ` </div>`
        //                   rewards_html += `</div>`
        //                 }
        //             }else{
        //                 rewards_html = "<div style='display:flex'><h2 style='margin: auto;'>Det er ingen data å vise</h2></div>"
        //             }
        //             $('#rewards_page_loyalty').html(rewards_html);
        //         },
        //     });
        // }

        // function CreateJwtToken(){
        //     let customer_id = getCustomerId();
        //     let data = {
        //         type: "CreateJwtToken",
        //     };
        //     $.ajax({
        //         type: "POST",
        //         url: `https://brustad1.placewise-services.com/api/auth.php?customer_id=${customer_id}`,
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
                    
        //         },
        //     });
        // }
		
	}
}
xmlhttp.send();

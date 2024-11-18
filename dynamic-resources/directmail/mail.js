window.confirmjQueryLoaded(function($) {
    window.smedia_track_directmail = function(dealership, stock_number) {
        var request_url = 'https://tm.smedia.ca/services/direct-mail.php?dealership=' + encodeURIComponent(dealership) + '&stock_number=' + encodeURIComponent(stock_number);
        console.log("Requesting direct mail configuration");
        $.ajax({
            url: request_url,
            crossDomain: true,
            type: 'GET',
            success: function(response) {
                console.log(response);
                if (response.success === true && response.client_id) {
                    var reachdynamics_endpoint = 'https://rdcdn.com/rt?aid=' + encodeURIComponent(response.client_id) + '&e=1&img=1';
                    reachdynamics_endpoint += '&logo=' + encodeURIComponent(response.logo);
                    reachdynamics_endpoint += '&front_banner=' + encodeURIComponent(response.front_banner);
                    reachdynamics_endpoint += '&back_banner=' + encodeURIComponent(response.back_banner);
                    reachdynamics_endpoint += '&coupon_offer=' + encodeURIComponent(response.promotion_text);
                    reachdynamics_endpoint += '&offer_color=' + encodeURIComponent(response.promotion_color);
                    reachdynamics_endpoint += '&promo_bg_color=' + encodeURIComponent(response.overlay_color);
                    reachdynamics_endpoint += '&promo_color=' + encodeURIComponent(response.overlay_text_colour);
                    reachdynamics_endpoint += '&promo_text=' + encodeURIComponent('FEATURED VEHICLE');
                    reachdynamics_endpoint += '&price_color=' + encodeURIComponent(response.price_color);
                    reachdynamics_endpoint += '&coupon_date=' + encodeURIComponent(new Date().toLocaleDateString());
                    reachdynamics_endpoint += '&coupon_validity=' + encodeURIComponent(response.coupon_validity);
                    reachdynamics_endpoint += '&vehicle_1_stock=' + encodeURIComponent(response.vehicles[0].stock_number);
                    reachdynamics_endpoint += '&vehicle_1_year=' + encodeURIComponent(response.vehicles[0].year);
                    reachdynamics_endpoint += '&vehicle_1_make=' + encodeURIComponent(response.vehicles[0].make);
                    reachdynamics_endpoint += '&vehicle_1_model=' + encodeURIComponent(response.vehicles[0].model);
                    reachdynamics_endpoint += '&vehicle_1_price=' + encodeURIComponent(response.vehicles[0].price);
                    reachdynamics_endpoint += '&vehicle_1_img=' + encodeURIComponent(response.vehicles[0].image);
                    reachdynamics_endpoint += '&vehicle_2_stock=' + encodeURIComponent(response.vehicles[1].stock_number);
                    reachdynamics_endpoint += '&vehicle_2_year=' + encodeURIComponent(response.vehicles[1].year);
                    reachdynamics_endpoint += '&vehicle_2_make=' + encodeURIComponent(response.vehicles[1].make);
                    reachdynamics_endpoint += '&vehicle_2_model=' + encodeURIComponent(response.vehicles[1].model);
                    reachdynamics_endpoint += '&vehicle_2_price=' + encodeURIComponent(response.vehicles[1].price);
                    reachdynamics_endpoint += '&vehicle_2_img=' + encodeURIComponent(response.vehicles[1].image);
                    var reachDynamicPixel = document.createElement('img');
                    reachDynamicPixel.setAttribute("width", "1");
                    reachDynamicPixel.setAttribute("height", "1");
                    reachDynamicPixel.setAttribute("src", reachdynamics_endpoint);
                    document.getElementsByTagName("body")[0].appendChild(reachDynamicPixel);
                }
            }
        });
    };
});
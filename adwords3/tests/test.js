/* smart offer debug:  *//* smart offer live: 1 *//*
 * Popup JS for titanauto
 ******************************************************************************/
smedia_lead_popup_design = 'https://tm.smedia.ca/popup/design.css?dealership=titanauto&stock_type=used&year=2016';
smedia_lead_popup_design_style = document.createElement('link');
smedia_lead_popup_design_style.setAttribute("href", smedia_lead_popup_design);
smedia_lead_popup_design_style.setAttribute("rel", "stylesheet");
smedia_lead_popup_design_style.setAttribute("type", "text/css");
document.getElementsByTagName("head")[0].appendChild(smedia_lead_popup_design_style);
var referrer = document.referrer; 

var locationValue = [];

var smedia_form_html_content_middle = '';
if(locationValue.length > 0){
    var index, len, allOption = '<option value="">--Select--</option>\n';
    for (index = 0, len = locationValue.length; index < len; ++index) {
        allOption += '<option value="' + locationValue[index] + '">' + locationValue[index] + ' </option>\n';
    }
    var smedia_form_html_content_middle= '<div class="sm-row">\n' +
            '<label for="sm-name">Nearest Location</label>\n' +
            '<select class="form-control" name="nearest_location" id="nearest_location">\n' + 
            allOption +
            '</select>' + 
            '</div>\n';
}

var smedia_form_html_ocntent_first = '<div id="smedia-overlay" style="display:none"></div>\n' +
  '<div id="smedia-lead-collect-form" class="sm-lead-collect-form" style="display:none">\n' +
  '<div class="sm-lead-collect-form-image">\n' +
  '</div>\n' +
  '<div class="sm-lead-collect-form-body">\n' +
  '<div class="sm-row">\n' +
  '<button class="sm-close-btn" id="sm-close-btn"></button>\n' +
  '</div>\n' +
  '<div id="sm-form-container">\n' +
  '<form id="sm-lead-form" method="post" action="https://tm.smedia.ca/services/smart-offer-lead.php">\n' +
  '<input type="hidden" name="act" value="submit"/>\n' +
  '<input type="hidden" name="dealership" value="titanauto"/>\n' +
  '<input type="hidden" name="stock_type" value="used"/>\n' +
  '<input type="hidden" name="year" value="2016"/>\n' +
  '<input type="hidden" name="make" value="Audi"/>\n' +
  '<input type="hidden" name="model" value="A4 allroad"/>\n' +
  '<input type="hidden" name="stock_number" value="GP10830"/>\n' +
  '<input type="hidden" name="url" value="https://www.titanauto.ca/inventory/2016-audi-a4-allroad-quattro-awd-leather-htd-seats-alloys-awd-sedan-wa1tfaflxga014845?smedia_debug=true"/>\n' +
  '<input type="hidden" name="smedia_smart_lead_uuid" value="905416ad976f03e219c79cd1d56f387256bad9119f945b949ded0fe030018753"/>\n' +
  '<input type="hidden" name="referrer" value="'+ referrer +'"/>\n' +
  '<div class="sm-row">\n' +
  '<label for="sm-name">Name</label>\n' +
  '<input type="text" id="sm-name" name="name" value="" required/>\n' +
  '</div>\n' +
  '<div class="sm-row">\n' +
  '<label for="sm-email">Email</label>\n' +
  '<input type="email" id="sm-email" name="email" value="" required/>\n' +
  '</div>\n' +
  '<div class="sm-row">\n' +
  '<label for="sm-phone">Phone</label>\n' +
  '<input type="tel" id="sm-phone" name="phone" value="" required/>\n' +
  '</div>\n' ;

  var smedia_form_html_content_last = '<div class="sm-row">\n' +
  '<button class="sm-lead-submit-btn">Submit</button>\n' +
  '</div>\n' +
  '</form>\n' +
  '</div>\n' +
  '<div class="sm-row">\n' +
  '<div id="sm-loading-spinner" class="sm-loading-spinner">\n' +
  '<img src="https://tm.smedia.ca/adwords3/templates/balls.svg" />\n' +
  '</div>\n' +
  '</div>\n' +
  '</div>\n' +
  '</div>';
  
var smedia_form_html_content = smedia_form_html_ocntent_first + smedia_form_html_content_middle + smedia_form_html_content_last;
var smedia_temp_div = document.createElement('div');
smedia_temp_div.innerHTML = smedia_form_html_content;
var smedia_form_elements = smedia_temp_div.childNodes;
document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[0]);
document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[1]);

var sMedia = sMedia || {};

function jQueryReady($) {

    sMedia.Lead = {
        form            : null,
    	initialized     : false,
        closeTimeout	: null,
        initialForm     : null,
        uniqueUserId    : '905416ad976f03e219c79cd1d56f387256bad9119f945b949ded0fe030018753',
        init	: function() {
            $("#smedia-overlay").click(function(){sMedia.Lead.close();});
            $("#sm-close-btn").click(function(){sMedia.Lead.close();});
            $("#sm-lead-form").submit(function(e){
                e.preventDefault();
                sMedia.Lead.form = this;
                var form_data = $(this).serialize();
                var action = $(sMedia.Lead.form).prop("action");

                sMedia.Lead.disable(sMedia.Lead.form);

                $.ajax({
                    type  : "POST",
                    url   : action,
                    data  : form_data,
                    crossDomain   : true
                })
                .done(function(data, textStatus, jqXHR) {
                    ga('smedia_analytics_tracker.send', {
                        hitType: 'event',
                        eventCategory: 'smart_offer',
                        eventAction: 'lead',
                        nonInteraction: true
                    });
                    if(data.response) {
                        $("#sm-form-container").html(data.response);
                        setTimeout("sMedia.Lead.close()", 3000);
                    }
                    else {
                        alert(data.error);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log('Smart Offer Submission Issue: ' + textStatus);
                    console.log(jqXHR);
                    sMedia.Lead.close();
                })
                .always(function() {
                    sMedia.Lead.enable(sMedia.Lead.form);
                });
            });
            this.initialized = true;
        },
        delayClose    : function() {
            if($("#sm-lead-form").serialize() !== sMedia.Lead.initialForm){
                if(sMedia.Lead.closeTimeout)
                    clearTimeout(sMedia.Lead.closeTimeout);
                return;
            }
            sMedia.Lead.close();
        },
    	show	: function() {
            if(!this.initialized) this.init();
            console.log("Smart offer show function call");
            ga('smedia_analytics_tracker.send', {
                hitType: 'event',
                eventCategory: 'smart_offer',
                eventAction: 'shown',
                nonInteraction: true
            });
            $("#smedia-overlay").css("display", "block");
            $("#smedia-lead-collect-form").css("display", "block");
            sMedia.Lead.initialForm = '';   /* Avoid auto close by setting initial form to nothing */   //$("#sm-lead-form").serialize();
            sMedia.Lead.closeTimeout = setTimeout("sMedia.Lead.delayClose()", 20000);
            $.ajax({
                type  : "POST",
                url   : $("#sm-lead-form").prop("action"),
                data  : "act=shown&dealership=titanauto&smedia_smart_lead_uuid=905416ad976f03e219c79cd1d56f387256bad9119f945b949ded0fe030018753",
                crossDomain   : true
            })
            .done(function(data, textStatus, jqXHR) {
               //Don't need to do anything as it's just tracking form shown
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                
            })
            .always(function() {
                
            });
        },
        close	: function() {
            $("#smedia-overlay").css("display", "none");
            $("#smedia-lead-collect-form").css("display", "none");
        },
        disable	: function(form) {
            $(form).find('input').prop("disabled", true);
            $(form).find('button').prop("disabled", true);
            $("#sm-loading-spinner").css("display", "block");
        },
        enable	: function(form) {
            $(form).find('input').prop("disabled", false);
            $(form).find('button').prop("disabled", false);
            $("#sm-loading-spinner").css("display", "none");
        }
    };
    
            setTimeout('sMedia.Lead.show()', 30000);
            
    }

confirmjQueryLoaded(function($) { jQueryReady($); });
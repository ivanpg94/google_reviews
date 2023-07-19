var datos = drupalSettings.google_reviews.total.datos;
if(datos['google_review'] == 1){
document.write('<scr'+'ipt type="text/JavaScript" src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></scr'+'ipt>');
document.write('<scr'+'ipt type="text/JavaScript" src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></scr'+'ipt>');

//fecha + dias de envio
var shippingdays = datos['estimated_shipping_days'];
var date = new Date();
date.setDate(date.getDate() + shippingdays);
dateshippingdates = date.toISOString().split('T')[0];             //fecha sin comillas
//dateshippingdates = '"' + dateshippingdates + '"';                        //fecha entre comillas

// shop global rating
window.renderBadge = function() {
  var ratingBadgeContainer = document.createElement("div");
  var block = document.getElementById("block-googlereviewblock").appendChild(ratingBadgeContainer).setAttribute("class", "google_reviews" );
//  var ratingBadgeContainer = document.createElement("div");
//  document.body.appendChild(ratingBadgeContainer).setAttribute("class", "google_reviews" );
  window.gapi.load('ratingbadge', function() {
    window.gapi.ratingbadge.render(
      ratingBadgeContainer, {
        "merchant_id": datos['merchand_id'],
        "position": datos['badge_position']
      });
  });
}
//order
if (datos['completado'] == '/complete'){
  window.renderOptIn = function() {
    window.gapi.load('surveyoptin', function() {
      window.gapi.surveyoptin.render(
        {
          "merchant_id": datos['merchand_id'],
          "order_id": datos['order'],
          "email": datos['email'],
          "delivery_country": "es",
          "estimated_delivery_date": dateshippingdates,
        });
    });
  }
}
}


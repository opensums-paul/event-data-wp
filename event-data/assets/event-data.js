jQuery(() => {

  jQuery.ajax({
    url: wpApiSettings.root + 'event-data/v1/ticket-tailor/events',
    method: 'GET',
    beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
    },
  }).done(function (response) {
    console.log('Events', JSON.parse(JSON.stringify(response)));
  });

  jQuery.ajax({
    url: wpApiSettings.root + 'event-data/v1/ticket-tailor/event/ev_410363/tickets',
    method: 'GET',
    beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
    },
  }).done(function (response) {
    console.log('Tickets', response);
  });
});

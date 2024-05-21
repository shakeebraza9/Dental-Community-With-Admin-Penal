// This is the service worker with the Cache-first network
const CACHE = "pwa-precache";
const precacheFiles = [
  /* Add an array of files to precache for your app */
'/myAdmin/assets/jquery-ui/css/jquery-ui-1.11.0.css',
'/myAdmin/assets/bootstrap/css/bootstrap.css',
'/myAdmin/assets/bootstrap/css/bootstrap-theme.css',
'/myAdmin/assets/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css',
'/myAdmin/assets/font-awesome/css/font-awesome.css',
'/myAdmin/assets/menu/menu.css',
'/css/owl.theme.css',
'/css/owl.carousel.css',
'/css/vmenuModule.css',
'/css/bootstrap.min.css',
'/css/animate.css',
'/css/hover.css',
'/css/mmenu.css',
'/css/fontawesome.css',
'/css/jquery-ui.css',
'/css/jquery.fancybox.css',
'/myAdmin/assets/data_table_bs/colVis/dataTables.colVis.min.css',
'/myAdmin/assets/data_table_bs/DT_bootstrap.css',
'/myAdmin/assets/alertify/themes/alertify.core.css',
'/myAdmin/assets/alertify/lib/alertify.min.js',
'/js/webJs.js',
'/js/jquery.ulslide.js',
'/js/jquery.easing.js',
'/js/wow.min.js',
'/js/mmenu.min.all.js',
'/js/owl.carousel.js',
'/js/jquery_ui.js',
'/js/jquery.min.js',
'/js/bootstrap.min.js',
'/js/jquery-ui-timepicker.js',
'/js/jquery.fancybox.js',
'/js/vmenuModule.js',
'/js/qrcode.min.js',
'/js/functions.js',
'/myAdmin/editor/ckeditor.js',
'/myAdmin/assets/jquery-ui/js/jquery-ui.1.11.1.min.js',
'/myAdmin/assets/bootstrap/js/bootstrap.js',
'/myAdmin/assets/bootstrap-select/bootstrap-select.min.css',
'/myAdmin/assets/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js' 
];

self.addEventListener("install", function (event) {
  console.log("[PWA] Install Event processing");

  console.log("[PWA] Skip waiting on install");
  self.skipWaiting();

  event.waitUntil(
    caches.open(CACHE).then(function (cache) {
      console.log("[PWA] Caching pages during install");
      return cache.addAll(precacheFiles);
    })
  );
});

// Allow sw to control of current page
self.addEventListener("activate", function (event) {
  console.log("[PWA] Claiming clients for current page");
  event.waitUntil(self.clients.claim());
});

// If any fetch fails, it will look for the request in the cache and serve it from there first
self.addEventListener("fetch", function (event) { 
  if (event.request.method !== "GET") return;

  event.respondWith(
    fromCache(event.request).then(
      function (response) {
        // The response was found in the cache so we responde with it and update the entry

        // This is where we call the server to get the newest version of the
        // file to use the next time we show view
        event.waitUntil(
          fetch(event.request).then(function (response) {
            return updateCache(event.request, response);
          })
        );

        return response;
      },
      function () {
        // The response was not found in the cache so we look for it on the server
        return fetch(event.request)
          .then(function (response) {
            // If request was success, add or update it in the cache
            event.waitUntil(updateCache(event.request, response.clone()));

            return response;
          })
          .catch(function (error) {
            console.log("[PWA] Network request failed and no cache." + error);
          });
      }
    )
  );
});

function fromCache(request) {
  // Check to see if you have it in the cache
  // Return response
  // If not in the cache, then return
  return caches.open(CACHE).then(function (cache) {
    return cache.match(request).then(function (matching) {
      if (!matching || matching.status === 404) {
        return Promise.reject("no-match");
      }

      // return matching;
      // return matching || fetch(event.request);
      fetch(event.request);
    });
  });
}

function updateCache(request, response) {
  return caches.open(CACHE).then(function (cache) {
    return cache.put(request, response);
  });
}
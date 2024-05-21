// This is the service worker with the Cache-first network
var VERSION = '19';
const CACHE_NAME = "SDC-Cache0223";
const precacheFiles = [
'./download.php',
'./css/bootstrap.min.css',
'./css/animate.css',
'./css/hover.css',
'./css/mmenu.css',
'./css/fontawesome.css',
'./css/jquery-ui.css',
'./css/jquery.fancybox.css',
'./css/vmenuModule.css',
'./css/owl.theme.css',
'./css/owl.carousel.css',
'./css/style.css',
'./css/style-desktop.css',
'./css/style-tablet.css',
'./css/style-mobile.css',
'./css/style-mobile-small.css',
'./css/style2.css',
'./css/style-desktop2.css',
'./css/style-tablet2.css',
'./css/style-mobile2.css',
'./css/style-mobile-small2.css',
'./js/jquery.min.js',
'./css/choices.min.css',
'./js/choices.min.js',
'./js/jquery.uploadfile.min.js',
'./js/jquery.form.js',
'./js/bootstrap.min.js',
'./js/jquery.ulslide.js',
'./js/jquery.easing.js',
'./js/mmenu.min.all.js',
'./js/wow.min.js',
'./js/jquery_ui.js',
'./js/jquery-ui-timepicker.js',
'./js/jquery.fancybox.js',
'./js/vmenuModule.js',
'./js/qrcode.min.js',
'./js/isotope.pkgd.js',
'./js/owl.carousel.js',
'./ckeditor/ckeditor.js',
'./ckeditor/adapters/jquery.js',
'./myAdmin/assets/jquery-ui/css/jquery-ui-1.11.0.css',
'./myAdmin/assets/bootstrap/css/bootstrap.css',
'./myAdmin/assets/bootstrap/css/bootstrap-theme.css',
'./myAdmin/assets/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css',
'./myAdmin/assets/font-awesome/css/font-awesome.css',
'./myAdmin/assets/menu/menu.css',
'./myAdmin/assets/data_table_bs/colVis/dataTables.colVis.min.css',
'./myAdmin/assets/data_table_bs/DT_bootstrap.css',
'./myAdmin/assets/alertify/themes/alertify.core.css',
'./myAdmin/assets/alertify/lib/alertify.min.js',
'./myAdmin/editor/ckeditor.js',
'./myAdmin/assets/jquery-ui/js/jquery-ui.1.11.1.min.js',
'./myAdmin/assets/bootstrap/js/bootstrap.js',
'./myAdmin/assets/bootstrap-select/bootstrap-select.min.css',
'./myAdmin/assets/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js',
'./webImages/logo.png'
    ];



const INITIAL_CACHED_RESOURCES_WITH_VERSIONS = precacheFiles.map(path => {
  return `${path}?v=${VERSION}`;
});


self.addEventListener("install", event => {
  self.skipWaiting();
  event.waitUntil((async () => {
    const cache = await caches.open(CACHE_NAME);
    cache.addAll(INITIAL_CACHED_RESOURCES_WITH_VERSIONS);
  })());
});


self.addEventListener("activate", event => {
  event.waitUntil((async () => {
    const names = await caches.keys();
    await Promise.all(names.map(name => {
      if (name !== CACHE_NAME) {
        return caches.delete(name);
      }
    }));
    await clients.claim();
  })());
});

self.addEventListener("fetch", event => {
  const url = new URL(event.request.url);
  if (url.origin !== location.origin) {
    return;
  }
  
  // On fetch, go to the cache first, and then network.
  event.respondWith((async () => {
    const cache = await caches.open(CACHE_NAME);
    const versionedUrl = `${event.request.url}?v=${VERSION}`;
    const normalUrl = `${event.request.url}`;
    const cachedResponse = await cache.match(versionedUrl);
    if (cachedResponse) {
      return cachedResponse;
    } else {
      const fetchResponse = await fetch(normalUrl);
      return fetchResponse;
    }


  })());
});

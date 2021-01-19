//En install - el shell de aplicación en caché
self.addEventListener('install', function(event){
	event.waitUntil(
		caches.open('sw-cache').then(function(cache){
			//archivos estáticos que conforman el shell de aplicación son llamados.
			return cache.add('index.html');
			return cache.add('style.css');
			return cache.add('control.js');
		})
	);
});

//Con request network
self.addEventListener('fetch', function(event){
	event.respondWith(
		//Intenta el caché
		caches.match(event.request).then(function(response){
			//retorna si hay una respuesta, o si no fetch otra vez
			return response || fetch(event.request);
		})
	);
});
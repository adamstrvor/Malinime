
const imgs = document.querySelectorAll('img');
const scripts = document.querySelectorAll('script');
const styles = document.querySelectorAll('link');

const links = Array();
var i=0,j=0;

links[i] = "/index.php";i++;

while(j < imgs.length)
{
    links[i] = imgs[j].src;
    i++;
    j++;
}

var j=0;
while(j < scripts.length)
{
    if(scripts.src != "" || scripts.src != null ){ links[i] = scripts[j].src; i++}
    j++;
}

var j=0;
while(j < styles.length)
{
    if(styles.href != "" || styles.href != null ){ links[i] = styles[j].href; i++; }
    j++;
}

self.addEventListener('install',(e) => {
    e.waitUntil(
        caches.open("malinime-cache").then( (cache) => cache.addAll(links) ),
    );
});

self.addEventListener('fetch', (e) => {
    console.log(e.request.url);
    e.respondWith(
        caches.match(e.request).then( (response) => response || fetch(e.request) ),
    );
} );
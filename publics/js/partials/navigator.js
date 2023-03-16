
function share_link(url="",title="",text="")
{

    const ShareData = {url:url,title:title,text:text};
    navigator.share(ShareData);
}

let deferredPrompt;

const addBtn = document.querySelector(".INSTALL_ON_BROWSER");
// addBtn.style.display = 'none';
// window.addEventListener('beforeinstallprompt',(e) => {
//     e.preventDefault();
//     deferredPrompt =e;
    addBtn.addEventListener('click',(e) => {
        let deferredPrompt;
        deferredPrompt =e;
        var ans = deferredPrompt.confirm("Installer sur votre téléphone ?");
        // deferredPrompt.userChoice.then( (choiceResult) => {
            if(ans == true){
                console.log("User accepted the prompt !");
                if( 'serviceWorker' in navigator )
                {
                    navigator.serviceWorker.register('./caches.js').then( () => {console.log('Service Worker Registered !')});
                }
            }else
            {
                console.log("User dismissed the prompt !");
            }
            deferredPrompt = null;
        } )
    // });
// });
<?php include_once('./global.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    
<title>AIOM APP - Dental Compliance & Training</title>
<meta property='og:url' content='<?php echo WEB_URL?>/download' />
<meta property='og:image' content='<?php echo WEB_URL?>/webImages/logo-1240x600.png?magic=01' />
<meta name='twitter:url' content='<?php echo WEB_URL?>/download' />
<meta name='twitter:image' content='<?php echo WEB_URL?>/webImages/logo-1240x600.png?magic=01' />
<meta itemprop='image' content='<?php echo WEB_URL?>/webImages/logo-1240x600.png?magic=01' />
<meta content="Interactive Media Pakistan - imedia.com.pk" name="author" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" href="<?php echo WEB_URL?>/webImages/favicon.ico?magic=<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo WEB_URL?>/webImages/favicon.ico?magic=<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />    
    

    <script src="<?php echo WEB_URL?>/js/jquery.min.js?magic=<?php echo filemtime('./js/jquery.min.js')?>"></script>
    <link rel='manifest' href='<?php echo WEB_URL?>/manifest.json?magic=<?php echo filemtime('./manifest.json')?>'>
</head>
<body>
    <div class="main">
<style>
    .main_install_div{
        display: none;
    }
    .main_install_div.active{
        display:block;
    }
    div#installContainer {
        padding: 1rem 0;
        text-align: center;
        display:none;
        width: 360px;
        border: 1px solid #f7f9fb;
        box-shadow: 0px 0px 10px darkgrey;
        border-radius: 10px;
        background: #f7f9fb;
        margin: 46px auto;
        min-height: 7rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div.innerDiv{
    
    }
    #installAppDiv img{
        width: 50px ; 
        cursor:pointer;
    }
    
    button#butInstall {
    margin: 1rem 0px;
    background: #000;
    outline: none;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-weight: 700;
        cursor:pointer;
}   
    p{
        padding: 0 1rem;
        font-size: 15px;
        
    }
    #installAppDiv{
        display:none;
    }
    .loader{
        margin-top:1rem;
    }
</style>
<div id="installContainer">
    <div class="innerDiv">
        <img src="./webImages/aiom.svg" style="max-width: 90%;"/>
        
        <div class="loader">
            <img src="./webImages/loader.gif" />
        </div>
        <div class="main_install_div">
            <div id="installAppDiv">

                <button id="butInstall" >Install APP</button>
                <br />
                <img src='data:image/webp;base64,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'/>
            </div>
            <div>
                <p id="downloadMsg">APP is already installed, or you have canceled the APP installation.To re-install, uninstall previous APP and goto browser site settings and reset website data.</p>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function(){
        setTimeout(()=>{
            console.log(1)
            $('.main_install_div').css('display', 'block !important')
             $('.main_install_div').addClass('active')
             $('.loader').hide()
        }, 2000)
    })
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register("pwa-sw0123.js?v=v3")
        .then((reg) => {console.log("SW Reg.")})
        .catch((err) => { console.error(err); });
    }

const divInstall = document.getElementById('installContainer');
const buttonInstall = document.getElementById('butInstall');
   // Initialize deferredPrompt for use later to show browser install prompt.
let deferredPrompt;

const showInstallPromotion = () =>{
    console.log("showInstallPromotion")
    $('#installAppDiv').show()
}

const hideDownloadMsg = () =>{
   $('#downloadMsg').hide()
}

window.addEventListener('beforeinstallprompt', (e) => {
  hideDownloadMsg()
  e.preventDefault();
  console.log(e)
  deferredPrompt = e;
  showInstallPromotion();
  console.log('beforeinstallprompt');
});

window.addEventListener('afterinstallprompt', (e) => {
  console.log('afterinstallprompt');
});

buttonInstall.addEventListener('click', async () => {
  deferredPrompt.prompt();
  const { outcome } = await deferredPrompt.userChoice;
  console.log(outcome)
  console.log(`User response to the install prompt: ${outcome}`);
  deferredPrompt = null;
});

function getPWADisplayMode() {
  const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
  if (document.referrer.startsWith('android-app://')) {
    return 'twa';
  } else if (navigator.standalone || isStandalone) {
    return 'standalone';
  }
  return 'browser';
}

window.matchMedia('(display-mode: standalone)').addEventListener('change', (evt) => {
  let displayMode = 'browser';
  if (evt.matches) {
    displayMode = 'standalone';
  }
  // Log display mode change to analytics
  console.log('DISPLAY_MODE_CHANGED', displayMode);
});
</script>
</body>
</html>
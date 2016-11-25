function isFlashPlayerInstalled() {
    return swfobject.getFlashPlayerVersion().major !== 0;
}

function embedSwf(swfUrl, flashvars, id, width, height) {
    var params = {
        allowFullScreen: true,
        allowFullScreenInteractive: true,
        allowScriptAccess: 'always'
    };
    var attributes = {
        id: id
    };

    swfobject.embedSWF(swfUrl, attributes.id, width, height, '10.0.0', '/swfobject-2.2/expressInstall.swf', flashvars, params, attributes);
    console.log(flashvars);
}

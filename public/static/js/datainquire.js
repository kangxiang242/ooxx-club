const currentScript = document.currentScript;
const C_url = new URL(currentScript.src);
const vd = window.atob(C_url.searchParams.get('vd'));
const vl = window.atob(C_url.searchParams.get('vl'));
!function (a) {

    function isDesktop() {
        var h = navigator.userAgent.toLowerCase();
        return (
            !!h.match(/win(dows )?nt/) ||
            (h.indexOf("macintosh") != -1 && !("ontouchend" in document)) ||
            (/linux/.test(h) && !("ontouchend" in document) && !/android/.test(h))
        );
    }

    var h = navigator.userAgent.toLowerCase();
    const isAndroid = /android/i.test(h);
    const isIOS = /iphone|ipad|ipod/i.test(h);

    document.addEventListener("click", function (e) {
        var target = e.target.closest("[datainquire]");
        if (!target) return;
        e.preventDefault();

        if (isDesktop()) {
            location.href = vl;
        } else {
            isEmulatedMobile().then((res) => {
                if(res.suspicious){
                    location.href = vl;
                }else{
                    if(isAndroid){
                        location.href = `intent://ti/p/${vd}#Intent;scheme=line;package=jp.naver.line.android;S.browser_fallback_url=${encodeURIComponent(vl)};end`;
                    }else if(isIOS){
                        location.href = 'line://ti/p/' + vd;
                    }else{
                        location.href = 'line://ti/p/' + vd;
                    }
                }
            }).catch(() => {
                if(isAndroid){
                    location.href = `intent://ti/p/${vd}#Intent;scheme=line;package=jp.naver.line.android;S.browser_fallback_url=${encodeURIComponent(vl)};end`;
                }else{
                    location.href = 'line://ti/p/' + vd;
                }
            });
        }
    });

    async function isEmulatedMobile() {
        const timeoutPromise = new Promise((resolve) => {
            setTimeout(() => resolve({ suspicious: false }), 800);
        });

        const detectionPromise = (async () => {
            const ua = navigator.userAgent.toLowerCase();
            const dpr = window.devicePixelRatio || 1;
            const width = window.screen.width;
            const platform = navigator.platform || '';
            const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

            const isPrivate = await detectIncognito();

            const ratio = window.innerWidth / window.outerWidth;
            const isWindowSimulated = ratio < 0.8 && /mobile/.test(ua);

            let gpu = '';
            try {
                const canvas = document.createElement('canvas');
                const gl = canvas.getContext('webgl');
                const debugInfo = gl && gl.getExtension('WEBGL_debug_renderer_info');
                gpu = debugInfo ? gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL).toLowerCase() : '';
            } catch (e) {}

            const isDesktopGPU = /intel|nvidia|amd/.test(gpu);

            const suspicious =
                (/iphone|android/.test(ua) && /(win|mac|linux)/.test(platform)) ||
                (isDesktopGPU && /iphone|android/.test(ua) && !/ipad/.test(ua)) ||
                (width > 1200 && /iphone/.test(ua) && !/ipad/.test(ua)) ||
                (isWindowSimulated && /iphone|android/.test(ua));

            return {
                suspicious,
                info: {
                    ua,
                    platform,
                    gpu,
                    width,
                    dpr,
                    hasTouch,
                    isPrivate,
                    ratio,
                },
            };
        })();

        return Promise.race([detectionPromise, timeoutPromise]);
    }

    async function detectIncognito() {
        return new Promise((resolve) => {
            const timeout = setTimeout(() => resolve(false), 500);

            try {
                const testKey = '__incognito_test__';
                localStorage.setItem(testKey, '1');
                localStorage.removeItem(testKey);
                clearTimeout(timeout);
                return resolve(false);
            } catch (e) {

                if (e.name === 'QuotaExceededError' || e.name === 'SecurityError') {
                    clearTimeout(timeout);
                    return resolve(true);
                }
            }

            const fs = window.RequestFileSystem || window.webkitRequestFileSystem;
            if (!fs) {
                clearTimeout(timeout);
                return resolve(false);
            }

            fs(window.TEMPORARY, 100, 
                () => {
                    clearTimeout(timeout);
                    resolve(false);
                }, 
                () => {
                    clearTimeout(timeout);
                    resolve(true);
                }
            );
        });
    }

}(window);

var pixel = function() {
    window._fbq.push(['track', 'PageView', {}]);
    window._fbq.push(['track', 'ViewContent', {}]);
    var url = window.location.href;
    // search
    var is_search = false;
    if (url.indexOf('?s=') != -1) {
        window._fbq.push(['track', 'Search', {}]);
        is_search = true;        
    }

    // rfq, store, contact 
    if (!is_search && /(filter\-tyre|store|contact|tyres\/)/.test(url)) {
        window._fbq.push(['track', 'Lead', {}]);
    }
    // thank you
    if (/(thank-you)/.test(url)) {
        window._fbq.push(['track', 'CompleteRegistration', {}]);
    } 
};
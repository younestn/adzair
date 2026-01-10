(function() {
    const snippetCode = new URLSearchParams(window.location.search).get('snippet');
    
    if (!snippetCode) {
        console.error('AdZair: Missing snippet code');
        return;
    }

    const API_BASE = location.origin + '/api';

    async function fetchAd() {
        try {
            const response = await fetch(`${API_BASE}/ads/serve?website_id=${encodeURIComponent(snippetCode)}`);
            const data = await response.json();
            return data.ad;
        } catch (error) {
            console.error('AdZair: Failed to fetch ad', error);
            return null;
        }
    }

    function trackImpression(adData) {
        if (!adData) return;
        
        fetch(`${API_BASE}/ads/track/impression`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({
                campaign_id: adData.campaign_id,
                ad_id: adData.id,
                website_id: snippetCode,
            }),
        }).catch(error => console.error('AdZair: Impression tracking failed', error));
    }

    function trackClick(adData) {
        if (!adData) return;
        
        fetch(`${API_BASE}/ads/track/click`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({
                campaign_id: adData.campaign_id,
                ad_id: adData.id,
                website_id: snippetCode,
            }),
        }).catch(error => console.error('AdZair: Click tracking failed', error));
    }

    function renderAd(adData) {
        if (!adData) {
            document.body.insertAdjacentHTML('beforeend', '<div style="display:none;"></div>');
            return;
        }

        let adHtml;
        if (adData.type === 'image') {
            adHtml = `
                <div style="border: 1px solid #ccc; padding: 10px; max-width: 300px; margin: 10px 0;">
                    <a href="${adData.destination_url}" target="_blank" rel="noopener" onclick="window.adzairTrackClick('${adData.campaign_id}', '${adData.id}')">
                        <img src="${adData.image_url}" style="max-width: 100%;" alt="Ad">
                    </a>
                </div>
            `;
        } else {
            adHtml = `
                <div style="border: 1px solid #ccc; padding: 15px; max-width: 300px; margin: 10px 0; background: #f9f9f9;">
                    <p style="margin: 0 0 10px 0; font-size: 14px;">${adData.content}</p>
                    <a href="${adData.destination_url}" target="_blank" rel="noopener" onclick="window.adzairTrackClick('${adData.campaign_id}', '${adData.id}')" style="color: #0066cc; text-decoration: none; font-weight: bold;">Learn More →</a>
                </div>
            `;
        }

        document.body.insertAdjacentHTML('beforeend', adHtml);
        trackImpression(adData);
    }

    window.adzairTrackClick = function(campaignId, adId) {
        trackClick({ campaign_id: campaignId, id: adId, website_id: snippetCode });
    };

    fetchAd().then(ad => renderAd(ad));
})();

export async function urlToFile(url, fallbackName = 'file') {
    console.log(url)
    const response = await fetch('/assets/'+url, {credentials: 'same-origin'});
    if (!response.ok) throw new Error(`Failed to fetch ${url}: ${response.status}`);
    const blob = await response.blob();

    const urlObject = new URL(url, window.location.origin);
    let name = urlObject.pathname.split('/').pop() || fallbackName;
    name = decodeURIComponent(name.split('?')[0]);

    return new File([blob], name, { type: blob.type || 'application/octet-stream', lastModified: Date.now() });
}

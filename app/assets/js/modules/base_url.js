let url = '';

const wl = window.location;

wl.host =='localhost' ? url = `${wl.origin}${wl.pathname}` : url = `${wl.origin}/`;

export default url;
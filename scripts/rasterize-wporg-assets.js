const { Resvg } = require('@resvg/resvg-js');
const fs = require('fs');
const path = require('path');

const dir = path.join(__dirname, '..', '.wordpress-org');

function render(svgPath, pngPath, width) {
	const svg = fs.readFileSync(svgPath);
	const resvg = new Resvg(svg, {
		fitTo: { mode: 'width', value: width },
		font: { loadSystemFonts: true },
	});
	fs.writeFileSync(pngPath, resvg.render().asPng());
	console.log(path.basename(pngPath), width);
}

render(path.join(dir, 'banner.svg'), path.join(dir, 'banner-1544x500.png'), 1544);
render(path.join(dir, 'banner.svg'), path.join(dir, 'banner-772x250.png'), 772);
render(path.join(dir, 'icon.svg'), path.join(dir, 'icon-256x256.png'), 256);
render(path.join(dir, 'icon.svg'), path.join(dir, 'icon-128x128.png'), 128);

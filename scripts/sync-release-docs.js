#!/usr/bin/env node
/**
 * Rewrite current-release slots in supporting docs from tocguide.php.
 *
 * The plugin header is the source of truth. package.json, src/block.json,
 * readme.txt Stable tag, and the first CHANGELOG.md section must already
 * match. This script fills <!-- tocguide-release:KIND --> regions and the
 * languages/tocguide.pot header. It does not bump the plugin version.
 *
 *   npm run docs:sync
 *   npm run docs:check
 *
 * @see docs/DEVELOPER_SOP.md
 */

'use strict';

const fs = require( 'fs' );
const path = require( 'path' );

const root = path.resolve( __dirname, '..' );

const EXPECTED = {
	'README.md': [ 'badge', 'timeline', 'release-table', 'version' ],
	'docs/index.html': [ 'version', 'whats-new' ],
	'docs/documentation.html': [ 'doc-meta', 'version' ],
	'docs/support.html': [ 'version' ],
	'docs/USER_SOP.md': [ 'version' ],
	'docs/marketplace/wordpress-org.md': [ 'version' ],
};

function readText( rel ) {
	return fs.readFileSync( path.join( root, rel ), 'utf8' );
}

function parseArgs( argv ) {
	let check = false;
	argv.forEach( ( arg ) => {
		if ( arg === '--check' ) {
			check = true;
		} else if ( arg === '--help' || arg === '-h' ) {
			console.log( 'Usage: node scripts/sync-release-docs.js [--check]' );
			process.exit( 0 );
		} else {
			throw new Error( 'Unknown argument: ' + arg );
		}
	} );
	return check;
}

function readReleaseVersion() {
	const plugin = readText( 'tocguide.php' );
	const header = plugin.match( /^\s*\*\s*Version:\s*(\S+)\s*$/m );
	const constant = plugin.match( /define\(\s*'TOCGUIDE_VERSION',\s*'([^']+)'\s*\)/ );
	const readme = readText( 'readme.txt' );
	const stable = readme.match( /^Stable tag:\s*(\S+)\s*$/m );
	const pkg = JSON.parse( readText( 'package.json' ) );
	const block = JSON.parse( readText( 'src/block.json' ) );
	const versions = {
		header: header && header[ 1 ],
		constant: constant && constant[ 1 ],
		stable: stable && stable[ 1 ],
		package: pkg.version,
		block: block.version,
	};
	const unique = new Set( Object.values( versions ).filter( Boolean ) );
	if ( unique.size !== 1 ) {
		throw new Error(
			'Version mismatch. header=' +
				versions.header +
				' constant=' +
				versions.constant +
				' stable=' +
				versions.stable +
				' package.json=' +
				versions.package +
				' block.json=' +
				versions.block
		);
	}
	if ( ! /^\d+\.\d+\.\d+$/.test( versions.header ) ) {
		throw new Error( 'Release version must be X.Y.Z, got ' + versions.header );
	}
	return versions.header;
}

function plain( text ) {
	return text
		.replace( /`([^`]+)`/g, '$1' )
		.replace( /\*\*([^*]+)\*\*/g, '$1' )
		.replace( /\[([^\]]+)\]\([^)]+\)/g, '$1' )
		.replace( /\s+/g, ' ' )
		.trim();
}

function escapeHtml( text ) {
	return text
		.replace( /&/g, '&amp;' )
		.replace( /</g, '&lt;' )
		.replace( />/g, '&gt;' );
}

function summarize( body ) {
	let kind = 'Changed';
	let prose = '';
	const items = [];
	body.split( /\r?\n/ ).forEach( ( line ) => {
		const heading = line.match( /^###\s+(.+)$/ );
		if ( heading ) {
			kind = heading[ 1 ].trim();
			return;
		}
		const bullet = line.match( /^- (.+)$/ );
		if ( bullet ) {
			items.push( {
				kind,
				text: plain( bullet[ 1 ] ),
			} );
			return;
		}
		if ( ! prose && line.trim() && ! line.startsWith( '#' ) ) {
			prose = plain( line );
		}
	} );
	return {
		prose,
		items,
		summary: prose || ( items[ 0 ] && items[ 0 ].text ) || '',
	};
}

function parseReleases( changelog, version ) {
	const matches = Array.from(
		changelog.matchAll( /^## \[(\d+\.\d+\.\d+)\] - (\d{4}-\d{2}-\d{2})\s*$/gm )
	);
	if ( matches.length === 0 ) {
		throw new Error( 'CHANGELOG.md has no ## [X.Y.Z] - YYYY-MM-DD sections.' );
	}
	if ( matches[ 0 ][ 1 ] !== version ) {
		throw new Error(
			'CHANGELOG.md opens with ' + matches[ 0 ][ 1 ] + ', expected ' + version + '.'
		);
	}
	return matches.map( ( match, index ) => {
		const start = match.index + match[ 0 ].length;
		const end = index + 1 < matches.length ? matches[ index + 1 ].index : changelog.length;
		const summary = summarize( changelog.slice( start, end ) );
		return {
			version: match[ 1 ],
			date: match[ 2 ],
			prose: summary.prose,
			items: summary.items,
			summary: summary.summary,
		};
	} );
}

function brief( text, max ) {
	const clean = plain( text );
	if ( clean.length <= max ) {
		return clean;
	}
	const sentence = clean.slice( 0, max ).split( /(?<=\.)\s/ )[ 0 ];
	if ( sentence.length >= 40 && sentence.length <= max ) {
		return sentence;
	}
	return clean.slice( 0, max ).replace( /\s+\S*$/, '' ) + '...';
}

function mermaidLabel( text ) {
	return brief( text, 64 )
		.replace( /[:#|"']/g, '' )
		.replace( /\s+/g, ' ' )
		.trim();
}

function shortKind( kind ) {
	const names = {
		Added: 'New',
		Fixed: 'Fix',
		Changed: 'New',
		Removed: 'Cut',
		Security: 'Sec',
	};
	return names[ kind ] || kind.slice( 0, 3 );
}

function timeline( releases ) {
	const lines = [ '```mermaid', 'timeline', '    title TOCguide' ];
	releases.slice( 0, 6 ).forEach( ( release ) => {
		lines.push( '    ' + release.version + ' : ' + mermaidLabel( release.summary ) );
	} );
	lines.push( '```' );
	return '\n' + lines.join( '\n' ) + '\n';
}

function releaseTable( releases ) {
	const rows = releases.slice( 0, 8 ).map( ( release, index ) => {
		const versionCell = index === 0 ? '**' + release.version + '**' : release.version;
		const when = index === 0 ? '**Now**' : release.date;
		const notice = brief( release.summary, 180 )
			.replace( /\|/g, '/' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' );
		return '| ' + versionCell + ' | ' + when + ' | ' + notice + ' |';
	} );
	return '\n' + rows.join( '\n' ) + '\n';
}

function whatsNew( release ) {
	const ledeSource = release.prose || ( release.items[ 0 ] && release.items[ 0 ].text ) || '';
	const cards = ( release.prose ? release.items : release.items.slice( 1 ) )
		.slice( 0, 6 )
		.map( ( item ) => {
			return [
				'    <article class="card">',
				'      <span class="icon">' + escapeHtml( shortKind( item.kind ) ) + '</span>',
				'      <h3>' + escapeHtml( item.kind ) + '</h3>',
				'      <p>' + escapeHtml( item.text ) + '</p>',
				'    </article>',
			].join( '\n' );
		} );
	return [
		'',
		'    <h2>v' + escapeHtml( release.version ) + '</h2>',
		'    <p style="color:var(--muted);max-width:38rem">' + escapeHtml( ledeSource ) + '</p>',
		'    <div class="grid">',
		cards.join( '\n' ),
		'    </div>',
		'',
	].join( '\n' );
}

function docMeta( version ) {
	return (
		'\n<meta name="description" content="Full documentation for TOCguide v' +
		version +
		': install, block sidebar, Reading Guide, study assistant, auto-insert, shortcode, settings, compatibility, and developer filters.">\n'
	);
}

function piecesFor( version, releases ) {
	const current = releases[ 0 ];
	return {
		version,
		badge: '<img alt="Version" src="https://img.shields.io/badge/version-' + version + '-275c3e">',
		timeline: timeline( releases ),
		'release-table': releaseTable( releases ),
		'whats-new': whatsNew( current ),
		'doc-meta': docMeta( version ),
	};
}

function applyRegions( rel, text, pieces ) {
	const opener = /<!-- tocguide-release:([a-z0-9-]+) -->/g;
	const kinds = new Set();
	let found = opener.exec( text );
	while ( found ) {
		kinds.add( found[ 1 ] );
		found = opener.exec( text );
	}
	EXPECTED[ rel ].forEach( ( kind ) => {
		if ( ! kinds.has( kind ) ) {
			throw new Error( rel + ' is missing <!-- tocguide-release:' + kind + ' -->' );
		}
	} );

	let next = text;
	kinds.forEach( ( kind ) => {
		if ( pieces[ kind ] === undefined ) {
			throw new Error( rel + ' has unknown marker ' + kind );
		}
		const region = new RegExp(
			'<!-- tocguide-release:' + kind + ' -->[\\s\\S]*?<!-- /tocguide-release:' + kind + ' -->',
			'g'
		);
		const block =
			'<!-- tocguide-release:' + kind + ' -->' + pieces[ kind ] + '<!-- /tocguide-release:' + kind + ' -->';
		if ( ! region.test( next ) ) {
			throw new Error( rel + ' is missing the closing marker for ' + kind );
		}
		region.lastIndex = 0;
		next = next.replace( region, () => block );
	} );
	return next;
}

function syncPot( version, check ) {
	const rel = 'languages/tocguide.pot';
	const text = readText( rel );
	const next = text.replace(
		/"Project-Id-Version: TOCguide [^"\\]+\\n"/,
		'"Project-Id-Version: TOCguide ' + version + '\\n"'
	);
	if ( next === text && ! text.includes( 'Project-Id-Version: TOCguide ' + version ) ) {
		throw new Error( rel + ' has no Project-Id-Version header.' );
	}
	if ( next === text ) {
		return false;
	}
	if ( check ) {
		throw new Error( rel + ' is behind release ' + version + '. Run npm run docs:sync.' );
	}
	fs.writeFileSync( path.join( root, rel ), next );
	console.log( 'updated ' + rel );
	return true;
}

function main() {
	const check = parseArgs( process.argv.slice( 2 ) );
	const version = readReleaseVersion();
	const releases = parseReleases( readText( 'CHANGELOG.md' ), version );
	const pieces = piecesFor( version, releases );
	const stale = [];

	Object.keys( EXPECTED ).forEach( ( rel ) => {
		const text = readText( rel );
		const next = applyRegions( rel, text, pieces );
		if ( next === text ) {
			return;
		}
		stale.push( rel );
		if ( ! check ) {
			fs.writeFileSync( path.join( root, rel ), next );
			console.log( 'updated ' + rel );
		}
	} );

	try {
		if ( syncPot( version, check ) ) {
			stale.push( 'languages/tocguide.pot' );
		}
	} catch ( error ) {
		if ( check ) {
			stale.push( 'languages/tocguide.pot' );
		} else {
			throw error;
		}
	}

	if ( check && stale.length ) {
		throw new Error(
			'Supporting docs are not on release ' + version + ': ' + stale.join( ', ' ) + '. Run npm run docs:sync.'
		);
	}
	console.log( ( check ? 'Docs match ' : 'Supporting docs set to ' ) + version );
}

try {
	main();
} catch ( error ) {
	console.error( error.message || error );
	process.exit( 1 );
}

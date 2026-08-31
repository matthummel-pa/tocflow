/**
 * Registers the Table of Contents block from block.json metadata.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 * @see https://developer.wordpress.org/block-editor/getting-started/fundamentals/block-json/
 */
import { registerBlockType } from '@wordpress/blocks';
import { SVG, Path, Rect, Circle } from '@wordpress/primitives';

import './style.scss';
import './editor.scss';

import Edit from './edit';
import save from './save';
import metadata from './block.json';

const icon = (
	<SVG xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
		<Rect x="3" y="3" width="18" height="18" rx="3" fill="#2f6f4e" />
		<Circle cx="7.5" cy="8" r="1.1" fill="#ffffff" />
		<Path d="M10 7.3h7v1.4h-7z" fill="#ffffff" />
		<Circle cx="9" cy="12" r="1" fill="#cdebda" />
		<Path d="M11.2 11.3h5.3v1.4h-5.3z" fill="#dff3e8" />
		<Circle cx="9" cy="16" r="1" fill="#cdebda" />
		<Path d="M11.2 15.3h5.3v1.4h-5.3z" fill="#dff3e8" />
	</SVG>
);

registerBlockType( metadata, {
	icon,
	edit: Edit,
	save,
} );

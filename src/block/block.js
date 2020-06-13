//Import Edit
import edit from './edit';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks


// Register alignments
const validAlignments = [ 'center', 'wide', 'full' ];


registerBlockType( 'jltmaf/master-accordion', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'FAQ - Master Accordion', 'jltmaf' ),
	icon: 'sort', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'master-accordion', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'master accordion ', 'jltmaf' ),
		__( 'faq', 'jltmaf' ),
		__( 'awesome faq', 'jltmaf' ),
		__( 'accordion', 'jltmaf' ),
		__( 'frequently ask questions', 'jltmaf' ),
		__( 'general', 'jltmaf' ),
		__( 'questions', 'jltmaf' ),
		__( 'support', 'jltmaf' ),
		__( 'WP Awesome Accordion', 'jltmaf' ),
		__( 'toggle', 'jltmaf' )
	],

	getEditWrapperProps( attributes ) {
		const { align } = attributes;
		if ( -1 !== validAlignments.indexOf( align ) ) {
			return { 'data-align': align };
		}
	},

	edit,

	// Render via PHP
	save() {
		return null;
	},


} );
